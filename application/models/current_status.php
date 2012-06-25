<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Retrieves and manipulates current status of hosts (and services?)
 */
class Current_status_Model extends Model
{
	const HOST_UP =  0; /**< Nagios' host up code */
	const HOST_DOWN = 1; /**< Nagios' host down code */
	const HOST_UNREACHABLE = 2; /**< Nagios' host unreachable code */
	const HOST_PENDING = 6; /**< Our magical "host pending" code for unchecked hosts */

	const SERVICE_OK = 0; /**< Nagios' service ok code */
	const SERVICE_WARNING = 1; /**< Nagios' service warning code */
	const SERVICE_CRITICAL = 2; /**< Nagios' service critical code */
	const SERVICE_UNKNOWN =  3; /**< Nagios' service unknown code */
	const SERVICE_PENDING = 6; /**< Our magical "service pending" code for unchecked services */
	const HOST_CHECK_ACTIVE = 0;	/**< Nagios performed the host check */
	const HOST_CHECK_PASSIVE = 1;	/**< the host check result was submitted by an external source */
	const SERVICE_CHECK_ACTIVE = 0; /**< Nagios performed the service check */
	const SERVICE_CHECK_PASSIVE = 1; /**< the service check result was submitted by an external source */

	public $flapping_services = 0; /**< Number of flapping services */
	public $notification_disabled_services = 0; /**< Number of services with disabled notifications */
	public $event_handler_disabled_svcs = 0; /**< Number of services with disabled event handler */
	public $active_checks_disabled_svcs = 0; /**< Number of services with disabled active checks */
	public $passive_checks_disabled_svcs = 0; /**< Number of services with disabled passive checks */

	public $services_ok_disabled = 0; /**< Number of ok services with disabled active checks */
	public $services_ok_unacknowledged = 0; /**< FIXME: Number of ok services that are actively checked. The fuck? */
	public $services_ok = 0; /**< Number of ok services */

	public $services_warning_host_problem = 0; /**< Number of services in warning on problem hosts */
	public $services_warning_scheduled = 0; /**< Number of services in warning in scheduled downtime */
	public $services_warning_acknowledged = 0; /**< Number of services in warning that are acknowledged */
	public $services_warning_disabled = 0; /**< Number of services in warning with active checks disabled */
	public $svcs_warning_unacknowledged = 0; /**< Number of services in warning that are unacknowledged */
	public $services_warning = 0; /**< Number of services in warning */

	public $services_unknown_host_problem = 0; /**< Number of services in unknown on problem hosts */
	public $services_unknown_scheduled = 0; /**< Number of services in unknown in scheduled downtime */
	public $services_unknown_acknowledged = 0; /**< Number of services in unknown that are acknowledged */
	public $services_unknown_disabled = 0; /**< Number of services in unknown with active checks disabled */
	public $svcs_unknown_unacknowledged = 0; /**< Number of services in unknown that are unacknowledged */
	public $services_unknown = 0; /**< Number of services in unknown */

	public $services_critical_host_problem = 0; /**< Number of services in critical on problem hosts */
	public $services_critical_scheduled = 0; /**< Number of services in critical in scheduled downtime */
	public $services_critical_acknowledged = 0; /**< Number of services in critical that are acknowledged */
	public $services_critical_disabled = 0; /**< Number of services in critical with active checks disabled */
	public $svcs_critical_unacknowledged = 0; /**< Number of services in critical that are unacknowledged */
	public $services_critical = 0; /**< Number of services in critical */

	public $services_pending_disabled = 0; /**< Number of pending services with active checks disabled */
	public $services_pending = 0; /**< Number of pending services */

	public $total_service_health = 0; /**< Strange total health algorithm as copied from nagios */
	public $potential_service_health = 0; /**< Strange potential health algorithm as copied from nagios */

	public $total_active_service_checks = 0; /**< Number of services where last check was active */
	public $min_service_latency = -1.0; /**< Minimum service check latency */
	public $max_service_latency = -1.0; /**< Maximum service check latency */
	public $min_service_execution_time = -1.0; /**< Minimum service check execution time */
	public $max_service_execution_time = -1.0; /**< Maximum service check execution time */
	public $total_service_latency = 0; /**< Total service check latency */
	public $total_service_execution_time = 0; /**< Total service check execution time */
	public $total_passive_service_checks = 0; /**< Number of services where last check was passive */
	public $total_services = 0; /**< The total number of services */

	public $flap_disabled_hosts = 0; /**< Number of hosts with flap detection disabled */
	public $flap_disabled_services = 0; /**< Number of services with flap detection disabled */
	public $flapping_hosts = 0; /**< Number of flapping hosts */
	public $notification_disabled_hosts = 0; /**< Number of hosts with notification disabled */
	public $event_handler_disabled_hosts = 0; /**< Number of hosts with event handlers disabled */
	public $active_checks_disabled_hosts = 0; /**< Number of hosts with active checks disabled */
	public $passive_checks_disabled_hosts = 0; /**< Number of hosts with passive checks disabled */

	public $hosts_up_disabled = 0; /**< Number of hosts that are up with active checks disabled */
	public $hosts_up_unacknowledged = 0; /**< FIXME: Number of hosts that are up with active checks enabled. Makes no sense. */
	public $hosts_up = 0; /**< Number of hosts that are up */

	public $hosts_down_scheduled = 0; /**< Number of hosts that are down and in scheduled downtime */
	public $hosts_down_acknowledged = 0; /**< Number of hosts that are down and acknowledged */
	public $hosts_down_disabled = 0; /**< Number of hosts that are down and disabled */
	public $hosts_down_unacknowledged = 0; /**< Number of hosts that are down and unacknowledged */
	public $hosts_down = 0; /**< Number of hosts that are down */

	public $hosts_unreachable_scheduled = 0; /**< Number of hosts that are unreachable and in scheduled downtime */
	public $hosts_unreachable_acknowledged = 0; /**< Number of hosts that are unreachable and acknowledged */
	public $hosts_unreachable_disabled = 0; /**< Number of hosts that are unreachable and disabled */
	public $hosts_unreach_unacknowledged = 0; /**< Number of hosts that are unreachable and unacknowledged */
	public $hosts_unreachable = 0; /**< Number of hosts that are unreachable */

	public $hosts_pending_disabled = 0; /**< Number of pending hosts with active checks disabled */
	public $hosts_pending = 0; /**< Number of pending hosts */

	public $total_active_host_checks = 0; /**< Number of hosts where last check was active */

	public $min_host_latency = -1.0; /**< Minimum host check latency */
	public $max_host_latency = -1.0; /**< Maximum host check latency */
	public $min_host_execution_time = -1.0; /**< Minimum host check execution time */
	public $max_host_execution_time = -1.0; /**< Maximum host check execution time */

	public $total_host_latency = 0; /**< Total host check latency */
	public $total_host_execution_time = 0; /**< Total host check execution time */
	public $total_passive_host_checks = 0; /**< Number of hosts where last check was passive */

	public $total_hosts = 0; /**< Total number of hosts */

	# health
	public $percent_service_health = 0; /**< Percentage of total service health by potential service health */
	public $percent_host_health = 0; /**< Percentage of total host health by potential host health */

	public $average_service_latency = 0; /**< Average latency for service checks */
	public $average_host_latency = 0; /**< Average latency for host checks */
	public $average_service_execution_time = 0; /**< Average execution time for service checks */
	public $average_host_execution_time = 0; /**< Average execution time for host checks */

	public $total_blocking_outages = 0; /**< Number of blocking outages */
	public $total_nonblocking_outages = 0; /**< Number of nonblocking outages */
	public $affected_hosts = array(); /**< Number of hosts affected by outages */
	public $unreachable_hosts = array(); /**< hosts being unreachable because of network outages */
	public $affected_services = array(); /**< Number of services affected by outages */

	private $host_data_present = false;
	private $service_data_present = false;
	private $outage_data_present = false;

	private $base_path = '';
	private $auth = false;
	private static $instance = false;

	public function __construct()
	{
		parent::__construct();
		$this->base_path = Kohana::config('config.nagios_base_path');
		$this->auth = Nagios_auth_Model::instance();
	}

	/**
	 * Use this class as a singleton, as it is quite slow
	 *
	 * @return A Current_status_Model object
	 */
	public static function instance()
	{
		if (!self::$instance) {
			self::$instance = new Current_status_Model();
		}
		return self::$instance;
	}

	/**
	 * Fetch current host status from db for current user
	 * return bool
	 */
	public function host_status()
	{
		if ($this->host_data_present)
			return true;

		$show_passive_as_active = config::get('checks.show_passive_as_active', '*');
		if ($show_passive_as_active) {
			$active_checks_condition = "Stats: active_checks_enabled = 1\nStats: accept_passive_checks = 1\nStatsOr: 2";
			$disabled_checks_condition = "Stats: active_checks_enabled != 1\nStats: accept_passive_checks != 1\nStatsAnd: 2";
		} else {
			$active_checks_condition = "Stats: active_checks_enabled = 1";
			$disabled_checks_condition = "Stats: active_checks_enabled != 1";
		}

		try {
			$ls = Livestatus::instance();
			$cols = array(
				'total_hosts' => 'Stats: state != 9999', // "any", as recommended by ls docs
				'flap_disabled_hosts' => 'Stats: flap_detection_enabled != 1',
				'flapping_hosts' => 'Stats: is_flapping = 1',
				'notification_disabled_hosts' => 'Stats: notifications_enabled != 1',
				'event_handler_disabled_hosts' => 'Stats: event_handler_enabled != 1',
				'active_checks_disabled_hosts' => $disabled_checks_condition,
				'passive_checks_disabled_hosts' => 'Stats: accept_passive_checks != 1',
				'hosts_up_disabled' => "Stats: state = 0\n$disabled_checks_condition\nStatsAnd: 2",
				'hosts_up_unacknowledged' => "Stats: state = 0\nStats: acknowledged != 1\nStatsAnd: 2",
				'hosts_up' => 'Stats: state = 0',
				'hosts_down_scheduled' => "Stats: state = 1\nStats: scheduled_downtime_depth > 0\nStatsAnd: 2",
				'hosts_down_acknowledged' => "Stats: state = 1\nStats: acknowledged = 1\nStatsAnd: 2",
				'hosts_down_disabled' => "Stats: state = 1\n$disabled_checks_condition\nStatsAnd: 2",
				'hosts_down_unacknowledged' => "Stats: state = 1\nStats: scheduled_downtime_depth = 0\nStats: acknowledged != 1\n$active_checks_condition\nStatsAnd: 4",
				'hosts_down' => 'Stats: state = 1',
				'hosts_unreachable_scheduled' => "Stats: state = 2\nStats: scheduled_downtime_depth > 0\nStatsAnd: 2",
				'hosts_unreachable_acknowledged' => "Stats: state = 2\nStats: acknowledged = 1\nStatsAnd: 2",
				'hosts_unreachable_disabled' => "Stats: state = 2\n$disabled_checks_condition\nStatsAnd: 2",
				'hosts_unreach_unacknowledged' => "Stats: state = 2\nStats: scheduled_downtime_depth = 0\nStats: acknowledged != 1\n$active_checks_condition\nStatsAnd: 4",
				'hosts_unreachable' => "Stats: state = 2",
				'hosts_pending_disabled' => "Stats: has_been_checked = 0\n$disabled_checks_condition\nStatsAnd: 2",
				'hosts_pending' => 'Stats: has_been_checked = 0',
				'total_active_host_checks' => 'Stats: check_type = 0',
				'total_passive_host_checks' => 'Stats: check_type > 0',
				'min_host_latency' => 'Stats: min latency',
				'max_host_latency' => 'Stats: max latency',
				'total_host_latency' => 'Stats: sum latency',
				'avg_host_latency' => 'Stats: avg latency',
				'min_host_execution_time' => 'Stats: min execution_time',
				'max_host_execution_time' => 'Stats: max execution_time',
				'total_host_execution_time' => 'Stats: sum execution_time',
				'avg_host_execution_time' => 'Stats: avg execution_time',
			);
			$res = $ls->query("GET hosts\n".implode("\n", $cols));
		} catch (LivestatusException $ex) {
			return false;
		}

		$data = $res[0];
		reset($data);
		foreach ($cols as $col => $_) {
			$this->$col = current($data);
			next($data);
		}

		$all = $this->hosts_up + $this->hosts_down + $this->hosts_unreachable;
		if ($all == 0)
			$this->percent_host_health = 0.0;
		else
			$this->percent_host_health = number_format($this->hosts_up/$all*100, 1);

		$this->host_data_present = true;
		return true;
	}

	/**
	 * Fetch and calculate status for all services for current user
	 * @return bool
	 */
	public function service_status()
	{
		if ($this->service_data_present)
			return true;

		$show_passive_as_active = config::get('checks.show_passive_as_active', '*');
		if ($show_passive_as_active) {
			$active_checks_condition = "Stats: active_checks_enabled = 1\nStats: accept_passive_checks = 1\nStatsOr: 2";
			$disabled_checks_condition = "Stats: active_checks_enabled != 1\nStats: accept_passive_checks != 1\nStatsAnd: 2";
		} else {
			$active_checks_condition = "Stats: active_checks_enabled = 1";
			$disabled_checks_condition = "Stats: active_checks_enabled != 1";
		}

		try {
			$ls = Livestatus::instance();
			$cols = array(
				'total_services' => 'Stats: state != 9999', // "any", as recommended by ls docs
				'flap_disabled_services' => 'Stats: flap_detection_enabled != 1',
				'flapping_services' => 'Stats: is_flapping = 1',
				'notification_disabled_services' => 'Stats: notifications_enabled != 1',
				'event_handler_disabled_svcs' => 'Stats: event_handler_enabled != 1',
				'active_checks_disabled_svcs' => $disabled_checks_condition,
				'passive_checks_disabled_svcs' => 'Stats: accept_passive_checks != 1',
				'services_ok_disabled' => "Stats: state = 0\n$disabled_checks_condition\nStatsAnd: 2",
				'services_ok_unacknowledged' => "Stats: state = 0\nStats: acknowledged != 1\nStatsAnd: 2",
				'services_ok' => 'Stats: state = 0',
				'services_warning_host_problem' => "Stats: state = 1\nStats: host_state > 0\nStats: service_scheduled_downtime_depth = 0\nStats: host_scheduled_downtime_depth = 0\nStatsAnd: 4",
				'services_warning_scheduled' => "Stats: state = 1\nStats: scheduled_downtime_depth > 0\nStats: host_scheduled_downtime_depth > 0\nStatsOr: 2\nStatsAnd: 2",
				'services_warning_acknowledged' => "Stats: state = 1\nStats: acknowledged = 1\nStatsAnd: 2",
				'services_warning_disabled' => "Stats: state = 1\n$disabled_checks_condition\nStatsAnd: 2",
				'svcs_warning_unacknowledged' => "Stats: state = 1\nStats: host_state != 1\nStats: host_state != 2\nStats: scheduled_downtime_depth = 0\nStats: host_scheduled_downtime_depth = 0\nStats: acknowledged != 1\n$active_checks_condition\nStatsAnd: 7",
				'services_warning' => 'Stats: state = 1',
				'services_critical_host_problem' => "Stats: state = 2\nStats: host_state > 0\nStats: service_scheduled_downtime_depth = 0\nStats: host_scheduled_downtime_depth = 0\nStatsAnd: 4",
				'services_critical_scheduled' => "Stats: state = 2\nStats: scheduled_downtime_depth > 0\nStats: host_scheduled_downtime_depth > 0\nStatsOr: 2\nStatsAnd: 2",
				'services_critical_acknowledged' => "Stats: state = 2\nStats: acknowledged = 1\nStatsAnd: 2",
				'services_critical_disabled' => "Stats: state = 2\n$disabled_checks_condition\nStatsAnd: 2",
				'svcs_critical_unacknowledged' => "Stats: state = 2\nStats: host_state != 1\nStats: host_state != 2\nStats: scheduled_downtime_depth = 0\nStats: host_scheduled_downtime_depth = 0\nStats: acknowledged != 1\n$active_checks_condition\nStatsAnd: 7",
				'services_critical' => 'Stats: state = 2',
				'services_unknown_host_problem' => "Stats: state = 3\nStats: host_state > 0\nStats: service_scheduled_downtime_depth = 0\nStats: host_scheduled_downtime_depth = 0\nStatsAnd: 4",
				'services_unknown_scheduled' => "Stats: state = 3\nStats: scheduled_downtime_depth > 0\nStats: host_scheduled_downtime_depth > 0\nStatsOr: 2\nStatsAnd: 2",
				'services_unknown_acknowledged' => "Stats: state = 3\nStats: acknowledged = 1\nStatsAnd: 2",
				'services_unknown_disabled' => "Stats: state = 3\n$disabled_checks_condition\nStatsAnd: 2",
				'svcs_unknown_unacknowledged' => "Stats: state = 3\nStats: host_state != 1\nStats: host_state != 2\nStats: scheduled_downtime_depth = 0\nStats: host_scheduled_downtime_depth = 0\nStats: acknowledged != 1\n$active_checks_condition\nStatsAnd: 7",
				'services_unknown' => 'Stats: state = 3',
				'services_pending_disabled' => "Stats: has_been_checked = 0\n$disabled_checks_condition\nStatsAnd: 2",
				'services_pending' => 'Stats: has_been_checked = 0',
				'total_active_service_checks' => 'Stats: check_type = 0',
				'total_passive_service_checks' => 'Stats: check_type > 0',
				'min_service_latency' => 'Stats: min latency',
				'max_service_latency' => 'Stats: max latency',
				'sum_service_latency' => 'Stats: sum latency',
				'avg_service_latency' => 'Stats: avg latency',
				'min_service_execution_time' => 'Stats: min execution_time',
				'max_service_execution_time' => 'Stats: max execution_time',
				'sum_service_execution_time' => 'Stats: sum execution_time',
				'avg_service_execution_time' => 'Stats: avg execution_time',
			);
			$res = $ls->query("GET services\n".implode("\n", $cols));
		} catch (LivestatusException $ex) {
			return false;
		}

		$data = $res[0];
		reset($data);
		foreach ($cols as $col => $_) {
			$this->$col = current($data);
			next($data);
		}

		$all = $this->services_ok + $this->services_warning + $this->services_critical + $this->services_unknown;
		if ($all == 0)
			$this->percent_service_health = 0.0;
		else
			$this->percent_service_health = number_format($this->services_ok/$all*100, 1);

		$this->service_data_present = true;
		return true;
	}

	/**
	 * Analyze all status data for hosts and services
	 * Calls
	 * - host_status()
	 * - service_status()
	 * @return bool
	 */
	public function analyze_status_data()
	{
		$errors = false;
		if (!$this->host_status()) {
			$errors[] = 'Faled to fetch host_status';
		}

		if (!$this->service_status()) {
			$errors[] = 'Failed to fetch service_status';
		}
		return empty($errors) ? true : false;
	}

	/**
	 * 	determine what hosts are causing network outages
	 * 	and the severity for each one found
	 */
	public function find_hosts_causing_outages()
	{
		if ($this->outage_data_present)
			return true;
		try {
			$ls = Livestatus::instance();

			$result = $ls->query(<<<EOQ
GET hosts
Filter: state = 1
Columns: name services childs
EOQ
);

			foreach ($result as $res){
				$this->unreachable_hosts[$res[0]] = count($res[2]);
				$this->affected_hosts[$res[0]] = count($res[2]) + 1;
				$this->affected_services[$res[0]] = count($res[1]);
				# check if each host has any affected child hosts
				foreach ($res[2] as $sub) {
					if (!($children = $this->get_child_hosts($sub)))
						$this->total_nonblocking_outages++;
					else
						$this->total_blocking_outages++;
					$this->affected_hosts[$res[0]] += $children['hosts'];
					$this->unreachable_hosts[$res[0]] += $children['hosts'];
					$this->affected_services[$res[0]]+= $children['services'];
				}
			}
		} catch (LivestatusException $ex) {
			return false;
		}

		$this->outage_data_present = true;
		return true;
	}

	/**
	 * Fetch child hosts for a host
	 * @param $host_id Id of the host to fetch children for
	 * @return True on success, false on errors
	 */
	private function get_child_hosts($host_name=false)
	{
		$ls = Livestatus::instance();

		$result = $ls->query(<<<EOQ
GET hosts
Filter: name = $host_name
Columns: services childs
EOQ
);

		$children = 0;
		$children_services = 0;
		foreach ($result as $res) {
			$children_services += count($res[0]);
			foreach ($res[1] as $sub_host) {
				$children++;
				$out = $this->get_child_hosts($sub_host);
				$children += $out['hosts'];
				$children_services += $out['services'];
			}
		}
		return array('hosts' => $children, 'services' => $children_services);
	}

	/**
	 * Translates a given status from db to a readable string
	 */
	public static function status_text($db_status=false, $type='host')
	{
		$host_states = array(
			self::HOST_UP => 'UP',
			self::HOST_DOWN => 'DOWN',
			self::HOST_UNREACHABLE => 'UNREACHABLE',
			self::HOST_PENDING => 'PENDING'
		);

		$service_states = array(
			self::SERVICE_OK => 'OK',
			self::SERVICE_WARNING => 'WARNING',
			self::SERVICE_CRITICAL => 'CRITICAL',
			self::SERVICE_PENDING => 'PENDING',
			self::SERVICE_UNKNOWN => 'UNKNOWN'
		);

		$retval = false;
		switch ($type) {
			case 'host': case 'hostgroup':
				if (array_key_exists($db_status, $host_states)) {
					$retval = $host_states[$db_status];
				}
				break;
			case 'service': case 'servicegroup':
				if (array_key_exists($db_status, $service_states)) {
					$retval = $service_states[$db_status];
				}
				break;
		}
		return $retval;
	}

	/**
	 * List available states for host or service
	 *
	 * @param $what string 'host' (or 'service')
	 * @return array
	 */
	public function get_available_states($what='host')
	{
		switch($what) {
			case 'host':
				return array(
					self::HOST_UP => 'UP',
					self::HOST_DOWN => 'DOWN',
					self::HOST_UNREACHABLE => 'UNREACHABLE',
					self::HOST_PENDING => 'PENDING'
				);
			case 'service':
				return array(
					self::SERVICE_OK => 'OK',
					self::SERVICE_WARNING => 'WARNING',
					self::SERVICE_CRITICAL => 'CRITICAL',
					self::SERVICE_PENDING => 'PENDING',
					self::SERVICE_UNKNOWN => 'UNKNOWN'
				);
			default:
				return array();
		}
	}

	/**
	 * Fetch information regarding the various merlin nodes
	 * @param $host Unused
	 * @return Array with various info elements
	 */
	public function get_merlin_node_status($host=null)
	{
		$sql = false;
		$db = New Database();
		$cols = array('instance_name' => false, 'instance_id' => false,
				'is_running' => false, 'last_alive' => false);
		$sql = "SELECT " . implode(',', array_keys($cols)) . " FROM program_status ORDER BY instance_name";

		$result = $db->query($sql);
		$result_set = array();

		foreach ($result as $row) {
			$result_set[$row->instance_id]['instance_name'] = $row->instance_name;
			$result_set[$row->instance_id]['instance_id'] = $row->instance_id;
			$result_set[$row->instance_id]['is_running'] = $row->is_running;
			$result_set[$row->instance_id]['last_alive'] = $row->last_alive;
			$result_set[$row->instance_id]['host']['checks'] = Current_status_Model::get_merlin_num_checks("host", $row->instance_id);
			$result_set[$row->instance_id]['host']['latency'] = Current_status_Model::get_merlin_min_max_avg('host', 'latency' , $row->instance_id);
			$result_set[$row->instance_id]['host']['exectime'] = Current_status_Model::get_merlin_min_max_avg('host', 'execution_time' , $row->instance_id);
			$result_set[$row->instance_id]['service']['checks'] = Current_status_Model::get_merlin_num_checks("service", $row->instance_id);
			$result_set[$row->instance_id]['service']['latency'] = Current_status_Model::get_merlin_min_max_avg('service', 'latency' , $row->instance_id);
			$result_set[$row->instance_id]['service']['exectime'] = Current_status_Model::get_merlin_min_max_avg('service', 'execution_time' , $row->instance_id);

		}

		return $result_set;
	}

	/**
	 * Fetch the number of checks performed by a specific merlin node
	 *
	 * @param $table The table to use ('host' or 'service')
	 * @param $iid The instance id we want to check for
	 * @return Number of checks executed by the node with iid $iid
	 */
	public function get_merlin_num_checks($table, $iid=false)
	{
		$sql = false;
		$db = New Database();
		$sql = "SELECT COUNT(*) as total FROM $table";
		if ($iid !== false) {
			$sql.= " WHERE instance_id = $iid";
		}

		if (!empty($sql)){
			$result = $db->query($sql);
			foreach ($result as $row) {
				return (int)$row->total;
			}
		}
		return false;
	}

	/**
	 * Get min, average and max values from a random table
	 *
	 * @param $table Usually 'host' or 'service', though table will work
	 * @param $column The column to get values from. Must be numerical
	 * @param $iid instance_id of the Merlin node we're interested in
	 * @return A string in the format "min / avg / max"
	 */
	public function get_merlin_min_max_avg($table, $column, $iid=false)
	{
		$sql = false;
		$db = New Database();

		$sql = "SELECT min($column) as min, avg($column) as avg, max($column) as max FROM $table";
		if ($iid != false) {
			$sql.= " WHERE instance_id = $iid";
		}

		if (!empty($sql)) {
			$result = $db->query($sql);
			foreach ($result as $row) {
				return number_format($row->min, 3) . " / " . number_format($row->avg, 3) . " / " . number_format($row->max, 3);
			}
		}
		return false;
	}
}
