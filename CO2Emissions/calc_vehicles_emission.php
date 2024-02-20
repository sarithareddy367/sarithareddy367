<!DOCTYPE html>
<html>
<head>
    	<meta charset="UTF-8">
    	<title>CO2 Emissions</title>

	<style>

	select {
            	width: 200px;
            	padding: 8px;
            	font-size: 14px;
            	border: 1px solid #ccc;
            	border-radius: 4px;
            	margin-bottom: 15px;
		margin-left:40px;
        }
	
	label {
		font-size: 18px;
            	font-weight: bold;
            	margin-top: 10px;
		margin-left:70px;
	}

	#btnCalc {
            	background-color: #2ecc71; 
            	padding: 10px 20px;
            	font-size: 16px;
            	border: none;
            	border-radius: 5px;
            	cursor: pointer;
		margin-left:80px; 
        }

        #btnCalc:hover {
            	background-color: #27ae60; 
        }

	#btnReset {
		background-color: #e74c3c;
	    	padding: 10px 20px;
            	font-size: 16px;
            	border: none;
            	border-radius: 5px;
            	cursor: pointer;
		margin-left:50px;
	}

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

	#divVehiclesEmission {
		width:600px;
		height:500px;
		align-items: center;
		margin:0 auto;
		margin-top:10px;
		padding: 40px;
	}
	
	td {
		padding: 5px; 
            text-align: left;
	}

	</style>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script>

	jQuery(document).ready(function() 
	{
		$('#model').val('');
		$('#company').on('change', function() 
		{
			var companySelected = $(this).val();
			$('#model').find('option').remove().end(); //clearing the model ddl when company is changed

			$.ajax	({
        			url:'getModel.php',
        			type:'GET',
        			data: {company: companySelected},
        			dataType:'json',
        			success:function(response)	{

         				var ddl = document.getElementById('model');  

					var option = document.createElement('option');      
               				option.value = "";
               				option.text  = "Select Model";
					ddl.appendChild(option);                    

         				for(var c=0;c<response.length;c++)
              				{      
						option = document.createElement('option');      
               					option.value = response[c];
               					option.text  = response[c];                           
               					ddl.appendChild(option);
              				}
    				},
        			error:function(jqXHR, textStatus, errorThrown)	{
					console.log(jqXHR.responseText);
    				}
    			});
		});
	});
	</script>

</head>
<body>
	
	<header>
		<h1>CO2 Emissions</h1>
	</header>

	<?php

	$co2Emission = "";
	$db = mysqli_connect('localhost', "root", "");
	mysqli_select_db($db,"co2emissions");
	
	if (isset($_POST['category'])) {
    		$selectedCategory = $_POST['category'];
    	}
	
	?>
	
	<div id="divVehiclesEmission">

	<form method="post" action="calculate_emissions.php">

	<table>
	<tr>

	<td>
	<label id="labelCompany" name="labelCompany">Select Company:</label>
	</td>
	<td>
	<select id="company" name="company" required>
	<option value="">Select Company</option>

	<?php

	$sqlStatement = $db->prepare("SELECT DISTINCT Company FROM vehicle_emissions");
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();

	while ($row = mysqli_fetch_array($result)) {
    		echo "<option value='" . $row['Company'] . "'>" . $row['Company'] . "</option>";
	}

	?>

	</select>
	</td>
	</tr>

	<tr><td>
	<label id="labelModel" name="labelModel">Select Model:</label>
	</td>
	<td>
	<select id="model" name="model" required>
	<option value="">Select Model</option>
	
	</select>
	</td></tr>

	<tr><td>
	<label id="lblVehicleClass" name="lblVehicleClass">Select Vehicle Class:</label>
	</td>
	<td>
	<select id="vehicleClass" name="vehicleClass" required>
	<option value="">Select Vehicle Class</option>

	<?php

	$sqlStatement = $db->prepare("SELECT DISTINCT VehicleClass FROM vehicle_emissions");
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();

	while ($row = mysqli_fetch_array($result)) {
    		echo "<option value='" . $row['VehicleClass'] . "'>" . $row['VehicleClass'] . "</option>";
	}

	?>
	
	</select>
	</td></tr>

	<tr><td>
	<label id="lblTransmission" name="lblTransmission">Select Transmission:</label>
	</td>
	<td>
	<select id="transmission" name="transmission" required>
	<option value="">Select Transmission</option>

	<?php

	$sqlStatement = $db->prepare("SELECT DISTINCT Transmission FROM vehicle_emissions");
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();

	while ($row = mysqli_fetch_array($result)) {
    		echo "<option value='" . $row['Transmission'] . "'>" . $row['Transmission'] . "</option>";
	}

	?>
	
	</select>
	</td></tr>

	<tr><td>
	<label id="lblFuelType" name="lblFuelType">Select Fuel Type:</label>
	</td>
	<td>
	<select id="fuelType" name="fuelType" required>
	<option value="">Select Fuel Type</option>

	<?php

	$sqlStatement = $db->prepare("SELECT DISTINCT FuelType FROM vehicle_emissions");
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();

	while ($row = mysqli_fetch_array($result)) {
    		echo "<option value='" . $row['FuelType'] . "'>" . $row['FuelType'] . "</option>";
	}

	?>
	
	</select>
	</td></tr>

	<tr><td>
	<input id="btnCalc" type="submit" value="Calculate Emissions" />
	</td>

	<td>
	<input id="btnReset" type="reset" value="Reset"/>
	</td></tr>

	</table>

	</form>

	</div>

	<footer>
        	<p>CO2 Emissions - Implemented by Group 8. All rights reserved!</p>
    	</footer>

</body>
</html>