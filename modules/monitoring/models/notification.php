<?php


/**
 * Describes a single object from livestatus
 */
class Notification_Model extends BaseNotification_Model {
	/**
	 * Get the state, as text
	 *
	 * @ninja orm depend[] state
	 * @ninja orm depend[] notification_type
	 */
	public function get_state_text() {
		$state = $this->get_state();
		$notification_type = $this->get_notification_type();

		switch( $notification_type ) {
			case 0: // host
				switch( $state ) {
					case 0: return 'up';
					case 1: return 'down';
					case 2: return 'unreachable';
				}
				return 'unknown'; // should never happen

			case 1: // service
				switch( $state ) {
					case 0: return 'ok';
					case 1: return 'warning';
					case 2: return 'critical';
					case 3: return 'unknown';
				}
				return 'unknown'; // should never happen
		}
		return 'unknown'; // should never happen
	}
}
