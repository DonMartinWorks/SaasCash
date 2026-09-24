<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputError extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  array|string|null  $messages
     */
    public function __construct(
        public array|string|null $messages = null
    ) {
        $this->messages = (array) $messages;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-error');
    }
}
