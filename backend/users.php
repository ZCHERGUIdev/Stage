<?php
include_once('connect.php');
include('function_inc.php');

session_start();

if(isset($_SESSION['admin_id'])){
    $admin_id=$_SESSION['admin_id'];
}else{
    header('location:login_admin.php');
}

if(isset($_POST['submit'])){
    $user_id=$_POST['user_id'];
    $amount=$_POST['amount'];
    $dayPrice=$_POST['dayPrice'];
    $days=$amount/$dayPrice;

    $q="SELECT * FROM `subscription` WHERE `user_id`='$user_id'";
    $r=mysqli_query($dbc,$q);
    $row=mysqli_fetch_assoc($r);
    $subscription_id=$row['id'];

    $q2="INSERT INTO `payment`(`sub_id`, `amount`, `dayPrice`, `days`) VALUES ('$subscription_id', '$amount', '$dayPrice', '$days')";
    $r2=mysqli_query($dbc,$q2);

    $getSubscriptionInfo=getInfoById('subscription',$subscription_id);
    $to_date=date('Y-m-d H:i:s', strtotime($getSubscriptionInfo['to_date']. ' + '.$days.' days'));
    
    $q3="UPDATE `subscription` SET `to_date`='$to_date' WHERE id='$subscription_id'";
    $r3=mysqli_query($dbc,$q3);

    $msg="Abonné avec succès";

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

    <title>Utilisateurs</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800">Utilisateurs</h1>

                    <?php if(isset($_GET['success'])){ ?>
                                        <div class="alert alert-success">
                                        <strong>Info!</strong> Inscription terminée avec succès, l'e-mail doit être activé
                                        </div>
                                    <?php } ?>

                                    <?php if(isset($msg)){ ?>
                                        <div class="alert alert-success">
                                        <strong>Info!</strong> <?= $msg ?>
                                        </div>
                                    <?php } ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="add_user.php">
                            <h6 class="m-0 font-weight-bold text-primary">+ Ajouter un utilisateur</h6>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom complet</th>
                                            <th>Numéro de téléphone</th>
                                            <th>Adresse email</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>subs</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom complet</th>
                                            <th>Numéro de téléphone</th>
                                            <th>Adresse email</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>subs</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $q="SELECT * FROM `user` where archived=0";
                                        $r=mysqli_query($dbc,$q);
                                        while($row=mysqli_fetch_assoc($r)){
                                            
                                        ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['fullname'] ?></td>
                                            <td><?= $row['phone'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['date'] ?></td>
                                            <?php
                                            if($row['active']==0){ ?>
                                            <td><h5><span class="badge badge-danger">Non-active</span></h5></td>
                                            <?php }else{ ?>
                                                <td><h5><span class="badge badge-success">Active</span></h5></td>
                                            <?php } ?>
                                            <td><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal<?= $row['id'] ?>">Ajouter un abonnement</button></td>

<!-- The Modal -->
  <div class="modal fade" id="myModal<?= $row['id'] ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Ajouter un abonnement</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="users.php" method="post">
                <div class="form-group">
                    <label>Prix ​​par jour</label>
                    <input type="number" class="form-control" value="100" name="dayPrice" required>
                </div>

                <div class="form-group">
                    <label>Le montant payé</label>
                    <input type="number" class="form-control" placeholder="Par exemple : 1000 DA" name="amount" required>
                </div>

                <input type="hidden" value="<?= $row['id'] ?>" name="user_id">
            
            <input type="submit" name="submit" class="btn btn-primary" value="Ajouter un abonnement">
            </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>