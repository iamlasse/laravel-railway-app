<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Subscription;
use Livewire\Component;

class InsikterTable extends Component
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;

    public function getRowsQueryProperty()
    {
        $query = company()->subscriptions()
            ->select('subscriptions.*', 'plans.name as plan_name', 'plans.data as plan_data')
            ->join('plans', 'subscriptions.current_plan_id', '=', 'plans.id');
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
            'livewire.insikter-table',
            [
            'subscriptions' => $this->rows
            ]
        );
    }
}
