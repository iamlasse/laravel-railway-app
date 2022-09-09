<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StatusTag extends Component
{
    public $model;
    public $field;
    public $statuses = [];

    public function mount($model, $field, $statuses = [])
    {
        $this->model = $model;
        $this->field = $field;
        $this->statuses = $statuses;
    }

    public function render()
    {
        dd($this->statuses);
        return view('livewire.status-tag');
    }
}
