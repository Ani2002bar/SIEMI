<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de autenticación">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Iniciar Sesión</title>

    <!-- Custom fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .bg-gradient-custom {
            background: linear-gradient(95deg, #11452d 10%, #1b3a34 50%, #112f24 100%);
            color: #ffffff;
        }

        .login-image {
            background: url('{{ asset('img/6QQGqDyu_400x400.jpg') }}') no-repeat center center;
            background-size: cover;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        .btn-primary {
            background: linear-gradient(95deg, #1b3a34, #112f24);
            border: none;
            color: #ffffff;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(95deg, #112f24, #11452d);
            transform: translateY(-2px);
        }

        .invalid-feedback {
            color: #e74a3b;
        }
    </style>
</head>

<body class="bg-gradient-custom">

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">

        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenido</h1>
                                    </div>

                                    <!-- Mensajes de Éxito o Error -->
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Formulario de Inicio de Sesión -->
                                    <form method="POST" action="{{ route('login.perform') }}" class="user"
                                        autocomplete="off">
                                        @csrf
                                        <!-- Campo de correo electrónico -->
                                        <div class="form-group">
                                            <input type="email" name="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                placeholder="Ingrese su correo electrónico" value="{{ old('email') }}"
                                                required autofocus autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Campo falso para evitar sugerencias de contraseña -->
                                        <input type="password" name="fake_password" style="display: none;" tabindex="-1"
                                            autocomplete="new-password">

                                        <!-- Campo real de contraseña -->
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                placeholder="Ingrese su contraseña" required
                                                autocomplete="new-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Iniciar Sesión
                                        </button>
                                    </form>


                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#">¿Olvidaste tu contraseña?</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>

</html>