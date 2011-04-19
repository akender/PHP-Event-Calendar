<?php

require_once 'icalendarparser.php';

$ical = new iCalendarEventParser();

//$ical->setParamsToArray('basic.ics');

require_once 'activecalendar/source/activecalendar.php';
require_once 'activecalendar/source/activecalendarweek.php';
$cal = new activeCalendarWeek("2010","2","1");
$cal->enableWeekNum("Week");
$cal->setEventContent("2010","2","2","Google","http://www.google.com");
$cal->setEventContent("2010","2","11","<img src=\"img/pager.png\" border=\"0\" alt=\"\" /> meeting");
$cal->setEventContent("2010","2","23","<img src=\"img/ok.png\" border=\"0\" alt=\"\" /> birthday");
print $cal->showWeeks(6);

?>
