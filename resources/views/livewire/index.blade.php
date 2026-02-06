<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <style>
     

        .welcome-left h1 {
            font-weight: 700;
            font-size: 2.6rem;
        }

        .welcome-left p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 18px;
        }

        .feature-item i {
            font-size: 1.8rem;
            color: #ffd369;
        }

        .welcome-right {
            padding: 50px;
        }

        .welcome-right h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-card {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card i {
            font-size: 2.2rem;
            color: #0d6efd;
        }

        .btn-start {
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
        }

        footer {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 30px;
        }
    </style>
    </head>

    <body>

        <div class="welcome-card row g-0">
            <!-- Lado izquierdo -->
            <div class="col-lg-5 welcome-left d-flex flex-column justify-content-center">
                <h1>Bienvenido al Sistema de Almacén</h1>
                <p class="mt-3">
                    Plataforma integral para el control, gestión y trazabilidad de productos, entradas y salidas.
                </p>

                <div class="mt-4">
                    <div class="feature-item">
                        <i class="bi bi-box-seam"></i>
                        <span>Control total de inventarios</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Gestión de entradas y salidas</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-clipboard-data"></i>
                        <span>Reportes y trazabilidad</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Información segura y confiable</span>
                    </div>
                </div>
            </div>

            <!-- Lado derecho -->
            <div class="col-lg-7 welcome-right">
                <h2>Panel de Control</h2>
                <p class="text-muted mb-4">
                    Accede rápidamente a la información clave del almacén.
                </p>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-boxes"></i>
                            <h5 class="mt-3 mb-1">Productos</h5>
                            <p class="text-muted mb-0">Gestión centralizada</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-truck"></i>
                            <h5 class="mt-3 mb-1">Movimientos</h5>
                            <p class="text-muted mb-0">Entradas / Salidas</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-bar-chart-line"></i>
                            <h5 class="mt-3 mb-1">Reportes</h5>
                            <p class="text-muted mb-0">Datos en tiempo real</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-primary btn-start">
                        <i class="bi bi-speedometer2 me-2"></i> Ir al Dashboard
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-start">
                        <i class="bi bi-question-circle me-2"></i> Ayuda
                    </a>
                </div>

                <footer>
                    <hr>
                    © 2026 Sistema de Almacén · Todos los derechos reservados
                </footer>
            </div>
        </div>
    </body>
</div>
