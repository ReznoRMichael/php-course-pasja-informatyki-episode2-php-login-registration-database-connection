<?php

session_start(); // pozwala dokumentowi korzystac z SESSION

if ( (!isset($_POST['login'])) || (!isset($_POST['password'])) )
{
	header('Location: index.php');
	exit();
}

require_once "connect-reznor.php";

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
		//$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
		//$password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
		
		$rezultat = $polaczenie->query(
			sprintf("SELECT * FROM reznor_settlers_users WHERE login='%s'",
			mysqli_real_escape_string($polaczenie,$login))
		);
		
		if (!$rezultat) throw new Exception($polaczenie->error);
		else
		{
			$ilu_userow = $rezultat->num_rows; // ilosc wierszy
			if ($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc(); // tablica z wiersza w bazie danych z nazwami kolumn
				
				if (password_verify($password, $wiersz['password'])) // funkcja weryfikujaca hasha z haslem
				{
					$_SESSION['loggedin'] = true; // bool do sprawdzania sesji logowania
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['login'] = $wiersz['login']; // SESSION = bezpieczne przesylanie zmiennych miedzy plikami php
					$_SESSION['drewno'] = $wiersz['drewno'];
					$_SESSION['kamien'] = $wiersz['kamien'];
					$_SESSION['zboze'] = $wiersz['zboze'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['dnipremium'] = $wiersz['dnipremium'];
					
					unset($_SESSION['error']); // po udanym logowaniu usunąć zmienną
					$rezultat->close(); // to samo co free() i free_result()
					
					header('Location: game.php'); // przekierowanie
				}
				else
				{
					$_SESSION['error'] = '<br><br><span style="color:red">Login and/or password not valid.</span>';
					header('Location: index.php'); // przekierowanie
				}
			}
			else
			{
				$_SESSION['error'] = '<br><br><span style="color:red">Login and/or password not valid.</span>';
				header('Location: index.php'); // przekierowanie
			}
		}
		$polaczenie->close();
	}
}
catch(Exception $e) // złap wyjątki, jeśli jakieś wystąpiły
{
	echo '<div style="color:red">Server error. We are sorry for the inconvenience and ask to login on a later time.</div>';
	//echo '<br>Developer info: '.$e;
}

?>