<?php

class iCalendarEventParser
{
	var $calparams = false;
	var $events = false;
	
	function setParamsToArray($file)
	{
		$f = fopen($file, 'r');
		$this->calparams = array();
		$this->events = array();
		$paramarray = array();
		$e = false;
		while ($line = fgets($f))
		{
			$pos1 = strpos($line, 'BEGIN:VEVENT');
			$pos2 = strpos($line, 'END:VEVENT');
			$param[2] = false;
			
			if ($e === false && $pos1 === false && $pos2 === false)
			{
				$a = explode(':', $line, 2);
				array_push($this->calparams, $a);
			}
			else if ($e !== false && $pos2 === false)
			{
				$a = explode(':', $line, 2);
				array_push($param, $a[0], $a[1]);
				array_push($paramarray, $param);
			}
			
			if ($pos1 !== false)
			{
				$e = true;
			}
			
			if ($pos2 !== false)
			{
				array_push($this->events, $paramarray);
				$paramarray = false;
			}
			
//			$subparam[2];
//			$a = explode(':', $line, 2);
//			array_push($subparam, $a[0], $a[1]);
//			array_push($paramarray, $subparam);
//			
//			print_r($line.'<br>');
		}
		fclose($f);
		print_r($this->events);
	}
	
	function test()
	{
		
	}
}

?>
