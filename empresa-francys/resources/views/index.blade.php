<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miscelánea-Francys T - Acceso</title>
    <!-- CARGA DE FONT AWESOME PARA LOS ÍCONOS DEL OJO -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f0f4f8; display: flex; flex-direction: column; min-height: 100vh; }
        
        header { background-color: #1e3a8a; color: white; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        header h1 { font-size: 2rem; letter-spacing: 1px; }

        .contenedor-formularios { display: flex; justify-content: center; align-items: flex-start; max-width: 1100px; margin: 40px auto; gap: 30px; width: 100%; padding: 0 20px; flex-wrap: wrap; }
        
        .box-form { background: white; flex: 1; min-width: 320px; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .box-form h2 { color: #1e3a8a; margin-bottom: 20px; font-size: 1.5rem; text-align: center; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9; }
        
        .grupo-campo { margin-bottom: 16px; }
        .grupo-campo label { display: block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem; }
        
        input, select { width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; background-color: #f8fafc; transition: all 0.3s; }
        input:focus, select:focus { outline: none; border-color: #3b82f6; background-color: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        
        /* NUEVO ESTILO: Contenedor relativo para posicionar el ojo */
        .campo-password-wrapper { position: relative; width: 100%; }
        /* Añadimos un padding extra a la derecha para que el texto no tape el ojo */
        .campo-password-wrapper input { padding-right: 40px; }
        /* Posicionamiento del ojo flotante */
        .ojo-icono { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b; font-size: 1.1rem; transition: color 0.2s; }
        .ojo-icono:hover { color: #1e3a8a; }

        button { width: 100%; padding: 12px; background-color: #10b981; color: white; font-weight: bold; font-size: 1rem; border: none; border-radius: 6px; cursor: pointer; transition: background 0.3s, transform 0.1s; margin-top: 10px; }
        button:hover { background-color: #059669; }
        button:active { transform: scale(0.98); }

        .alert { width: 100%; max-width: 1060px; margin: 20px auto 0 auto; padding: 12px 20px; border-radius: 6px; font-size: 0.95rem; text-align: center; }
        .alert-success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

    <header>
        <h1>MISCELÁNEA-FRANCYS T</h1>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <main class="contenedor-formularios">
        <!-- FORMULARIO 1: INICIAR SESIÓN -->
        <div class="box-form">
            <h2>Iniciar Sesión</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="grupo-campo">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>
                <div class="grupo-campo">
                    <label>Contraseña</label>
                    <!-- Agregamos el contenedor y el ícono del ojo -->
                    <div class="campo-password-wrapper">
                        <input type="password" id="pass-login" name="password" placeholder="********" required>
                        <i class="fa-solid fa-eye ojo-icono" id="ojo-login"></i>
                    </div>
                </div>
                <button type="submit" style="background-color: #1e3a8a;">Ingresar al Sistema</button>
            </form>
        </div>

        <!-- FORMULARIO 2: REGISTRAR NUEVO USUARIO -->
        <div class="box-form">
            <h2>Registrar Nuevo Usuario</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="grupo-campo">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" placeholder="Juan Pérez" required>
                </div>
                <div class="grupo-campo">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="juan@correo.com" required>
                </div>
                <div class="grupo-campo">
                    <label>Contraseña</label>
                    <!-- Agregamos el contenedor y el ícono del ojo -->
                    <div class="campo-password-wrapper">
                        <input type="password" id="pass-register" name="password" placeholder="Mínimo 6 caracteres" required>
                        <i class="fa-solid fa-eye ojo-icono" id="ojo-register"></i>
                    </div>
                </div>
                <div class="grupo-campo">
                    <label>Asignar Rol Corporativo</label>
                    <select name="rol" required>
                        <option value="cliente">Cliente</option>
                        <option value="vendedor">Vendedor</option>
                        <option value="domiciliario">Domiciliario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit">Crear Cuenta</button>
            </form>
        </div>
    </main>

    <!-- SCRIPT DE JAVASCRIPT PARA MANEJAR LA INTERACTIVIDAD -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Configuración para el ojo del Login
            const ojoLogin = document.getElementById('ojo-login');
            const passLogin = document.getElementById('pass-login');

            if (ojoLogin && passLogin) {
                ojoLogin.addEventListener('click', function() {
                    const tipo = passLogin.getAttribute('type') === 'password' ? 'text' : 'password';
                    passLogin.setAttribute('type', tipo);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Configuración para el ojo del Registro
            const ojoRegister = document.getElementById('ojo-register');
            const passRegister = document.getElementById('pass-register');

            if (ojoRegister && passRegister) {
                ojoRegister.addEventListener('click', function() {
                    const tipo = passRegister.getAttribute('type') === 'password' ? 'text' : 'password';
                    passRegister.setAttribute('type', tipo);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>