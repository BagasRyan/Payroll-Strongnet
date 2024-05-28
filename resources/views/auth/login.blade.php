<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Strong net | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">


    <!-- Link CDNJS SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <link href="{{ asset('dist/css/styles.css') }}" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="row">
            @if(session('gagal'))
            <p class="bg-danger p-2">{{ session('gagal') }}</p>
            @endif
            <h2 class="text-center">Login</h2>
            <div class="col-lg-6 col-md-6 p-5">
                <div class="login-logo m-2">
                    <img src="{{ asset('images/strongnet2.png') }}" alt="AdminLTE Logo" width="375" height="175"
                        style="opacity: .8">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 p-5">
                <div class="card-body">
                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input class="form-control bg-dark text-light" name="email" id="inputEmail" type="email"
                                placeholder="" />
                            <label for="inputEmail">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control bg-dark text-light" id="inputPassword" name="password"
                                type="password" placeholder="Password" />
                            <label for="inputPassword">Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0 w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
    <!-- @if(session('logout'))
    <script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "success",
        title: `{{ session('logout') }}`
    });
    </script>
    @endif -->
</body>

</html>