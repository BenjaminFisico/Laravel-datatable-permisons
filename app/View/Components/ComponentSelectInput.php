<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComponentSelectInput extends Component
{
    public string $label = '';
    public string $inputName = '';
    public string $functionOnChange = '';
    public array $options = [];
    
    public function __construct(string $label, string $inputName, array $options, string $functionOnChange = '')
    {
        $this->label = $label;
        $this->inputName = $inputName;
        $this->options = $options;
        $this->functionOnChange = $functionOnChange;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.component-select-input');
    }
}
