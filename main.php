<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <title>axbuglak TODO</title>
  </head>
	<?php
		if((int)date('G') < 5) {
			echo "<body class='night'>";     			
		} else {
    			echo "<body class='light'>";
		}
		if(empty($_POST['name']) || empty($_POST['password']) || empty($_POST['list'])) {
			echo "<h1>Keine Daten wurden gesendet</h1>";
			return;
		}
		echo "<h1>" . $_POST['list'] . "</h1>";
		$accountsFileName = "/var/www/html/10k/oleksii.buglak/2302/accountsAndLists/" . $_POST['list'] . "Users.txt";
		$accountsFile = file_get_contents($accountsFileName);
		$accounts = explode("\n", $accountsFile);
		$isAuth = '';
		foreach ($accounts as $key => $value) {
			$namePassword = explode("||", $value);
			if($_POST['name'] == $namePassword[0]) {
				if( $_POST['password'] != $namePassword[1]) {
					echo "False password";
					return;
				}
				$isAuth = trim(strtolower($namePassword[2]));				
			}
		};
		if($isAuth == '') {
			if($_POST['horns'] == false) {
				echo "<h1>AGB ist pflicht</h1>";
				return;
			}
			$newUser = fopen($accountsFileName, 'a+');
			if($newUser) {
				fwrite($newUser, $_POST['name'] . "||" . $_POST['password'] . "||" . "admin" . "\n");
				fclose($newUser);
			}
			$isAuth = 'admin';
			echo 'New user was created';
		};
		$todoListName = "/var/www/html/10k/oleksii.buglak/2302/accountsAndLists/" . $_POST['list'] . "Text.txt";
		
		$listContent = file_get_contents("accountsAndLists/" . $_POST['list'] . "Text.txt");
		$linesLength = 0;
		$listLinesArray = explode("\n", $listContent);
		if($isAuth == "admin") {
			$usersListName = "accountsAndLists/" . $_POST['list'] . "Users.txt";
			$usersContent = file_get_contents($usersListName);
			if(isset($_POST['newTodoList'])) {
				$list = fopen($todoListName, 'w');
				fwrite($list, $_POST['newTodoList']);
				$listContent = $_POST['newTodoList'];
				$listLinesArray = explode("\n", $listContent);
				fclose($list);
			};
			echo '<div>';
			echo "<form action='main.php' method='POST'> <textarea name='newTodoList' class='login__input' rows='10'>" . $listContent . "</textarea>";
			echo "<input type='hidden' name='name' value='" . $_POST['name'] ."'><input value='" . $_POST['password']. "' type='hidden' name='password'><input value='" . $_POST['list']. "' type='hidden' name='list'>";
			echo "<div><input type='submit' class='login__submit' value='Update list'></div> </form>";

			if(isset($_POST['userIndexToDelete']) && $_POST['userIndexToDelete'] != '') {
				$accounts[$_POST['userIndexToDelete']] = '';
				$usersContent = join("\n", $accounts);
				file_put_contents($usersListName, $usersContent);
			} elseif (isset($_POST['newUserName']) && isset($_POST['newUserPassword']) && isset($_POST['newUserRole'])) {
				array_push($accounts, $_POST['newUserName'] . "||" . $_POST['newUserPassword'] . "||" . $_POST['newUserRole'] . "\n");
				$usersContent = join("\n", $accounts);
				file_put_contents($usersListName, $usersContent);
			}
			
			
			foreach ($accounts as $key => $value) {
				if($value != '') {
					$userInfo = explode("||", $value);
					echo "<form action='main.php' method='POST' style='display: flex; gap: 10px; margin-top: 20px; width: 100%; align-items: center;' ><div>" . $userInfo[0] . "</div><div>" . $userInfo[1] . "</div><div>" . $userInfo[2] . "</div></div><input class='login__submit' style='background:red;' type='submit' style='margin-left: 15px;' value='Delete user'>";
					echo "<input type='hidden' name='userIndexToDelete' value='" . $key ."'> <input type='hidden' name='name' value='" . $_POST['name'] ."'><input value='" . $_POST['password']. "' type='hidden' name='password'><input value='" . $_POST['list']. "' type='hidden' name='list'></form>";
				}
			};

			echo "<form action='main.php' method='POST' style='display: flex; gap: 10px; margin-top: 5px;'>";
			echo '<input class="login__input" type="text" name="newUserName" size="20" placeholder="Name" required maxlength="30">';
			echo '<input class="login__input" type="text" name="newUserPassword" maxlength="30" required placeholder="password">';
			echo '<input class="login__input" type="text" name="newUserRole" maxlength="30" required placeholder="New user role">';
		    echo "<input type='hidden' name='name' value='" . $_POST['name'] ."'><input value='" . $_POST['password']. "' type='hidden' name='password'><input value='" . $_POST['list']. "' type='hidden' name='list'>";
			echo '<div><input class="login__submit" style="background:red;" type="reset"  value="Verwerfen"><input class="login__submit" type="submit" value="Create new user for this list"></div></form>';
			echo "</div>";
		} elseif($isAuth == 'user') {
				if($listContent == '') {
					echo 'TODO not found or you are not a member of this sheet';
					return;
				}
				echo "<div class='list'> <p> You can not edit this list </p>";
				foreach ($listLinesArray as $key => $line) {
					echo "<p class='list__item'>" . $line . "</p>";	
				}
				echo "</div>";	
		};
		foreach ($listLinesArray as $key => $line) {
			$linesLength += strlen($line);
		}
		$averageLineLength = $linesLength / count($listLinesArray);
		echo "<p>Averag length of your exercise: " . $averageLineLength . "</p>";
		$computer = $_SERVER['HTTP_USER_AGENT'];
		echo $_SERVER['REMOTE_ADDR'] . " - API</br>";
		echo $computer;
		$file = 'static.log';
		$current = file_get_contents($file);
		$current .= $_SERVER['REMOTE_ADDR'] . "\n";
		file_put_contents($file, $current);
		echo "</body>";
	?>
</html>
