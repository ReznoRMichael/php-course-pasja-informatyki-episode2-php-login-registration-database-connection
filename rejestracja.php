<?php

session_start();


if (isset($_POST['email']))
{
	// początkowe założenie poprawnej walidacji
	$validation_OK=true;
	
	// check = poprawność nickname
	$nick = $_POST['nick'];
	// dlugosc nickname
	if ( (strlen($nick)<3) || (strlen($nick)>20) )
	{
		$validation_OK=false;
		$_SESSION['e_nick']="Nick must be between 3 to 20 characters.";
	}
	// znaki alfanumeryczne
	if (ctype_alnum($nick)==false)
	{
		$validation_OK=false;
		$_SESSION['e_nick']="Nick can consist of only letters and numbers (no special characters).";
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
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	// dlugosc hasla
	if ( (strlen($haslo1)<8) || (strlen($haslo2)>20) )
	{
		$validation_OK=false;
		$_SESSION['e_haslo']="Password length must be between 8 to 20 characters.";
	}
	// poprawnosc obu hasel
	if ( $haslo1!=$haslo2 )
	{
		$validation_OK=false;
		$_SESSION['e_haslo']="Entered passwords are not identical.";
	}
	// hashowanie hasla
	$haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT); // standardowa domyślna najnowsza wersja algorytmu hashującego
	
	// check = akceptacja regulaminu
	if (!isset($_POST['regulamin'])) // ! = negacja
	{
		$validation_OK=false;
		$_SESSION['e_regulamin']="Please accept the Terms of Service.";
	}
	
	// Bot or not?
	$secret = 'secret.php';
	$botornot = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$botornot_decoded = json_decode($botornot);
	// check = bot or not
	if ($botornot_decoded->success==false)
	{
		$validation_OK=false;
		$_SESSION['e_bot']="Please confirm that you're not a bot.";
	}
	
	// zapamietaj wprowadzone dane przy pomocy sesji
	$_SESSION['fr_nick'] = $nick;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_haslo1'] = $haslo1;
	$_SESSION['fr_haslo2'] = $haslo2;
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
			// check = czy nick istnieje w bazie
			$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");
			if (!$rezultat) throw new Exception($polaczenie->error); // jak cos poszlo nie tak, rzuc wyjatkiem
			
			$ile_nickow = $rezultat->num_rows; // ile bylo takich maili w bazie
			if ($ile_nickow>0)
			{
				$validation_OK=false;
				$_SESSION['e_nick']="There already exists a player with that nick. Please choose another nick.";
			}
			
			// jesli wszystko poszlo ok
			if ($validation_OK==true)
			{
				// dodajemy gracza do bazy danych
				//echo "Udana walidacja!"; exit();
				if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, now() + INTERVAL 14 DAY )")) // curdate(), curtime()
				{
					$_SESSION['udanarejestracja']=true;
					header('Location: witamy.php');
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
		//echo '<br/>Informacja dla developera: '.$e;
	}
}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Settlers - create a free account</title>
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
.error
{
	color: red;
	margin: 0 10px;
}
</style>
</head>

<body>

<form method="post">

	Nickname: <br/>
	<input type="text" name="nick" value="<?php if (isset($_SESSION['fr_nick'])){echo $_SESSION['fr_nick']; unset($_SESSION['fr_nick']);}?>"/><br/>
	<?php
	if (isset($_SESSION['e_nick']))
	{
		echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
		unset($_SESSION['e_nick']);
	}
	?>
	E-mail: <br/>
	<input type="text" name="email" value="<?php if (isset($_SESSION['fr_email'])){echo $_SESSION['fr_email']; unset($_SESSION['fr_email']);}?>"/><br/>
	<?php
	if (isset($_SESSION['e_email']))
	{
		echo '<div class="error">'.$_SESSION['e_email'].'</div>';
		unset($_SESSION['e_email']);
	}
	?>
	Password: <br/>
	<input type="password" name="haslo1" value="<?php if (isset($_SESSION['fr_haslo1'])){echo $_SESSION['fr_haslo1']; unset($_SESSION['fr_haslo1']);}?>"/><br/>
	<?php
	if (isset($_SESSION['e_haslo']))
	{
		echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
		unset($_SESSION['e_haslo']);
	}
	?>
	Repeat password: <br/>
	<input type="password" name="haslo2" value="<?php if (isset($_SESSION['fr_haslo2'])){echo $_SESSION['fr_haslo2']; unset($_SESSION['fr_haslo2']);}?>"/><br/><br/>
	<label>
	<input type="checkbox" name="regulamin" <?php if (isset($_SESSION['fr_regulamin'])){echo "checked"; unset($_SESSION['fr_regulamin']);}?>/>I accept the Terms of Service
	</label><br/>
	<?php
	if (isset($_SESSION['e_regulamin']))
	{
		echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
		unset($_SESSION['e_regulamin']);
	}
	?>
	<br/>
	<div class="g-recaptcha" data-sitekey="6Ld2PYoUAAAAAMWTKzQXMyWPg-rATi-rh0skddBR"></div><br/>
	<?php
	if (isset($_SESSION['e_bot']))
	{
		echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
		unset($_SESSION['e_bot']);
	}
	?><br/>
	<input type="submit" value="Register"/><br/>

</form>

</body>

</html>