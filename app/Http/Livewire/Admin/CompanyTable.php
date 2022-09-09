<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Jobs\CreateOffers;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Rules\UsernameValid;
use Illuminate\Support\Str;
use Livewire\Component;

class CompanyTable extends Component
{
    use WithPerPagePagination;
    use WithSorting;
    use WithCachedRows;
    use WithBulkActions;

    public $order;

    protected $listeners = ['companyCreated' => '$refresh'];

    public function getRowsQueryProperty()
    {
        $query = Company::query()->without(['offers', 'subscriptions'])->with('rep');
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(
            function () {
                return $this->applyPagination($this->rowsQuery);
            }
        );
    }

    public function render()
    {
        return view(
            'livewire.admin.company-table',
            [
            'companies' => $this->rows
            ]
        );
    }
}
