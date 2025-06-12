<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;
    public $options;
    public $value;
    public $placeholder;


    public function __construct($label, $options = [], $value = null, $placeholder = null)
    {
        $this->label = $label;
        $this->options = $options;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
