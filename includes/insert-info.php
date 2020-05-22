<?php
	print_r($_REQUEST);
	include('db_connection.php');
	$description = mysqli_real_escape_string($conn, $_REQUEST['description']);
	$sql = "INSERT INTO info(user_name, latitude, longitutde, user_mobile, user_email, city, description) VALUES('".$_REQUEST['name']."', '".$_REQUEST['lat']."', '".$_REQUEST['long']."', ".$_REQUEST['mobile'].", '".$_REQUEST['email']."', 'city_name', '$description')";
	echo "<pre>";
	echo $sql;
?>