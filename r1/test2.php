<html>
<head>
<title>PHP Calendar testpage</title>
<link type="text/css" rel="stylesheet" href="phpeventcalendar/css/style.css">
</head>
<body>
<noscript><br>
Some features are not available, because Your browser does not support
JavaScript! <br>
</noscript>

<?php

require_once 'phpeventcalendar/phpeventcal.php';
$cal2 = new PHPEventCalendar();
//$cal2->getWeekView(2011, 4, 20, 4);
$cal2->setEvent("Test1", 2011, 4, 21, 0, 0);
$e = new Event("Test2", 2011, 4, 21, 0, 0);
$e->setColorRGB("100,100,100");
$cal2->addEvent($e);
//$cal2->setEvent("Test2", 2011, 4, 21, 0, 0);
$cal2->setEvent("Test3", 2011, 4, 21, 0, 0);
$cal2->setEvent("Test4", 2011, 4, 21, 0, 0);
$cal2->setEvent("Test5", 2011, 4, 21, 0, 0);
$cal2->setEvent("Test6", 2011, 4, 22, 0, 0);
$cal2->setEvent("Test7", 2011, 4, 25, 0, 0);
$cal2->getMonthView(2011, 4, 1);
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
