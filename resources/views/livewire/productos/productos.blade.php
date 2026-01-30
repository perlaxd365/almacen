<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10 col-md-11">

            <div class="card shadow-lg border-0 rounded-lg">

                {{-- HEADER --}}
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <span class="badge badge-primary p-3 rounded-circle">
                                <i class="fas fa-box fa-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0 text-dark font-weight-bold">
                                Registro de Producto
                            </h4>
                            <small class="text-muted">
                                Sistema de almacén – Semmar Manufacturing
                            </small>
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <hr class="my-3">

                {{-- BODY --}}
                <div class="card-body pt-2">

                    <div class="row">

                        <div class="col-md-3">
                            <label class="text-muted font-weight-semibold">Código</label>
                            <input wire:model.defer="codigo" readonly type="text"
                                class="form-control form-control-lg" placeholder="TUB-001">
                            @error('codigo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label class="text-muted font-weight-semibold">Nombre del producto</label>
                            <input wire:model.defer="nombre" type="text" class="form-control form-control-lg"
                                placeholder="Tubo estructural 2x2">
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label class="text-muted font-weight-semibold">Tipo</label>
                            <select wire:model.defer="tipo" class="form-control form-control-lg">
                                <option value="consumible">Consumible</option>
                                <option value="retornable">Retornable</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="text-muted font-weight-semibold">Unidad</label>
                            <input wire:model.defer="unidad" type="text" class="form-control form-control-lg"
                                placeholder="kg / m / und">
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-md-3">
                            <label class="text-muted font-weight-semibold">Stock mínimo</label>
                            <input wire:model.defer="stock_minimo" type="number" class="form-control form-control-lg"
                                min="0">
                        </div>

                        <div class="col-md-9 d-flex align-items-end justify-content-end">
                            <button wire:click="guardar" wire:loading.attr="disabled"
                                class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save mr-2"></i>
                                Guardar producto
                            </button>
                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer bg-white text-right text-muted small">
                    Gestión interna de almacén · Semmar Manufacturing
                </div>

            </div>

        </div>
    </div>



    <div class="row justify-content-center mt-4">
        <div class="col-xl-9 col-lg-10 col-md-11">

            <div class="card shadow-lg border-0 rounded-lg">

                {{-- HEADER --}}
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="mb-0 text-dark font-weight-bold">
                                <i class="fas fa-list mr-2 text-secondary"></i>
                                Lista de Productos
                            </h5>
                            <small class="text-muted">
                                Materiales y herramientas registrados
                            </small>
                        </div>

                        {{-- FILTRO --}}
                        <div class="w-25">
                            <input type="text" wire:model.live.300ms="buscar" class="form-control form-control-sm"
                                placeholder="Buscar producto...">
                        </div>

                    </div>
                </div>

                {{-- DIVIDER --}}
                <hr class="my-3">

                {{-- BODY --}}
                <div class="card-body pt-2">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Unidad</th>
                                    <th class="text-right">Stock mín.</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($productos as $item)
                                    <tr>
                                        <td class="font-weight-bold">{{ $item->codigo }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $item->tipo == 'consumible' ? 'info' : 'warning' }}">
                                                {{ ucfirst($item->tipo) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->unidad }}</td>
                                        <td class="text-right">{{ $item->stock_minimo }}</td>
                                        <td class="text-center">
                                            @if ($item->estado)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="editar({{ $item->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No hay productos registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Mostrando {{ $productos->firstItem() }} - {{ $productos->lastItem() }}
                            de {{ $productos->total() }} productos
                        </small>

                        {{ $productos->links() }}
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer bg-white text-muted small">
                    Total de productos: <strong>{{ $productos->count() }}</strong>
                </div>

            </div>
        </div>
    </div>



    <div wire:ignore.self class="modal fade" id="modalEditarProducto" tabindex="-1" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-lg shadow">

                <div class="modal-header bg-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-box-open mr-2 text-primary"></i>
                        Editar Producto
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" wire:click="resetForm">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label>Código</label>
                            <input type="text" class="form-control" wire:model="codigo">
                        </div>

                        <div class="form-group col-md-8">
                            <label>Nombre</label>
                            <input type="text" class="form-control" wire:model="nombre">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Tipo</label>
                            <select class="form-control" wire:model="tipo">
                                <option value="consumible">Consumible</option>
                                <option value="retornable">Retornable</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Unidad</label>
                            <input type="text" class="form-control" wire:model="unidad">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Stock mínimo</label>
                            <input type="number" class="form-control" wire:model="stock_minimo">
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" wire:model="estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" wire:click="resetForm" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button class="btn btn-primary" wire:click="actualizar">
                        <i class="fas fa-save mr-1"></i> Guardar cambios
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script>
        window.addEventListener('abrir-modal-editar', () => {
            $('#modalEditarProducto').modal('show');
        });

        window.addEventListener('cerrar-modal-editar', () => {
            $('#modalEditarProducto').modal('hide');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modal = document.getElementById('modalEditarProducto');

            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    Livewire.dispatch('resetForm');
                });
            }

        });
    </script>
</div>
