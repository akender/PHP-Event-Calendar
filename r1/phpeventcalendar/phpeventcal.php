<?php

require_once 'config.php';
require_once 'event.php';

class PHPEventCalendar
{
	private $settings;
	private $events;
	
	function PHPEventCalendar()
	{
		$this->settings = new Config();
		$this->events = array();
	}
	
	function addEvent(Event $event)
	{
		array_push($this->events, $event);
	}
	
	function getAgendaView($days = 10)
	{
		$startdatetime = mktime(0, 0, 0, date("m"), date("d"), date("y"));
		$seqdatetime = $startdatetime;
		$today = false;
		include_once "css.php";
		$out = "";
		$out .= "<div class=\"cal\">\n";
		$out .= "<table class=\"agenda\" cellspacing=\"1\">\n";
		$out .= "<tbody>\n";
		
		for ($i = 1; $i <= $days; $i++)
		{
			if ($this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime)) >= 1)
			{
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $today = true;
				else $today = false;
				$out .= "<tr>\n<th";
				if ($today != false) $out .= " class=\"today\"";
				$out .= ">".date("j.n", $seqdatetime)."</th>\n<td class=\"";
				if ($today != false) $out .= "today";
				else $out .= "day";
				$out .= "\">\n<table class=\"day22\" cellspacing=\"0\">\n<tbody>\n";
				
				foreach ($this->getEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime)) as $event)
				{
					$out .= "<tr";
					if ($event->getColorRGB()) $out .= " style=\"color: rgb(".$event->getColorRGB().");\"";
					$out .= ">\n<td class=\"time\">";
					if (date("Y", $event->datetime_end) >= date("Y"))
					{
						$out .= date("H:i", $event->datetime_start)." - ".date("H:i", $event->datetime_end);
					}
					else $out .= $this->settings->allday;
					$out .= "</td>\n<td>".$event->content_visible."</td>\n</tr>\n";
				}
				
				$out .= "</tbody>\n";
				$out .= "</table>\n";
				$out .= "</td>\n";
				$out .= "</tr>\n";
			}
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		
		$out .= "</tbody>\n";
		$out .= "</table>\n";
		$out .= "</div>\n";
		echo $out;
	}
	
	function getWeekView($year, $month, $day)
	{
		$startdatetime = $this->getFirstDateForWeekView($year, $month, $day);
		$seqdatetime = $startdatetime;
		$proportion = 100/7;
		include_once "css.php";
		$out = "";
		$out .= "<div class=\"cal\">\n<table class=\"week\" cellspacing=\"1\">\n<tbody>\n<tr>\n";
		$out .= "<th rowspan=\"2\" style=\"min-width: 50px;\"></th>\n";
		foreach ($this->settings->getDays(1) as $d)
		{
			$out .= "<th class=\"";
			if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= "today";
			else $out .= "day";
			$out .= "\" style=\"width: ".$proportion."%;\">".$d." ".date("j.n", $seqdatetime)."</th>\n";
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		$seqdatetime = $startdatetime;
		$out .= "</tr>\n";
		$out .= "<tr class=\"allday\">\n";
		foreach ($this->settings->getDays() as $d)
		{
			$out .= "<td";
			if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= " class=\"today\"";
			$out .= ">\n<div style=\"min-height: 40px;\">";
			
			$out .= $this->drawSmallSizeEvents(date("Y", $seqdatetime), date("n", $seqdatetime), date("j", $seqdatetime), true);
			
			$out .= "</div>\n</td>\n";
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		$seqdatetime = $startdatetime;
		$out .= "</tr>\n";
		for ($i = 0; $i <= 23; $i++)
		{
			$out .= "<tr class=\"hour\">\n";
			$out .= "<th class=\"hour\">".date("H:i", $seqdatetime)."</th>\n";
			for ($j = 1; $j <= 7; $j++)
			{
				$out .= "<td class=\"";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= "today";
				else $out .= "notoday";
				$out .= "\">\n";
				
				$out .= "<div id=\"dt".$seqdatetime."\" class=\"quarter\">\n";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";

				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</div>\n";
				$out .= "<div id=\"dt".$seqdatetime."\" class=\"quarter\">\n";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</div>\n";
				$out .= "<div id=\"dt".$seqdatetime."\" class=\"quarter\">\n";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</div>\n";
				$out .= "<div id=\"dt".$seqdatetime."\" class=\"lquarter\">\n";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</div>\n</td>\n";
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) - 60, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
			}
			$out .= "</tr>\n";
			$seqdatetime = mktime(date("G", $seqdatetime) + 1, 0, 0, date("m", $startdatetime), date("d", $startdatetime), date("y", $startdatetime));
		}
		$out .= "</tbody>\n</table>\n</div>\n";
		echo $out;
	}
	
	function getMonthView($year, $month)
	{
		$date = mktime(0, 0, 0, $month, 1, $year);
		$dateToday = $date;
		$week = (int)date("W", $date);
		$FirstDay = $this->getFirstDateForMonthView($year, $month);
		$date = $FirstDay;
		$pr = 100/7;
		$today = false;
		include_once "css.php";
		$out = "";
		$out .= "<div class=\"cal\">\n<table class=\"month\" cellspacing=\"1\">\n<caption>";
		$m = $this->settings->getMonths();
		$out .= $m[$month - 1]." ".$year;
		$out .= "</caption>\n<tbody>\n<tr>\n";
		if ($this->settings->showweeknumber)
		{
			$out .= "<th style=\"min-width: 50px;\">".$this->settings->weekname."</th>\n";
		}
		foreach ($this->settings->getDays() as $d)
		{
			$out .= "<th class=\"weekday\" style=\"width: ".$pr."%;\">".$d."</th>\n";
		}
		$out .= "</tr>\n";
		while (date("Y-m", $date) <= date("Y-m", $dateToday))
		{
			$out .= "<tr>\n";
			if ($this->settings->showweeknumber)
			{
				$out .= "<th>".date("W", $date)."</th>\n";
			}
			for ($j = 1; $j <= 7; $j++)
			{
				if (date("Y-m-d", $date) === date("Y-m-d")) $today = true;
				else $today = false;
				$out .= "<td class=\"";
				if ($today != false) $out .= "today";
				else $out .= "notoday";
				$out .= "\">\n<table class=\"day\" cellspacing=\"0\">\n<tbody>\n<tr>\n<th";
				if ($today != false) $out .= " class=\"today\"";
				$out .= ">".date("j", $date)."</th>\n</tr>\n<tr>\n<td>\n<div class=\"content\">\n";
				
				$out .= $this->drawSmallSizeEvents(date("Y", $date), date("n", $date), date("j", $date));
				
				$out .= "</div>\n</td>\n</tr>\n</tbody>\n</table>\n";
				$out .= "</td>\n";
				$date = mktime(0, 0, 0, date("m", $date), date("d", $date) + 1, date("y", $date));
			}
			$out .= "</tr>\n";
		}
		$out .= "</tbody>\n</table>\n</div>\n";
		echo $out;
	}
	
	private function drawEvents($year, $month, $day, $hour, $min)
	{
		$out = "";
		$dt = mktime($hour, $min, 0, $month, $day, $year);
		$events = $this->getEvents($year, $month, $day, $hour, $min, false);
		$count = count($events);
		if ($count > 0) $w = 100 / $count;
		else $w = 100;
		$i = 0;
		foreach ($events as $event)
		{
			$x = $event->datetime_start - $dt;
			$x = $x / 60;
			$out .= "<div class=\"event\" style=\"top: ".$x."px; left: ".$i * $w."%;";
			$out .= " width: ".$w."%;";
			$out .= " height: ".$this->getEventHeight($event->duration)."px; background-color: rgb(";
			if ($event->getColorRGB() != null) $out .= $event->getColorRGB();
			else $out .= $this->settings->rgbdefaulteventcolor;
			$out .= ");\">\n<div style=\"background-color: white; opacity: 0.3;\">\n<div style=\"max-height: 1.3em; overflow: hidden; padding-left: 3px;\">".date("H:i", $event->datetime_start)." - ".date("H:i", $event->datetime_end)."</div>\n</div>\n";
			$out .= $event->content_visible."\n";
			$out .= "</div>\n";
			$i++;
		}
		return $out;
	}
	
	private function drawSmallSizeEvents($year, $month, $day, $allday = false)
	{
		$out = "";
		
		if ($allday != false)
		{
			foreach ($this->getEvents($year, $month, $day) as $event)
			{
				if ($event->isAllDayEvent() != false)
				{
					$out .= "<div class=\"sevent\"  style=\"background-color: rgb(";
					if ($event->getColorRGB()) $out .= $event->getColorRGB();
					else $out .= $this->settings->rgbdefaulteventcolor;
					$out .= ");\">\n".$event->content_visible."\n</div>\n";
				}
			}
		}
		else if ($allday != true)
		{
			foreach ($this->getEvents($year, $month, $day) as $event)
			{
				$out .= "<div class=\"sevent\"  style=\"background-color: rgb(";
				if ($event->getColorRGB()) $out .= $event->getColorRGB();
				else $out .= $this->settings->rgbdefaulteventcolor;
				$out .= ");\">\n".$event->content_visible."\n</div>\n";
			}
		}
		return $out;
	}
	
	private function getNumberOfEvents($year, $month, $day, $hour = false, $min = false)
	{
		$out = 0;
		if ($hour != false)
		{
			foreach ($this->events as $event)
			{
				if ($event->isRunningOnSpecTime($year, $month, $day, $hour, $min)) $out++;
			}
		}
		else
		{
			$date = mktime(0, 0, 0, $month, $day, $year);
			foreach ($this->events as $event)
			{
				if (date("Y.m.d", $event->datetime_start) == date("Y.m.d", $date)) $out++;
			}
		}
		return $out;
	}
	
	private function getEventHeight($duration)
	{
		if ($duration > 900) return $duration / 60;
		else return 15;
	}
	
	private function getEvents($year, $month, $day, $hr = null, $min = null, $allday = true)
	{
		$dt1 = mktime($hr, $min, 0, $month, $day, $year);
		$dt2 = mktime($hr, $min + 15, 0, $month, $day, $year);
		$out = array();
		$ctrl1 = 0;
		$ctrl2 = 1;
		if ($hr != null && $allday != true)
		{
			while ($ctrl1 != $ctrl2)
			{
				$ctrl2 = $ctrl1;
				foreach ($this->events as $event)
				{
					if ($event->isAllDayEvent() != true && $event->checked != true && ($event->datetime_start >= $dt1 && $event->datetime_start < $dt2))
					{
						array_push($out, $event);
						if ($dt2 < $event->datetime_end) $dt2 = $event->datetime_end;
						$event->checked = true;
						$ctrl1++;
					}
				}
			}
		}
		else if ($hr != null)
		{
			foreach ($this->events as $event)
			{
				if ($dt1 >= $event->datetime_start && $dt1 <= $event->datetime_end)
				{
					array_push($out, $event);
				}
			}
		}
		else if ($hr == null)
		{
			foreach ($this->events as $event)
			{
				if ((date("Y", $dt1) == date("Y", $event->datetime_start) && date("n", $dt1) == date("n", $event->datetime_start) && date("j", $dt1) == date("j", $event->datetime_start)) || (date("Y", $dt1) >= date("Y", $event->datetime_start) && date("Y", $dt1) <= date("Y", $event->datetime_end) && date("n", $dt1) >= date("n", $event->datetime_start) && date("n", $dt1) <= date("n", $event->datetime_end) && date("j", $dt1) >= date("j", $event->datetime_start) && date("j", $dt1) <= date("j", $event->datetime_end)))
				{
					array_push($out, $event);
				}
			}
		}
		return $out;
	}
	
	private function getFirstDateForMonthView($year, $month)
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
	
	private function getFirstDateForWeekView($year, $month, $day)
	{
		$date1 = mktime(0, 0, 0, $month, $day, $year);
		$date2 = $date1;
		$week = (int)date("W", $date1);
		while ($week === (int)date("W", $date2))
		{
			$date2 = $date2 - 1;
		}
		return $date2 + 1;
	}
}

?>