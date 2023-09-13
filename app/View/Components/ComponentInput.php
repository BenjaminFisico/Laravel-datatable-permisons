<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComponentInput extends Component
{
    public string $label;
    public string $placeholder;
    public string $inputName;
    public string $type;
    

    public function __construct(string $label, string $placeholder, string $inputName, string $type = 'text')
    {
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->inputName = $inputName;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.component-input');
    }
}
