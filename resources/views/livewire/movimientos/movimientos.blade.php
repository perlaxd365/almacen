<div class="container-fluid py-4">

    <div class="container-fluid py-4">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-box-open text-primary me-2"></i>
                    Registro de movimiento
                </h5>
                <small class="text-muted">Entradas y salidas por orden de compra</small>
            </div>

            <div class="card-body">
                {{-- ================= FILA 1 ================= --}}
                <div class="row g-4 mb-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Orden / Proyecto</label>
                        <select wire:model="ordenSeleccionada" class="form-control">
                            <option value="">Seleccione orden</option>
                            @foreach ($ordenes as $orden)
                                <option value="{{ $orden['numero'] }}">
                                    {{ $orden['numero'] }} — {{ $orden['proyecto'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('ordenSeleccionada')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="col-md-6 position-relative">
                        <label class="form-label fw-semibold">Buscar producto</label>
                        <input type="text" wire:model.live="buscarProductoRegistro" class="form-control"
                            placeholder="Código o nombre">
                        @error('producto_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if ($buscarProductoRegistro)
                            <div class="list-group position-absolute w-100 shadow mt-1" style="z-index:1000">
                                @foreach ($this->productosFiltrados as $prod)
                                    <button type="button" class="list-group-item list-group-item-action"
                                        wire:click="seleccionarProducto({{ $prod->id }})">
                                        <strong>{{ $prod->codigo }}</strong> — {{ $prod->nombre }}
                                        <span class="float-end text-muted">
                                            Stock: {{ $prod->stock }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                {{-- ================= PRODUCTO SELECCIONADO ================= --}}
                @if ($productoSeleccionado)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">

                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-cube fa-2x text-primary"></i>
                                        </div>
                                        <div class="pl-2">
                                            <h6 class="mb-0 fw-bold">
                                                {{ $productoSeleccionado->nombre }}
                                            </h6>
                                            <small class="text-muted">
                                                Código: {{ $productoSeleccionado->codigo }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <small class="text-muted d-block">Stock actual</small>

                                        @php $stock = $productoSeleccionado->stock; @endphp
                                        <span
                                            class="badge fs-6
                                        {{ $stock <= 0 ? 'bg-danger' : ($stock <= 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                                            {{ $stock }} unidades
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ================= DATOS DEL MOVIMIENTO ================= --}}
                <div class="row g-4">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tipo</label>
                        <select wire:model="tipo" class="form-control">
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                        </select>
                        @error('tipo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Cantidad</label>
                        <input type="number" min="1" wire:model.defer="cantidad" class="form-control">
                        @error('cantidad')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Persona que recibe</label>
                        <select wire:model.defer="receptor_user_id" class="form-control">
                            <option value="">Seleccione usuario</option>
                            @foreach ($usuarios as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('receptor_user_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Motivo / Observación</label>
                        <input type="text" wire:model.defer="motivo" class="form-control"
                            placeholder="Compra, consumo, ajuste">
                        @error('motivo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer bg-white text-end">
                <button wire:click="registrar" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>
                    Registrar movimiento
                </button>
            </div>
        </div>

    </div>

    {{-- =========================
        LISTADO DE MOVIMIENTOS
    ========================== --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">📊 Movimientos de almacén</h5>
            <small class="text-muted">Historial tipo Kardex</small>
        </div>

        {{-- FILTROS --}}
        <div class="card-body border-bottom">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" wire:model.live.300ms="buscarProductoTabla" class="form-control"
                        placeholder="Producto">
                </div>

                <div class="col-md-2">
                    <select wire:model.live.300ms="filtroTipo" class="form-control">
                        <option value="">Todos</option>
                        <option value="entrada">Entrada</option>
                        <option value="salida">Salida</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="text" wire:model.live.300ms="orden" class="form-control" placeholder="Orden">
                </div>

                <div class="col-md-3">
                    <input type="text" wire:model.live.300ms="proyecto" class="form-control" placeholder="Proyecto">
                </div>

                <div class="col-md-2">
                    <button wire:click="resetFiltros" class="btn btn-outline-secondary w-100">
                        Limpiar
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Stock antes</th>
                        <th class="text-end">Stock después</th>
                        <th>Orden</th>
                        <th>Proyecto</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movimientos as $mov)
                        <tr>
                            <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $mov->producto->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $mov->tipo == 'entrada' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($mov->tipo) }}
                                </span>
                            </td>
                            <td class="text-end">{{ $mov->cantidad }}</td>
                            <td class="text-end">{{ $mov->stock_anterior }}</td>
                            <td class="text-end">{{ $mov->stock_resultante }}</td>
                            <td>{{ $mov->orden_compra_numero }}</td>
                            <td>{{ $mov->proyecto_nombre }}</td>
                            <td>{{ $mov->usuario->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No hay movimientos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
