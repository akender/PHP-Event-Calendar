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
$e = new Event("allday1", "", 2011, 5, 2, 0, 0);
$e->setColorRGB("100,100,100");
$cal2->addEvent($e);
$cal2->setEvent("allday2", "", 2011, 5, 3, 0, 0);
$cal2->setEvent("Test3", "", 2011, 5, 3, 15, 0, 2011, 5, 3, 15, 30);
$cal2->setEvent("Test4", "", 2011, 5, 3, 15, 0, 2011, 5, 3, 15, 15);
$cal2->setEvent("Test5", "", 2011, 5, 4, 16, 0, 2011, 5, 3, 17, 0);
$cal2->setEvent("Test6", "", 2011, 5, 4, 16, 0, 2011, 5, 3, 18, 0);
$cal2->setEvent("Test7", "", 2011, 5, 4, 16, 30, 2011, 5, 3, 17, 0);
$cal2->setEvent("Test8", "", 2011, 5, 4, 16, 45, 2011, 5, 3, 18, 0);
$cal2->setEvent("link", '<a href="http://maps.google.com/maps?f=d&hl=en&geocode=10741331078457941886,59.457082,24.839939&saddr=&daddr=59.457159,24.840152&mra=dme&mrcr=0&mrsp=1&sz=16&sll=59.457236,24.840496&sspn=0.007895,0.020084&ie=UTF8&ll=59.457072,24.838715&spn=0.031579,0.080338&z=14">http://maps.google.com/maps?f=d&hl=en&geocode=10741331078457941886,59.457082,24.839939&saddr=&daddr=59.457159,24.840152&mra=dme&mrcr=0&mrsp=1&sz=16&sll=59.457236,24.840496&sspn=0.007895,0.020084&ie=UTF8&ll=59.457072,24.838715&spn=0.031579,0.080338&z=14</a>', 2011, 4, 22);
$cal2->setEvent("See on pikem s�ndmuse kirjeldus", "", 2011, 5, 5);
$cal2->setEvent("allday3", "", 2011, 5, 5);
$cal2->getMonthView(2011, 5);
echo "</br>";
$cal2->getWeekView(2011, 5, 3);
echo "</br>";
$cal2->getAgendaView(15);

$d1 = mktime(10 ,0 ,null ,5 ,4 ,2011);
$d2 = mktime(11 ,0 ,null ,5 ,4 ,2011);
if ($d1 <= $d2) echo "on";
else echo "ei ole";
$d3 = $d2 - $d1;
echo date("Y-m-d", $d3);
echo $d3;

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
