<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CO2 Emissions</title>

	<style>
	h1 {
		text-align:center;
	}

	select {
            width: 200px;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
	    margin-left:50px;
        }

	label {
		font-size: 18px;
            	font-weight: bold;
            	margin-bottom: 10px;
		margin-left:50px;
	}	

	#btnSubmit {
            background-color: #2ecc71; 
            color: #000; 
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
	    margin-left:200px;    
        }

        #btnSubmit:hover {
            background-color: #27ae60; 
        }

	div {
		width:500px;
		height:300px;
		align-items: center;
		margin:0 auto;
		margin-top:50px;
		padding: 40px;
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

	</style>

</head>
<body>
	<header>
		<h1>CO2 Emissions</h1>
	</header>

	<?php

	$db = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($db,"co2emissions");

	$sqlStatement = $db->prepare("SELECT CategoryID,CategoryName FROM category");
	$sqlStatement->execute();
	$result = $sqlStatement->get_result();

	$numfields=mysqli_num_fields($result);
	$numrows=mysqli_num_rows($result);

	?>

	<div id="divCategory">

	<form method="get" action="page_redirection.php"> 
	<label for="category">Select Category: </label>
	<select id="category" name="category" required>
	<option value="">Select Category</option>

	<?php
	while ($row = mysqli_fetch_assoc($result)) {
    		echo "<option value='" . $row['CategoryID'] . "'>" . $row['CategoryName'] . "</option>";
	}

	?>

	</select><br><br>
	<input id="btnSubmit" type="submit" value="Submit">
	</form>

	</div>

	<footer>
        	<p>CO2 Emissions - Implemented by Group 8. All rights reserved!</p>
    	</footer>
     
</body>
</html>