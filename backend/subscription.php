<?php
include_once('connect.php');
include('function_inc.php');

session_start();

if(isset($_SESSION['admin_id'])){
    $admin_id=$_SESSION['admin_id'];
}else{
    header('location:login_admin.php');
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

    <title>Abonnements</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Abonnements</h1>

                    <?php if(isset($_GET['success'])){ ?>
                                        <div class="alert alert-success">
                                        <strong>Info!</strong> Inscription terminée avec succès, l'e-mail doit être activé
                                        </div>
                                    <?php } ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Abonnements</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom complet</th>
                                            <th>Numéro de téléphone</th>
                                            <th>De</th>
                                            <th>à</th>
                                            <th>il rest</th>
                                            <th>Modifier</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom complet</th>
                                            <th>Numéro de téléphone</th>
                                            <th>De</th>
                                            <th>à</th>
                                            <th>il rest</th>
                                            <th>Modifier</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $q="SELECT * FROM `subscription`";
                                        $r=mysqli_query($dbc,$q);
                                        while($row=mysqli_fetch_assoc($r)){
                                            $id=$row['user_id'];
                                            $getSubscriptionInfo=getInfoById('user',$id);
                                        ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $getSubscriptionInfo['fullname'] ?></td>
                                            <td><?= $getSubscriptionInfo['phone'] ?></td>
                                            <td><?= $row['from_date'] ?></td>
                                            <td><?= $row['to_date'] ?></td>

<?php
// Declare and define two dates
$date1 = strtotime(date("Y-m-d H:i:s")); 
$date2 = strtotime($row['to_date']); 
  
// Formulate the Difference between two dates
$diff = abs($date2 - $date1); 
  
  
// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
$years = floor($diff / (365*60*60*24)); 
  
  
// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
$months = floor(($diff - $years * 365*60*60*24)
                               / (30*60*60*24)); 
  
  
// To get the day, subtract it with years and 
// months and divide the resultant date into
// total seconds in a days (60*60*24)
$days = floor(($diff - $years * 365*60*60*24 - 
             $months*30*60*60*24)/ (60*60*24));
  
  
// To get the hour, subtract it with years, 
// months & seconds and divide the resultant
// date into total seconds in a hours (60*60)
$hours = floor(($diff - $years * 365*60*60*24 
       - $months*30*60*60*24 - $days*60*60*24)
                                   / (60*60)); 
  
  
// To get the minutes, subtract it with years,
// months, seconds and hours and divide the 
// resultant date into total seconds i.e. 60
$minutes = floor(($diff - $years * 365*60*60*24 
         - $months*30*60*60*24 - $days*60*60*24 
                          - $hours*60*60)/ 60); 
  
  
// To get the minutes, subtract it with years,
// months, seconds, hours and minutes 
$seconds = floor(($diff - $years * 365*60*60*24 
         - $months*30*60*60*24 - $days*60*60*24
                - $hours*60*60 - $minutes*60)); 
  
// Print the result
printf("<td>%d ans, %d mois, %d jours, %d heures, "
     . "%d minutes, %d seconds", $years, $months,
             $days, $hours, $minutes, $seconds."<td>");
?>
                                        <td><button type="button" class="btn btn-success btn-block">Modifier</button></td>    
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