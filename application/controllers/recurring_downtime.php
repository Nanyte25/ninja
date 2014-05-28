<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller to handle Recurring Downtime Schedules
 * Requires authentication
 *
 *  op5, and the op5 logo are trademarks, servicemarks, registered servicemarks
 *  or registered trademarks of op5 AB.
 *  All other trademarks, servicemarks, registered trademarks, and registered
 *  servicemarks mentioned herein may be the property of their respective owner(s).
 *  The information contained herein is provided AS IS with NO WARRANTY OF ANY
 *  KIND, INCLUDING THE WARRANTY OF DESIGN, MERCHANTABILITY, AND FITNESS FOR A
 *  PARTICULAR PURPOSE.
 */
class recurring_downtime_Controller extends Authenticated_Controller {

	/**
	*	Setup/Edit schedules
	*/
	public function index($id=false)
	{
		if (!empty($_POST)) {
			$data = false;
			$missing = array();
			foreach (ScheduleDate_Model::$valid_fields as $field) {
				if (!isset($_REQUEST[$field])) {
					if ($field === 'fixed') {
						$data[$field] = false;
					}
					else if ($field === 'author') {
						$data[$field] = Auth::instance()->get_user()->username;
					}
					else {
						$missing[] = $field;
					}
				}
				else {
					$data[$field] = $_REQUEST[$field];
				}
			}

			if ($missing) {
				$recurring_downtime_error = 'Missing required fields: ' . implode(', ', $missing);
			} else {
				$id = arr::search($_REQUEST, 'schedule_id');

				$sd = new ScheduleDate_Model();
				if ($sd->edit_schedule($data, $id))
					return url::redirect(url::base(true) . 'listview?q=[recurring_downtimes]%20all');
				$recurring_downtime_error = 'Failed to save changed schedule';
			}
		}

		$this->template->disable_refresh = true;

		$this->template->title = _('Monitoring » Scheduled downtime » Recurring downtime');

		$this->template->content = $this->add_view('recurring_downtime/setup');
		$template = $this->template->content;

		$this->xtra_js[] = 'application/media/js/jquery.datePicker.js';
		$this->xtra_js[] = 'application/media/js/jquery.timePicker.js';
		$this->xtra_js[] = $this->add_path('reports/js/common.js');
		$this->xtra_js[] = $this->add_path('recurring_downtime/js/recurring_downtime.js');

		$this->xtra_css[] = $this->add_path('reports/css/datePicker.css');

		$date_format = cal::get_calendar_format(true);

		$schedule_id = arr::search($_REQUEST, 'schedule_id', $id);

		if (isset($recurring_downtime_error)) {
			$this->template->content->error = $recurring_downtime_error;
		}

		$this->template->toolbar = new Toolbar_Controller('Recurring scheduled downtimes');

		$this->template->toolbar->button('<span class="icon-menu menu-schedulereports"></span>' . _('Schedules'), array('href' => url::base(true) . 'listview?q=[recurring_downtimes]%20all'));

		$data = false;
		$schedule_info = array(
			'start_time' => 12 * 3600,
			'end_time' => 14 * 3600,
			'duration' => 2 * 3600,
			'fixed' => true,
			'comment' => '',
		);
		if (!empty($_POST)) {
			$schedule_info = array_merge($schedule_info, $_POST);
			$schedule_info = new RecurringDowntime_Model($schedule_info, '', false);
		}
		else if ($schedule_id) {
			$set = RecurringDowntimePool_Model::get_by_query('[recurring_downtimes] id = ' . $schedule_id);
			$schedule_info = $set->it(array('id', 'downtime_type', 'objects', 'start_time', 'end_time', 'duration', 'fixed', 'weekdays', 'months', 'comment'))->current();
		} else {
			$schedule_info = new RecurringDowntime_Model($schedule_info, '', false);
		}

		if ($schedule_id) {
			$this->js_strings .= "var _report_data = " . json_encode(array('objects' => $schedule_info->get_objects(), 'downtime_type' => $schedule_info->get_downtime_type())) . "\n";
			$this->js_strings .= "var _schedule_id = " . $schedule_id . "\n";
		}
		$this->js_strings .= reports::js_strings();

		$this->js_strings .= "var _reports_err_str_noobjects = '".sprintf(_("Please select objects by moving them from %s the left selectbox to the right selectbox"), '<br />')."';\n";
		$this->js_strings .= "var _form_err_empty_fields = '"._("Please Enter valid values in all required fields (marked by *) ")."';\n";
		$this->js_strings .= "var _form_err_bad_timeformat = '"._("Please Enter a valid %s value (hh:mm[:ss])")."';\n";
		$this->js_strings .= "var _schedule_error = '"._("An error occurred when trying to delete this schedule")."';\n";

		$this->js_strings .= "var _schedule_delete_ok = '"._("OK")."';\n";
		$this->js_strings .= "var _schedule_delete_success = '"._("The schedule was successfully removed")."';\n";

		$this->js_strings .= "var _form_field_start_time = '"._("Start Time")."';\n";
		$this->js_strings .= "var _form_field_end_time = '"._("End Time")."';\n";
		$this->js_strings .= "var _form_field_duration = '"._("duration")."';\n";


		$template->day_names = date::day_names();
		$template->day_index = array(1, 2, 3, 4, 5, 6, 0);
		$template->month_names = date::month_names();

		$template->schedule_id = $schedule_id;
		$template->schedule_info = $schedule_info;

		$this->template->inline_js = $this->inline_js;
		$this->template->js_strings = $this->js_strings;
	}

	/**
	 * Insert a downtime
	 *
	 * @return string
	 **/
	function insert_downtimes()
	{
		$this->auto_render = false;
		$objects = $this->input->post('objects', false);
		$object_type = $this->input->post('object_type', false);
		$start_time = $this->input->post('start_time', false);
		$end_time = $this->input->post('end_time', false);
		$fixed = $this->input->post('fixed', false);
		$duration = $this->input->post('duration', false);
		$comment = $this->input->post('comment', false);

		if (ScheduleDate_Model::insert_downtimes($objects, $object_type, $start_time, $end_time, $fixed, $duration, $comment) !== false) {
			return json::ok("Downtime successfully scheduled");
		} else {
			return json::fail("Failed to schedule downtime");
		}
	}

	/**
	 * Delete a schedule
	 */
	public function delete()
	{
		$this->auto_render=false;
		$schedule_id = $this->input->post('schedule_id', false);

		if (!$schedule_id) {
			return json::fail('Error: no schedule id provided');
		}

		if (ScheduleDate_Model::delete_schedule($schedule_id) !== false) {
			return json::ok("Schedule deleted");
		} else {
			return json::fail("Not authorized to delete schedule or it doesn't exist.");
		}
	}
}
