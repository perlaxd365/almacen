<?php

namespace App\Livewire\Reportes;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class Reportes extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /* =========================
     | FILTROS
     ========================= */
    public $producto = '';
    public $tipo = '';
    public $desde;
    public $hasta;
    public $proyecto;
    public $orden_compra;

    /* =========================
     | RESET PAGINACIÓN
     ========================= */
    public function updating()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset(['producto', 'tipo', 'desde', 'hasta']);
    }

    /* =========================
     | QUERY BASE (REUTILIZABLE)
     ========================= */
   protected function queryMovimientos()
{
    return Movimiento::with(['producto', 'usuario'])
        ->when($this->producto, function ($q) {
            $q->whereHas('producto', fn ($p) =>
                $p->where('nombre', 'like', "%{$this->producto}%")
            );
        })
        ->when($this->tipo, fn ($q) =>
            $q->where('tipo', $this->tipo)
        )
        ->when($this->proyecto, fn ($q) =>
            $q->where('proyecto_nombre', 'like', "%{$this->proyecto}%")
        )
        ->when($this->orden_compra, fn ($q) =>
            $q->where('orden_compra_numero', 'like', "%{$this->orden_compra}%")
        )
        ->when($this->desde, fn ($q) =>
            $q->whereDate('created_at', '>=', $this->desde)
        )
        ->when($this->hasta, fn ($q) =>
            $q->whereDate('created_at', '<=', $this->hasta)
        )
        ->latest();
}

    /* =========================
     | EXPORTAR PDF
     ========================= */
    public function exportarPdf()
    {
        $movimientos = $this->queryMovimientos()->get();

        $pdf = Pdf::loadView('reportes.movimientos-pdf', compact('movimientos'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'reporte-movimientos.pdf'
        );
    }

    /* =========================
     | RENDER
     ========================= */
    public function render()
    {
        return view('livewire.reportes.reportes', [
            'movimientos' => $this->queryMovimientos()->paginate(12)
        ]);
    }
}
