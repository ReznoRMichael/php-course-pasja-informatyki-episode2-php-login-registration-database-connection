<?php

session_start();

if (!isset($_SESSION['udanarejestracja']))
{
	header('Location: index.php');
	exit(); // opuszczamy plik, natychmiastowe otwarcie przekierowania bez straty mocy obliczeniowej na dalsze wykonanie pliku
}
else
{
	unset($_SESSION['udanarejestracja']);
}

// usuwanie zmiennych ustawionych w sesji po udanym logowaniu
if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

// usuwanie błędów rejestracji
if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Settlers - web game</title>
</head>

<body>

Thank you for the registration! You can now login into your account. <br/><br/>

<a href="index.php">Login into your account.</a><br/><br/>

</body>

</html>