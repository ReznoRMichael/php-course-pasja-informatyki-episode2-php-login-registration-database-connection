<?php

session_start(); // pozwala dokumentowi korzystac z SESSION

if ( (!isset($_POST['login'])) || (!isset($_POST['haslo'])) )
{
	header('Location: index.php');
	exit();
}

require_once "connect.php"; // łączenie z bazą danych SQL
//$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); // @ - operator kontroli błędów (wyciszanie php)
mysqli_report(MYSQLI_REPORT_STRICT); // zamiast warning rzuć wyjątkiem

/*if($polaczenie->connect_errno!=0)
{
	echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
}*/
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
		$haslo = $_POST['haslo'];
			
		$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
		//$haslo = htmlentities($_POST['haslo'], ENT_QUOTES, "UTF-8");
			
		$rezultat = $polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie,$login)));
			
		if (!$rezultat) throw new Exception($polaczenie->error);
		else
		{
			$ilu_userow = $rezultat->num_rows; // ilosc wierszy jakie występują w bazie
			if ($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc(); // tablica z wiersza w bazie danych z nazwami kolumn
					
				if (password_verify($haslo, $wiersz['pass'])) // funkcja weryfikujaca hasha z haslem
				{
					$_SESSION['zalogowany'] = true; // bool do sprawdzania sesji logowania
					$_SESSION['id'] = $wiersz['id']; // SESSION = bezpieczne przesylanie zmiennych miedzy plikami php
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['drewno'] = $wiersz['drewno'];
					$_SESSION['kamien'] = $wiersz['kamien'];
					$_SESSION['zboze'] = $wiersz['zboze'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['dnipremium'] = $wiersz['dnipremium'];
					
					unset($_SESSION['blad']); // po udanym logowaniu usunąć zmienną
					$rezultat->close(); // to samo co free() i free_result()
					
					header('Location: gra.php'); // przekierowanie
				}
				else
				{
					$_SESSION['blad'] = '<br/><span style="color:red">Enter a valid password.</span>';
					header('Location: index.php'); // przekierowanie
				}
			}
			else
			{
				$_SESSION['blad'] = '<br/><span style="color:red">Login is not valid.</span>';
				header('Location: index.php'); // przekierowanie
			}
		}
		$polaczenie->close();
	}
}
catch(Exception $e) // złap wyjątki, jeśli jakieś wystąpiły
{
	echo '<div style="color:red">Server error. We are sorry for the inconvenience and ask to login on a later time.</div>';
	//echo '<br/>Developer info: '.$e;
}



//echo $login."<br/>";
//echo $haslo;

?>