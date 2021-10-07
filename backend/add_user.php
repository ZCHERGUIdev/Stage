<?php
include_once('connect.php');

session_start();

if(isset($_SESSION['admin_id'])){
    $admin_id=$_SESSION['admin_id'];
}else{
    header('location:login_admin.php');
}

if(isset($_POST['submit'])){
    $fullname=$_POST['fullname'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];

    $q="SELECT * FROM `user` WHERE `email`='$email'";
    $r=mysqli_query($dbc,$q);
    $num=mysqli_num_rows($r);

    if($num==0){
        if($password==$cpassword){
            $password=md5($password);

            $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
			$token = str_shuffle($token);
            $token = substr($token, 0, 30);
            $message="
            Veuillez cliquer sur le lien ci-dessous:
            http://localhost/stage/backend/confirm_user.php?email=".$email."&token=".$token;

            if(mail($email,"Resto",$message)){
                $q="INSERT INTO `user`(`fullname`, `phone`, `email`, `password`, `token`) VALUES ('$fullname', '$phone', '$email', '$password', '$token')";
              $r=mysqli_query($dbc,$q);
              if($r){
                header('Location: users.php?success');
              }else{
                $msg="Il y a un problème pendant le processus d'inscription";
              }
            }

        }else{
            $msg="Les deux mots de passe ne sont pas identiques";
        }
    }else{
        $msg="Ce email est déja utilisé";
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

    <title>Ajouter un utilisateur</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include('sidebar.html'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include('topbar.html'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Ajouter un utilisateur</h1>

                                    <?php if(isset($msg)){ ?>
                                        <div class="alert alert-info">
                                        <strong>Info!</strong> <?= $msg ?>
                                        </div>
                                    <?php } ?>

                                    

                    <form action="add_user.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nom complet" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Numéro de téléphone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Adresse email" name="email" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-md">
                            <input type="password" class="form-control" placeholder="Mot de passe" name="password" required>
                        </div>
                        <div class="form-group col-md">
                            <input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="cpassword" required>
                        </div>
                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-primary" value="Ajouter un utilisateur">
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include('footer.html') ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>