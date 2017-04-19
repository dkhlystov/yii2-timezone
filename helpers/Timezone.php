<?php

namespace dkhlystov\helpers;

/**
 * Helper for set and get timezone
 */
class Timezone
{

	/**
	 * Getter for timezone
	 * @return int
	 */
	public static function get()
	{
		$h = date('H');
		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$offset = $h - date('H');
		date_default_timezone_set($timezone);

		//correcting
		if ($offset < -12) $offset += 24;
		elseif ($offset > 12) $offset -= 24;

		return $offset;
	}

	/**
	 * Setter for timezone
	 * @param int $offset 
	 * @return bool
	 */
	public static function set($offset) {
		$timezone = date_default_timezone_get();
		$b = false;
		date_default_timezone_set('UTC');
		$target = date('H') + $offset;

		//correcting
		if ($target > 24) $target -= 24;
		elseif ($target < 0) $target += 24;

		//try to fing timezone
		$tmp = timezone_identifiers_list();
		foreach ($tmp as $v) {
			date_default_timezone_set($v);
			if (date('H') == $target) {
				$b = true;
				break;
			}
		}

		//if timezone is not found, return original
		if (!$b)
			date_default_timezone_set($timezone);

		return $b;
	}

}
