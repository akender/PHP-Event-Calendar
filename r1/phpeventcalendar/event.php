<?php

class Event extends PHPEventCalendar
{
	var $content_visible;
	var $content_hidden;
	var $colorRGB;
	var $datetime_start;
	var $datetime_end;
	
//	var $year_start;
//	var $month_start;
//	var $day_start;
//	var $hour_start;
//	var $min_start;
//	var $year_finish;
//	var $month_finish;
//	var $day_finish;
//	var $hour_finish;
//	var $min_finish;
	
	function Event($content_vis, $content_hid, $year_st, $month_st, $day_st, $hour_st = null, $min_st = null, $year_end = null, $month_end = null, $day_end = null, $hour_end = null, $min_end = null)
	{
		$this->content_visible = $content_vis;
		$this->content_hidden = $content_hid;
		$this->colorRGB = null;
		$this->datetime_start = mktime($hour_st, $min_st, null, $month_st, $day_st, $year_st);
		$this->datetime_end = mktime($hour_end, $min_end, null, $month_end, $day_end, $year_end);
		
//		$this->year_start = $year_st;
//		$this->month_start = $month_st;
//		$this->day_start = $day_st;
//		$this->hour_start = $hour_st;
//		$this->min_start = $min_st;
//		$this->year_finish = $year_fs;
//		$this->month_finish = $month_fs;
//		$this->day_finish = $day_fs;
//		$this->hour_finish = $hour_fs;
//		$this->min_finish = $min_fs;
	}
	
	function setColorRGB($RGBstring)
	{
		$this->colorRGB = $RGBstring;
	}
	
	function getColorRGB()
	{
		return $this->colorRGB;
	}
	
	function isAllDayEvent()
	{
		if ($this->datetime_start >= $this->datetime_end) return true;
		else return false;
	}
	
	function getVisibleContent()
	{
		return $this->content_visible;
	}
	
	function getHiddenContent()
	{
		return $this->content_hidden;
	}
	
	function getDateTimeStart()
	{
		return $this->datetime_start;
	}
	
	function getDuration()
	{
		if ($this->datetime_end > $this->datetime_start)
		{
			$duration = $this->datetime_end - $this->datetime_start;
			return $duration;
		}
		else
		{
			return 0;
		}
	}
	
	/**
 	*
 	* Get datetime finish of event
 	*
 	* @param	none
 	* @return	false or datetime
 	*
 	*/
	function getDateTimeEnd()
	{
		return $this->datetime_end;
	}
}

?>
