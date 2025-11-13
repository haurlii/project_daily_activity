<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Daily Activity - Daftar Akun</title>

    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        /* Menggunakan path gambar yang sama dengan Login (sesuai permintaan) */
        body.bg-gambar-login {
            background: url('../../img/bgg.jpg') no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>

</head>

<body class="bg-gambar-login">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            
                            <div class="col-lg-12"> 
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="../../img/Logo dac.webp" 
                                            alt="Logo Perusahaan" 
                                            style="max-width: 150px; margin-bottom: 25px;"> 
                                        
                                        <h1 class="h5 text-gray-900 mb-2"> 
                                            <span class="font-weight-bold">Buat Akun Daily Activity</span>
                                        </h1>
                                        <div class="mb-4 text-gray-600">
                                            Silahkan Masukkan Data Anda untuk Mendaftar
                                        </div>
                                    </div>
                                    <form class="user" method="post" onsubmit="event.preventDefault(); register();" id="registerForm">
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="nama_depan" class="form-control form-control-user" id="exampleFirstName"
                                                     placeholder="Nama Depan" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="nama_belakang" class="form-control form-control-user" id="exampleLastName"
                                                     placeholder="Nama Belakang" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                                 placeholder="Alamat Email" required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" name="password" class="form-control form-control-user"
                                                     id="exampleInputPassword" placeholder="Kata Sandi" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" name="konfirmasi_password" class="form-control form-control-user"
                                                     id="exampleRepeatPassword" placeholder="Ulangi Kata Sandi" required>
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-primary btn-user btn-block" type="submit">Daftar Akun</button>
                                    </form>

                                    <hr>
                                    
                                    <div class="text-center">
                                        <a class="small" href="login.html">Sudah punya akun? Masuk!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../../js/sb-admin-2.min.js"></script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const nama_depan = document.getElementById('exampleFirstName').value.trim();
            const nama_belakang = document.getElementById('exampleLastName').value.trim();
            const email = document.getElementById('exampleInputEmail').value.trim();
            const password = document.getElementById('exampleInputPassword').value;
            const konfirmasi_password = document.getElementById('exampleRepeatPassword').value;
            
            // Contoh validasi sederhana: memastikan semua field terisi
            if (!nama_depan || !nama_belakang || !email || !password || !konfirmasi_password) {
                alert('Semua field wajib diisi, termasuk memilih Role!');
                return;
            }
        });
    </script>

    <script src="../../script/auth.js"></script>
</body>

</html>