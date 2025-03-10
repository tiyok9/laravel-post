<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlertStatus extends Component
{
    public string $type;
    public string $message;

    /**
     * Create a new component instance.
     */
    public function __construct(string $type = 'info', string $message = '')
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert-status');
    }
}
