<?php

class iCalendarEventParser
{
	var $events = false;
	var $paramarray = false;
	
	function setParamsToArray($file)
	{
		$f = fopen($file, 'r');
		$this->events[] = false;
		while ($line = fgets($f))
		{
			print_r($line.'<br>');
			explode(':', $line);
		}
		fclose($f);
	}
}

?>
