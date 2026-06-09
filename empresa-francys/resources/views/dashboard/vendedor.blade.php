<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrancysT - Panel del Vendedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f8fafc; color: #333; }

        header { 
            background-color: #000000; color: white; padding: 15px 40px; 
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 50;
        }
        .logo-area h1 { font-size: 1.6rem; font-weight: bold; }
        .logo-area span { color: #f59e0b; }
        
        .nav-right { display: flex; align-items: center; gap: 20px; }
        .user-tag { background: #1e293b; border: 1px solid #334155; padding: 6px 12px; border-radius: 20px; font-size: 0.9rem; color: #f59e0b; font-weight: bold; }

        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }

        /* MÓDULOS EN TARJETAS */
        .card { background: white; border-radius: 8px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.01); }
        .card h3 { font-size: 1.3rem; color: #1e293b; margin-bottom: 20px; border-bottom: 2px solid #f59e0b; padding-bottom: 8px; display: flex; align-items: center; gap: 10px; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.85rem; color: #64748b; font-weight: 600; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none; }
        .form-control:focus { border-color: #f59e0b; }

        .btn-submit { background: #f59e0b; color: black; border: none; padding: 12px; width: 100%; border-radius: 6px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.2s; }
        .btn-submit:hover { background: #d97706; }

        /* TABLAS INTERNAS */
        .vendedor-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem; }
        .vendedor-table th { background: #f8fafc; padding: 12px; color: #64748b; font-weight: 600; border-bottom: 2px solid #e2e8f0; }
        .vendedor-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; }

        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }
        .badge-recibido { background: #fee2e2; color: #991b1b; }
        .badge-preparado { background: #e0f2fe; color: #0369a1; }

        .btn-action { background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: bold; }
        .btn-action:hover { background: #059669; }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">
            <h1>Francys<span>T</span> Logística</h1>
        </div>
        <div class="nav-right">
            <span class="user-tag"><i class="fa-solid fa-store"></i> Vendedor: {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-weight:bold; font-size:0.95rem;">Salir</button>
            </form>
        </div>
    </header>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; max-width: 1200px; margin: 20px auto; border-radius: 6px; font-weight: bold; text-align: center;">
            🎉 {{ session('success') }}
        </div>
    @endif

    <main class="container">
        
        <div class="card">
            <h3><i class="fa-solid fa-boxes-packing"></i> Cargar Inventario</h3>
            <form action="{{ route('vendedor.productos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre del Producto / Artículo</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Papas Fritas Mega" required>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <select name="categoria" class="form-control" style="background: white;" required>
                        <option value="aseo-limpieza">🧽 Aseo y Limpieza</option>
                        <option value="golosinas-paquetes">🍬 Golosinas y Paquetes</option>
                        <option value="escolares-oficina">✏️ Artículos Escolares / Oficina</option>
                        <option value="comestibles">🍏 Comestibles</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Precio de Venta ($ COP)</label>
                    <input type="number" name="precio" class="form-control" placeholder="Ej: 5000" min="0" required>
                </div>
                <div class="form-group">
                    <label>Cantidad de Unidades a Añadir (Stock)</label>
                    <input type="number" name="stock" class="form-control" placeholder="Ej: 50" min="1" required>
                </div>
                <button type="submit" class="btn-submit">Sincronizar Stock</button>
            </form>
        </div>

        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <div class="card">
                <h3><i class="fa-solid fa-bell"></i> Órdenes de Clientes (Por Preparar)</h3>
                <div style="overflow-x: auto;">
                    <table class="vendedor-table">
                        <thead>
                            <tr><th>Orden</th><th>Destino</th><th>Estado</th><th>Acción</th></tr>
                        </thead>
                        <tbody>
                            @forelse($pedidosParaPreparar ?? [] as $pedido)
                                <tr>
                                    <td><b>#FT-{{ $pedido->id }}</b></td>
                                    <td>{{ $pedido->direccion_entrega }}</td>
                                    <td>
                                        <span class="badge {{ $pedido->estado == 'Recibido' ? 'badge-recibido' : 'badge-preparado' }}">
                                            {{ $pedido->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($pedido->estado == 'Recibido')
                                            <form action="{{ route('vendedor.pedidos.preparar', $pedido->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-action"><i class="fa-solid fa-box-open"></i> Despachar</button>
                                            </form>
                                        @else
                                            <span style="color:#64748b; font-size:0.85rem;"><i class="fa-solid fa-circle-check"></i> Empacado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align: center; color: #64748b;">No hay compras pendientes por empacar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3><i class="fa-solid fa-list"></i> Vista del Stock Actualizado</h3>
                <div style="overflow-x: auto;">
                    <table class="vendedor-table">
                        <thead>
                            <tr><th>Producto</th><th>Categoría</th><th>Precio</th><th>Stock Disponible</th></tr>
                        </thead>
                        <tbody>
                            @forelse($productos ?? [] as $prod)
                                <tr>
                                    <td><b>{{ $prod->nombre }}</b></td>
                                    <td>{{ $prod->categoria }}</td>
                                    <td>$ {{ number_format($prod->precio, 0, ',', '.') }}</td>
                                    <td>
                                        @if(($prod->stock ?? 0) < 5)
                                            <span style="font-weight: bold; color: #ef4444;">{{ $prod->stock ?? 0 }} uds (Bajo)</span>
                                        @else
                                            <span style="font-weight: bold; color: #1e293b;">{{ $prod->stock ?? 0 }} uds</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align: center; color: #64748b;">No has subido ningún producto todavía.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>