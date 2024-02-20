<?php

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

switch ($selectedCategory) {
    case 1:
        header('Location: calc_vehicles_emission.php');
        exit();
    case 2:
        header('Location: calc_country_emission.php');
        exit();
    default:
        header('Location: category.php');
        exit();
}

?>