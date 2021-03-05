<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{

    public $minuted,$secondd;

    public function mount($minuted, $second){
        $this->minuted = $minuted;
        $this->secondd = $second;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
