<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>axbuglak todo login</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
  </head>
	<?php 
		$colors = array('#deffc2', '#b1eff0', '#f0b1e3', '#d0b1f0', '#f0ccb1', '#f0b1b2');
		$colorNum = rand(1, count($colors));
		echo "<body class='light' style='background-color:" . $colors[$colorNum] . ";'>";
	?>
	<h1>Login to admin</h1>
	<form class="login__form" action="main.php" class="register__form" method="post"> 
 		<input class="login__input" type="text" name="name" size="20" placeholder="Dein Name" required maxlength="30">
		<input class="login__input" type="text" name="password" maxlength="30" required placeholder="password">
		<input class="login__input" type="text" name="list" maxlength="30" required placeholder="TODO List name">

 		<div>
			<input type="checkbox" id="horns" name="horns" required />	
			<label for="horns">mit AGB einverstanden</label>
		</div>
		<div>
 			<input class="login__submit" style="background:red;" type="reset"  value="Verwerfen"> 				
			<input class="login__submit" type="submit" value="Anmelden">
		</div>
 	</form>
	<?php 
		echo "</body>";
	?>
</html>
