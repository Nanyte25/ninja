<?php
$auth = Auth::instance();

# translate menu labels
$menu_items = false;
$menu_items['section_about'] = _('About');
$menu_items['portal'] = _('op5 Portal');
$menu_items['manual'] = _('op5 Monitor manual');
$menu_items['support'] = _('op5 Support portal');
$menu_items['ninja_project'] = _('The Ninja project');
$menu_items['merlin_project'] = _('The Merlin project');
$menu_items['project_documentation'] = _('Project documentation');

$menu_items['section_monitoring'] = _('Monitoring');
$menu_items['tac'] = _('Tactical overview');
$menu_items['host_detail'] = _('Host detail');
$menu_items['service_detail'] = _('Service detail');

$menu_items['hostgroup_summary'] = _('Hostgroup summary');

$menu_items['servicegroup_summary'] = _('Servicegroup summary');

$menu_items['network_outages'] = _('Network outages');

$menu_items['comments'] = _('Comments');
$menu_items['schedule_downtime'] = _('Schedule downtime');
$menu_items['process_info'] = _('Process info');
$menu_items['performance_info'] = _('Performance info');
$menu_items['scheduling_queue'] = _('Scheduling queue');
$menu_items['rotation'] = _('Rotation');

$menu_items['nagvis'] = _('NagVis');

if (Kohana::config('hypergraph.hyperapplet_path') !== false) {
	$menu_items['hyper_map'] = _('Hyper Map');
}

$menu_items['section_reporting'] = _('Reporting');
$menu_items['pnp'] = _('Graphs');
$menu_items['alert_history'] = _('Alert history');
$menu_items['alert_summary'] = _('Alert summary');
$menu_items['notifications'] = _('Notifications');
$menu_items['event_log'] = _('Event log');
$menu_items['availability'] = _('Availability');
$menu_items['sla'] = _('SLA Reporting');
$menu_items['schedule_reports'] = _('Schedule reports');

if (Kohana::config('config.cacti_path')) {
	$menu_items['statistics'] = _('Statistics');
}

if ($auth->authorized_for('configuration_information') && Kohana::config('config.nacoma_path') !== false) {
	$menu_items['configure'] = _('Configure');
}

$menu_items['section_configuration'] = _('Configuration');
$menu_items['view_config'] = _('View config');
$menu_items['my_account'] = _('My Account');
$menu_items['backup_restore'] = _('Backup/Restore');

# menu structure using array keys from translated labels above
$menu = array(
	'section_about' => array('portal', 'manual', 'support', 'ninja_project', 'merlin_project', 'project_documentation'),
	'section_monitoring' => array('tac', 'host_detail', 'service_detail',
		'hostgroup_summary', 'hostgroup_overview', 'hostgroup_grid',
		'servicegroup_summary', 'servicegroup_overview', 'servicegroup_grid',
		'network_outages', //'host_problems', 'service_problems', 'unhandled_problems',
		'comments', 'schedule_downtime', 'process_info', 'scheduling_queue', 'performance_info', 'hyper_map', 'nagvis'), /* remove hardcoded nagvis menu entry */
	'section_reporting' => array('trends', 'pnp', 'alert_history', 'alert_summary', 'notifications', 'event_log',
		'availability', 'sla', 'schedule_reports', 'statistics'),
	'section_configuration' => array('view_config', 'my_account', 'backup_restore', 'configure')
);

// Preparing the reporting section on beforehand since it might or might not include the pnp link
$section_reporting = array();
if(Kohana::config('config.pnp4nagios_path') !== false) {
	$section_reporting[$menu_items['pnp']] = array('/pnp?host=.pnp-internal&srv=runtime', 'pnp',0);
}
$section_reporting[$menu_items['alert_history']] = array('/alert_history/generate', 'alerthistory',0);
$section_reporting[$menu_items['alert_summary']]= array('/summary', 'alertsummary',0);
$section_reporting[$menu_items['notifications']]  = array('/listview?q=[notifications] all', 'notifications',0);
$section_reporting[$menu_items['event_log']] = array('/showlog/showlog', 'eventlog',0);
$section_reporting[$menu_items['availability']] = array('/avail/index', 'availability',0);
$section_reporting[$menu_items['sla']] = array('/sla/index', 'sla',0);
$section_reporting[$menu_items['schedule_reports']]= array('/schedule/show', 'schedulereports',0);

# base menu (all)
$menu_base = array(
	$menu_items['section_about'] => array(
		$menu_items['portal'] 					=> array('//'.$_SERVER['HTTP_HOST'], 'portal',2),
		$menu_items['manual'] 					=> array('//'.$_SERVER['HTTP_HOST'].'/monitor/op5/manual/index.html', 'manual',2),
		$menu_items['support'] 					=> array('http://www.op5.com/support', 'support',2),
		$menu_items['ninja_project'] 			=> array('http://www.op5.org/community/plugin-inventory/op5-projects/ninja', 'ninja',3),
		$menu_items['merlin_project'] 			=> array('http://www.op5.org/community/plugin-inventory/op5-projects/merlin', 'merlin',3),
		$menu_items['project_documentation'] 	=> array('https://wiki.op5.org', 'eventlog',3),
	),
	$menu_items['section_monitoring'] => array(
		$menu_items['tac'] 						=> array('/tac', 'tac',0),
		$menu_items['host_detail'] 				=> array('/listview?q=[hosts] all', 'host',0),
		$menu_items['service_detail'] 			=> array('/listview?q=[services] all', 'service',0),
		$menu_items['hostgroup_summary']		=> array('/listview?q=[hostgroups] all', 'hostgroupsummary',0),
		$menu_items['servicegroup_summary'] 	=> array('/listview?q=[servicegroups] all', 'servicegroupsummary',0),
		$menu_items['network_outages']  		=> array('/outages', 'outages',0),
		$menu_items['comments'] 				=> array('/listview?q=[comments] all', 'comments',0),
		$menu_items['schedule_downtime']		=> array('/listview?q=[downtimes] all', 'scheduledowntime',0),

		$menu_items['process_info'] 			=> array('/extinfo/show_process_info', 'processinfo',0),
		$menu_items['performance_info'] 		=> array('/extinfo/performance', 'performanceinfo',0),
		$menu_items['scheduling_queue'] 		=> array('/extinfo/scheduling_queue', 'schedulingqueue',0),
		$menu_items['rotation'] 		=> array('/rotation/index', 'nagvis',0)
	),
	$menu_items['section_reporting'] => $section_reporting,
	$menu_items['section_configuration'] => array(
		$menu_items['view_config'] 				=> array('/config', 'viewconfig',0),
		$menu_items['my_account'] 				=> array('/user', 'password',0),
		$menu_items['backup_restore']			=> array('/backup', 'backup',0)
	)
);


if (isset($menu_items['statistics']))
	$menu_base[$menu_items['section_reporting']][$menu_items['statistics']] = array('/statistics', 'statistics',1);

# Add NACOMA link only if enabled in config
if (isset($menu_items['configure']))
	$menu_base[$menu_items['section_configuration']][$menu_items['configure']] = array('/configuration/configure','nacoma',0);


if (isset($menu_items['hyper_map']))
	$menu_base[$menu_items['section_monitoring']][$menu_items['hyper_map']] = array('/hypermap', 'hypermap',0);
unset($auth);

/* remove hardcoded nagvis menu entry */
if (isset($menu_items['nagvis']) && Kohana::config('nagvis.nagvis_path'))
	$menu_base[$menu_items['section_monitoring']][$menu_items['nagvis']] = array('/nagvis/index', 'nagvis',0);


if (Kohana::config('config.site_domain') != '/monitor/') {
	# remove op5 monitor specific links
	unset($menu_base[$menu_items['section_about']][$menu_items['portal']]);
	unset($menu_items['portal']);
	unset($menu['section_about']['portal']);

	unset($menu_base[$menu_items['section_about']][$menu_items['manual']]);
	unset($menu_items['manual']);
	unset($menu['section_about']['manual']);

	unset($menu_base[$menu_items['section_about']][$menu_items['support']]);
	unset($menu_items['support']);
	unset($menu['section_about']['support']);
}

# master menu section
$sections = array(
	'about',
	'monitoring',
	'reporting',
	'configuration'
);

$xtra_menu = Kohana::config('menu.items');
if (!empty($xtra_menu)) {
	foreach ($xtra_menu as $section => $page_info) {
		foreach ($page_info as $page => $info) {
			# Use key from info array if available
			# if not - we use the page as key
			# info array should contain the following fields:
			# path, icon, link_flag, page_key
			# where link_flag has value 0-3 and controls link type
			# (relative/absolute) and visibility (op5/community)
			$page_key = isset($info[3]) ? $info[3] : $page;
			$menu_items[$page] = $page_key;
			$menu_base[$section][$page_key] = $info;
			$menu['section_'.strtolower($section)][] = $page;
		}
		unset($xtra_menu[$section]);
	}
}