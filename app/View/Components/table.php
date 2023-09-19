<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class table extends Component
{
    public string $tittle = '';

    public function __construct(string $tittle)
    {
        $this->tittle = $tittle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
