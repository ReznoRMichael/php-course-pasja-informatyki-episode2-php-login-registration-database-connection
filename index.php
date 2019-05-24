<?php

session_start();

if (isset($_SESSION['login'])) unset($_SESSION['login']);
if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin']==true))
{
	header('Location: game.php');
	exit(); // opuszczamy plik, natychmiastowe otwarcie przekierowania bez straty mocy obliczeniowej na dalsze wykonanie pliku
}

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
	<title>Settlers - Game</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<link href="css/styles.css" type="text/css" rel="stylesheet">
	
</head>

<body>
<div id="container"></div>
		<div id="form_login">
			<p>Settlers - Game</p>
			<a href="register.php" class="tilelinkhtml5"><div class="button">Register</div></a>
			<form action="login.php" method="post">

			<input type="text" name="login" placeholder="Login"> <br>
			<input type="password" name="password" placeholder="Password"> <br>
			<button>Enter</button>
			
			</form>
			
			<?php if (isset($_SESSION['error'])) {echo $_SESSION['error']; session_unset();} ?>
		</div>

</body>

</html>