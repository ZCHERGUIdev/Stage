<?php
include_once('connect.php');

session_start();

if(isset($_SESSION['admin_id'])){
    header('location:dashboard.php');
}

if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $password=md5($password);

    $q="SELECT * FROM `admin` WHERE `email`='$email' and `password`='$password'";
    $r=mysqli_query($dbc,$q);
    $num=mysqli_num_rows($r);

    if($num==1){
        $row=mysqli_fetch_assoc($r);

        if($row['active']==1){
            if($row['archived']==0){
                $_SESSION['admin_id']=$row['id'];
                $_SESSION['admin_fullname']=$row['fullname'];
                $_SESSION['admin_phone']=$row['phone'];
                $_SESSION['admin_email']=$row['email'];
                header('location:dashboard.php');
            }else{
                $msg="dsl ce compte est supprimé";
            }
        }else{
            $msg="svp confirmer votre email";
        }

    }else{
        $msg="Erreur dans l'adresse mail ou dans mot de passe";
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

    <title>Connexion administrateur</title>

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
                                        <h1 class="h4 text-gray-900 mb-4">Connexion administrateur</h1>
                                    </div>

                                    <?php if(isset($msg)){ ?>
                                        <div class="alert alert-info">
                                        <strong>Info!</strong> <?= $msg ?>
                                        </div>
                                    <?php } ?>

                                    <?php if(isset($_GET['success'])){ ?>
                                        <div class="alert alert-success">
                                        <strong>Info!</strong> Votre compte a été activé, vous pouvez vous connecter maintenant
                                        </div>
                                    <?php } ?>

                                    <?php if(isset($_GET['pass_change'])){ ?>
                                        <div class="alert alert-success">
                                        <strong>Info!</strong> Mot de passe modifié avec succès, vous pouvez vous connecter maintenant
                                        </div>
                                    <?php } ?>

                                    <form class="user" action="login_admin.php" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" placeholder="Entrer l'adresse e-mail..." name="email" required value="belalia.alaaeddine@gmail.com">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Mot de passe" name="password" required value="123">
                                        </div>
                                        <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="S'identifier">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password_admin.php">Mot de passe oublié?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Page d'accueil</a>
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