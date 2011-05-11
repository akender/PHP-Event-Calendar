<html>
<head>
<title>PHP Calendar testpage</title>
</head>
<body>
<noscript><br>
Some features are not available, because Your browser does not support
JavaScript! <br>
</noscript>

<?php

require_once 'phpeventcalendar/phpeventcal.php';
$cal2 = new PHPEventCalendar();
$e1 = new Event("terve p�eva kestev s�ndmus1", "", 2011, 5, 9);
$e1->setColorRGB("100,100,100");
$cal2->addEvent($e1);
$cal2->addEvent(new Event("s�ndmus 0", "", 2011, 5, 10, 2, 0, 2011, 5, 10, 3, 15));
$cal2->addEvent(new Event("terve p�eva kestev s�ndmus2", "", 2011, 5, 7, 0, 0));
$cal2->addEvent(new Event("s�ndmus 1", "", 2011, 5, 3, 15, 0, 2011, 5, 3, 15, 30));
$e2 = new Event("s�ndmus 2", "", 2011, 5, 3, 15, 0, 2011, 5, 3, 15, 15);
$cal2->addEvent($e2);
$cal2->addEvent(new Event("s�ndmus 3", "", 2011, 5, 4, 16, 45, 2011, 5, 4, 18, 0));
$cal2->addEvent(new Event("s�ndmus 4", "", 2011, 5, 4, 16, 0, 2011, 5, 4, 18, 0));
$cal2->addEvent(new Event("s�ndmus 5", "", 2011, 5, 4, 16, 30, 2011, 5, 4, 17, 0));
$cal2->addEvent(new Event("s�ndmus 6", "", 2011, 5, 4, 16, 0, 2011, 5, 4, 17, 0));
$cal2->addEvent(new Event("s�ndmus 7", "", 2011, 5, 4, 18, 0, 2011, 5, 4, 18, 45));
$cal2->addEvent(new Event("s�ndmus 8", "", 2011, 5, 12, 16, 0, 2011, 5, 12, 18, 0));
$cal2->addEvent(new Event("s�ndmus 9", "", 2011, 5, 12, 16, 0, 2011, 5, 12, 17, 0));
$cal2->addEvent(new Event("s�ndmus 10", "", 2011, 5, 12, 16, 30, 2011, 5, 12, 17, 0));
$cal2->addEvent(new Event("s�ndmus 11", "", 2011, 5, 12, 16, 45, 2011, 5, 12, 18, 0));
$cal2->addEvent(new Event("s�ndmus 12", "", 2011, 5, 12, 18, 0, 2011, 5, 12, 18, 45));
$cal2->addEvent(new Event("See on pikem s�ndmuse kirjeldus", "", 2011, 5, date("j"), 4, 15, 2011, 5, date("j"), 5, 30));
$cal2->addEvent(new Event("terve p�eva kestev s�ndmus3", "", 2011, 5, date("j")));
$cal2->getMonthView(2011, 5);
echo "<br>";
$cal2->getWeekView(2011, 5, 10);
echo "<br>";
$cal2->getAgendaView(15);

$newarr = array();
$newsubarr = array();
foreach ($cal2->events as $event)
{
	array_push($newsubarr, "datetime_start => ".$event->datetime_start);
	array_push($newsubarr, "datetime_end => ".$event->datetime_end);
	array_push($newarr, $newsubarr);
	$newsubarr = array();
}


function cmp($a, $b) {
    if ($a['datetime_start'] == $b['datetime_start']) return 0;
    if ($a['datetime_start'] < $b['datetime_start']) return 1;
    else return -1;
}

print_r($newarr);
echo "<br>";

usort($newarr, "cmp");
foreach ($newarr as $e)
{
    print date("Y.m.d H:i", $e['datetime_start'])." - ".$e['datetime_start']."<br>";
}



//print_r($cal2->getEvents(2011, 4, 23));
//foreach ($cal2->getEvents() as $event)
//{
//	echo date("Y", $event->getDateTimeStart());
//}

//print_r($cal2->settings->getDays(1));
//print_r($cal2->settings->getMonths(3));

?>

</body>
</html>
