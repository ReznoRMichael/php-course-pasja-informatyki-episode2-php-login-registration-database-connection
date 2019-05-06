<?php

session_start();

if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true))
{
	header('Location: gra.php');
	exit(); // opuszczamy plik, natychmiastowe otwarcie przekierowania bez straty mocy obliczeniowej na dalsze wykonanie pliku
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Settlers - web game</title>
</head>

<body>

Only the dead have seen the end of war - Plato <br/><br/>

<a href="rejestracja.php">Register - create a free account!</a><br/><br/>

<form action="zaloguj.php" method="post">

Login: <br/> <input type="text" name="login"/> <br/>

Password: <br/> <input type="password" name="haslo"/> <br/> <br/>

<input type="submit" value="Log in"/>

</form>

<?php

if (isset($_SESSION['blad']))
{
	echo $_SESSION['blad'];
	session_unset();
}

?>

</body>

</html>