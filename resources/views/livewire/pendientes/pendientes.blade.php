<div class="container " style="max-width: 1100px;">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-semibold mb-1">Retornables pendientes</h4>
        <small class="text-muted">
            Control de productos entregados que aún no han sido devueltos
        </small>
    </div>

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label small text-muted">Producto</label>
                    <input type="text" wire:model.live.300ms="buscarProducto"
                        class="form-control rounded-3 border-0 shadow-sm" placeholder="Buscar producto...">
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted">Orden</label>
                    <input type="text" wire:model.live.300ms="orden"
                        class="form-control rounded-3 border-0 shadow-sm" placeholder="ORD-000123">
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted">Nombre Proyecto</label>
                    <input type="text" wire:model.live.300ms="proyecto"
                        class="form-control rounded-3 border-0 shadow-sm" placeholder="Nombre del proyecto">
                </div>

                <div class="col-md-3">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" wire:model.live.300ms="filtroPrestamoLargo">

                        <label class="form-check-label small">
                            Mostrar préstamos largos
                        </label>
                    </div>
                </div>

                <div class="col-md-2 d-grid">
                    <button class="btn btn-light border rounded-3" wire:click="resetFiltros">
                        Limpiar
                    </button>
                </div>

            </div>

        </div>
    </div>



    {{-- TABLA --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr class="text-muted text-uppercase  small">
                            <th class="ps-4">Producto</th>
                            <th>Orden</th>
                            <th>Nombre Proyecto</th>
                            <th>Responsable</th>
                            <th>Fecha</th>
                            <th class="text-center">Pendiente</th>
                            <th class="pe-4 text-end">Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pendientes as $item)
                            <tr class="border-top">

                                {{-- PRODUCTO --}}
                                <td class="ps-4">
                                    <div class="fw-semibold">
                                        {{ $item->producto->nombre }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $item->producto->codigo }}
                                    </small>
                                </td>

                                {{-- ORDEN --}}
                                <td class="small">
                                    {{ $item->orden_compra_numero }}
                                </td>

                                {{-- PROYECTO --}}
                                <td class="small text-muted">
                                    {{ $item->proyecto_nombre }}
                                </td>

                                {{-- USUARIO --}}
                                <td>
                                    {{ $item->usuario->name }}
                                </td>
                                {{-- USUARIO --}}
                                <td>
                                    {{ DateUtil::getFechaHora($item->created_at) }}
                                </td>

                                {{-- PENDIENTE --}}
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        {{ $item->cantidad_pendiente }}
                                    </span>
                                </td>

                                {{-- BOTÓN --}}
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-dark rounded-3 px-3"
                                        wire:click="abrirModal({{ $item->id }})">
                                        Registrar
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    No hay retornos pendientes
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINACIÓN --}}
        <div class="p-3">
            {{ $pendientes->links() }}
        </div>
    </div>

    @if ($mostrarModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">

                    {{-- HEADER --}}
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Registrar retorno</h6>

                        <button class="btn btn-sm btn-light rounded-circle" wire:click="cerrarModal">
                            ✕
                        </button>
                    </div>

                    {{-- BODY --}}
                    <div class="p-3">

                        <small class="text-muted">Producto</small>
                        <div class="fw-semibold mb-3">
                            {{ $producto_nombre }}
                        </div>

                        <label class="form-label small text-muted">
                            Cantidad a devolver
                        </label>

                        <input type="number" class="form-control rounded-3 border-0 shadow-sm" min="1"
                            max="{{ $cantidad_pendiente }}" wire:model.defer="cantidad_devolver">

                        <small class="text-muted">
                            Pendiente: {{ $cantidad_pendiente }}
                        </small>

                    </div>

                    {{-- FOOTER --}}
                    <div class="p-3 border-top d-flex justify-content-end gap-2">

                        <button class="btn btn-light border rounded-3" wire:click="cerrarModal">
                            Cancelar
                        </button>

                        <button class="btn btn-dark rounded-3" wire:click="registrarRetorno">
                            Confirmar
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

</div>
