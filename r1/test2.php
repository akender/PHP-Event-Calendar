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
$cal2->setEvent("Test2", 2011, 4, 21, 0, 0);
$cal2->getMonthView(2011, 4, 1);
print_r($cal2->getEvents());

//print_r($cal2->settings->getDays(1));
//print_r($cal2->settings->getMonths(3));

?>

</body>
</html>
