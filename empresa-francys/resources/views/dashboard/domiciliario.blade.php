<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrancysT - Domiciliario</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #ffffff; color: #333; }

        /* NAVBAR SUPERIOR NEGRA CORPORATIVA */
        header { 
            background-color: #000000; 
            color: white; 
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .logo-area h1 { font-size: 1.6rem; font-weight: bold; letter-spacing: 0.5px; }
        .logo-area span { color: #f59e0b; }
        
        nav ul { list-style: none; display: flex; gap: 25px; align-items: center; }
        nav ul li a { color: #ffffff; text-decoration: none; font-size: 0.95rem; transition: color 0.2s; }
        nav ul li a:hover { color: #f59e0b; }
        
        .user-profile { display: flex; align-items: center; gap: 8px; font-size: 0.95rem; color: #f1f5f9; }
        .btn-logout-inline { background: none; border: none; color: #ef4444; cursor: pointer; font-weight: bold; font-size: 0.95rem; margin-left: 10px; }

        /* CONTENIDO PRINCIPAL */
        .main-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* ACCIONES SUPERIORES (Botón volver y Título) */
        .top-actions { display: flex; align-items: center; gap: 20px; margin-bottom: 45px; }
        .btn-back { 
            background: #f3f4f6; 
            border: 1px solid #cbd5e1; 
            padding: 8px 16px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 0.9rem;
            font-weight: 500;
            color: #475569;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #e2e8f0; color: #1e293b; }
        .title-role { font-size: 2rem; font-weight: 700; color: #0f172a; }

        /* CUADRÍCULA DE TARJETAS (4 Columnas exactas del Wireframe) */
        .grid-framework { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 50px 35px; 
        }

        /* Adaptabilidad para pantallas medianas y pequeñas */
        @media (max-width: 1024px) { .grid-framework { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .grid-framework { grid-template-columns: 1fr; } }

        /* DISEÑO DE CADA MÓDULO */
        .card-item { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            text-align: center; 
            background: #ffffff;
            border: 1px solid transparent;
            padding: 10px;
            border-radius: 8px;
        }
        .card-item img { width: 60px; height: 60px; object-fit: contain; margin-bottom: 16px; }
        .card-item p { font-size: 0.95rem; color: #1e293b; margin-bottom: 14px; font-weight: 500; line-height: 1.4; min-height: 40px; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .card-item small { display: block; color: #64748b; font-size: 0.8rem; margin-top: 4px; font-weight: 400; }
        
        /* BOTONES NARANJAS CORPORATIVOS */
        .btn-orange { 
            background-color: #d97706; 
            color: white; 
            border: none; 
            padding: 9px 20px; 
            border-radius: 6px; 
            font-size: 0.85rem; 
            font-weight: bold; 
            cursor: pointer; 
            width: 100%;
            max-width: 170px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(217, 119, 6, 0.2);
        }
        .btn-orange:hover { background-color: #b45309; }
        .btn-orange:active { transform: scale(0.97); }

        /* Estilo especial cuando una tarea o estado cambia exitosamente */
        .btn-disabled { background-color: #cbd5e1 !important; color: #64748b !important; cursor: not-allowed !important; box-shadow: none !important; }

        /* COMPONENTES DE FORMULARIO DENTRO DE LAS TARJETAS */
        .card-input, .card-select {
            width: 100%;
            max-width: 170px;
            padding: 7px 10px;
            margin-bottom: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.85rem;
            text-align: center;
            background-color: #f8fafc;
            color: #334155;
            outline: none;
        }
        .card-input:focus, .card-select:focus { border-color: #d97706; background-color: #fff; }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">
            <h1>Francys<span>T</span></h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Precios</a></li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="#">Soporte</a></li>
                <li class="user-profile">
                    <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" width="18" style="filter: invert(1);">
                    Hola, {{ auth()->user()->name }}
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout-inline">Salir</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <div class="top-actions">
            <button class="btn-back" onclick="alert('Regresando al mapa general de rutas...')">‹ Volver a Mapa</button>
            <h2 class="title-role">Panel de Control: Domiciliario</h2>
        </div>

        <div class="grid-framework">
            
            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/854/854878.png" alt="Mapa u optimización de rutas">
                <p>Ver ruta de entregas asignadas</p>
                <button class="btn-orange" onclick="alert('Calculando la ruta más rápida mediante el mapa del sistema...')">Optimizar Ruta</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/2972/2972185.png" alt="Moto o cambio de estado">
                <p id="txtEstadoRuta">Cambiar estado a "En Camino"</p>
                <button class="btn-orange" id="btnCambiarEstado" onclick="cambiarEstadoCamino()">Cambiar Estado</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/2143/2143150.png" alt="Entrega exitosa">
                <p>Registrar entrega exitosa</p>
                <input type="text" id="inputFirma" class="card-input" placeholder="Nombre de quien recibe">
                <button class="btn-orange" onclick="registrarEntregaExitosa()">Registrar Entrega</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="Reportar novedades">
                <p>Reportar novedades en entrega</p>
                <select id="selectNovedad" class="card-select">
                    <option>Cliente no en casa</option>
                    <option>Dirección incorrecta</option>
                    <option>Rechazado por cliente</option>
                </select>
                <button class="btn-orange" onclick="enviarReporteNovedad()">Enviar Reporte</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Detalles del cliente">
                <p>Consultar detalles del cliente</p>
                <button class="btn-orange" onclick="alert('Orden #FT-4029\nCliente: Samuel Nieto\nTeléfono: 3124567890\nDirección: Calle Central, Transversal 5 #10-20')">Ver Datos de Contacto</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/2693/2693507.png" alt="Historial de entregas">
                <p>Ver historial de entregas</p>
                <input type="text" class="card-input" value="05/06 - 27/09" disabled style="background-color: #f1f5f9; color: #64748b; font-weight: bold; cursor: not-allowed;">
                <button class="btn-orange" onclick="alert('Cargando registros históricos de rutas anteriores completadas...')">Ver Historial</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png" alt="Efectivo recaudado">
                <p id="txtEfectivo">Liquidar efectivo recaudado<small id="smallEfectivo">Resumen de efectivo en mano: $0.00 COP</small></p>
                <button class="btn-orange" onclick="liquidarEfectivoCaja()">Liquidar Efectivo</button>
            </div>

            <div class="card-item">
                <img src="https://cdn-icons-png.flaticon.com/512/3652/3652191.png" alt="Disponibilidad">
                <p id="txtDisponibilidad">Gestionar disponibilidad<small id="smallDisponibilidad">Disponibilidad: Activa</small></p>
                <button class="btn-orange" onclick="toggleDisponibilidad()">Cambiar Disponibilidad</button>
            </div>

        </div>
    </main>

    <script>
        let ordenEstado = 1; // 1 = Recibido/Asignado, 2 = En Camino, 3 = Entregado
        let efectivoMano = 0;
        let disponible = true;

        function cambiarEstadoCamino() {
            if(ordenEstado === 1) {
                ordenEstado = 2;
                document.getElementById('txtEstadoRuta').innerText = 'Estado actual: "En Camino"';
                const btn = document.getElementById('btnCambiarEstado');
                btn.innerText = "En Ruta...";
                btn.classList.add('btn-disabled');
                alert('¡Ruta Iniciada! El estado de la Orden #FT-4029 ha cambiado a "En Camino". El cliente ya puede ver tu ubicación.');
            } else {
                alert('La orden ya se encuentra en camino o ya fue procesada.');
            }
        }

        function registrarEntregaExitosa() {
            const firma = document.getElementById('inputFirma').value.trim();
            if(firma === "") {
                alert("Por favor introduce el nombre de la persona que recibe para registrar la entrega.");
                return;
            }
            
            ordenEstado = 3;
            efectivoMano += 45000; // Simulamos que entregó el "Insumo Francys Tipo A"
            
            document.getElementById('smallEfectivo').innerText = "Resumen de efectivo en mano: $" + efectivoMano.toLocaleString() + " COP";
            document.getElementById('txtEstadoRuta').innerText = 'Estado actual: "Entregado"';
            
            alert("¡Entrega registrada con éxito!\nRecibió: " + firma + "\nSe cargaron $" + (45000).toLocaleString() + " COP a tu caja provisional.");
            document.getElementById('inputFirma').value = "";
        }

        function enviarReporteNovedad() {
            const novedad = document.getElementById('selectNovedad').value;
            alert("Reporte enviado al Administrador y Vendedor:\nNovedad registrada: '" + novedad + "' en Orden #FT-4029.");
        }

        function liquidarEfectivoCaja() {
            if(efectivoMano === 0) {
                alert("No tienes efectivo acumulado en este turno para liquidar.");
                return;
            }
            alert("Solicitud de arqueo enviada.\nRindiendo $" + efectivoMano.toLocaleString() + " COP ante la caja del Vendedor/Admin.");
            efectivoMano = 0;
            document.getElementById('smallEfectivo').innerText = "Resumen de efectivo en mano: $0 COP";
        }

        function toggleDisponibilidad() {
            disponible = !disponible;
            const smallDisp = document.getElementById('smallDisponibilidad');
            if(disponible) {
                smallDisp.innerText = "Disponibilidad: Activa";
                smallDisp.style.color = "#64748b";
                alert("Ahora estás en estado: DISPONIBLE para recibir nuevas órdenes del carrito.");
            } else {
                smallDisp.innerText = "Disponibilidad: Inactiva";
                smallDisp.style.color = "#ef4444";
                alert("Has cambiado a estado: NO DISPONIBLE. No recibirás alertas de entregas temporales.");
            }
        }
    </script>
</body>
</html>