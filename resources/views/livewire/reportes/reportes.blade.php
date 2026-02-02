<div class="container-fluid py-3">

    {{-- ================= HEADER ================= --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0">📊 Reporte de Movimientos</h5>
                <small class="text-muted">
                    Entradas y salidas de almacén por producto, proyecto y fecha
                </small>
            </div>

            <button class="btn btn-sm btn-danger" wire:click="exportarPdf">
                <i class="fas fa-file-pdf me-1"></i> Exportar PDF
            </button>
        </div>
    </div>

    {{-- ================= FILTROS ================= --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                {{-- PRODUCTO --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Producto</label>
                    <input type="text" class="form-control form-control-sm" wire:model.live.300ms="producto"
                        placeholder="Nombre del producto">
                </div>

                {{-- ORDEN DE COMPRA --}}
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small">Orden</label>
                    <input type="text" class="form-control form-control-sm" wire:model.live.300ms="orden_compra"
                        placeholder="ORD-000123">
                </div>

                {{-- PROYECTO --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Proyecto</label>
                    <input type="text" class="form-control form-control-sm" wire:model.live.300ms="proyecto"
                        placeholder="Nombre del proyecto">
                </div>

                {{-- TIPO --}}
                <div class="col-lg-2 col-md-4">
                    <label class="form-label fw-semibold small">Tipo</label>
                    <select class="form-control form-control-sm" wire:model.live.300ms="tipo">
                        <option value="">Todos</option>
                        <option value="entrada">Entrada</option>
                        <option value="salida">Salida</option>
                    </select>
                </div>

                {{-- DESDE --}}
                <div class="col-lg-1 col-md-4">
                    <label class="form-label fw-semibold small">Desde</label>
                    <input type="date" class="form-control form-control-sm" wire:model.live.300ms="desde">
                </div>

                {{-- HASTA --}}
                <div class="col-lg-1 col-md-4">
                    <label class="form-label fw-semibold small">Hasta</label>
                    <input type="date" class="form-control form-control-sm" wire:model.live.300ms="hasta">
                </div>

                {{-- LIMPIAR --}}
                <div class="col-12 text-end">
                    <button class="btn btn-sm btn-outline-secondary mt-2" wire:click="resetFiltros">
                        Limpiar filtros
                    </button>
                </div>

            </div>


        </div>
    </div>

    {{-- ================= TABLA ================= --}}
    <div class="card border-0 shadow">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-light text-uppercase small">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th class="text-center">Cantidad</th>
                        <th>Proyecto</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($movimientos as $m)
                        <tr>
                            <td class="text-muted">
                                {{ $m->created_at->format('d/m/Y') }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $m->producto->nombre }}
                                </div>
                                <small class="text-muted">
                                    {{ $m->producto->codigo }}
                                </small>
                            </td>

                            <td>
                                <span
                                    class="badge rounded-pill
                                    bg-{{ $m->tipo === 'entrada' ? 'success' : 'danger' }}">
                                    {{ strtoupper($m->tipo) }}
                                </span>
                            </td>

                            <td class="text-center fw-semibold">
                                {{ $m->cantidad }}
                            </td>

                            <td>{{ $m->proyecto_nombre }}</td>

                            <td>{{ $m->usuario->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No se encontraron registros
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ================= FOOTER ================= --}}
        <div class="card-footer bg-white py-2 d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Total: {{ $movimientos->total() }} registros
            </small>
            {{ $movimientos->links() }}
        </div>
    </div>

</div>
