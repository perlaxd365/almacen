<div>
    <div class="container-fluid py-4">

        {{-- ================= HEADER ================= --}}
        <div class="mb-4">
            <h4 class="mb-1 fw-bold">
                🔁 Retornables pendientes
            </h4>
            <small class="text-muted">
                Productos retornables entregados que aún no han sido devueltos
            </small>
        </div>

        {{-- ================= FILTROS ================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label text-muted">Producto</label>
                        <input type="text" class="form-control" wire:model.live.300ms="buscarProducto"
                            placeholder="Buscar producto">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted">Orden</label>
                        <input type="text" class="form-control" wire:model.live.300ms="orden"
                            placeholder="ORD-000123">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted">Proyecto</label>
                        <input type="text" class="form-control" wire:model.live.300ms="proyecto"
                            placeholder="Nombre del proyecto">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100" wire:click="resetFiltros">
                            Limpiar
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= TABLA ================= --}}
        <div class="card shadow-lg border-0">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Orden</th>
                                <th>Proyecto</th>
                                <th>Responsable</th>
                                <th class="text-center">Salidas</th>
                                <th class="text-center">Pendiente</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pendientes as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->producto->nombre }}</strong><br>
                                        <small class="text-muted">{{ $item->producto->codigo }}</small>
                                    </td>

                                    <td>{{ $item->orden_compra_numero }}</td>
                                    <td>{{ $item->proyecto_nombre }}</td>
                                    <td>{{ $item->usuario->name }}</td>

                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark fs-6">
                                            {{ $item->cantidad_pendiente }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <button class="btn btn-sm btn-success"
                                            wire:click="abrirModal({{ $item->id }})">
                                            ↩ Registrar retorno
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>

            {{-- ================= FOOTER ================= --}}
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $pendientes->firstItem() }} - {{ $pendientes->lastItem() }}
                    de {{ $pendientes->total() }} registros
                </small>

                {{ $pendientes->links() }}
            </div>
        </div>

    </div>
    @if ($mostrarModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Registrar retorno</h5>
                        <button type="button" class="btn-close" wire:click="cerrarModal"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-1"><strong>Producto:</strong></p>
                        <p class="text-muted">{{ $producto_nombre }}</p>

                        <label class="form-label">Cantidad a devolver</label>
                        <input type="number" class="form-control" min="1" max="{{ $cantidad_pendiente }}"
                            wire:model.defer="cantidad_devolver">
                        <small class="text-muted">
                            Pendiente: {{ $cantidad_pendiente }}
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="cerrarModal">
                            Cancelar
                        </button>

                        <button class="btn btn-success" wire:click="registrarRetorno">
                            Confirmar retorno
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

</div>
