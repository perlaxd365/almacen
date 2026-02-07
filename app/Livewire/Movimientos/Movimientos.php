<?php

namespace App\Livewire\Movimientos;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\RetornoPendiente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Movimientos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /* =========================
     | REGISTRO
     ========================= */
    public $producto_id;
    public $productoSeleccionado;
    public $buscarProductoRegistro = '';

    public $tipo = 'entrada';
    public $cantidad;
    public $motivo;

    public $ordenSeleccionada;
    public $orden_compra_numero;
    public $proyecto_nombre;

    public $receptor_user_id;
    public $proyectoNombre;

    public $ordenes = [];

    /* =========================
     | LISTADO / FILTROS
     ========================= */
    public $buscarProductoTabla = '';
    public $filtroTipo = '';
    public $orden = '';
    public $proyecto = '';

    /* =========================
     | CICLO DE VIDA
     ========================= */
    public function mount()
    {
        $this->ordenes = [
            ['numero' => 'ORD-000123', 'proyecto' => 'Proyecto Planta Norte'],
            ['numero' => 'ORD-000124', 'proyecto' => 'Proyecto Almacén Central'],
            ['numero' => 'ORD-000125', 'proyecto' => 'Proyecto Línea Producción'],
        ];
    }

    /* =========================
     | ORDEN
     ========================= */
    public function updatedOrdenSeleccionada($value)
    {
        $orden = collect($this->ordenes)->firstWhere('numero', $value);

        if ($orden) {
            $this->orden_compra_numero = $orden['numero'];
            $this->proyecto_nombre = $orden['proyecto'];
        }
    }

    /* =========================
     | PRODUCTOS (AUTOCOMPLETE)
     ========================= */
    public function getProductosFiltradosProperty()
    {
        if (strlen($this->buscarProductoRegistro) < 2) {
            return collect();
        }

        return Producto::where('estado', true)
            ->where(function ($q) {
                $q->where('nombre', 'like', "%{$this->buscarProductoRegistro}%")
                    ->orWhere('codigo', 'like', "%{$this->buscarProductoRegistro}%");
            })
            ->limit(8)
            ->get();
    }

    public function seleccionarProducto($id)
    {
        $this->productoSeleccionado = Producto::findOrFail($id);
        $this->producto_id = $id;
        $this->buscarProductoRegistro = '';
    }

    /* =========================
     | VALIDACIÓN
     ========================= */
    protected function rules()
    {
        return [
            'orden_compra_numero' => 'required',
            'proyecto_nombre' => 'required',
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'receptor_user_id' => 'required|exists:users,id',
        ];
    }

    /* =========================
     | REGISTRAR MOVIMIENTO
     ========================= */

    public function registrar()
    {
        $this->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'ordenSeleccionada' => 'required',
            'receptor_user_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () {

            $producto = Producto::lockForUpdate()->findOrFail($this->producto_id);

            $stockAnterior = $producto->stock;

            if ($this->tipo === 'salida' && $stockAnterior < $this->cantidad) {
                throw new \Exception('Stock insuficiente');
            }

            $stockResultante = $this->tipo === 'entrada'
                ? $stockAnterior + $this->cantidad
                : $stockAnterior - $this->cantidad;

            Movimiento::create([
                'producto_id' => $producto->id,
                'user_id' => $this->receptor_user_id,
                'tipo' => $this->tipo,
                'cantidad' => $this->cantidad,
                'stock_anterior' => $stockAnterior,
                'stock_resultante' => $stockResultante,
                'orden_compra_numero' => $this->orden_compra_numero,
                'proyecto_nombre' => $this->proyecto_nombre,
                'observacion' => $this->motivo,

                // 🔥 NUEVO
                'es_retornable' => $producto->tipo === 'retornable',
                'devuelto' => false,
                'fecha_devolucion' => null,
            ]);
            if (
                $this->tipo === 'salida' &&
                $producto->tipo === 'retornable'
            ) {
                RetornoPendiente::create([
                    'producto_id' => $producto->id,
                    'user_id' => $this->receptor_user_id,
                    'orden_compra_numero' => $this->orden_compra_numero,
                    'proyecto_nombre' => $this->proyecto_nombre,
                    'cantidad_entregada' => $this->cantidad,
                    'cantidad_pendiente' => $this->cantidad,
                ]);
            }

            if (
                $this->tipo === 'entrada' &&
                $producto->tipo === 'retornable'
            ) {
                $pendiente = RetornoPendiente::where('producto_id', $producto->id)
                    ->where('user_id', $this->receptor_user_id)
                    ->where('orden_compra_numero', $this->orden_compra_numero)
                    ->where('estado', 'pendiente')
                    ->orderBy('id')
                    ->first();

                if ($pendiente) {
                    $pendiente->cantidad_devuelta += $this->cantidad;
                    $pendiente->cantidad_pendiente =
                        $pendiente->cantidad_entregada - $pendiente->cantidad_devuelta;

                    if ($pendiente->cantidad_pendiente <= 0) {
                        $pendiente->estado = 'cerrado';
                        $pendiente->cantidad_pendiente = 0;
                    }

                    $pendiente->save();
                }
            }

            $producto->update([
                'stock' => $stockResultante
            ]);
        });

        $this->reset([
            'productoSeleccionado',
            'producto_id',
            'cantidad',
            'motivo',
            'buscarProductoRegistro'
        ]);

        $this->dispatch(
            'alert',
            ['type' => 'success', 'title' => 'Movimiento registrado', 'message' => 'Éxito']
        );
    }


    /* =========================
     | FILTROS
     ========================= */
    public function updating()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset(['buscarProductoTabla', 'filtroTipo', 'orden', 'proyecto']);
    }

    /* =========================
     | RENDER
     ========================= */
    public function render()
    {
        return view('livewire.movimientos.movimientos', [
            'usuarios' => User::select('id', 'name')->where('tipo','OPERADOR')->orderBy('name')->get(),
            'movimientos' => Movimiento::with(['producto', 'usuario'])
                ->when($this->buscarProductoTabla, function ($q) {
                    $q->whereHas(
                        'producto',
                        fn($p) =>
                        $p->where('nombre', 'like', "%{$this->buscarProductoTabla}%")
                    );
                })
                ->when(
                    $this->filtroTipo,
                    fn($q) =>
                    $q->where('tipo', $this->filtroTipo)
                )
                ->when(
                    $this->orden,
                    fn($q) =>
                    $q->where('orden_compra_numero', 'like', "%{$this->orden}%")
                )
                ->when(
                    $this->proyecto,
                    fn($q) =>
                    $q->where('proyecto_nombre', 'like', "%{$this->proyecto}%")
                )
                ->latest()
                ->paginate(10),
        ]);
    }
}
