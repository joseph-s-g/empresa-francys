<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrancysT - Portal de Compras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f8fafc; color: #333; }

        /* NAVBAR SUPERIOR NEGRA CORPORATIVA */
        header { 
            background-color: #000000; 
            color: white; 
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 50;
        }
        .logo-area h1 { font-size: 1.6rem; font-weight: bold; cursor: pointer; }
        .logo-area span { color: #f59e0b; }
        
        nav ul { list-style: none; display: flex; gap: 20px; align-items: center; }
        nav ul li a { color: #ffffff; text-decoration: none; font-size: 0.95rem; transition: color 0.2s; cursor: pointer; }
        nav ul li a:hover, nav ul li a.active-nav { color: #f59e0b; font-weight: bold; }
        
        /* PERFIL COMO BOTÓN INTERACTIVO */
        .user-profile-btn { 
            display: flex; align-items: center; gap: 8px; font-size: 0.95rem; color: #f1f5f9; 
            background: #1e293b; border: 1px solid #334155; padding: 6px 12px; border-radius: 20px;
            cursor: pointer; transition: background 0.2s, border-color 0.2s;
        }
        .user-profile-btn:hover { background: #334155; border-color: #f59e0b; }

        .cart-badge { background: #f59e0b; color: #000; border-radius: 50%; padding: 2px 6px; font-size: 0.8rem; font-weight: bold; margin-left: 3px; }

        /* CONTENIDO PRINCIPAL */
        .main-container { max-width: 1200px; margin: 30px auto; padding: 0 20px; min-height: 70vh; }
        
        /* PESTAÑAS / PAGINAS VIRTUALES */
        .page-section { display: none; }
        .page-section.active-page { display: block; animation: fadeIn 0.4s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-title { font-size: 1.8rem; font-weight: 600; color: #1e293b; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }

        /* BARRA DE BÚSQUEDA Y FILTROS */
        .search-filter-container {
            background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;
            display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.01);
        }
        .search-wrapper { flex-grow: 2; position: relative; }
        .search-wrapper i { position: absolute; left: 12px; top: 12px; color: #94a3b8; }
        .search-input { width: 100%; padding: 10px 10px 10px 38px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 0.95rem; }
        .search-input:focus { border-color: #f59e0b; }
        
        .filter-wrapper { flex-grow: 1; min-width: 200px; }
        .filter-select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 0.95rem; background: white; cursor: pointer; }
        .filter-select:focus { border-color: #f59e0b; }

        /* GRILLA DE CATÁLOGO */
        .tienda-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px; }
        .producto { 
            background: white; border-radius: 8px; padding: 20px; text-align: center; border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: transform 0.2s, box-shadow 0.2s;
        }
        .producto:hover { transform: translateY(-4px); box-shadow: 0 10px 15px rgba(0,0,0,0.05); }
        .img-placeholder { 
            background: #f1f5f9; width: 100%; height: 150px; border-radius: 6px; 
            display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 2.5rem; margin-bottom: 15px;
        }
        .producto h4 { font-size: 1.1rem; color: #1e293b; margin-bottom: 5px; font-weight: 600; }
        .categoria-tag { display: inline-block; background: #e2e8f0; color: #475569; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; margin-bottom: 10px; font-weight: 500; }
        .precio { color: #1e3a8a; font-weight: bold; font-size: 1.2rem; margin-bottom: 15px; }
        
        .compra-actions { display: flex; gap: 10px; justify-content: center; margin-top: 10px; }
        .input-cantidad { width: 70px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; text-align: center; font-size: 0.95rem; outline: none; }
        .input-cantidad:focus { border-color: #d97706; }
        .btn-buy { 
            background-color: #d97706; color: white; border: none; padding: 10px 15px; flex-grow: 1;
            border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 0.9rem; transition: background 0.2s; 
        }
        .btn-buy:hover { background-color: #b45309; }

        /* SECCIÓN DE HISTORIAL Y SEGUIMIENTO DE PEDIDOS */
        .tracking-box { background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .order-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 15px; }
        .tracking-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .tracking-status { background: #d1fae5; color: #065f46; padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; }
        
        .timeline { display: flex; justify-content: space-between; position: relative; margin-top: 25px; margin-bottom: 25px; }
        .timeline::before { content: ''; position: absolute; top: 15px; left: 5%; width: 90%; height: 4px; background: #e2e8f0; z-index: 1; }
        .timeline-progress { content: ''; position: absolute; top: 15px; left: 5%; width: 50%; height: 4px; background: #10b981; z-index: 2; transition: width 0.8s ease; }
        .step { position: relative; z-index: 3; text-align: center; width: 25%; }
        .step-icon { width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; margin: 0 auto 8px auto; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #64748b; transition: 0.3s; }
        .step.active .step-icon { background: #10b981; color: white; box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.2); }
        .step p { font-size: 0.85rem; font-weight: 600; color: #64748b; }
        .step.active p { color: #1e293b; }

        /* SECCIÓN DE FACTURAS */
        .facturas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 20px; }
        .factura-papel { 
            background: #fff; border: 1px solid #cbd5e1; border-top: 8px solid #1e3a8a; padding: 20px; 
            border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.03);
        }
        .factura-header { display: flex; justify-content: space-between; border-bottom: 1px dashed #cbd5e1; padding-bottom: 10px; margin-bottom: 10px; }
        .factura-header h4 { color: #1e3a8a; }
        .factura-datos { font-size: 0.85rem; color: #475569; margin-bottom: 12px; line-height: 1.4; }
        .factura-items { font-size: 0.85rem; width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .factura-items th { text-align: left; color: #64748b; border-bottom: 1px solid #e2e8f0; padding: 4px 0; }
        .factura-items td { padding: 6px 0; border-bottom: 1px dashed #f1f5f9; }
        .factura-total { text-align: right; font-weight: bold; font-size: 1rem; color: #1e293b; margin-top: 5px; border-top: 1px solid #cbd5e1; padding-top: 5px; }

        /* PANEL LATERAL DEL CARRITO */
        .cart-sidebar { 
            position: fixed; top: 0; right: -420px; width: 420px; height: 100%; 
            background: white; box-shadow: -5px 0 25px rgba(0,0,0,0.1); z-index: 100; 
            transition: right 0.3s ease; display: flex; flex-direction: column; 
        }
        .cart-sidebar.open { right: 0; }
        .cart-header { padding: 20px; background: #000; color: white; display: flex; justify-content: space-between; align-items: center; }
        .close-cart { cursor: pointer; font-size: 1.6rem; font-weight: bold; color: #94a3b8; }
        .close-cart:hover { color: white; }
        
        .cart-items-container { padding: 20px; flex-grow: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; }
        .cart-item-details h5 { font-size: 0.95rem; color: #1e293b; font-weight: 600; }
        .cart-item-details span { font-size: 0.9rem; color: #1e3a8a; font-weight: bold; }
        .cart-item-qty { background: #d97706; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; margin-right: 5px; }
        .btn-remove { background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.85rem; font-weight: bold; }

        .checkout-form { padding: 15px; background: #f8fafc; border-radius: 6px; margin: 10px 20px; border: 1px solid #e2e8f0; display: none; }
        .checkout-form h4 { font-size: 1rem; color: #1e3a8b; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; font-size: 0.8rem; color: #64748b; font-weight: 600; margin-bottom: 4px; }
        .form-control { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem; outline: none; background: white; }

        .cart-footer { padding: 20px; border-top: 1px solid #e2e8f0; background: #f8fafc; }
        .cart-total-row { display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: bold; margin-bottom: 15px; color: #1e293b; }
        .btn-checkout { background: #10b981; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.2s; }
        .btn-checkout:hover { background: #059669; }

        /* ESTILOS DEL MODAL DE PERFIL DE USUARIO */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 150; display: none;
            align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .profile-modal {
            background: white; width: 90%; max-width: 450px; border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2); overflow: hidden;
            animation: fadeIn 0.3s ease;
        }
        .profile-modal-header { background: #000; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .profile-modal-body { padding: 20px; }
        .profile-modal-footer { padding: 15px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right; }
        .btn-save-profile { background: #f59e0b; color: black; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; }
        .btn-save-profile:hover { background: #d97706; }
    </style>
</head>
<body>

    <header>
        <div class="logo-area" onclick="navigateTo('catalogoPage')">
            <h1>Francys<span>T</span></h1>
        </div>
        <nav>
            <ul>
                <li><a id="nav-catalogoPage" class="active-nav" onclick="navigateTo('catalogoPage')"><i class="fa-solid fa-store"></i> Catálogo</a></li>
                <li><a id="nav-pedidosPage" onclick="navigateTo('pedidosPage')"><i class="fa-solid fa-truck"></i> Mis Pedidos</a></li>
                <li><a id="nav-facturasPage" onclick="navigateTo('facturasPage')"><i class="fa-solid fa-file-invoice-dollar"></i> Mis Facturas</a></li>
                <li><a onclick="toggleCart(true)"><i class="fa-solid fa-cart-shopping"></i> Carrito <span class="cart-badge" id="cartCount">0</span></a></li>
                <li>
                    <button class="user-profile-btn" onclick="toggleProfileModal(true)">
                        <i class="fa-solid fa-user-gear" style="color: #f59e0b;"></i>
                        <span id="lblNombreHeader">{{ Auth::user()->name }}</span>
                    </button>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-weight:bold; font-size:0.95rem; margin-left:10px;">Salir</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main class="main-container">

        <div id="catalogoPage" class="page-section active-page">
            <h2 class="section-title">Catálogo de Productos</h2>
            
            <div class="search-filter-container">
                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar productos por nombre..." onkeyup="filterProducts()">
                </div>
                <div class="filter-wrapper">
                    <select id="categoryFilter" class="filter-select" onchange="filterProducts()">
                        <option value="todos">📦 Todas las Categorías</option>
                        <option value="aseo-limpieza">🧽 Aseo y Limpieza</option>
                        <option value="golosinas-paquetes">🍬 Golosinas y Paquetes</option>
                        <option value="escolares-oficina">✏️ Artículos Escolares / Oficina</option>
                        <option value="comestibles">🍏 Comestibles</option>
                    </select>
                </div>
            </div>

            <div class="tienda-grid" id="productsGrid">
                @if(isset($productos) && count($productos) > 0)
                    @foreach($productos as $key => $prod)
                        <div class="producto" data-name="{{ $prod->nombre }}" data-category="{{ $prod->categoria ?? 'comestibles' }}">
                            <div class="img-placeholder">
                                @if(($prod->categoria ?? '') == 'aseo-limpieza') <i class="fa-solid fa-pump-soap"></i>
                                @elseif(($prod->categoria ?? '') == 'golosinas-paquetes') <i class="fa-solid fa-cookie-bite"></i>
                                @elseif(($prod->categoria ?? '') == 'escolares-oficina') <i class="fa-solid fa-book"></i>
                                @else <i class="fa-solid fa-bowl-rice"></i> @endif
                            </div>
                            <span class="categoria-tag">{{ ucfirst(str_replace('-', ' ', $prod->categoria ?? 'General')) }}</span>
                            <h4>{{ $prod->nombre }}</h4>
                            <p class="precio">${{ number_format($prod->precio, 0, ',', '.') }} COP</p>
                            <div class="compra-actions">
                                <input type="number" id="qty-p{{ $key }}" class="input-cantidad" value="1" min="1" max="{{ $prod->stock }}">
                                
                                <button class="btn-buy" 
                                        data-name="{{ $prod->nombre }}" 
                                        data-price="{{ $prod->precio }}" 
                                        data-input-id="qty-p{{ $key }}"
                                        onclick="handleProductClick(this)">
                                    Añadir
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #64748b;">
                        <i class="fa-solid fa-boxes-empty" style="font-size: 3rem; margin-bottom: 10px;"></i>
                        <p>No hay productos disponibles en el catálogo en este momento.</p>
                    </div>
                @endif
            </div>
        </div>

        <div id="pedidosPage" class="page-section">
            <h2 class="section-title">Seguimiento de Mis Pedidos</h2>
            <div class="tracking-box">
                <div id="pedidoActivoContainer" style="display: none; margin-bottom: 30px;" class="order-card">
                    <div class="tracking-header">
                        <h3>📦 Orden Activa Enviada #FT-4029</h3>
                        <span class="tracking-status" id="trackingStatusText" style="background: #fef3c7; color: #92400e;">En Espera de Vendedor</span>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-progress" id="timelineProgress"></div>
                        <div class="step active" id="step1"><div class="step-icon">1</div><p>Solicitado</p></div>
                        <div class="step active" id="step2"><div class="step-icon">2</div><p>En Verificación</p></div>
                        <div class="step" id="step3"><div class="step-icon">3</div><p>Despachado</p></div>
                        <div class="step" id="step4"><div class="step-icon">4</div><p>Entregado</p></div>
                    </div>
                    <div style="font-size: 0.9rem; color: #334155; background: #fff; padding: 12px; border-radius: 6px; border: 1px dashed #cbd5e1;" id="datosDespachoResumen">
                        </div>
                </div>

                <h3>📋 Historial de Pedidos</h3>
                <div style="margin-top: 15px;" id="historialPedidosLista">
                    <div class="order-card" style="opacity: 0.85;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                            <b>Orden #FT-3912 (Procesada)</b>
                            <span style="color:#065f46; font-weight:bold;"><i class="fa-solid fa-circle-check"></i> Entregado e Inventariado</span>
                        </div>
                        <p style="font-size:0.85rem; color:#475569;">Productos: 1x Cuaderno Argollado Cuadriculado — Total: $8.500 COP</p>
                        <p style="font-size:0.85rem; color:#64748b;">Entregado en: Av. Caracas #32-10 — Domiciliario: Andrés Rojas</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="facturasPage" class="page-section">
            <h2 class="section-title">Historial de Facturas Corporativas</h2>
            <div class="facturas-grid" id="facturasContainer">
                <div class="factura-papel">
                    <div class="factura-header">
                        <h4>FRANCYS T S.A.S</h4>
                        <span style="font-size:0.8rem; color:#64748b;">N° FT-3912</span>
                    </div>
                    <div class="factura-datos">
                        <b>Fecha/Hora:</b> 28/05/2026 - 15:42:10<br>
                        <b>Cliente:</b> <span class="factura-cliente-nombre">{{ Auth::user()->name }}</span><br>
                        <b>Dirección:</b> Av. Caracas #32-10<br>
                        <b>Pago:</b> PSE (Cuenta de Ahorros)<br>
                        <b>Domiciliario:</b> Andrés Rojas
                    </div>
                    <table class="factura-items">
                        <thead><tr><th>Ítem</th><th>Cant</th><th>Subtotal</th></tr></thead>
                        <tbody><tr><td>Cuaderno Argollado Cuadriculado</td><td>1</td><td>$8.500</td></tr></tbody>
                    </table>
                    <div class="factura-total">Total Pagado: $8.500 COP</div>
                </div>
            </div>
        </div>

    </main>

    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>🛒 Tu Pedido</h3>
            <span class="close-cart" onclick="toggleCart(false)">&times;</span>
        </div>
        
        <div class="cart-items-container" id="cartItems">
            <p style="text-align: center; color: #64748b; margin-top: 20px;" id="emptyCartText">El carrito está vacío.</p>
        </div>

        <div class="checkout-form" id="checkoutForm">
            <h4><i class="fa-solid fa-location-dot" style="color: #10b981;"></i> Datos de Despacho</h4>
            <div class="form-group">
                <label>Dirección de Envío</label>
                <input type="text" id="txtDireccion" class="form-control" placeholder="Ej: Calle 45 #10-20 Apto 302">
            </div>
            <div class="form-group">
                <label>Método de Pago</label>
                <select id="selectPago" class="form-control">
                    <option value="Efectivo contra entrega">Efectivo contra entrega</option>
                    <option value="Tarjeta de Crédito / Débito">Tarjeta de Crédito / Débito</option>
                    <option value="PSE (Cuenta de Ahorros)">PSE (Cuenta de Ahorros)</option>
                </select>
            </div>
        </div>
        
        <div class="cart-footer">
            <div class="cart-total-row">
                <span>Total:</span>
                <span id="cartTotal">$ 0 COP</span>
            </div>
            <button class="btn-checkout" id="btnActionCart" onclick="handleCartAction()">Confirmar Compra</button>
        </div>
    </div>

    <div class="modal-overlay" id="profileModal">
        <div class="profile-modal">
            <div class="profile-modal-header">
                <h3><i class="fa-solid fa-id-card"></i> Mi Perfil Corporativo</h3>
                <span class="close-cart" onclick="toggleProfileModal(false)">&times;</span>
            </div>
            <div class="profile-modal-body">
                <div class="form-group">
                    <label>Nombre de Usuario</label>
                    <input type="text" id="profileNombre" class="form-control" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                    <label>Dirección Predeterminada de Envío</label>
                    <input type="text" id="profileDireccion" class="form-control" placeholder="Configura tu dirección habitual">
                </div>
                <div class="form-group">
                    <label>Método de Pago Preferido</label>
                    <select id="profilePago" class="form-control">
                        <option value="Efectivo contra entrega">Efectivo contra entrega</option>
                        <option value="Tarjeta de Crédito / Débito">Tarjeta de Crédito / Débito</option>
                        <option value="PSE (Cuenta de Ahorros)">PSE (Cuenta de Ahorros)</option>
                    </select>
                </div>
            </div>
            <div class="profile-modal-footer">
                <button class="btn-save-profile" onclick="saveProfileData()">Guardar Datos</button>
            </div>
        </div>
    </div>

    <script>
        let cart = {}; 

        // Perfil dinámico del usuario
        let userProfile = {
            nombre: "{{ Auth::user()->name }}",
            direccion: localStorage.getItem('user_direccion') || "Calle 45 #10-20",
            pago: localStorage.getItem('user_pago') || "Efectivo contra entrega"
        };

        // Rellenar inputs de perfil iniciales
        document.getElementById('profileDireccion').value = userProfile.direccion;
        document.getElementById('profilePago').value = userProfile.pago;

        function toggleProfileModal(open) {
            document.getElementById('profileModal').classList.toggle('open', open);
        }

        function saveProfileData() {
            const nuevoNombre = document.getElementById('profileNombre').value.trim();
            const nuevaDir = document.getElementById('profileDireccion').value.trim();
            const nuevoPago = document.getElementById('profilePago').value;

            if(nuevoNombre === "") { alert("El nombre no puede estar vacío."); return; }

            userProfile.nombre = nuevoNombre;
            userProfile.direccion = nuevaDir;
            userProfile.pago = nuevoPago;

            localStorage.setItem('user_direccion', nuevaDir);
            localStorage.setItem('user_pago', nuevoPago);

            document.getElementById('lblNombreHeader').innerText = nuevoNombre;
            document.querySelectorAll('.factura-cliente-nombre').forEach(el => el.innerText = nuevoNombre);

            alert("¡Perfil guardado y sincronizado! Los datos se usarán en tus compras.");
            toggleProfileModal(false);
        }

        function navigateTo(pageId) {
            document.querySelectorAll('.page-section').forEach(section => section.classList.remove('active-page'));
            document.querySelectorAll('nav ul li a').forEach(navLink => navLink.classList.remove('active-nav'));

            document.getElementById(pageId).classList.add('active-page');
            const targetNav = document.getElementById('nav-' + pageId);
            if (targetNav) targetNav.classList.add('active-nav');
        }

        function filterProducts() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const selectedCategory = document.getElementById('categoryFilter').value;
            const products = document.querySelectorAll('.producto');

            products.forEach(product => {
                const productName = product.getAttribute('data-name').toLowerCase();
                const productCategory = product.getAttribute('data-category');
                const matchesSearch = productName.includes(searchText);
                const matchesCategory = (selectedCategory === 'todos' || productCategory === selectedCategory);
                product.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
            });
        }

        function toggleCart(open) {
            document.getElementById('cartSidebar').classList.toggle('open', open);
            if (open) {
                document.getElementById('txtDireccion').value = userProfile.direccion;
                document.getElementById('selectPago').value = userProfile.pago;
            }
        }

        function handleProductClick(buttonElement) {
            const name = buttonElement.getAttribute('data-name');
            const price = parseFloat(buttonElement.getAttribute('data-price'));
            const inputId = buttonElement.getAttribute('data-input-id');
            addWithQty(name, price, inputId);
        }

        function addWithQty(name, price, inputId) {
            const qtyInput = document.getElementById(inputId);
            const qty = parseInt(qtyInput.value);
            
            if (isNaN(qty) || qty < 1) { alert("Ingresa una cantidad válida."); return; }

            if (cart[name]) { cart[name].qty += qty; } 
            else { cart[name] = { price: price, qty: qty }; }

            qtyInput.value = 1; 
            updateCartUI();
        }

        function removeCartItem(name) {
            delete cart[name];
            updateCartUI();
        }

        function updateCartUI() {
            const container = document.getElementById('cartItems');
            const countBadge = document.getElementById('cartCount');
            const totalText = document.getElementById('cartTotal');
            const checkoutForm = document.getElementById('checkoutForm');
            const btnAction = document.getElementById('btnActionCart');
            
            const keys = Object.keys(cart);
            let totalItemsCount = 0;
            let totalMoney = 0;
            container.innerHTML = "";

            if(keys.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #64748b; margin-top: 20px;">El carrito está vacío.</p>';
                countBadge.innerText = 0;
                totalText.innerText = "$ 0 COP";
                checkoutForm.style.display = 'none';
                btnAction.innerText = "Confirmar Compra";
                btnAction.style.background = "#10b981";
                return;
            }

            keys.forEach((name) => {
                const item = cart[name];
                totalItemsCount += item.qty;
                totalMoney += (item.price * item.qty);

                container.innerHTML += `
                    <div class="cart-item">
                        <div class="cart-item-details">
                            <h5><span class="cart-item-qty">x${item.qty}</span> ${name}</h5>
                            <span>$ ${(item.price * item.qty).toLocaleString()} COP</span>
                        </div>
                        <button class="btn-remove" onclick="removeCartItem('${name}')"><i class="fa-solid fa-trash"></i></button>
                    </div>
                `;
            });

            countBadge.innerText = totalItemsCount;
            totalText.innerText = "$ " + totalMoney.toLocaleString() + " COP";
        }

        function handleCartAction() {
            const checkoutForm = document.getElementById('checkoutForm');
            const btnAction = document.getElementById('btnActionCart');

            if (checkoutForm.style.display === 'none' || checkoutForm.style.display === '') {
                checkoutForm.style.display = 'block';
                btnAction.innerText = "Solicitar Domicilio Final";
                btnAction.style.background = "#0284c7"; 
                return;
            }

            const direccion = document.getElementById('txtDireccion').value.trim();
            const pago = document.getElementById('selectPago').value;

            if (direccion === "") { alert("Por favor introduce una dirección válida."); return; }

            // Actualizar dirección si la cambió en caliente
            userProfile.direccion = direccion;
            userProfile.pago = pago;

            // --- FLUJO LOGICO DE PROPUESTA SENA ---
            alert("¡Pedido enviado al panel del Vendedor! El stock no variará hasta que la venta sea aprobada.");

            // 1. Mostrar la sección en "Mis Pedidos" (Simulación de espera del panel administrativo)
            document.getElementById('pedidoActivoContainer').style.display = 'block';
            document.getElementById('datosDespachoResumen').innerHTML = `
                <b>Dirección de entrega:</b> ${direccion}<br>
                <b>Método solicitado:</b> ${pago}<br>
                <span style="color: #b45309;"><i class="fa-solid fa-hourglass-half"></i> Estado: Esperando confirmación de factura del Vendedor.</span>
            `;

            // 2. Generar automáticamente la factura correspondiente en la pestaña "Mis Facturas"
            const facturasContainer = document.getElementById('facturasContainer');
            let nFactura = Math.floor(Math.random() * 9000) + 1000;
            let totalFactura = 0;
            let filasTablaItems = "";

            Object.keys(cart).forEach(name => {
                let sub = cart[name].price * cart[name].qty;
                totalFactura += sub;
                filasTablaItems += `<tr><td>${name}</td><td>${cart[name].qty}</td><td>$${sub.toLocaleString()}</td></tr>`;
            });

            const nuevaFacturaHtml = `
                <div class="factura-papel" style="border-top: 8px solid #f59e0b;">
                    <div class="factura-header">
                        <h4>FRANCYS T S.A.S</h4>
                        <span style="font-size:0.8rem; color:#d97706; font-weight:bold;">PENDIENTE APROBACIÓN (N° FT-${nFactura})</span>
                    </div>
                    <div class="factura-datos">
                        <b>Fecha/Hora:</b> Hoy (Recién Generada)<br>
                        <b>Cliente:</b> <span>${userProfile.nombre}</span><br>
                        <b>Dirección:</b> ${direccion}<br>
                        <b>Pago:</b> ${pago}<br>
                        <b>Estado Stock:</b> Bloqueado Temporalmente (50 unidades originales)
                    </div>
                    <table class="factura-items">
                        <thead><tr><th>Ítem</th><th>Cant</th><th>Subtotal</th></tr></thead>
                        <tbody>${filasTablaItems}</tbody>
                    </table>
                    <div class="factura-total">Total a Pagar: $${totalFactura.toLocaleString()} COP</div>
                </div>
            `;
            
            facturasContainer.innerHTML = nuevaFacturaHtml + facturasContainer.innerHTML;

            // Limpiar carrito
            cart = {};
            updateCartUI();
            toggleCart(false);
            navigateTo('pedidosPage');
        }
    </script>
</body>
</html>