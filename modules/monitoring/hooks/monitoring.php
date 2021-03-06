<?php

require_once('op5/mayi.php');
require_once('op5/sysinfo.php');

/**
 * Class containing hooks to interface with the monitoring subsystem.
 */
class monitoring_hooks implements op5MayI_Actor {
	public function __construct() {

		Event::add('system.post_controller_constructor',
			array ($this,'load_notices'));

		Event::add('system.post_controller',
			array ($this,'add_extras'));

		$mayi = op5MayI::instance();
		$mayi->be('monitor.monitoring', $this);
	}

	/**
	 * Return information about the system usage.
	 *
	 * @return array environemnt
	 */
	public function getActorInfo() {
		$sysinfo = op5sysinfo::instance()->get_usage();
		return array(
			'hosts' => isset($sysinfo['monitor']) ? $sysinfo['monitor'] : 0,
			'services' => isset($sysinfo['monitor.service']) ? $sysinfo['monitor.service'] : 0
		);
	}

	/**
	 * Hook executed in system.post_controller_constructor to load notices
	 * for system status and configuration.
	 */
	public function load_notices() {
		$controller = Event::$data;
		/*
		 * We can only add notices to the ninja controller, so don't
		 * bother otherwise
		 */
		if ($controller instanceof Ninja_Controller) {

			$status = StatusPool_Model::status();
			if ($status) {
				// we've got access
				if (!$status->get_enable_notifications()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Notifications are disabled')
						)
					);
				}
				if (!$status->get_execute_service_checks()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Service checks are disabled')
						)
					);
				}
				if (!$status->get_execute_host_checks()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Host checks are disabled')
						)
					);
				}
				if (!$status->get_process_performance_data()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Performance data processing is disabled')
						)
					);
				}
				if (!$status->get_accept_passive_service_checks()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Passive service checks are disabled')
						)
					);
				}
				if (!$status->get_accept_passive_host_checks()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Passive host checks are disabled')
						)
					);
				}
				if (!$status->get_enable_event_handlers()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Event handlers are disabled')
						)
					);
				}
				if (!$status->get_enable_flap_detection()) {
					$controller->notices[] = new ErrorNotice_Model(
						html::href(
							url::method('extinfo', 'show_process_info'),
							_('Flap detection is disabled')
						)
					);
				}

				unset($status);
			}
		}
	}

	/**
	 * Hook for adding extra details to the page
	 */
	public function add_extras() {
		$controller = Event::$data;

		// add context menu items (hidden in html body)
		$controller->template->context_menu = new View('status/context_menu');
	}
}

new monitoring_hooks();

/**
 * Provides "installation_time" actor info
 */
class monitor_mayi_actor implements op5MayI_Actor {
	private $actorinfo = array();

	/**
	 * @return array
	 */
	public function getActorInfo() {
		if (!isset($this->actorinfo['installation_time'])) {
			$this->actorinfo['installation_time'] = installation::get_installation_time();
		}
		return $this->actorinfo;
	}
}

op5mayi::instance()->be('monitor', new monitor_mayi_actor());
