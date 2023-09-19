<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComponentModal extends Component
{
    public $showModal;
    public $action;
    public $closeText;

    public function __construct(string $showModal, string $action = '', string $closeText = '')
    {
        $this->showModal = $showModal;
        $this->action = $action;
        $this->closeText = $closeText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.component-modal');
    }
}
