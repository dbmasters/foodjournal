<?php
error_reporting(E_ALL);
session_start();
include("classes/Load.php");
$db = new Database();
$meal = new Meal();
$meal->db = $db;

$meal_id = "";
$title = "";
$ingredients = "";
$calories = "";
$served_date = "";
$served_time = "";
$form_title = "Add a Meal";

$feedback = "";
if(array_key_exists('submit', $_POST)) {
	$username = $_POST["username"];
	$userpass = md5($_POST["userpass"]);
	$sql = "SELECT * FROM user WHERE username = '" . $username . "' AND userpass = '" . $userpass . "'";
	$result = $db->query($sql)->fetchAll();
	if(count($result) == 1)
	{
		$feedback = $result[0]["username"] . " (" . $result[0]["user_id"] . "), you are logged in!";
		$_SESSION["user"] = $result[0]["user_id"];
	}
}
if(array_key_exists('meal_submit', $_POST)) {
	$meal->user_id = $_SESSION["user"];
	$meal->served = $_POST["served_date"] . " " . $_POST["served_time"];
	$meal->title = $_POST["title"];
	$meal->ingredients = $_POST["ingredients"];
	$meal->calories = $_POST["calories"];
	if($_POST["meal_id"] != "") {
		$meal->meal_id = $_POST["meal_id"];
		$meal->updateMeal();
	} else {
		$meal->addMeal();
	}
}
if(array_key_exists('edit', $_GET)) {
	$form_title = "Edit a Meal";
	$meal->user_id = $_SESSION["user"];
	$meal->meal_id = $_GET["edit"];
	$results = $meal->getMealByMealId();
	foreach($results as $result) {
		$meal_id = $result["meal_id"];
		$title = $result["title"];
		$ingredients = $result["ingredients"];
		$calories = $result["calories"];
		$served_date = substr($result["datetime_served"], 0, 10);
		$served_time = substr($result["datetime_served"], 11);
	}
}
if(array_key_exists('delete', $_GET)) {
	$meal->user_id = $_SESSION["user"];
	$meal->meal_id = $_GET["delete"];
	$meal->deleteMeal();

}
$datetimes = [
	"01:00:00" => "1AM", 
	"02:00:00" => "2AM", 
	"03:00:00" => "3AM", 
	"04:00:00" => "4AM", 
	"05:00:00" => "5AM", 
	"06:00:00" => "6AM", 
	"07:00:00" => "7AM", 
	"08:00:00" => "8AM", 
	"09:00:00" => "9AM", 
	"10:00:00" => "10AM", 
	"11:00:00" => "11AM", 
	"12:00:00" => "12PM", 
	"13:00:00" => "1PM", 
	"14:00:00" => "2PM", 
	"15:00:00" => "3PM", 
	"16:00:00" => "4PM", 
	"17:00:00" => "5PM", 
	"18:00:00" => "6PM", 
	"19:00:00" => "7PM", 
	"20:00:00" => "8PM", 
	"21:00:00" => "9PM", 
	"22:00:00" => "10PM", 
	"23:00:00" => "11PM", 
	"24:00:00" => "12PM"
	];
include('includes/header.php');
?>
<div class="container">
	<div class="row">
		<div class="col">
			<h1>Food Journal</h1>
		</div>
	</div>
	<?php if ($feedback != "") { ?>

	<div class="row">
		<div class="col">
			<h4><?php echo $feedback; ?></h4>
		</div>
	</div>

	<?php } ?>

	<?php if (isset($_SESSION["user"]) && $_SESSION["user"] != "") { ?>

	<div class="row">
		<div class="col-9">
			<table id="dataTable" class="display stripe hover cell-border">
				<thead>
					<tr>
						<th><a href="index.php">Add</a></th>
						<th>&nbsp;</th>
						<th>Served</th>
						<th>Title</th>
						<th>Ingredients</th>
						<th>Calories</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$meal->user_id = $_SESSION["user"];
					$results = $meal->getMealByUser();
					foreach($results as $result)
					{
						echo "<tr>";
						echo "<td><a href=\"index.php?edit=" . $result["meal_id"] . "\">Edit</a></td>";
						echo "<td><a href=\"index.php?delete=" . $result["meal_id"] . "\" onclick=\"return confirm('Are you sure you want to delete " . $result["title"] . "');\">Delete</a></td>";
						echo "<td>" . $result["datetime_served"] . "</td>";
						echo "<td>" . $result["title"] . "</td>";
						echo "<td>" . $result["ingredients"] . "</td>";
						echo "<td>" . $result["calories"] . "</td>";
						echo "</tr>";
					}
				?>			
				</tbody>
			</table>
		</div>
		<div class="col-3">
			<div style="margin: 5px;">
				<form action="" method="post">
					<label>Title *</label>
					<br>
					<input type="text" name="title" id="title" value="<?php echo $title; ?>" required>
					<br>
					<label>Serve Date/Time *</label>
					<br>
					<input type="date" name="served_date" id="served_date" value="<?php echo $served_date; ?>" required>
					<br>
					<select name="served_time" id="served_time" required>
						<?php
						foreach($datetimes as $key => $value) {
							$selected = "";
							if($served_time == $key) {
								$selected = " selected";
							}
							echo "<option value =\"" . $key . "\"" . $selected . ">" . $value . "</option>";
						}
						?>
					</select>
					<br>
					<label>Ingredients</label>
					<br>
					<textarea name="ingredients" id="ingredients"><?php echo $ingredients; ?></textarea>
					<br>
					<label>Calories</label>
					<br>
					<input type="number" name="calories" id="calories" value="<?php echo $calories; ?>">
					<input type="hidden" name="meal_id" id="meal_id" value="<?php echo $meal_id; ?>">
					<br><br>
					<input type="submit" name="meal_submit" id="meal_submit" value="<?php echo $form_title; ?>">
				</form>
			</div>
		</div>
	</div>
	
	<?php } else { ?>

	<div class="row">
		<div class="col">
			<form action="" method="post">
				<label>Username</label>
				<br>
				<input type="text" name="username" id="username">
				<br>
				<label>Password</label>
				<br>
				<input type="password" name="userpass" id="userpass">
				<br><br>
				<input type="submit" name="submit" id="submit" value="Login!">
			</form>
		</div>
	</div>

	<?php } ?>
</div>
<?php
include('includes/footer.php');
?>