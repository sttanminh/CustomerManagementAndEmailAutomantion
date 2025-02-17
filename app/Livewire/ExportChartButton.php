<?php
namespace App\Http\Livewire;

use Livewire\Component;

class ExportChartButton extends Component
{
    public $chartId;

    public function render()
    {
        return view('livewire.export-chart-button');
    }
}
