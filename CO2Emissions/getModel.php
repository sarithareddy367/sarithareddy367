<?php

	$db = mysqli_connect('localhost', "root", "");
	mysqli_select_db($db,"co2emissions");

	$selectedCompany = $_GET['company'];

	$sqlStatement = $db->prepare("SELECT DISTINCT Model FROM vehicle_emissions WHERE Company=?");
	$sqlStatement->bind_param("s",$selectedCompany);
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();
	$numrows=mysqli_num_rows($result);

	$temp = array();

	while ($row = mysqli_fetch_array($result)) {
		if(empty($temp))
 		{
   			$temp=array($row['Model']);
 		}
 		else
 		{  
   			array_push($temp,$row['Model']);
 		}
	}

	header('Content-Type: application/json');
	echo (json_encode($temp));
	exit;

?>
