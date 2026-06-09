<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrancysT - Panel Administrativo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f1f5f9; color: #1e293b; }
        .navbar { background-color: #000; color: white; padding: 15px 40px; display: flex; align-items: center; justify-content: space-between; }
        .menu-list { list-style: none; display: flex; gap: 20px; }
        .menu-item button { background: none; border: none; color: #94a3b8; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 1rem; }
        .menu-item button:hover, .menu-item button.active-tab { color: #f59e0b; font-weight: bold; }
        .main-content { padding: 40px; }
        .admin-section { display: none; }
        .admin-section.active-section { display: block; }
        .table-container { background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 15px; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .admin-table th, .admin-table td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .btn-action { padding: 5px 10px; border-radius: 4px; border: none; cursor: pointer; color: white; font-weight: bold; }
        .search-box { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #cbd5e1; border-radius: 6px; }
    </style>
</head>
<body>

    <nav class="navbar">
        @if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 15px; margin: 20px 40px 0; border-radius: 6px; border: 1px solid #bbf7d0; font-weight: bold;">
        ✅ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #fee2e2; color: #991b1b; padding: 15px; margin: 20px 40px 0; border-radius: 6px; border: 1px solid #fecaca; font-weight: bold;">
        ❌ Hubo un error al procesar la solicitud.
    </div>
@endif
        <h2>Francys<span>T</span> Admin</h2>
        <ul class="menu-list">
            <li class="menu-item"><button id="btn-resumen" class="active-tab" onclick="switchSection('resumen')"><i class="fa-solid fa-chart-pie"></i> General</button></li>
            <li class="menu-item"><button id="btn-domiciliarios" onclick="switchSection('domiciliarios')"><i class="fa-solid fa-users"></i> Usuarios</button></li>
            <li class="menu-item"><button id="btn-productos" onclick="switchSection('productos')"><i class="fa-solid fa-boxes-stacked"></i> Productos</button></li>
            <li class="menu-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="color: #ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
                </form>
            </li>
        </ul>
    </nav>
    
    <div class="main-content">
        <input type="text" id="searchInput" class="search-box" onkeyup="filterTable()" placeholder="🔍 Buscar en la tabla activa...">

        <div id="domiciliarios" class="admin-section">
            <h2>Gestión de Usuarios</h2>
            <div class="table-container">
                <h3>Crear Nuevo Usuario</h3>
              <form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required style="padding: 5px;">
    <input type="email" name="email" placeholder="Correo" required style="padding: 5px;">
    <input type="password" name="password" placeholder="Contraseña" required style="padding: 5px;">
    <button type="submit" class="btn-action" style="background: #22c55e;">Crear</button>
</form>

<form action="{{ route('admin.productos.store') }}" method="POST" style="margin: 15px 0;">
    @csrf
    <input type="text" name="nombre" placeholder="Nombre" required style="padding: 5px;">
    <input type="number" name="precio" placeholder="Precio" required style="padding: 5px;">
    <input type="number" name="stock" placeholder="Stock" required style="padding: 5px;">
    
    <input type="text" name="categoria" placeholder="Categoría" required style="padding: 5px;">
    
    <button type="submit" class="btn-action" style="background: #22c55e;">Guardar</button>
</form>
                <table class="admin-table" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Nombre y Correo</th>
                            <th>Estado / Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios ?? [] as $user)
                        <tr>
                            <td>
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="display:flex; gap:5px;">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $user->name }}" required>
                                    <input type="email" name="email" value="{{ $user->email }}" required>
                                    <button type="submit" class="btn-action" style="background: #f59e0b;">Guardar</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-action" @style([
                                        'background-color: #ef4444' => $user->activo,
                                        'background-color: #22c55e' => !$user->activo,
                                    ])>
                                        {{ $user->activo ? 'Deshabilitar' : 'Habilitar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="productos" class="admin-section">
            <h2>Gestión de Inventario</h2>
            <div class="table-container">
                <h3>Agregar Nuevo Producto</h3>
                <form action="{{ route('admin.productos.store') }}" method="POST" style="margin: 15px 0;">
                    @csrf
                    <input type="text" name="nombre" placeholder="Nombre" required style="padding: 5px;">
                    <input type="number" name="precio" placeholder="Precio" required style="padding: 5px;">
                    <input type="number" name="stock" placeholder="Stock" required style="padding: 5px;">
                    <button type="submit" class="btn-action" style="background: #22c55e;">Guardar</button>
                </form>
                <table class="admin-table" id="tablaProductos">
                    <thead><tr><th>Nombre</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr></thead>
                    <tbody>
                        @foreach($productos ?? [] as $prod)
                        <tr>
                            <td>
                                <form action="{{ route('admin.productos.update', $prod->id) }}" method="POST" style="display:flex; gap:5px;">
                                    @csrf @method('PUT')
                                    <input type="text" name="nombre" value="{{ $prod->nombre }}" style="width: 100px;">
                                    <input type="number" name="precio" value="{{ $prod->precio }}" style="width: 60px;">
                                    <input type="number" name="stock" value="{{ $prod->stock }}" style="width: 50px;">
                                    <button type="submit" class="btn-action" style="background: #f59e0b;">Editar</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.productos.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action" style="background: #ef4444;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function switchSection(sectionId) {
            document.querySelectorAll('.admin-section').forEach(sec => sec.classList.remove('active-section'));
            document.querySelectorAll('.menu-list button').forEach(btn => btn.classList.remove('active-tab'));
            document.getElementById(sectionId).classList.add('active-section');
            document.getElementById('btn-' + sectionId).classList.add('active-tab');
        }

        function filterTable() {
            let input = document.getElementById("searchInput").value.toUpperCase();
            let tables = document.querySelectorAll(".admin-table");
            tables.forEach(table => {
                let rows = table.getElementsByTagName("tr");
                for (let i = 1; i < rows.length; i++) {
                    rows[i].style.display = rows[i].innerText.toUpperCase().indexOf(input) > -1 ? "" : "none";
                }
            });
        }
    
    // Recupera la última pestaña abierta al recargar
    window.onload = function() {
        let lastSection = localStorage.getItem('activeSection') || 'resumen';
        switchSection(lastSection);
    };

    function switchSection(sectionId) {
        // Guardamos la sección activa en el navegador
        localStorage.setItem('activeSection', sectionId);
        
        document.querySelectorAll('.admin-section').forEach(sec => sec.classList.remove('active-section'));
        document.querySelectorAll('.menu-list button').forEach(btn => btn.classList.remove('active-tab'));
        document.getElementById(sectionId).classList.add('active-section');
        document.getElementById('btn-' + sectionId).classList.add('active-tab');
    }
</script>

</body>
</html>