<?php

require_once 'config.php';

class PHPEventCalendar
{
	var $settings;
	var $events;
	
	function PHPEventCalendar($vcalendar = false)
	{
		$this->settings = new config();
		if ($vcalendar !== false)
		{
			
		}
	}
	
	function setEvent()
	{
		
	}
	
	function getWeekView($year, $month, $day)
	{
		$out = '';
		$out .= '<table><tbody>';
		for ($i = 1; $i <= 4; $i++)
		{
			$out .= '<tr>';
			$out .= '<th>*</th>';
			for ($j = 1; $j <= 7; $j++)
			{
				$out .= '<td>*</td>';
			}
			$out .= '</tr>';
		}
		$out .= '</tbody></table>';
		echo $out;
	}
}

?>