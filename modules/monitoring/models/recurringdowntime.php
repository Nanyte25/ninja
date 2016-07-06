<?php


/**
 * Autogenerated class RecurringDowntime_Model
 *
 * @todo: documentation
 */
class RecurringDowntime_Model extends BaseRecurringDowntime_Model {
	public function get_weekdays()
	{
		$weekdays = parent::get_weekdays();
		if (is_string($weekdays))
			$weekdays = unserialize($weekdays);
		if (!$weekdays)
			$weekdays = array();
		return $weekdays;
	}

	public function get_months()
	{
		$months = parent::get_months();
		if (is_string($months))
			$months = unserialize($months);
		if (!$months)
			$months = array();
		return $months;
	}

	/**
	 * Get the start time, but format it the way times are usually
	 * formatted: hh:mm:ss
	 *
	 * @ninja orm depend[] start_time
	 */
	public function get_start_time_string()
	{
		$start_time = $this->get_start_time();
		return sprintf("%02d:%02d:%02d", (int)($start_time / 3600 % 24), (int)($start_time / 60 % 60), (int)($start_time % 60));
	}

	/**
	 * Get the end time, but format it the way times are usually
	 * formatted: hh:mm:ss
	 *
	 * @ninja orm depend[] end_time
	 */
	public function get_end_time_string()
	{
		$end_time = $this->get_end_time();
		return sprintf("%02d:%02d:%02d", (int)($end_time / 3600 % 24), (int)($end_time / 60 % 60), (int)($end_time % 60));
	}

	/**
	 * Get the duration, but format it the way times are usually
	 * formatted: hh:mm:ss, or an empty string if the downtime is 'fixed'.
	 *
	 * @ninja orm depend[] duration
	 * @ninja orm depend[] fixed
	 */
	public function get_duration_string()
	{
		if($this->get_fixed()) {
			return "";
		}
		$duration = $this->get_duration();
		return sprintf("%02d:%02d:%02d", (int)($duration / 3600 % 24), (int)($duration / 60 % 60), (int)($duration % 60));
	}

	/**
	 * Get all objects in this schedule as a list
	 *
	 * @ninja orm depend[] id
	 */
	public function get_objects()
	{
		$ret = array();
		$id = $this->get_id();
		if ($id) {
			$db = Database::instance();
			$res = $db->query('SELECT object_name from recurring_downtime_objects WHERE recurring_downtime_id = '.$id);
			foreach ($res->result(false) as $row) {
				$ret[] = $row['object_name'];
			}
		}
		return $ret;
	}
}
