<?php

require_once 'config.php';
require_once 'event.php';

class PHPEventCalendar
{
	var $settings;
	var $events;
	
	function PHPEventCalendar($vcalendar = false)
	{
		$this->settings = new config();
		$this->events = array();
		if ($vcalendar !== false)
		{
			
		}
	}
	
	function setEvent($content, $year_st, $month_st, $day_st, $hour_st = 0, $min_st = 0, $year_fs = false, $month_fs = false, $day_fs = false, $hour_fs = 0, $min_fs = 0)
	{
		array_push($this->events, new Event($content, $year_st, $month_st, $day_st));
	}
	
	function getEvents($year = false, $month = false, $day = false)
	{
		$out = array();
		foreach ($this->events as $e)
		{
			array_push($out, $e);
		}
		return $out;
	}
	
	function getFirstDateForMonthView($year, $month)
	{
		$date1 = mktime(0, 0, 0, $month, 1, $year);
		$date2 = $date1;
		$week = (int)date("W", $date1);
		while ($week === (int)date("W", $date2))
		{
			$date2 = $date2 - 1;
		}
		return $date2 + 1;
	}
	
	function getWeekView($year, $month, $day, $weeks = 1)
	{
		$date = mktime(0, 0, 0, $month, $day, $year);
		$week = (int)date('W', $date);
		$pr = 100/7;
		$out = '';
		if ($weeks > 1)
		{
			$out .= '<table class="cal" cellspacing="0" style="width: 100%;">\n<tbody>\n';
			$out .= '<tr>\n';
			if ($this->settings->showweeknumber)
			{
				$out .= '<th style="min-width: 50px;"></th>\n';
			}
			for ($j = 1; $j <= 7; $j++)
			{
				$out .= '<th style="width: '.$pr.'%;">*</th>\n';
			}
			$out .= '</tr>\n';
			for ($i = 1; $i <= $weeks; $i++)
			{
				$out .= '<tr>\n';
				if ($this->settings->showweeknumber)
				{
					$out .= '<th>'.$week.'</th>\n';
					$week++;
				}
				for ($j = 1; $j <= 7; $j++)
				{
					$out .= '<td id="'.'">*</td>\n';
				}
				$out .= '</tr>\n';
			}
			$out .= '</tbody>\n</table>\n';
			echo $out;
		}
	}
	
	function getMonthView($year, $month, $day)
	{
		$date = mktime(0, 0, 0, $month, 1, $year);
		$dateToday = mktime(0, 0, 0, $month, $day, $year);
		$week = (int)date("W", $date);
		$FirstDay = $this->getFirstDateForMonthView($year, $month);
		$date = $FirstDay;
		$pr = 100/7;
		$out = "";
		$out .= "<table class=\"cal\" cellspacing=\"0\" style=\"width: 100%;\">\n<caption>";
		$m = $this->settings->getMonths();
		$out .= $m[$month - 1];
		$out .= "</caption>\n<tbody>\n";
		$out .= "<tr>\n";
		if ($this->settings->showweeknumber)
		{
			$out .= "<th style=\"min-width: 50px;\">".$this->settings->weekname."</th>\n";
		}
		foreach ($this->settings->getDays() as $d)
		{
			$out .= "<th style=\"width: ".$pr."%; min-width: 100px;\">".$d."</th>\n";
		}
		$out .= "</tr>\n";
		for ($i = 1; $i <= 4; $i++)
		{
			
		}
		while (date("Y-m", $date) <= date("Y-m", $dateToday))
		{
			$out .= "<tr>\n";
			if ($this->settings->showweeknumber)
			{
				$out .= "<th>".date("W", $date)."</th>\n";
			}
			for ($j = 1; $j <= 7; $j++)
			{
				if (date("Y-m-d", $date) === date("Y-m-d")) $out .= "<td id=\"\" class=\"today\">\n";
				else $out .= "<td id=\"\">\n";
				
				$out .= "<table class=\"day\" cellspacing=\"0\" style=\"width: 100%;\">\n<tbody>\n<tr>\n";
				$out .= "<th>".date("j", $date)."</th>\n";
				$out .= "</tr>\n<tr>\n";
				$out .= "<td>\n";
				$out .= "<div class=\"event\">s�ndmus1</div>\n";
				$out .= "</td>\n";
				$out .= "</tr>\n</tbody>\n</table>\n";
				
				$out .= "</td>\n";
				$date = mktime(0, 0, 0, date("m", $date), date("d", $date) + 1, date("y", $date));
			}
			$out .= "</tr>\n";
		}
		$out .= "</tbody>\n</table>\n";
		echo $out;
	}
}

?>