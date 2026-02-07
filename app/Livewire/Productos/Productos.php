<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class Productos extends Component
{

    public $codigo, $nombre, $tipo = 'consumible',
        $unidad = 'unidad', $stock = 0, $estado = true;

    public function mount()
    {
        $this->codigo = $this->generarCodigo();
    }
    protected $rules = [
        'codigo' => 'required|unique:productos,codigo',
        'nombre' => 'required',
        'tipo' => 'required',
        'unidad' => 'required',
        'stock' => 'integer|min:0'
    ];

    public function guardar()
    {
        $this->validate();

        Producto::create([
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'unidad' => $this->unidad,
            'stock' => $this->stock,
            'estado' => $this->estado,
        ]);

        $this->reset();
        $this->codigo = $this->generarCodigo();
        $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Se registro el producto correctamente', 'message' => 'Exito']
        );
    }



    public $producto_id;
    public function editar($id)
    {
        $producto = Producto::findOrFail($id);

        $this->producto_id   = $producto->id;
        $this->codigo = $producto->codigo;
        $this->nombre        = $producto->nombre;
        $this->tipo          = $producto->tipo;
        $this->unidad        = $producto->unidad;
        $this->stock         = $producto->stock;
        $this->estado        = $producto->estado;

        $this->dispatch('abrir-modal-editar');
    }


    public function actualizar()
    {
        $this->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'tipo'   => 'required',
        ]);

        Producto::where('id', $this->producto_id)->update([
            'nombre'        => $this->nombre,
            'tipo'          => $this->tipo,
            'unidad'        => $this->unidad,
            'stock'         => $this->stock,
            'estado'        => $this->estado,
        ]);

        $this->dispatch('cerrar-modal-editar');


        $this->resetForm();
        $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Producto actualizado correctamente', 'message' => 'Exito']
        );
    }

    protected $listeners = ['resetForm'];

    public function resetForm()
    {

        $this->codigo = $this->generarCodigo();
        $this->reset([
            'producto_id',
            'nombre',
            'tipo',
            'unidad',
            'stock',
            'estado',
        ]);
        $this->estado = true;
    }

    private function generarCodigo()
    {
        $ultimo = Producto::latest('id')->first();

        $numero = $ultimo ? intval(substr($ultimo->codigo, 4)) + 1 : 1;

        return 'SM-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function confirmarEliminar($id)
    {
        $this->dispatch('confirmar-eliminacion', id: $id);
    }

    public function eliminarProducto($id)
    {
        Producto::findOrFail($id)->update([
            'estado' => false
        ]);

        $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Producto eliminado correctamente', 'message' => 'Exito']
        );
    }

    public function habilitarProducto($id)
    {
        Producto::findOrFail($id)->update([
            'estado' => true
        ]);

        $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Producto habilitado correctamente', 'message' => 'Exito']
        );
    }

    public  $buscar;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.productos.productos', [
            'productos' => Producto::where('nombre', 'like', "%{$this->buscar}%")
                ->where('estado', true)
                ->orWhere('codigo', 'like', "%{$this->buscar}%")
                ->orderBy('nombre')
                ->paginate(5)
        ]);
    }
}
