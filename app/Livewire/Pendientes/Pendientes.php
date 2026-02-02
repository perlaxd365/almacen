<?php

namespace App\Livewire\Pendientes;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\RetornoPendiente;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pendientes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /* =========================
     | FILTROS
     ========================= */
    public $buscarProducto = '';
    public $orden = '';
    public $proyecto = '';

    /* =========================
     | RESET PAGINACIÓN
     ========================= */
    public function updating()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'buscarProducto',
            'orden',
            'proyecto'
        ]);
    }



    /* =========================
     | MODAL RETORNO
     ========================= */
    public $mostrarModal = false;

    public $retorno_id;
    public $producto_nombre;
    public $cantidad_pendiente;
    public $cantidad_devolver = 1;

    /* =========================
     | LISTADO
     ========================= */
    public function getPendientesProperty()
    {
        return RetornoPendiente::with(['producto', 'usuario'])
            ->where('estado', 'pendiente')
            ->paginate(10);
    }

    /* =========================
     | ABRIR MODAL
     ========================= */
    public function abrirModal($id)
    {
        $retorno = RetornoPendiente::with('producto')->findOrFail($id);

        $this->retorno_id = $retorno->id;
        $this->producto_nombre = $retorno->producto->nombre;
        $this->cantidad_pendiente = $retorno->cantidad_pendiente;
        $this->cantidad_devolver = 1;

        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->reset([
            'mostrarModal',
            'retorno_id',
            'producto_nombre',
            'cantidad_pendiente',
            'cantidad_devolver'
        ]);
    }

    public function registrarRetorno()
    {
        $this->validate([
            'cantidad_devolver' => 'required|integer|min:1|max:' . $this->cantidad_pendiente,
        ]);

        DB::transaction(function () {

            $retorno = RetornoPendiente::lockForUpdate()->findOrFail($this->retorno_id);
            $producto = Producto::lockForUpdate()->findOrFail($retorno->producto_id);

            // ================= STOCK =================
            $stockAnterior = $producto->stock;
            $stockResultante = $stockAnterior + $this->cantidad_devolver;

            // ================= MOVIMIENTO (KARDEX) =================
            Movimiento::create([
                'producto_id' => $producto->id,
                'user_id' => $retorno->user_id,
                'tipo' => 'entrada',
                'cantidad' => $this->cantidad_devolver,
                'stock_anterior' => $stockAnterior,
                'stock_resultante' => $stockResultante,
                'orden_compra_numero' => $retorno->orden_compra_numero,
                'proyecto_nombre' => $retorno->proyecto_nombre,
                'observacion' => 'Retorno de material',
            ]);

            // ================= ACTUALIZAR RETORNO =================
            $retorno->cantidad_devuelta += $this->cantidad_devolver;
            $retorno->cantidad_pendiente =
                $retorno->cantidad_entregada - $retorno->cantidad_devuelta;

            if ($retorno->cantidad_pendiente <= 0) {
                $retorno->estado = 'cerrado';
                $retorno->cantidad_pendiente = 0;
            }

            $retorno->save();

            // ================= ACTUALIZAR STOCK =================
            $producto->update([
                'stock' => $stockResultante
            ]);
        });

        $this->cerrarModal();

        $this->dispatch(
            'alert',
            ['type' => 'success', 'message' => 'Retorno registrado correctamente']
        );
    }

    public function render()
    {
        return view('livewire.pendientes.pendientes', [
            'pendientes' => $this->pendientes
        ]);
    }
}
