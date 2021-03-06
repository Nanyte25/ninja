<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Helper class for alert log
 *
 * Copyright 2009 op5 AB
 *  op5, and the op5 logo are trademarks, servicemarks, registered servicemarks
 *  or registered trademarks of op5 AB.
 *  All other trademarks, servicemarks, registered trademarks, and registered
 *  servicemarks mentioned herein may be the property of their respective owner(s).
 *  The information contained herein is provided AS IS with NO WARRANTY OF ANY
 *  KIND, INCLUDING THE WARRANTY OF DESIGN, MERCHANTABILITY, AND FITNESS FOR A
 *  PARTICULAR PURPOSE.
 */
class alert_history {
	/**
	 * Convert all sorts of constants to user-readable strings, add html, and generally make things pretty
	 * @param $entry A database row
	 * @return An array, somewhat similar to the entry one, but with new values
	 */
	public static function get_user_friendly_representation($entry) {
		$ret = array(
			'type' => '',
			'obj_name' => '',
			'state' => '',
			'image' => '',
			'softorhard' => ''
		);
		switch ($entry['event_type']) {
		 case 100:
			$ret['type'] = 'Process start';
			$ret['state'] = "Start";
			$ret['image'] = '<span class="icon-16 x16-' . strtolower($ret['state']) . '" title="' . $ret['state'] . '"></span>';
			break;
		 case 102:
			$ret['type'] = 'Process restart';
			$ret['state'] = "Restart";
			$ret['image'] = '<span class="icon-16 x16-' . strtolower($ret['state']) . '" title="' . $ret['state'] . '"></span>';
			break;
		 case 103:
			$ret['type'] = 'Process shutdown';
			$ret['state'] = 'Stop';
			$ret['image'] = '<span class="icon-16 x16-' . strtolower($ret['state']) . '" title="' . $ret['state'] . '"></span>';
			break;
		 case 701:
			$ret['type'] = 'Service alert';
			switch ($entry['state']) {
			 case 0:
				$ret['state'] = 'OK';
				break;
			 case 1:
				$ret['state'] = 'Warning';
				break;
			 case 2:
				$ret['state'] = 'Critical';
				break;
			 case 3:
				$ret['state'] = 'Unknown';
				break;
			 default:
				# technically, "unknown unknown, as opposed to known unknown above"
				$ret['state'] = 'Pending';
				break;
			}
			$ret['image'] = '<span class="icon-16 x16-shield-' . strtolower($ret['state']) . '" title="' . $ret['state'] . '"></span>';
			$ret['softorhard'] = $entry['hard'] ? 'Hard' : 'Soft';
			break;
		 case 801:
			$ret['type'] = 'Host alert';
			switch ($entry['state']) {
			 case 0:
				$ret['state'] = 'Up';
				break;
			 case 1:
				$ret['state'] = 'Down';
				break;
			 case 2:
				$ret['state'] = 'Unreachable';
				break;
			 default:
				$ret['state'] = 'Pending';
				break;
			}
			$ret['image'] = '<span class="icon-16 x16-shield-' . strtolower($ret['state']) . '" title="' . $ret['state'] . '"></span>';
			$ret['softorhard'] = $entry['hard'] ? 'Hard' : 'Soft';
			break;
		 case 1000:
		 case 1001:
			if ($entry['service_description']) {
				$ret['type'] = 'Service flapping alert';
			} else {
				$ret['type'] = 'Host flapping alert';
			}
			$ret['softorhard'] = $entry['event_type'] == 1000 ? 'Started' : 'Stopped';
			$ret['image'] = '<span class="icon-16 x16-flapping" title="Flapping"></span>';
			break;
		 case 1103:
		 case 1104:
			if ($entry['service_description'])
				$ret['type'] = 'Service downtime alert';
			else
				$ret['type'] = 'Host downtime alert';
			$ret['softorhard'] = $entry['event_type'] == 1103 ? 'Started' : 'Stopped';
			$ret['image'] = '<span class="icon-16 x16-scheduled-downtime" title="Sheduled downtime"></span>';
			break;
		 default:
			$ret['type'] = "Unknown event #{$entry['entry_type']}";
			break;
		}

		return $ret;
	}
}
