<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>

    <link href="css/vendor.css" rel="stylesheet">
    <link href="css/sux-admin.min.css" rel="stylesheet">
    <link href="css/app-login.css" rel="stylesheet">
  </head>
  <body>
    <div class="col-md-4 col-md-offset-4 form-login">
        <div class="outter-form-login">
        <div class="logo-login">
            <em class="glyphicon glyphicon-user"></em>
        </div>
            <form action="login-validate.php" class="inner-login" method="post">
                <h3 class="text-center title-login">Login Member</h3>
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>

                <input type="submit" class="btn btn-block btn-custom-green" value="LOGIN" />
            </form>
        </div>
    </div>

    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/vendor.js"></script>
    <script src="js/sux-admin.min.js"></script>
  </body>
</html>