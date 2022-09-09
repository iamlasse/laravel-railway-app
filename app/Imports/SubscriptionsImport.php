<?php

namespace App\Imports;

use App\Models\Offer;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Str;

class SubscriptionsImport extends StringValueBinder implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithCalculatedFormulas
{
    use Importable;

    protected $companyId;
    protected $operatorId;

    public function __construct($companyId, $operatorId)
    {
        $this->companyId = $companyId;
        $this->operatorId = $operatorId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {

        $allowedKeys = [
            "typ",
            "nummer",
            "avdelning",
            "namn",
            "abonnemangsform",
            "datamangd_som_ingar_idag",
            "pris_per_manad",
            "aktivt",
            "anvand_dataforbrukning",
            "vaxelanvandare_idag",
            "avslutas",
            "startdatum",
            "slutdatum",
            "tele2",
            "telia",
            "telenor",
            "tre",
            "soluno",
        ];

        foreach ($rows as $row) {
            if (!$row->has($allowedKeys)) {
                continue;
            }

            $validated = Validator::make(
                data: $row->toArray(), 
                rules: [
                'typ' => 'nullable|in:M,MB,DK',
                'nummer' => 'nullable',
                'avdelning' => 'nullable|string',
                'namn' => 'required|string',
                'abonnemangsform' => 'required|string',
                'datamangd_som_ingar_idag' => 'required|numeric',
                'pris_per_manad' => 'required|numeric',
                'aktivt' => 'nullable|in:Ja,Nej',
                'anvand_dataforbrukning' => 'required|numeric|min:0',
                'vaxelanvandare_idag' => 'nullable|in:Ja,Nej',
                'startdatum' => ['nullable', function($attribute, $value, $fail){
                    if ($value !== null) {
                        $date = Date::excelToTimestamp($value);
                        if ( Carbon::createFromFormat('m/d/Y', date('m/d/Y', $date)) === false) {
                            $fail('Datumet är inte i korrekt format');
                        }
                    }
                }],
                'slutdatum' => ['nullable', function($attribute, $value, $fail){
                    if ($value !== null) {
                        $date = Date::excelToTimestamp($value);
                        if ( Carbon::createFromFormat('m/d/Y', date('m/d/Y', $date)) === false) {
                            $fail('Datumet är inte i korrekt format');
                        }
                    }
                }],
            ], messages: [
                'typ.in' => 'Abonnemangtyp måste vara M, MB eller DK',
                'abonnemangsform.required' => 'Abonnmangsform måste anges',
                'anvand_dataforbrukning.required' => 'Använd dataforbrukning måste anges',
                'prist_per_manad.required' => 'Pris måste anges',
                'datamangd_som_ingar_idag.numeric' => ':attribute måste vara ett nummer',
                
            ])->validate();

            /*
            *  "typ" => "M"
            *  "nummer" => 700000001.0
            *  "avdelning" => "Försäljning"
            *  "namn" => "För.Efternamn 1"
            *  "abonnemangsform" => "Mobilt Fastpris 40 GB"
            *  "datamangd_som_ingar_idag" => 40000.0
            *  "pris_per_manad" => 239.0
            *  "anvand_dataforbrukning" => 0.0
            *  "vaxelanvandare_idag" => 1.0
            *  "startdatum" =>
            *  "slutdatum" =>
            *  "aktivt" => "Nej"
            *  "avslutas" => 1.0
            *  "tele2" => null
            *  "telia" => null
            *  "telenor" => null
            *  "tre" => null
            *  "soluno" => null
            */

            DB::beginTransaction();
            try {
                $currentPlan = Plan::where('name', 'like', '%' . $validated['abonnemangsform'] . '%')->first();
                if (!$currentPlan) {
                    $currentPlan = Plan::create(
                        [
                        'name' => $validated['abonnemangsform'],
                        'data' => intval($validated['datamangd_som_ingar_idag']),
                        'price' => intval($validated['pris_per_manad']),
                        'operator_id' => $this->operatorId,
                        ]
                    );
                    cache()->forget($this->operatorId . '-plans');
                    $offer = Offer::whereCompanyId($this->companyId)->whereOperatorId($this->operatorId)->first();
                    $offer->plans()->attach(
                        $currentPlan->id,
                        [
                        'price_new' => $currentPlan->price, 'price_org' => $currentPlan->price
                        ]
                    );
                }

                $current_usage = $validated['anvand_dataforbrukning'];
                
                $start_date = Arr::get($validated, 'startdatum');
                $end_date = Arr::get($validated, 'slutdatum');
                
                $should_cancel = Arr::get($row, 'avslutas');
                $should_be_cancelled = Str::is(['Ja', 'JA', 'ja'], $should_cancel);

                $numbers = Str::of($validated['nummer'])->explode(',');

               
                $data = [
                    'company_id' => $this->companyId,
                    'type' => $validated['typ'] ?? 'M',
                    'numbers' => $numbers,
                    'name' => $validated['namn'],
                    'department' => $validated['avdelning'],
                    'current_plan_id' => $currentPlan->id,
                    'status' => Str::is(['Nej', 'NEJ', 'nej'], $validated['aktivt']) ? 0 : 1,
                    'current_plan_data' => $currentPlan->data,
                    'current_plan_usage' => $current_usage <= 0 ? 0 : $current_usage,
                    'vaxel_user' => Arr::get($validated, 'vaxelanvandare_idag') === 'Ja' ? true : false,
                    'starts_at' => $start_date ? Date::excelToDateTimeObject($start_date) : null,
                    'ends_at' => $end_date ? Date::excelToDateTimeObject($end_date) : null,
                    'to_be_cancelled' => $should_be_cancelled,
                ];



                $subscription = Subscription::whereCompanyId($this->companyId)
                    ->where(
                        function (Builder $query) use ($validated) {
                            $query->whereJsonContains('numbers', $validated['nummer'])
                                ->orWhere('name', 'like', '%' . $validated['namn'] . '%');
                        }
                    )
                    ->first();

                if ($subscription) {
                    $subscription->plans()->detach();
                    $subscription->updateOrFail($data);
                } else {
                    $subscription = Subscription::create($data);
                }


                if (!$subscription->to_be_cancelled) {
                    $rows = collect(
                        [
                        'tele2' => $row['tele2'],
                        'telia' => $row['telia'],
                        'telenor' => $row['telenor'],
                        'tre' => $row['tre'],
                        'soluno' => $row['soluno']
                        ]
                    );
                    $this->createPlans($rows, $subscription);
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function createPlans(Collection $operators, Subscription $subscription)
    {
        $operators->each(
            function ($plan, $operator) use ($subscription) {
                if ($plan) {
                    $operatorId = operators()->where('code', $operator)->first()['id'];

                    cache()->forget('company-' . $this->companyId . '-subscriptions-' . $operator);




                    if ($operatorId) {
                        $dataPlan = Plan::where('name', 'like', '%' . $plan . '%')->whereOperatorId($operatorId)->first();
                        $vaxelPlan = null;

                        if ($subscription->vaxel_user) {
                            $vaxelPlan = Plan::whereOperatorId($operatorId)->where('is_vaxel_plan', true)->first();
                        }

                        if ($dataPlan) {
                            $subscription->plans()->attach(
                                $dataPlan->id,
                                [
                                'operator_id' => $operatorId,
                                'vaxel_plan_id' => $subscription->vaxel_user ? $vaxelPlan->id : null,
                                ]
                            );
                        }
                    }
                }
            }
        );
    }
}
