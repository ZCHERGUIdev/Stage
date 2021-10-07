<?php
include_once('connect.php');

session_start();

if(isset($_SESSION['admin_id'])){
    header('location:dashboard.php');
}

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    header('Location: forgot-password_admin.php?error');
} else {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $q="SELECT * FROM `admin` WHERE `email`='$email' and `token`='$token'";
        $r=mysqli_query($dbc,$q);
        $num=mysqli_num_rows($r);

        if($num==1){
            if(isset($_POST['submit'])){
                $password=$_POST['password'];
                $cpassword=$_POST['cpassword'];
              
                    if($password==$cpassword){
                      $password=md5($password);
                      $q="UPDATE `admin` SET `password`='$password' WHERE email='$email'";
                      $r=mysqli_query($dbc,$q);
                      //$msg="Le mot de passe a été changé avec succès";
                      header('Location: login_admin.php?pass_change');
                    }else{
                      $msg="Les deux mots de passe ne sont pas identiques";
                    }
              }
        }else{
            header('Location: forgot-password_admin.php?error');
        }

        
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mot de passe oublié?</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Mot de passe oublié?</h1>
                                        <p class="mb-4">Nous comprenons, il se passe des choses. Entrez simplement votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
                                    </div>

                                    <?php if(isset($msg)){ ?>
                                        <div class="alert alert-info">
                                        <strong>Info!</strong> <?= $msg ?>
                                        </div>
                                    <?php } ?>

                                    <?php if(isset($_GET['success'])){ ?>
                                        <div class="alert alert-success">
                                        <strong>Info!</strong> Le lien de récupération du mot de passe a été envoyé, vérifiez votre email
                                        </div>
                                    <?php } ?>

                                    

                                    <form class="user" action="reset_password_admin.php?email=<?= $email ?>&token=<?= $token ?>" method="post">

                                    <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Nouveau mot de passe" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Confirmation mot de passe" name="cpassword" required>
                                        </div>
                                        
                                        <input type="submit" name="submit" class="btn btn-success btn-user btn-block" value="Changer mot de passe">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Page d'accueil</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login_admin.php">Vous avez déjà un compte? Connexion!</a>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>