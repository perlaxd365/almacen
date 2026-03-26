<div class="container-fluid">

    <div class="container-fluid py-3">

        {{-- REGISTRO --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 font-weight-semibold text-dark">
                    Registro de producto
                </h5>
                <small class="text-muted">Sistema de almacén · Semmar Manufacturing</small>
            </div>

            <div class="card-body">

                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label text-muted">CÓDIGO</label>
                        <input wire:model.defer="codigo" type="text" readonly
                            class="form-control form-control-sm bg-light">

                        @error('codigo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted">PRODUCTO</label>
                        <input wire:model.defer="nombre" type="text" class="form-control form-control-sm"
                            placeholder="Tubo estructural 2x2">

                        @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label text-muted">TIPO</label>
                        <select wire:model.defer="tipo" class="form-control form-control-sm">
                            <option value="consumible">Consumible</option>
                            <option value="retornable">Equipos/Herramientas</option>
                        </select>

                    </div>

                    <div class="col-md-2">
                        <label class="form-label text-muted">UNIDAD</label>
                        <select wire:model.defer="unidad" class="form-control form-control-sm">
                            <option value="">Seleccionar</option>
                            <option value="unidad">Unidad</option>
                            <option value="kg">KG</option>
                        </select>

                        @error('unidad')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label text-muted">STOCK</label>
                        <input wire:model.defer="stock" type="number" min="0"
                            class="form-control form-control-sm">
                    </div>
                </div>

            </div>

            <div class="card-footer bg-white text-end">
                <button wire:click="guardar" wire:loading.attr="disabled" class="btn btn-primary btn-sm px-4">
                    Guardar producto
                </button>
            </div>
        </div>




        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 font-weight-semibold">Productos registrados</h6>
                    <small class="text-muted">Materiales y herramientas</small>
                </div>

                <input type="text" wire:model.live.300ms="buscar" class="form-control form-control-sm w-25"
                    placeholder="Buscar...">
            </div>

            <div class="card-body p-0">

                <style>
                    .bg-yellow {
                        background-color: #ffc107;
                        color: #000;
                    }
                </style>

                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light text-uppercase fw-bold">
                            <tr class="text-muted">
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Unidad</th>
                                <th class="text-end">Stock</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($productos as $item)
                                @php
                                    // 🔥 LÓGICA DE COLORES
                                    $stock = $item->stock;

                                    if ($stock <= 5) {
                                        $colorStock = 'danger'; // rojo
                                    } elseif ($stock <= 10) {
                                        $colorStock = 'warning'; // naranja
                                    } elseif ($stock <= 20) {
                                        $colorStock = 'yellow'; // amarillo
                                    } else {
                                        $colorStock = 'success'; // normal
                                    }
                                @endphp

                                <tr>
                                    <td class="fw-semibold">{{ $item->codigo }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td class="text-capitalize">{{ $item->tipo }}</td>
                                    <td>{{ $item->unidad }}</td>

                                    <!-- 🔥 STOCK CON COLOR -->
                                    <td class="text-end">
                                        <span class="badge bg-{{ $colorStock }}">
                                            {{ $stock }}
                                        </span>
                                    </td>

                                    <!-- ESTADO -->
                                    <td class="text-center">
                                        <span class="badge bg-{{ $item->estado ? 'success' : 'danger' }}">
                                            {{ $item->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    <!-- ACCIONES -->
                                    <td class="text-center">
                                        <button class="btn btn-outline-secondary btn-xs"
                                            wire:click="editar({{ $item->id }})">
                                            Editar
                                        </button>

                                        @if ($item->estado)
                                            <button class="btn btn-outline-danger btn-xs"
                                                wire:click="confirmarEliminar({{ $item->id }})">
                                                Eliminar
                                            </button>
                                        @else
                                            <button class="btn btn-outline-info btn-xs"
                                                wire:click="habilitarProducto({{ $item->id }})">
                                                Habilitar
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Sin productos registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    {{ $productos->firstItem() }} - {{ $productos->lastItem() }}
                    de {{ $productos->total() }} registros
                </small>

                {{ $productos->links() }}
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
                            <label>CÓDIGO</label>
                            <input type="text" class="form-control" wire:model="codigo">
                        </div>

                        <div class="form-group col-md-8">
                            <label>NOMBRE</label>
                            <input type="text" class="form-control" wire:model="nombre">
                        </div>

                        <div class="form-group col-md-4">
                            <label>TIPO</label>
                            <select class="form-control" wire:model="tipo">
                                <option value="consumible">Consumible</option>
                                <option value="retornable">Equipos/Herramientas</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>UNIDAD</label>
                            <select wire:model.defer="unidad" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="unidad">Unidad</option>
                                <option value="kg">KG</option>
                            </select>

                            @error('unidad')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>STOCK</label>
                            <input type="number" class="form-control" wire:model="stock">
                        </div>

                    </div>

                    <div class="form-group">
                        <label>ESTADO</label>
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

    <script>
        window.addEventListener('confirmar-eliminacion', event => {
            Swal.fire({
                title: '¿Eliminar producto?',
                text: 'El producto quedará inactivo en el sistema',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('eliminarProducto', event.detail.id)
                }
            })
        })
    </script>

</div>
