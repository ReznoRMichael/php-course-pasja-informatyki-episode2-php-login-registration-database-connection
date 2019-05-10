<?php

session_start();


if (isset($_POST['login']))
{
	// początkowe założenie poprawnej walidacji
	$validation_OK=true;
	
	// check = poprawność login
	$login = $_POST['login'];
	// dlugosc login
	if ( (strlen($login)<3) || (strlen($login)>20) )
	{
		$validation_OK=false;
		$_SESSION['e_login']="Login must be between 3 to 20 characters.";
	}
	// znaki alfanumeryczne
	if (ctype_alnum($login)==false)
	{
		$validation_OK=false;
		$_SESSION['e_login']="Login can consist of only letters and numbers (no special characters).";
	}
	
// check = poprawność e-mail
	$email = $_POST['email'];
	// sanityzacja email
	$emailSafe = filter_var($email,FILTER_SANITIZE_EMAIL);
	// walidacja email
	if ((filter_var($emailSafe,FILTER_VALIDATE_EMAIL)==false) || ($emailSafe!=$email))
	{
		$validation_OK=false;
		$_SESSION['e_email']="Enter a valid e-mail address.";
	}

	// check = poprawność hasła
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	// dlugosc hasla
	if ( (strlen($pass1)<5) || (strlen($pass2)>20) )
	{
		$validation_OK=false;
		$_SESSION['e_pass']="Password length must be between 5 to 20 characters.";
	}
	// poprawnosc obu hasel
	if ( $pass1!=$pass2 )
	{
		$validation_OK=false;
		$_SESSION['e_pass']="Entered passwords are not identical.";
	}
	// hashowanie hasla
	$pass_hash = password_hash($pass1,PASSWORD_DEFAULT); // standardowa domyślna najnowsza wersja algorytmu hashującego
	
	// check = akceptacja regulaminu
	if (!isset($_POST['regulamin'])) // ! = negacja
	{
		$validation_OK=false;
		$_SESSION['e_regulamin']="Please accept the Terms of Service.";
	}
	
	// Bot or not?
	$secret = require_once 'secret.php';
	$botornot = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$botornot_decoded = json_decode($botornot);
	// check = bot or not
	if ($botornot_decoded->success==false)
	{
		$validation_OK=false;
		$_SESSION['e_bot']="Please confirm that you're not a bot.";
	}

	// zapamietaj wprowadzone dane przy pomocy sesji
	$_SESSION['fr_login'] = $login;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_pass1'] = $pass1;
	$_SESSION['fr_pass2'] = $pass2;
	if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
	
	
	require_once "connect.php"; // łączenie z bazą danych SQL
	mysqli_report(MYSQLI_REPORT_STRICT); // zamiast warning rzuć wyjątkiem

	try // nowy sposób łapania błędów w PHP
	{
		$polaczenie = new mysqli($host,$db_user,$db_password,$db_name); // nowe połączenie z bazą danych
		if($polaczenie->connect_errno!=0) // jeśli wystąpił jakiś wyjątek w połączeniu
		{
			throw new Exception(mysqli_connect_errno()); // rzuć nowym wyjątkiem
		}
		else
		{
			// check = czy email istnieje w bazie
			$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
			if (!$rezultat) throw new Exception($polaczenie->error); // jak cos poszlo nie tak, rzuc wyjatkiem
			
			$ile_maili = $rezultat->num_rows; // ile bylo takich maili w bazie
			if ($ile_maili>0)
			{
				$validation_OK=false;
				$_SESSION['e_email']="There already exists an account using this e-mail.";
			}
			// check = czy login istnieje w bazie
			$rezultat = $polaczenie->query("SELECT id FROM users WHERE login='$login'");
			if (!$rezultat) throw new Exception($polaczenie->error); // jak cos poszlo nie tak, rzuc wyjatkiem
			
			$ile_loginow = $rezultat->num_rows; // ile bylo takich maili w bazie
			if ($ile_loginow>0)
			{
				$validation_OK=false;
				$_SESSION['e_login']="There already exists someone with that login. Please choose another login.";
			}
			
			// jesli wszystko poszlo ok
			if ($validation_OK==true)
			{
				// dodajemy gracza do bazy danych
				//echo "Udana walidacja!"; exit();
				if ($polaczenie->query(
					"INSERT INTO users VALUES (NULL, '$login', '$pass_hash', '$email', 100, 100, 100, now() + INTERVAL 14 DAY )")) // curdate(), curtime()
				{
					$_SESSION['udanarejestracja']=true;
					$_SESSION['login'] = $login;
					header('Location: welcome.php');
				}
				else throw new Exception($polaczenie->error);
			}
			
			// zamknij polaczenie
			$polaczenie->close();
		}
	}
	catch(Exception $e) // złap wyjątki, jeśli jakieś wystąpiły
	{
		echo '<div class="error">Server error. We are sorry for the inconvenience and ask to create an account on a later time.</div>';
		//echo '<br>Developer info: '.$e;
	}
}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Settlers - Game</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="icon" href="favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<link href="css/styles.css" type="text/css" rel="stylesheet">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

<div id="container"></div>

<div id="form_register">
<form method="post">
	<div style="margin: 18px 0px;color:#6ed1ff;">Do you want to register<br>for the Settlers Game?</div>

	Enter Login: <br>
	<input type="text" name="login" value="<?php if (isset($_SESSION['fr_login'])){echo $_SESSION['fr_login']; unset($_SESSION['fr_login']);}?>"><br>

	E-mail: <br>
	<input type="text" name="email" value="<?php if (isset($_SESSION['fr_email'])){echo $_SESSION['fr_email']; unset($_SESSION['fr_email']);}?>"><br>
	
	Enter Password: <br>
	<input type="password" name="pass1" value="<?php if (isset($_SESSION['fr_pass1'])){echo $_SESSION['fr_pass1']; unset($_SESSION['fr_pass1']);}?>"><br>
	
	Repeat Password: <br>
	<input type="password" name="pass2" value="<?php if (isset($_SESSION['fr_pass2'])){echo $_SESSION['fr_pass2']; unset($_SESSION['fr_pass2']);}?>"><br>

	<label>
		<input type="checkbox" name="regulamin" <?php if (isset($_SESSION['fr_regulamin'])){echo "checked"; unset($_SESSION['fr_regulamin']);}?>>I accept the Terms of Service
	</label>
	
	<br><br>
	<div class="g-recaptcha" data-sitekey="6Ld2PYoUAAAAAMWTKzQXMyWPg-rATi-rh0skddBR"></div><br>

	<button>Yes, I want to register!</button>
</form>
	<a href="index.php"><div class="button">Go back to the main page</div></a>
	<?php
	if (isset($_SESSION['e_login']))
	{
		echo '<div class="error">'.$_SESSION['e_login'].'</div>';
		unset($_SESSION['e_login']);
	}
	?>
	<?php
	if (isset($_SESSION['e_email']))
	{
		echo '<div class="error">'.$_SESSION['e_email'].'</div>';
		unset($_SESSION['e_email']);
	}
	?>
	<?php
	if (isset($_SESSION['e_pass']))
	{
		echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
		unset($_SESSION['e_pass']);
	}
	?>
	<?php
	if (isset($_SESSION['e_regulamin']))
	{
		echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
		unset($_SESSION['e_regulamin']);
	}
	?>
	<?php
	if (isset($_SESSION['e_bot']))
	{
		echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
		unset($_SESSION['e_bot']);
	}
	?>
</div>

</body>

</html>