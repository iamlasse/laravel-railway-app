<?php

namespace App\Http\Livewire\Utils;

use Carbon\Carbon;
use Livewire\Component;

class ToggleSwitch extends Component
{
    public $active = false;
    public $type;
    public $model;
    public $attribute;

    protected $listeners = [
        'refreshToggles' => '$refresh'
    ];

    public function mount($model, $attribute, $active = false, $type = null)
    {
        $this->active = $active;
        $this->model = $model;
        $this->attribute = $attribute;
        $this->active = !!$this->model->getAttribute($attribute);
        $this->type = $type;
    }

    public function updatedActive($value)
    {
        if ('date' === $this->type) {
            if ($value) {
                $this->model->setAttribute($this->attribute, now());
            } else {
                $this->model->setAttribute($this->attribute, null);
            }
        } else {
            // Assume it's a boolean
            if ($value) {
                $this->model->setAttribute($this->attribute, true);
            } else {
                $this->model->setAttribute($this->attribute, false);
            }
        }

        $this->emitUp('updateModels', $this->model, $this->attribute, $value);
    }

    public function render()
    {
        return view('livewire.utils.toggle-switch');
    }
}
