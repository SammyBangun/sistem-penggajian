<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SIPEKA CleanX</title>

    <?php include('./header.php'); ?>
    <?php include('./db_connect.php'); ?>
    <?php ?>

</head>
<style>
    .judul {
        text-align: center;
        margin: 25px;
        margin-bottom: 10px;
        width: fit-content;
    }

    body {
        width: 100%;
        height: calc(100%);
    }

    main#main {
        width: 100%;
        height: calc(100%);
        background: white;
    }

    #login-right {
        position: absolute;
        right: 0;
        width: 40%;
        height: calc(100%);
        display: block;
        align-items: center;
        justify-content: center;
    }

    #login-left {
        position: absolute;
        left: 0;
        width: 60%;
        height: calc(100%);
        background: #59b6ec61;
        display: flex;
        align-items: center;
        background: url(assets/img/img-log.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

    #login-right .card {
        margin: auto;
        z-index: 1
    }

    .logo {
        margin: auto;
        font-size: 8rem;
        background: white;
        padding: .5em 0.7em;
        border-radius: 50% 50%;
        color: #000000b3;
        z-index: 10;
    }

    div#login-right::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(100%);
        height: calc(100%);
    }

    #login-form {
        margin-top: 20px;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .button-container a {
        text-decoration: none;
    }
</style>

<body>

    <main id="main" class=" bg-dark">
        <div id="login-left"></div>

        <div id="login-right">
            <h1 class="judul">SIPEKA CleanX</h1>
            <div class="card col-md-8">
                <div class="card-body">
                    <h2 style="text-align: center;">Register Staff</h2>
                    <form id="register-form">
                        <div class="form-group">
                            <label for="name" class="control-label">Nama</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="contact" class="control-label">Contact</label>
                            <input type="text" id="contact" name="contact" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">Address</label>
                            <input type="text" id="address" name="address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <center><button type="submit" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Kirim</button></center>
                    </form>
                    <div class="button-container">
                        <a href="login.php">kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#register-form').submit(function(e) {
        e.preventDefault();
        var $btn = $('#register-form button[type="submit"]');
        $btn.attr('disabled', true).html('Mengirim...');
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'ajax.php?action=signup',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err);
                $btn.removeAttr('disabled').html('Kirim');
            },
            success: function(resp) {
                if (resp == 1) {
                    alert('Registrasi berhasil. Anda akan dialihkan ke halaman login.');
                    location.href = 'login.php';
                } else if (resp == 2) {
                    $('#register-form').prepend('<div class="alert alert-danger">Username sudah digunakan.</div>');
                    $btn.removeAttr('disabled').html('Kirim');
                } else {
                    $('#register-form').prepend('<div class="alert alert-danger">Registrasi gagal. Silakan coba lagi.</div>');
                    $btn.removeAttr('disabled').html('Kirim');
                }
            }
        });
    });
</script>

</html>