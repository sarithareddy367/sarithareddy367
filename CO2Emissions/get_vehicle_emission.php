<!DOCTYPE html>
<html>
<head>
    	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>CO2 Emissions</title>

	<style>

	header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

	footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

	#divShowEmission {
		width:500px;
		height:500px;
		align-items: center;
		margin:0 auto;
		margin-top:10px;
		padding: 40px;
		margin-left:500px;
	}

	#co2BarChart {
		height:20px;
		width:20px;
	}

	

	</style>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
	
	</script>

</head>
<body>

	<header>
		<h1>CO2 Emissions</h1>
	</header>

	<div id="divShowEmission">

	<?php

	$db = mysqli_connect('localhost', "root", "");
	mysqli_select_db($db,"co2emissions");
	
	if (isset($_POST['company']) || isset($_POST['model']) || isset($_POST['vehicleClass'])|| isset($_POST['transmission']) || isset($_POST['fuelType'])) 
	{
    		$selectedCompany = $_POST['company'];
		$selectedModel = $_POST['model'];
		$selectedVehicleClass = $_POST['vehicleClass'];
		$selectedTransmission = $_POST['transmission'];
		$selectedFuelType = $_POST['fuelType'];
    	}

	echo "<b>Your selected values:</b><br>Company: ".$selectedCompany."<br>Model: ".$selectedModel."<br>VehicleClass: ".$selectedVehicleClass."<br>Transmission: ".$selectedTransmission."<br>FuelType: ".$selectedFuelType."<br>";

	$result=null;
	$row=null;
	header("Cache-Control: no-cache, must-revalidate");
	
	$sqlStatement = $db->prepare("SELECT DISTINCT CO2Emissions AS 'CO2Emissions' FROM vehicle_emissions WHERE Company=? AND Model=? AND VehicleClass=? AND Transmission=? AND FuelType=? LIMIT 1");
	$sqlStatement->bind_param("sssss", $selectedCompany,$selectedModel,$selectedVehicleClass,$selectedTransmission,$selectedFuelType);
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();

	$numrows=mysqli_num_rows($result);

	echo $numrows;

	if($numrows < 1)
	{
		echo "<br><b>No data found for above input values, contact admin to request for data update.</b>";
	}
	else
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			echo "<br><b>Calculated CO2 Emission: ".$row['CO2Emissions']."</b>";
			$emissionVal=$row['CO2Emissions'];
		}
		mysqli_free_result($result);
	}

	?>

	</div>

	<footer>
        	<p>CO2 Emissions - Implemented by Group 8. All rights reserved!</p>
    	</footer>
</body>
</html>