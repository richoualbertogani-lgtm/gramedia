<?php

namespace App\View\Components;

use App\Models\BookCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Menyediakan komponen navigasi bersama untuk tampilan aplikasi.
 */
class navbar extends Component
{
    public $bookCategories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->bookCategories = BookCategory::withCount('books')->orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
