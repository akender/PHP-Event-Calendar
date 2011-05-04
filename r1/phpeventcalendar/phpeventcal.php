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
	
	function setEvent($content_vis, $content_hid, $year_st, $month_st, $day_st, $hour_st = null, $min_st = null, $year_end = null, $month_end = null, $day_end = null, $hour_end = null, $min_end = null)
	{
		$e = new Event($content_vis, $content_hid, $year_st, $month_st, $day_st, $hour_st = null, $min_st = null, $year_end = null, $month_end = null, $day_end = null, $hour_end = null, $min_end = null);
		array_push($this->events, $e);
	}
	
	function addEvent(Event $event)
	{
		array_push($this->events, $event);
	}
	
	function getNumberOfEvents($year, $month, $day, $hour = null, $min = null)
	{
		$out = 0;
		if ($hour != null)
		{
			$date = mktime($hour, $min, null, $month, $day, $year);
			foreach ($this->events as $event)
			{
				if ((date("Y-m-d-H-i", $event->getDateTimeStart()) == date("Y-m-d-H-i", $date)) || (date("Y-m-d-H-i", $date) >= date("Y-m-d-H-i", $event->getDateTimeStart()) && date("Y-m-d-H-i", $date) <= date("Y-m-d-H-i", $event->getDateTimeEnd()))) $out++;
			}
		}
		else
		{
			$date = mktime(null, null, null, $month, $day, $year);
			foreach ($this->events as $event)
			{
				if (date("Y-m-d", $event->getDateTimeStart()) == date("Y-m-d", $date)) $out++;
			}
		}
		return $out;
	}
	
	function getEventHeight($duration)
	{
		$hr = (int)date("G", $duration);
		$min = (int)date("i", $duration);
		$totalmin = ($hr * 60) + $min;
		return $totalmin;
	}
	
	function getEvents($year = null, $month = null, $day = null)
	{
		$date = mktime(null, null, null, $month, $day, $year);
		$out = array();
		if ($year != null && $month != null && $day != null)
		{
			foreach ($this->events as $event)
			{
				if (date("Y", $event->getDateTimeStart()) == date("Y", $date) && date("n", $event->getDateTimeStart()) == date("n", $date) && date("j", $event->getDateTimeStart()) == date("j", $date))
				{
					array_push($out, $event);
				}
			}
			return $out;
		}
		else
		{
			return $this->events;
		}
	}
	
	function drawSmallSizeEvents($year, $month, $day, $allday = false)
	{
		$out = "";
		
		if ($allday === true)
		{
			foreach ($this->getEvents($year, $month, $day) as $event)
			{
				if ($event->isAllDayEvent() === true)
				{
					$out .= "<span class=\"event\"  style=\"background-color: rgb(";
					if ($event->getColorRGB()) $out .= $event->getColorRGB();
					else $out .= $this->settings->rgbdefaulteventcolor;
					$out .= "); display: block; max-height: 1.3em; overflow: hidden; margin: 1px; padding-left: 3px;\">\n";
					$out .= $event->getVisibleContent()."\n";
					$out .= "</span>\n";
				}
			}
		}
		else if ($allday === false)
		{
			foreach ($this->getEvents($year, $month, $day) as $event)
			{
				$out .= "<span class=\"event\"  style=\"background-color: rgb(";
				if ($event->getColorRGB()) $out .= $event->getColorRGB();
				else $out .= $this->settings->rgbdefaulteventcolor;
				$out .= "); display: block; max-height: 1.3em; overflow: hidden; margin: 1px; padding-left: 3px;\">\n";
				$out .= $event->getVisibleContent()."\n";
				$out .= "</span>\n";
			}
		}
		return $out;
	}
	
	function drawEvents($year, $month, $day, $hour, $min, $width)
	{
		$out = "";
		$count = $this->getNumberOfEvents($year, $month, $day, $hour, $min);
		if ($count != 0) $w = $width / $count;
		else $w = $width;
		foreach ($this->getEvents($year, $month, $day) as $event)
		{
			if ($this->getEventHeight($event->getDuration()) != null)
			{
				$out .= "<div style=\"width: ".$w."%; height: ".$this->getEventHeight($event->getDuration())."px;";
				if ($event->getColorRGB() != null) $out .= " background-color: rgb(".$event->getColorRGB().");";
				$out .= "\">\n";
				$out .= $event->getVisibleContent()."\n";
				$out .= "</div>\n";
			}
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
	
	function getFirstDateForWeekView($year, $month, $day)
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
	
	function getMonthView($year, $month)
	{
		$date = mktime(0, 0, 0, $month, 1, $year);
		$dateToday = $date;
		$week = (int)date("W", $date);
		$FirstDay = $this->getFirstDateForMonthView($year, $month);
		$date = $FirstDay;
		$pr = 100/7;
		$out = "";
		$out .= "<div class=\"cal\">\n<table class=\"monthview\" cellspacing=\"1\" style=\"width: 100%; background-color: rgb(".$this->settings->rgbheadercolor.");\">\n<caption>";
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
			$out .= "<th style=\"width: ".$pr."%; min-width: 100px; max-width: 200px;\">".$d."</th>\n";
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
				$out .= "<td id=\"\" style=\"background-color: rgb(".$this->settings->rgbbackgroundcolor.");";
				if (date("Y-m-d", $date) === date("Y-m-d")) $out .= " border-style: solid; border-width: 1px; border-color: rgb(".$this->settings->rgbtodayheadercolor.");";
				$out .= "\">\n";
				
				$out .= "<table class=\"day\" cellspacing=\"0\" style=\"width: 100%;\">\n<tbody>\n<tr>\n";
				
				$out .= "<th";
				if (date("Y-m-d", $date) === date("Y-m-d")) $out .= " style=\"background-color: rgb(".$this->settings->rgbtodayheadercolor.");\"";
				$out .= ">".date("j", $date)."</th>\n";
				
				$out .= "</tr>\n<tr>\n";
				$out .= "<td>\n";
				
				$out .= $this->drawSmallSizeEvents(date("Y", $date), date("n", $date), date("j", $date));
				
				$out .= "</td>\n";
				$out .= "</tr>\n</tbody>\n</table>\n";
				
				$out .= "</td>\n";
				$date = mktime(0, 0, 0, date("m", $date), date("d", $date) + 1, date("y", $date));
			}
			$out .= "</tr>\n";
		}
		$out .= "</tbody>\n</table>\n</div>\n";
		echo $out;
	}
	
	function getWeekView($year, $month, $day)
	{
		$startdatetime = $this->getFirstDateForWeekView($year, $month, $day);
		$seqdatetime = $startdatetime;
		$proportion = 100/7;
		$out = "";
		$out .= "<div class=\"cal\">\n<table class=\"weekview\" cellspacing=\"1\" style=\"width: 100%; background-color: rgb(".$this->settings->rgbheadercolor.");\">\n<tbody>\n";
		$out .= "<tr>\n";
		$out .= "<th rowspan=\"2\" style=\"min-width: 50px;\"></th>\n";
		foreach ($this->settings->getDays(1) as $d)
		{
			$out .= "<th style=\"width: ".$proportion."%; min-width: 100px;";
			if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= " background-color: rgb(".$this->settings->rgbtodayheadercolor.");";
			$out .= "\">".$d." ".date("j.n", $seqdatetime)."</th>\n";
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		$seqdatetime = $startdatetime;
		$out .= "</tr>\n";
		$out .= "<tr class=\"allday\">\n";
		foreach ($this->settings->getDays() as $d)
		{
			$out .= "<td style=\"border-bottom-style: solid; border-width: 5px; font-size: small; border-color: rgb(".$this->settings->rgbheadercolor."); background-color: rgb(";
			if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= $this->settings->rgbtodaycolor;
			else $out .= $this->settings->rgbbackgroundcolor;
			$out .= ")\"><div style=\"min-height: 40px;\">";
			
			$out .= $this->drawSmallSizeEvents(date("Y", $seqdatetime), date("n", $seqdatetime), date("j", $seqdatetime), true);
			
			$out .= "</div></td>\n";
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		$seqdatetime = $startdatetime;
		$out .= "</tr>\n";
		for ($i = 0; $i <= 23; $i++)
		{
			$out .= "<tr class=\"hour\">\n";
			$out .= "<th style=\"text-align: right; vertical-align: top;\">".date("H:i", $seqdatetime)."</th>\n";
			for ($j = 1; $j <= 7; $j++)
			{
				$out .= "<td id=\"\" style=\"background-color: rgb(";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= $this->settings->rgbtodaycolor;
				else $out .= $this->settings->rgbbackgroundcolor;
				$out .= "); font-size: small;\">\n";
				
				$out .= "<table class=\"hour\" cellspacing=\"0\" style=\"width: 100%; border-color: rgb(".$this->settings->rgbheadercolor.");\">\n<tbody>\n<tr>\n";
				$out .= "<td style=\"border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				
				$out .= "</td>\n";
				$out .= "</tr>\n";
				$out .= "<tr>\n";
				$out .= "<td style=\"border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				
				$out .= $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n";
				$out .= "<tr>\n";
				$out .= "<td style=\"border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				
				$out .= $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n";
				$out .= "<tr>\n";
				$out .= "<td class=\"last\" style=\"border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				
				$out .= $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n</tbody>\n</table>\n";
				
				$out .= "</td>\n";
				$seqdatetime = mktime(date("G", $seqdatetime), 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
			}
			$out .= "</tr>\n";
			$seqdatetime = mktime(date("G", $seqdatetime) + 1, 0, 0, date("m", $startdatetime), date("d", $startdatetime), date("y", $startdatetime));
		}
		$out .= "</tbody>\n</table>\n</div>\n";
		echo $out;
	}
	
	function getAgendaView($days = 10)
	{
		$startdatetime = mktime(0, 0, 0, date("m"), date("d"), date("y"));
		$seqdatetime = $startdatetime;
		$out = "";
		$out .= "<div class=\"cal\">\n";
		$out .= "<table class=\"agenda\" cellspacing=\"1\" style=\"width: 100%; background-color: rgb(".$this->settings->rgbheadercolor.");\">\n";
		$out .= "<tbody>\n";
		
		for ($i = 1; $i <= $days; $i++)
		{
			if ($this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime)) >= 1)
			{
				$out .= "<tr>\n";
				$out .= "<th style=\"";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= "background-color: rgb(".$this->settings->rgbtodayheadercolor.");";
				$out .= "width: 50px; min-width: 50px; vertical-align: top;\">".date("j.n", $seqdatetime)."</th>\n";
				$out .= "<td style=\"background-color: rgb(";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= $this->settings->rgbtodaycolor;
				else $out .= $this->settings->rgbbackgroundcolor;
				$out .= ");\">";
				$out .= "<table cellspacing=\"0\" style=\"width: 100%;\">\n";
				$out .= "<tbody>\n";
				
				foreach ($this->getEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime)) as $event)
				{
					$out .= "<tr>\n";
					$start = $event->getDateTimeStart();
					$finish = $event->getDateTimeEnd();
					$out .= "<td style=\"width: 100px; text-align: center;\">".date("H:i", $start)." - ".date("H:i", $finish)."</td>\n";
					$out .= "<td";
					if ($event->getColorRGB()) $out .= " style=\"color: rgb(".$event->getColorRGB().");\"";
					$out .= ">".$event->content_visible."</td>\n";
					$out .= "</tr>\n";
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
}

?>