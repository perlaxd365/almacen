<?php

namespace App\Livewire\Trabajador;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Trabajador extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // 🔍 FILTROS
    public $buscar = '';
    public $tipo = '';
    public $estado = '';

    // 🧾 FORM
    public $user_id;
    public $name, $email, $dni, $telefono, $password, $tipo_form = 'OPERADOR', $estado_form = 'ACTIVO';

    public $modal = false;

    public function updating()
    {
        $this->resetPage();
    }

    // 📊 LISTADO
    public function getTrabajadoresProperty()
    {
        return User::query()
            ->when(
                $this->buscar,
                fn($q) =>
                $q->where('name', 'like', "%{$this->buscar}%")
                    ->orWhere('dni', 'like', "%{$this->buscar}%")
            )
            ->when($this->tipo, fn($q) => $q->where('tipo', $this->tipo))
            ->when($this->estado, fn($q) => $q->where('estado', $this->estado))
            ->latest()
            ->paginate(10);
    }

    // 🟢 CREAR
    public function crear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    // ✏️ EDITAR
    public function editar($id)
    {
        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->dni = $user->dni;
        $this->telefono = $user->telefono;
        $this->tipo_form = $user->tipo;
        $this->estado_form = $user->estado;

        $this->modal = true;
    }

    // 💾 GUARDAR (CREATE / UPDATE)
    public function guardar()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'dni' => 'required',
            'telefono' => 'required',
        ]);

        User::updateOrCreate(
            ['id' => $this->user_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'dni' => $this->dni,
                'telefono' => $this->telefono,
                'tipo' => $this->tipo_form,
                'estado' => $this->estado_form,
                'password' => $this->password ? Hash::make($this->password) : User::find($this->user_id)?->password ?? Hash::make('12345678'),
            ]
        );

        $this->cerrarModal();

         $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Usuario registrado correctamente', 'message' => 'Exito']
        );
    }

    // ❌ ELIMINAR
    public function eliminar($id)
    {
        User::findOrFail($id)->delete();
         $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Usuario eliminado correctamente', 'message' => 'Exito']
        );
    }

    public function cerrarModal()
    {
        $this->resetForm();
        $this->modal = false;
    }

    public function resetForm()
    {
        $this->reset([
            'user_id',
            'name',
            'email',
            'dni',
            'telefono',
            'password',
            'tipo_form',
            'estado_form'
        ]);
    }


    public function render()
    {
        return view('livewire.trabajador.trabajador', [
            'trabajadores' => $this->trabajadores
        ]);
    }
}
