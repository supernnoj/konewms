<?php

namespace App\Livewire\Kpi;

use Livewire\Component;

class OrderFillRateWidget extends Component
{
    public array $series = [];

    public function mount()
    {
        // Example: 7 days of fill‑rate data (x = day index, y = %)
        $this->series = [
            [0, 94],
            [1, 95],
            [2, 96],
            [3, 92],
            [4, 97],
            [5, 98],
            [6, 99],
        ];
    }

    public function render()
    {
        return view('livewire.kpi.order-fill-rate-widget');
    }
}
