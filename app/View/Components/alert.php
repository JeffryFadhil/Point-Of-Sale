<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class alert extends Component
{
    /**
     * Create a new component instance.
     */
    public $type ,$errors;
    public function __construct( $type = 'danger', $errors = null)
    {
        $this->type = $type; // Type of alert (e.g., success, error, info)
        $this->errors = $errors; // Optional errors to display
    
      
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
