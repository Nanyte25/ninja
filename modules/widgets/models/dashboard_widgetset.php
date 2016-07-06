<?php


/**
 * Autogenerated class Dashboard_WidgetSet_Model
 *
 * @todo: documentation
 */
class Dashboard_WidgetSet_Model extends BaseDashboard_WidgetSet_Model {

	protected function get_auth_filter() {
		$auth = Auth::instance();
		$username = $auth->get_user()->get_username();

		$result_filter = new LivestatusFilterAnd();
		$result_filter->add($this->filter);
		$result_filter->add(new LivestatusFilterMatch('dashboard.username', $username));
		return $result_filter;
	}
}
