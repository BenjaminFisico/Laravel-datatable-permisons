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
    public string $firstOption = '';
    
    public function __construct(string $label, string $inputName, array $options, string $functionOnChange = '', string $firstOption = '')
    {
        $this->label = $label;
        $this->inputName = $inputName;
        $this->options = $options;
        $this->functionOnChange = $functionOnChange;
        $this->firstOption = $firstOption;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.component-select-input');
    }
}
