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
if (isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
if (isset($_SESSION['fr_pass1'])) unset($_SESSION['fr_pass1']);
if (isset($_SESSION['fr_pass2'])) unset($_SESSION['fr_pass2']);
if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

// usuwanie błędów rejestracji
if (isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
if (isset($_SESSION['e_pass'])) unset($_SESSION['e_pass']);
if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);

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
		<div id="form_welcome">
			<div style="margin: 18px 0px;">Welcome, <?php echo $_SESSION['login']; ?>.<br><br>You can now log in<br>to your account:</div>
			
			<a href="index.php"><div class="button" style="margin: 30px 25px;">Log in to your account</div></a>
			
			
			<?php if (isset($_SESSION['error'])) {echo $_SESSION['error']; session_unset();} ?>
		</div>

</body>

</html>