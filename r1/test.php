<?php

require_once 'icalendarparser.php';

$ical = new iCalendarEventParser();

$ical->setParamsToArray('basic.ics');

?>
