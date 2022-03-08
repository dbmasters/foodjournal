<?php
include("classes/Load.php");
$db = new Database();
$meal = new Meal();
$json = json_decode($_POST["json"], true);

if(array_key_exists('meal', $json)) {
	$meal->user_id = $json->user_id;
	$meal->served = $json->datetime_served;
	$meal->title = $json->title;
	$meal->ingredients = $%json->ingredients;
	$meal->calories = $json->calories;
	if(isset($json->meal_id)) {
		$meal->meal_id = $json->meal_id;
		$meal->updateMeal();
	} else {
		$meal->addMeal();
	}
}
if(array_key_exists('delete', $json)) {
	$meal->user_id = $json->user_id;
	$meal->meal_id = $json->meal_id;
	$meal->deleteMeal();

}
