<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $menuActivo = '';

    protected $listeners = ['setMenuActivo'];

    public function setMenuActivo($menu)
    {
        $this->menuActivo = $menu;
    }

    public function render()
    {
        return view('livewire.layout.sidebar', [
            'usuario' => Auth::user()
        ]);
    }
}
