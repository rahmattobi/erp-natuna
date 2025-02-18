<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ERP Natuna Global - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('adminAssets/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0 ">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img width="200" src="{{ asset('adminAssets/img/natuna2.png') }}" alt="" srcset="">
                                        {{-- <h1 class="h4 text-gray-900 mb-4">Erp Natuna Global</h1> --}}
                                    </div>
                                    <br><br>
                                    <form action="{{ route('login.action') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input name="email" type="email" class= "form-control form-control-user @error('email') is-invalid @enderror"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                                @error('email')
                                                    <span class="invalid-feedback"> {{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="exampleInputPassword" placeholder="Password">
                                                @error('password')
                                                    <span class="invalid-feedback"> {{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                       <br>
                                       <br>
                                       <br>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('adminAssets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminAssets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('adminAssets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('adminAssets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
