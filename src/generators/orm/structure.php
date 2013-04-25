<?php

$tables = array (
	'columns' =>
	array (
		'class' => 'Column',
		'source' => 'LS',
		'key' => array('name', 'table'),
		'structure' =>
		array (
			'description' => 'string',
			'name' => 'string',
			'table' => 'string',
			'type' => 'string',
		),
	),
	'commands' =>
	array (
		'class' => 'Command',
		'source' => 'LS',
		'key' => array('line','name'),
		'structure' =>
		array (
			'line' => 'string',
			'name' => 'string',
		),
	),
	'comments' =>
	array (
		'class' => 'Comment',
		'source' => 'LS',
		'key' => array('id','is_service'),
		'structure' =>
		array (
			'author' => 'string',
			'comment' => 'string',
			'entry_time' => 'time',
			'entry_type' => 'int',
			'expire_time' => 'time',
			'expires' => 'int',
			'host' => array( 'Host', 'host_' ),
			'id' => 'int',
			'is_service' => 'int',
			'persistent' => 'int',
			'service' => array( 'Service', 'service_' ),
			'source' => 'int',
			'type' => 'int',
		),
	),
	'contactgroups' =>
	array (
		'class' => 'ContactGroup',
		'source' => 'LS',
		'key' => array('name'),
		'structure' =>
		array (
			'alias' => 'string',
			'members' => 'list',
			'name' => 'string',
		),
	),
	'contacts' =>
	array (
		'class' => 'Contact',
		'source' => 'LS',
		'key' => array('name'),
		'structure' =>
		array (
			'address1' => 'string',
			'address2' => 'string',
			'address3' => 'string',
			'address4' => 'string',
			'address5' => 'string',
			'address6' => 'string',
			'alias' => 'string',
			'can_submit_commands' => 'int',
			'custom_variable_names' => 'list',
			'custom_variable_values' => 'list',
			'custom_variables' => 'dict',
			'email' => 'string',
			'host_notification_period' => 'string',
			'host_notifications_enabled' => 'int',
			'in_host_notification_period' => 'int',
			'in_service_notification_period' => 'int',
			'modified_attributes' => 'int',
			'modified_attributes_list' => 'list',
			'name' => 'string',
			'pager' => 'string',
			'service_notification_period' => 'string',
			'service_notifications_enabled' => 'int',
		),
	),
	'downtimes' =>
	array (
		'class' => 'Downtime',
		'source' => 'LS',
		'key' => array('id', 'is_service'),
		'structure' =>
		array (
			'author' => 'string',
			'comment' => 'string',
			'duration' => 'int',
			'end_time' => 'time',
			'entry_time' => 'time',
			'fixed' => 'int',
			'host' => array( 'Host', 'host_' ),
			'id' => 'int',
			'is_service' => 'int',
			'service' => array( 'Service', 'service_' ),
			'start_time' => 'time',
			'triggered_by' => 'int',
			'type' => 'int',
		),
	),
	'hostgroups' =>
	array (
		'class' => 'HostGroup',
		'source' => 'LS',
		'key' => array('name'),
		'structure' =>
		array (
			'action_url' => 'string',
			'alias' => 'string',
			'members' => 'list',
			'members_with_state' => 'list',
			'name' => 'string',
			'notes' => 'string',
			'notes_url' => 'string',
			'num_hosts' => 'int',
			'num_hosts_down' => 'int',
			'num_hosts_pending' => 'int',
			'num_hosts_unreach' => 'int',
			'num_hosts_up' => 'int',
			'num_services' => 'int',
			'num_services_crit' => 'int',
			'num_services_hard_crit' => 'int',
			'num_services_hard_ok' => 'int',
			'num_services_hard_unknown' => 'int',
			'num_services_hard_warn' => 'int',
			'num_services_ok' => 'int',
			'num_services_pending' => 'int',
			'num_services_unknown' => 'int',
			'num_services_warn' => 'int',
			'worst_host_state' => 'int',
			'worst_service_hard_state' => 'int',
			'worst_service_state' => 'int',
		),
	),
	'hosts' =>
	array (
		'class' => 'Host',
		'source' => 'LS',
		'key' => array('name'),
		'structure' =>
		array (
			'accept_passive_checks' => 'int',
			'acknowledged' => 'int',
			'acknowledgement_type' => 'int',
			'action_url' => 'string',
		//	'action_url_expanded' => 'string',
			'active_checks_enabled' => 'int',
			'address' => 'string',
			'alias' => 'string',
			'check_command' => 'string',
			'check_flapping_recovery_notification' => 'int',
			'check_freshness' => 'int',
			'check_interval' => 'float',
			'check_options' => 'int',
			'check_period' => 'string',
			'check_type' => 'int',
			'checks_enabled' => 'int',
			'childs' => 'list',
			'comments' => 'list',
			'comments_with_info' => 'list',
			'contact_groups' => 'list',
			'contacts' => 'list',
			'current_attempt' => 'int',
			'current_notification_number' => 'int',
			'custom_variable_names' => 'list',
			'custom_variable_values' => 'list',
			'custom_variables' => 'dict',
			'display_name' => 'string',
			'downtimes' => 'list',
			'downtimes_with_info' => 'list',
			'event_handler' => 'string',
			'event_handler_enabled' => 'int',
			'execution_time' => 'float',
			'filename' => 'string',
			'first_notification_delay' => 'float',
			'flap_detection_enabled' => 'int',
			'groups' => 'list',
			'hard_state' => 'int',
			'has_been_checked' => 'int',
			'high_flap_threshold' => 'float',
			'hourly_value' => 'int',
			'icon_image' => 'string',
			'icon_image_alt' => 'string',
		//	'icon_image_expanded' => 'string',
			'in_check_period' => 'int',
			'in_notification_period' => 'int',
			'initial_state' => 'int',
			'is_executing' => 'int',
			'is_flapping' => 'int',
			'last_check' => 'time',
			'last_hard_state' => 'int',
			'last_hard_state_change' => 'time',
			'last_notification' => 'time',
			'last_state' => 'int',
			'last_state_change' => 'time',
			'last_time_down' => 'time',
			'last_time_unreachable' => 'time',
			'last_time_up' => 'time',
			'latency' => 'float',
			'long_plugin_output' => 'string',
			'low_flap_threshold' => 'float',
			'max_check_attempts' => 'int',
			'modified_attributes' => 'int',
			'modified_attributes_list' => 'list',
			'name' => 'string',
			'next_check' => 'time',
			'next_notification' => 'time',
			'no_more_notifications' => 'int',
			'notes' => 'string',
		//	'notes_expanded' => 'string',
			'notes_url' => 'string',
		//	'notes_url_expanded' => 'string',
			'notification_interval' => 'float',
			'notification_period' => 'string',
			'notifications_enabled' => 'int',
			'num_services' => 'int',
			'num_services_crit' => 'int',
			'num_services_hard_crit' => 'int',
			'num_services_hard_ok' => 'int',
			'num_services_hard_unknown' => 'int',
			'num_services_hard_warn' => 'int',
			'num_services_ok' => 'int',
			'num_services_pending' => 'int',
			'num_services_unknown' => 'int',
			'num_services_warn' => 'int',
			'obsess' => 'int',
			'parents' => 'list',
			'pending_flex_downtime' => 'int',
			'percent_state_change' => 'float',
			'perf_data' => 'string',
			'plugin_output' => 'string',
			'pnpgraph_present' => 'int',
			'process_performance_data' => 'int',
			'retry_interval' => 'float',
			'scheduled_downtime_depth' => 'int',
			'services' => 'list',
			'services_with_info' => 'list',
			'services_with_state' => 'list',
			'should_be_scheduled' => 'int',
			'state' => 'int',
			'state_type' => 'int',
			'statusmap_image' => 'string',
			'total_services' => 'int',
			'worst_service_hard_state' => 'int',
			'worst_service_state' => 'int',
		/*
			'x_3d' => 'float',
			'y_3d' => 'float',
			'z_3d' => 'float',
		*/
		),
	),
	'servicegroups' =>
	array (
		'class' => 'ServiceGroup',
		'source' => 'LS',
		'key' => array('name'),
		'structure' =>
		array (
			'action_url' => 'string',
			'alias' => 'string',
			'members' => 'list',
			'members_with_state' => 'list',
			'name' => 'string',
			'notes' => 'string',
			'notes_url' => 'string',
			'num_services' => 'int',
			'num_services_crit' => 'int',
			'num_services_hard_crit' => 'int',
			'num_services_hard_ok' => 'int',
			'num_services_hard_unknown' => 'int',
			'num_services_hard_warn' => 'int',
			'num_services_ok' => 'int',
			'num_services_pending' => 'int',
			'num_services_unknown' => 'int',
			'num_services_warn' => 'int',
			'worst_service_state' => 'int',
		),
	),
	'services' =>
	array (
		'class' => 'Service',
		'source' => 'LS',
		'key' => array('host.name', 'description'),
		'structure' =>
		array (
			'accept_passive_checks' => 'int',
			'acknowledged' => 'int',
			'acknowledgement_type' => 'int',
			'action_url' => 'string',
		//	'action_url_expanded' => 'string',
			'active_checks_enabled' => 'int',
			'check_command' => 'string',
			'check_freshness' => 'int',
			'check_interval' => 'float',
			'check_options' => 'int',
			'check_period' => 'string',
			'check_type' => 'int',
			'checks_enabled' => 'int',
			'comments' => 'list',
			'comments_with_info' => 'list',
			'contact_groups' => 'list',
			'contacts' => 'list',
			'current_attempt' => 'int',
			'current_notification_number' => 'int',
			'custom_variable_names' => 'list',
			'custom_variable_values' => 'list',
			'custom_variables' => 'dict',
			'description' => 'string',
			'display_name' => 'string',
			'downtimes' => 'list',
			'downtimes_with_info' => 'list',
			'event_handler' => 'string',
			'event_handler_enabled' => 'int',
			'execution_time' => 'float',
			'first_notification_delay' => 'float',
			'flap_detection_enabled' => 'int',
			'groups' => 'list',
			'has_been_checked' => 'int',
			'high_flap_threshold' => 'float',
			'host' => array( 'Host', 'host_' ),
			'hourly_value' => 'int',
			'icon_image' => 'string',
			'icon_image_alt' => 'string',
		//	'icon_image_expanded' => 'string',
			'in_check_period' => 'int',
			'in_notification_period' => 'int',
			'initial_state' => 'int',
			'is_executing' => 'int',
			'is_flapping' => 'int',
			'last_check' => 'time',
			'last_hard_state' => 'int',
			'last_hard_state_change' => 'time',
			'last_notification' => 'time',
			'last_state' => 'int',
			'last_state_change' => 'time',
			'last_time_critical' => 'time',
			'last_time_ok' => 'time',
			'last_time_unknown' => 'time',
			'last_time_warning' => 'time',
			'latency' => 'float',
			'long_plugin_output' => 'string',
			'low_flap_threshold' => 'float',
			'max_check_attempts' => 'int',
			'modified_attributes' => 'int',
			'modified_attributes_list' => 'list',
			'next_check' => 'time',
			'next_notification' => 'time',
			'no_more_notifications' => 'int',
			'notes' => 'string',
		//	'notes_expanded' => 'string',
			'notes_url' => 'string',
		//	'notes_url_expanded' => 'string',
			'notification_interval' => 'float',
			'notification_period' => 'string',
			'notifications_enabled' => 'int',
			'obsess' => 'int',
			'percent_state_change' => 'float',
			'perf_data' => 'string',
			'plugin_output' => 'string',
			'pnpgraph_present' => 'int',
			'process_performance_data' => 'int',
			'retry_interval' => 'float',
			'scheduled_downtime_depth' => 'int',
			'should_be_scheduled' => 'int',
			'state' => 'int',
			'state_type' => 'int',
		),
	),
	'status' =>
	array (
		'class' => 'Status',
		'source' => 'LS',
		'key' => array(),
		'structure' =>
		array (
			'accept_passive_host_checks' => 'int',
			'accept_passive_service_checks' => 'int',
			'cached_log_messages' => 'int',
			'check_external_commands' => 'int',
			'check_host_freshness' => 'int',
			'check_service_freshness' => 'int',
			'connections' => 'int',
			'connections_rate' => 'float',
			'enable_event_handlers' => 'int',
			'enable_flap_detection' => 'int',
			'enable_notifications' => 'int',
			'execute_host_checks' => 'int',
			'execute_service_checks' => 'int',
			'forks' => 'int',
			'forks_rate' => 'float',
			'host_checks' => 'int',
			'host_checks_rate' => 'float',
			'interval_length' => 'int',
			'last_log_rotation' => 'time',
			'livecheck_overflows' => 'int',
			'livecheck_overflows_rate' => 'float',
			'livechecks' => 'int',
			'livechecks_rate' => 'float',
			'livestatus_version' => 'string',
			'log_messages' => 'int',
			'log_messages_rate' => 'float',
			'nagios_pid' => 'int',
			'neb_callbacks' => 'int',
			'neb_callbacks_rate' => 'float',
			'num_hosts' => 'int',
			'num_services' => 'int',
			'obsess_over_hosts' => 'int',
			'obsess_over_services' => 'int',
			'process_performance_data' => 'int',
			'program_start' => 'time',
			'program_version' => 'string',
			'requests' => 'int',
			'requests_rate' => 'float',
			'service_checks' => 'int',
			'service_checks_rate' => 'float',
		),
	),
	'timeperiods' =>
	array (
		'class' => 'TimePeriod',
		'source' => 'LS',
		'key' => array('name'),
		'structure' =>
		array (
			'alias' => 'string',
			'in' => 'int',
			'name' => 'string',
		),
	),
	'notifications' =>
	array(
		'class' => 'Notification',
		'source' => 'SQL',
		'table' => 'notification',
		'key' => array('id'),
		'default_sort' => array('id desc'),
		'structure' => array(
			'instance_id' => 'int',
			'id' => 'int',
			'notification_type' => 'int',
			'start_time' => 'int',
			'end_time' => 'int',
			'contact_name' => 'string',
			'host_name' => 'string',
			'service_description' => 'string',
			'command_name' => 'string',
			'reason_type' => 'int',
			'state' => 'int',
			'output' => 'string',
			'ack_author' => 'string',
			'ack_data' => 'string',
			'escalated' => 'int',
			'contacts_notified' => 'int',
			),
		),
	'saved_filters' =>
	array(
		'class' => 'SavedFilter',
		'source' => 'SQL',
		'table' => 'ninja_saved_filters',
		'key' => array('id'),
		'default_sort' => array('filter_name asc'),
		'structure' => array(
			'id' => 'int',
			'username' => 'string',
			'filter_name' => 'string',
			'filter_table' => 'string',
			'filter' => 'string',
			'filter_description' => 'string'
			),
		)
	);
/*

		'log' =>
		array (
			'class' => 'LogEntry',
			'structure' =>
			array (
				'attempt' => 'int',
				'class' => 'int',
				'command_name' => 'string',
				'comment' => 'string',
				'contact_name' => 'string',
				'current_command_line' => 'string',
				'current_command_name' => 'string',
				'current_contact' => array( 'Contact', 'current_contact_' ),
				'current_host' => array( 'Host', 'current_host_' ),
				'current_service' => array( 'Service', 'current_service_' ),
				'host_name' => 'string',
				'lineno' => 'int',
				'message' => 'string',
				'options' => 'string',
				'plugin_output' => 'string',
				'service_description' => 'string',
				'state' => 'int',
				'state_type' => 'string',
				'time' => 'time',
				'type' => 'string',
			),
		),
		'hostsbygroup' =>
		array (
			'class' => 'HostByGroup',
			'structure' =>
			array (
				'host' => array( 'Host', '' ),
				'hostgroup' => array( 'HostGroup', 'hostgroup_' ),
			),
		),
		'servicesbygroup' =>
		array (
			'class' => 'ServiceByGroup',
			'structure' =>
			array (
				'service' => array( 'Service', '' ),
				'servicegroup' => array( 'ServiceGroup', 'servicegroup_' ),
			),
		),
		'servicesbyhostgroup' =>
		array (
			'class' => 'ServiceByHostGroup',
			'structure' =>
			array (
				'service' => array( 'Service', '' ),
				'hostgroup' => array( 'HostGroup', 'hostgroup_' ),
			),
		),
*/