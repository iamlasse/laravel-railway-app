<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use Livewire\Component;
use App\Rules\ExcelRule;
use Maatwebsite\Excel\Excel;
use Livewire\WithFileUploads;
use App\Imports\SubscriptionsImport;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Response;

class ImportSubscriptionsModal extends ModalComponent
{
    use WithFileUploads;

    public $companyId;
    public $sheet;
    public $operatorId;

    public function mount($companyId)
    {
        $this->companyId = $companyId;
    }

    public function handleImport()
    {
        $this->validate(
            [
                'sheet' => ['required', 'file', new ExcelRule($this->sheet)],
                // 'operatorId' => ['required'],
            ]
        );

        $operatorId = Company::find($this->companyId)->currentOffer->operator_id;
        if ($operatorId !== null) {
            $this->sheet->storeAs('/', $this->companyId . '_' . $this->operatorId . '_import.xlsx');
            
                (new SubscriptionsImport($this->companyId, $operatorId))
                    ->import($this->sheet, 'local', Excel::XLSX);
                $this->emitTo('admin.subscriptions-table', 'subscriptionsImported');
                // $this->emitTo('admin.offer-plan-table', 'updateViews');
                $this->closeModal();
                $this->dispatchBrowserEvent('save', ['message' => __('Abonnemang importerade ladda om sidan')]);
                $this->redirectRoute('admin.company.edit', $this->companyId);
                return;
            
        }

        $this->addError('operatorId', 'Operatören måste finnas i offerter');
    }

    public function getTemplate()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/mallar/mall.xlsx";

        $headers = array(
            'Content-Type: application/vnd.openxmlformats',
        );

        return Response::download($file, 'mall.xlsx', $headers);
    }

    public function render()
    {
        return view('livewire.admin.import-subscriptions-modal');
    }
}
