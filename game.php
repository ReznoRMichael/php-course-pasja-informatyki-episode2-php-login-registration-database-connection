<?php

	session_start(); // pozwala dokumentowi korzystac z SESSION

	if (!isset($_SESSION['loggedin'])) // jesli nie ma sesji logowania
	{
		header('Location: index.php');
		exit(); // opuszczamy plik, natychmiastowe otwarcie przekierowania bez straty mocy obliczeniowej na dalsze wykonanie pliku
	}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="icon" href="favicon.png">
<link rel="stylesheet" href="css/styles.css">
<title>Settlers - web game</title>
</head>

<body>

	<div id="form_logout">

<?php

	echo "<p>Welcome, ".$_SESSION['login'].'! [ <a href="logout.php">Log out</a> ]</p>';
	echo "<p><strong>Wood: </strong>".$_SESSION['drewno'];
	echo " | <strong>Stone: </strong>".$_SESSION['kamien'];
	echo " | <strong>Grain: </strong>".$_SESSION['zboze'];
	echo "</p>";

	echo "<p><strong>E-mail: </strong>".$_SESSION['email'];
	echo "<br><strong>Premium until: </strong>".$_SESSION['dnipremium'];
	echo "</p>";

	//$serverdatetime = new DateTime('2019-02-05 17:48:05');
	$serverdatetime = new DateTime();
	echo "<strong>Server date and time: </strong>".$serverdatetime -> format('Y-m-d H:i:s')."<br><br>";

	$validuntil = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']); // :: operator zasiegu, wywolanie metody bezposrednio, bez obiektu
	$premiumdaysleft = $serverdatetime -> diff($validuntil); // roznica czasu między dwoma obiektami, zawsze będzie dodatnia, kolejnosc dowolna

	if ($serverdatetime < $validuntil)
		echo "<strong>Premium days left:</strong> ".$premiumdaysleft -> format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds');
	else echo "<strong>Premium inactive since:</strong> ".$premiumdaysleft -> format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds');

	/* echo "<br><br>";
	echo "time() <br>"; // czas od 01.01.1970 00:00 - Unix Epoch [POSIX time]
	echo time()."<br>"; 

	echo "mktime(20, 30, 0, 1, 13, 2019) <br>"; // hour, minute, second, month, day, year = zamienia czas na sekundy
	echo mktime(20, 30, 0, 1, 13, 2019)."<br>";

	echo "microtime() <br>"; // POSIX time + mikrosekundy
	echo microtime()."<br>";

	echo "date() <br>"; // wyświetla datę z custom template
	echo date('Y-m-d H:i:s')."<br>"; // MySQL DATETIME
	echo date('d.m.Y')."<br>";

	echo "nowy obiekt klasy DateTime() [podejście obiektowe] <br>";
	// stworzenie nowego obiektu dataczas klasy DateTime
	$dataczas = new DateTime(); // pusty - domyślne zachowanie konstruktora - aktualny czas i data
	// metoda - nazwa na funkcję wewnętrz klasy, wywołaną na rzecz obiektu
	echo $dataczas -> format('Y-m-d H:i:s')."<br>";
	echo print_r($dataczas)."<br>"; // wyświetl rekursywnie - podejrzenie zawartości obiektu

	$day = 26;
	$month = 7;
	$year = 1875;

	echo "checkdate() ".$day.":".$month.":".$year."<br>";
	if (checkdate($month, $day, $year))
		echo "Valid date <br>";
	else echo "Invalid date <br>"; */

?>

	</div>

</body>

</html>