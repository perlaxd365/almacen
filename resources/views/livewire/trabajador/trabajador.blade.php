<div>

    <div class="container" style="max-width: 1100px;">

        {{-- HEADER --}}
        <div class="mb-4">
            <h4 class="fw-semibold mb-1">Trabajadores</h4>
            <small class="text-muted">
                Gestión de usuarios del sistema
            </small>
        </div>

        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">

                <div class="row g-3">

                    <div class="col-md-4">
                        <input type="text" wire:model.live="buscar" class="form-control rounded-3 border-0 shadow-sm"
                            placeholder="Buscar trabajador...">
                    </div>

                    <div class="col-md-3">
                        <select wire:model.live="tipo" class="form-control rounded-3 border-0 shadow-sm">
                            <option value="">Tipo</option>
                            <option>ADMINISTRADOR</option>
                            <option>OPERADOR</option>
                            <option>ALMACENERO</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select wire:model.live="estado" class="form-control rounded-3 border-0 shadow-sm">
                            <option value="">Estado</option>
                            <option>ACTIVO</option>
                            <option>INACTIVO</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-dark rounded-3" wire:click="crear">
                            + Nuevo
                        </button>
                    </div>

                </div>

            </div>
        </div>

        {{-- TABLA --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nombre</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($trabajadores as $t)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $t->name }}</td>
                                <td>{{ $t->dni }}</td>
                                <td>{{ $t->telefono }}</td>
                                <td>{{ $t->tipo }}</td>

                                <td>
                                    <span class="badge bg-{{ $t->estado == 'ACTIVO' ? 'success' : 'secondary' }}">
                                        {{ $t->estado }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light" wire:click="editar({{ $t->id }})">
                                        Editar
                                    </button>

                                    <button class="btn btn-sm btn-danger" wire:click="eliminar({{ $t->id }})">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No hay trabajadores
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

            <div class="p-3">
                {{ $trabajadores->links() }}
            </div>
        </div>

        {{-- MODAL --}}
        @if ($modal)
            <div class="modal fade show d-block">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content p-3">

                        <h6 class="fw-semibold mb-3">
                            {{ $user_id ? 'Editar' : 'Nuevo' }} trabajador
                        </h6>

                        <input class="form-control mb-2" wire:model="name" placeholder="Nombre">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control mb-2" wire:model="email" placeholder="Email">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control mb-2" wire:model="dni" placeholder="DNI">

                        @error('dni')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control mb-2" wire:model="telefono" placeholder="Teléfono">

                        @error('telefono')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control mb-2" wire:model="password" placeholder="Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <select class="form-control mb-2" wire:model="tipo_form">
                            <option>ADMINISTRADOR</option>
                            <option>OPERADOR</option>
                            <option>ALMACENERO</option>
                        </select>
                        @error('tipo_form')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <select class="form-control mb-3" wire:model="estado_form">
                            <option>ACTIVO</option>
                            <option>INACTIVO</option>
                        </select>

                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-light" wire:click="cerrarModal">Cancelar</button>
                            <button class="btn btn-dark" wire:click="guardar">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif

    </div>
</div>
