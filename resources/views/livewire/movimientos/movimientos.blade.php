<div>
    <div class="container py-5" style="max-width: 1100px;">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">📦 Control de Almacén</h4>
                <small class="text-muted">Kardex + herramientas</small>
            </div>

            <button wire:click="registrar" class="btn btn-dark px-4 rounded-3">
                Registrar
            </button>
        </div>

        {{-- CARD --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                {{-- FILA PRINCIPAL --}}
                <div class="row g-3 align-items-end">

                    {{-- BUSCADOR --}}
                    <div class="col-md-6 position-relative">
                        <label class="form-label small text-muted">Producto</label>

                        <input type="text" wire:model.live="buscarProductoRegistro"
                            class="form-control form-control-lg rounded-3 border-0 shadow-sm"
                            placeholder="Buscar producto...">

                        {{-- AUTOCOMPLETE --}}
                        @if ($buscarProductoRegistro)
                            <div class="list-group position-absolute w-100 mt-1 shadow-sm"
                                style="z-index:1000; border-radius:12px; overflow:hidden;">
                                @foreach ($this->productosFiltrados as $prod)
                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex justify-content-between"
                                        wire:click="seleccionarProducto({{ $prod->id }})">

                                        <span>
                                            <strong>{{ $prod->codigo }}</strong> — {{ $prod->nombre }}
                                        </span>

                                        <small class="text-muted">Stock: {{ $prod->stock }}</small>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- TIPO --}}
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Tipo</label>

                        <select wire:model.live="tipo"
                            class="form-control form-control-lg rounded-3 border-0 shadow-sm">
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                        </select>
                    </div>

                    {{-- CANTIDAD --}}
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Cantidad</label>

                        <input type="number" wire:model.defer="cantidad"
                            class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="0">
                    </div>

                    {{-- BOTÓN --}}
                    <div class="col-md-2">
                        <button wire:click="agregarItem" class="btn btn-dark w-100 rounded-3 h-100">
                            + Agregar
                        </button>
                    </div>

                </div>

                {{-- PRODUCTO SELECCIONADO --}}
                @if ($productoSeleccionado)
                    <div class="mt-4 p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">

                        <div>
                            <div class="fw-semibold">{{ $productoSeleccionado->nombre }}</div>
                            <small class="text-muted">{{ $productoSeleccionado->codigo }}</small>
                        </div>

                        <span class="badge bg-white border px-3 py-2">
                            Stock: {{ $productoSeleccionado->stock }}
                        </span>

                    </div>
                @endif

                {{-- LISTA --}}
                @if (count($items))
                    <div class="mt-4">

                        <div class="text-muted small mb-2">Productos agregados</div>

                        <div class="border rounded-4 overflow-hidden bg-white">

                            @foreach ($items as $index => $item)
                                <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">

                                    <div>
                                        <div class="fw-semibold">{{ $item['producto']->nombre }}</div>
                                        <small class="text-muted">{{ $item['producto']->codigo }}</small>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-light text-dark px-3 py-2">
                                            x{{ $item['cantidad'] }}
                                        </span>

                                        <button wire:click="removeItem({{ $index }})"
                                            class="btn btn-sm btn-light border rounded-circle">
                                            ✕
                                        </button>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif

                {{-- EXTRA --}}
                <div class="row g-3 mt-4">

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Trabajador</label>
                        <select wire:model.defer="receptor_user_id" class="form-control rounded-3 border-0 shadow-sm">
                            <option value="">Seleccionar</option>
                            @foreach ($usuarios as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Orden</label>
                        <select wire:model="ordenSeleccionada" class="form-control rounded-3 border-0 shadow-sm">
                            <option value="">Seleccionar</option>
                            @foreach ($ordenes as $orden)
                                <option value="{{ $orden['numero'] }}">
                                    {{ $orden['numero'] }} — {{ $orden['proyecto'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Observación</label>
                        <input type="text" wire:model.defer="motivo"
                            class="form-control rounded-3 border-0 shadow-sm">
                    </div>

                    @if ($tipo === 'salida')
                        <div class="col-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" wire:model="es_prestamo_largo">
                                <label class="form-check-label">
                                    Préstamo largo (herramienta)
                                </label>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

    <div class="container pb-5" style="max-width: 1100px;">

        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr class="text-muted small">
                                <th class="ps-4">Fecha</th>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th class="text-end">Cant.</th>
                                <th class="text-end">Stock</th>
                                <th>Orden</th>
                                <th class="pe-4">Usuario</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($movimientos as $mov)
                                <tr class="border-top">

                                    <td class="ps-4 small text-muted">
                                        {{ $mov->created_at->format('d/m/Y') }}<br>
                                        <span class="text-secondary">
                                            {{ $mov->created_at->format('H:i') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $mov->producto->nombre ?? '-' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $mov->producto->codigo ?? '' }}
                                        </small>
                                    </td>

                                    <td class="">
                                        <span class="badge bg-light border text-dark">
                                            {{ ucfirst($mov->tipo) }}
                                        </span>
                                        <br>
                                        @if ($mov->es_prestamo_largo)
                                            <span class="badge bg-primary">
                                                Prestamo a largo plazo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end fw-semibold">
                                        {{ $mov->cantidad }}
                                    </td>

                                    <td class="text-end">
                                        <small class="text-muted">
                                            {{ $mov->stock_anterior }}
                                        </small>
                                        →
                                        <span class="fw-semibold">
                                            {{ $mov->stock_resultante }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="small">
                                            {{ $mov->orden_compra_numero }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $mov->proyecto_nombre }}
                                        </small>
                                    </td>
                                    <td class="pe-4">
                                        {{ $mov->usuario->name ?? '-' }}
                                        <br>
                                        @if ($mov->observacion)
                                            <small class="text-muted">Observación: {{ $mov->observacion }}</small>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        Sin movimientos
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-3 px-2">
            {{ $movimientos->links() }}
        </div>

    </div>

</div>
