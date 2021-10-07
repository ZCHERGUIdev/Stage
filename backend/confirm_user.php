<?php
	include_once 'connect.php';

	if (!isset($_GET['email']) || !isset($_GET['token'])) {
		header('Location: login_user.php');
	} else {
		$email = $_GET['email'];
		$token = $_GET['token'];

        

		$q="SELECT * FROM `user` WHERE `email`='$email' and `token`='$token'";
        
  		$r=mysqli_query($dbc,$q);
		$num=mysqli_num_rows($r);
		if($num==1){
		
		$row=mysqli_fetch_assoc($r);
		$user_id=$row['id'];

		$q0="UPDATE `user` SET `active`=1 WHERE `id`='$user_id'";
		$r0=mysqli_query($dbc,$q0);
		header('Location: login_user.php?success');
		}else{
			header('Location: login_user.php');
		}
	}
?>