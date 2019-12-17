<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Render admin tickets table
 * @param string  $name        table name
 * @param boolean $bulk_action include checkboxes on the left side for bulk actions
 */
function AdminTicketsTableStructure($name = '', $bulk_action = false)
{
    $table = '<table class="table customizable-table dt-table-loading ' . ($name == '' ? 'tickets-table' : $name) . ' table-tickets" id="table-tickets" data-last-order-identifier="tickets" data-default-order="' . get_table_last_order('tickets') . '">';
    $table .= '<thead>';
    $table .= '<tr>';

    $table .= '<th class="' . ($bulk_action == true ? '' : 'not_visible') . '">';
    $table .= '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="tickets"><label></label></div>';
    $table .= '</th>';

    $table .= '<th class="toggleable" id="th-number">' . _l('the_number_sign') . '</th>';
    $table .= '<th class="toggleable" id="th-subject">' . _l('ticket_dt_subject') . '</th>';
    $table .= '<th class="toggleable" id="th-tags">' . _l('tags') . '</th>';
    $table .= '<th class="toggleable" id="th-company">' . _l('settings_general_company_name') . '</th>';
    $table .= '<th class="toggleable" id="th-department">' . _l('ticket_dt_department') . '</th>';
    $services_th_attrs = '';
    if (get_option('services') == 0) {
        $services_th_attrs = ' class="not_visible"';
    }
    $table .= '<th' . $services_th_attrs . '>' . _l('ticket_dt_service') . '</th>';
    $table .= '<th class="toggleable" id="th-submitter">' . _l('ticket_dt_submitter') . '</th>';
    $table .= '<th class="toggleable" id="th-status">' . _l('ticket_dt_status') . '</th>';
    $table .= '<th class="toggleable" id="th-priority">' . _l('ticket_dt_priority') . '</th>';
    $table .= '<th class="toggleable" id="th-last-reply">' . _l('ticket_dt_last_reply') . '</th>';
    $table .= '<th class="toggleable ticket_created_column" id="th-created">' . _l('ticket_date_created') . '</th>';
    /*** Start New Code Add New two filed in datatable */
    $table .= '<th class="toggleable " id="th-assigned">' . _l('ticket_summary_assigned') . '</th>';
    $table .= '<th class="toggleable " id="th-channel-type">' . _l('ticket_drp_channel_type') . '</th>';
    /*** End New Code Add New two filed in datatable */
    $custom_fields = get_table_custom_fields('meter_number');

    foreach ($custom_fields as $field) {
        $table .= '<th>' . $field['name'] . '</th>';
    }
    

    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody></tbody>';
    $table .= '</table>';

    $table .= '<script id="hidden-columns-table-tickets" type="text/json">';
    $table .= get_staff_meta(get_staff_user_id(), 'hidden-columns-table-tickets');
    $table .= '</script>';

    return $table;
}
/*** Start New Code Add New Fuction For Meter number datatabel */
function AdminMeterNumberStructure($name = '', $bulk_action = false)
{
    $table = '<table class="table customizable-table dt-table-loading ' . ($name == '' ? 'meter_number-table' : $name) . ' table-meter_number" id="table-meter_number" data-last-order-identifier="meter_number" data-default-order="' . get_table_last_order('tickets') . '">';
    $table .= '<thead>';
    $table .= '<tr>';

    $table .= '<th class="' . ($bulk_action == true ? '' : 'not_visible') . '">';
    $table .= '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="meter_number"><label></label></div>';
    $table .= '</th>';

    $table .= '<th class="toggleable" id="th-number">' . _l('meter_section_number') . '</th>';
    $table .= '<th class="toggleable" id="th-type">' . _l('meter_section_type') . '</th>';
    $table .= '<th class="toggleable" id="th-machine_id">' . _l('meter_section_machine') . '</th>';
    $table .= '<th class="toggleable" id="th-building_type">' . _l('meter_section_building_type') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_accessible">' . _l('meter_section_meter_accessible') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_location">' . _l('meter_section_meter_location') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_serial_number">' . _l('meter_section_meter_serial_number') . '</th>';
    $table .= '<th class="toggleable" id="th-seals_on_arrival">' . _l('meter_section_seals_on_arrival') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_type">' . _l('meter_section_meter_type') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_manufacturer">' . _l('meter_section_meter_manufacturer') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_reading">' . _l('meter_section_meter_reading') . '</th>';
    $table .= '<th class="toggleable" id="th-phase">' . _l('meter_section_phase') . '</th>';
    $table .= '<th class="toggleable" id="th-trip_test_done">' . _l('meter_section_trip_test_done') . '</th>';
    $table .= '<th class="toggleable" id="th-trip_test_results">' . _l('meter_section_trip_test_results') . '</th>';
    $table .= '<th class="toggleable" id="th-meter_condition">' . _l('meter_section_meter_condition') . '</th>';
    $table .= '<th class="toggleable" id="th-other_illegal_connection">' . _l('meter_section_other_illegal_connection') . '</th>';
    $table .= '<th class="toggleable" id="th-sgc_number">' . _l('meter_section_sgc_number') . '</th>';
    $table .= '<th class="toggleable" id="th-new_seals_fitted">' . _l('meter_section_new_seals_fitted') . '</th>';
    $table .= '<th class="toggleable" id="th-new_seal_numbers">' . _l('meter_section_new_seal_numbers') . '</th>';
    $table .= '<th class="toggleable" id="th-time_stamp ">' . _l('meter_section_time_stamp ') . '</th>';
    
    
    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody></tbody>';
    $table .= '</table>';

    $table .= '<script id="hidden-columns-table-tickets" type="text/json">';
    //$table .= get_staff_meta(get_staff_user_id(), 'hidden-columns-table-tickets');
    $table .= '</script>';

    return $table;
}
/*** End New Code Add New Fuction For Meter number datatabel */

/**
 * Function to translate ticket status
 * The app offers ability to translate ticket status no matter if they are stored in database
 * @param  mixed $id
 * @return string
 */
function ticket_status_translate($id)
{
    if ($id == '' || is_null($id)) {
        return '';
    }

    $line = _l('ticket_status_db_' . $id, '', false);

    if ($line == 'db_translate_not_found') {
        $CI = & get_instance();
        $CI->db->where('ticketstatusid', $id);
        $status = $CI->db->get(db_prefix() . 'tickets_status')->row();

        return !$status ? '' : $status->name;
    }

    return $line;
}

/**
 * Function to translate ticket priority
 * The apps offers ability to translate ticket priority no matter if they are stored in database
 * @param  mixed $id
 * @return string
 */
function ticket_priority_translate($id)
{
    if ($id == '' || is_null($id)) {
        return '';
    }

    $line = _l('ticket_priority_db_' . $id, '', false);

    if ($line == 'db_translate_not_found') {
        $CI = & get_instance();
        $CI->db->where('priorityid', $id);
        $priority = $CI->db->get(db_prefix() . 'tickets_priorities')->row();

        return !$priority ? '' : $priority->name;
    }

    return $line;
}

/**
 * When ticket will be opened automatically set to open
 * @param integer  $current Current status
 * @param integer  $id      ticketid
 * @param boolean $admin   Admin opened or client opened
 */
function set_ticket_open($current, $id, $admin = true)
{
    if ($current == 1) {
        return;
    }

    $field = ($admin == false ? 'clientread' : 'adminread');

    $CI = & get_instance();
    $CI->db->where('ticketid', $id);

    $CI->db->update(db_prefix() . 'tickets', [
        $field => 1,
    ]);
}

/**
 * Check whether to show ticket submitter on clients area table based on applied settings and contact
 * @since  2.3.2
 * @return boolean
 */
function show_ticket_submitter_on_clients_area_table()
{
    $show_submitter_on_table = true;
    if (!can_logged_in_contact_view_all_tickets()) {
        $show_submitter_on_table = false;
    }

    return hooks()->apply_filters('show_ticket_submitter_on_clients_area_table', $show_submitter_on_table);
}

/**
 * Check whether the logged in contact can view all tickets in customers area
 * @since  2.3.2
 * @return boolean
 */
function can_logged_in_contact_view_all_tickets()
{
    return !(!is_primary_contact() && get_option('only_show_contact_tickets') == 1);
}

/**
 * Get clients area ticket summary statuses data
 * @since  2.3.2
 * @param  array $statuses  current statuses
 * @return array
 */
function get_clients_area_tickets_summary($statuses)
{
    foreach ($statuses as $key => $status) {
        $where = ['userid' => get_client_user_id(), 'status' => $status['ticketstatusid']];
        if (!can_logged_in_contact_view_all_tickets()) {
            $where[db_prefix() . 'tickets.contactid'] = get_contact_user_id();
        }
        $statuses[$key]['total_tickets']   = total_rows(db_prefix() . 'tickets', $where);
        $statuses[$key]['translated_name'] = ticket_status_translate($status['ticketstatusid']);
        $statuses[$key]['url']             = site_url('clients/tickets/' . $status['ticketstatusid']);
    }

    return hooks()->apply_filters('clients_area_tickets_summary', $statuses);
}

/**
 * Check whether contact can change the ticket status (single ticket) in clients area
 * @since  2.3.2
 * @param  mixed $status  the status id, if not passed, will first check from settings
 * @return boolean
 */
function can_change_ticket_status_in_clients_area($status = null)
{
    $option = get_option('allow_customer_to_change_ticket_status');

    if (is_null($status)) {
        return $option == 1;
    }

    /*
    *   For all cases check the option too again, because if the option is set to No, no status changes on any status is allowed
     */
    if ($option == 0) {
        return false;
    }

    $forbidden = hooks()->apply_filters('forbidden_ticket_statuses_to_change_in_clients_area', [3, 4]);

    if (in_array($status, $forbidden)) {
        return false;
    }

    return true;
}
/*** Start New Code Add New Fuction For Ems Dashboard Summary Data */
function ticket_ems_dashboard_summary_data($customer_id = null, $group_id = null,$departments_id = null,$province = null) {
    $CI = &get_instance();
    $CI->load->model('tickets_model');
    $tasks_summary = [];
    $statuses = $CI->tickets_model->get_ems_dashboard_status();
    
    foreach ($statuses as $status) {
        $where = '';
        $join ='';
            if($customer_id != ''){
                $where .= ' AND tbltickets.company_id ='.$customer_id.'';
                $ticket_where['company_id'] = $customer_id;
            }
            if($group_id != ''){
               $where .= ' AND tbltickets.group_id ='.$group_id.''; 
               $ticket_where['group_id'] = $group_id;
            }
            if($departments_id != ''){
               $where .= ' AND tbltickets.department ='.$departments_id.''; 
               $ticket_where['department'] = $departments_id;
            }
            if($province != ''){
                $join .= 'LEFT JOIN tblclients ON tblclients.userid = tbltickets.company_id ';
                        
               $where .= ' AND tblclients.state ="'.$province.'"'; 
               //$ticket_where['department'] = $departments_id;
            }
        $ticket_where = [];
//         if ($status['id'] == 1) {
//            $ticket_where['status'] = 5;
//        } else
       
        if($customer_id != ''){
         //   $ticket_where['company_id'] = $customer_id;
        }
        
        $summary = [];
        $ticket_where_new=array();
        if($status['id'] == 3){
//            if($customer_id != ''){
                $summary_result =  $CI->db->query('SELECT 
                                            tbltickets.ticketid as ticket_number
                                            FROM tbltickets 
                                            '.$join.'
                                                WHERE tbltickets.status NOT IN (5,0) 
                                                '.$where.'
                                            ');
                
                $summary_data = $summary_result->num_rows();
                //$summary['total_tasks'] = total_rows(db_prefix() . 'tickets', 'status NOT IN (5,0) '.$where );
                $summary['total_tasks'] = $summary_data;
                
//            }else{
//                $summary['total_tasks'] = total_rows(db_prefix() . 'tickets', 'status NOT IN (5,0)');
//            }
        }elseif($status['id'] == 4){
//            if($customer_id != ''){
                $summary_result =  $CI->db->query('SELECT 
                                            tbltickets.ticketid as ticket_number
                                            FROM tbltickets 
                                            '.$join.'
                                                WHERE tbltickets.status NOT IN (5,0)  AND assigned > 0
                                                '.$where.'
                                            ');
                
                $summary_data = $summary_result->num_rows();
                $summary['total_tasks'] = $summary_data;
                //$summary['total_tasks'] = total_rows(db_prefix() . 'tickets', 'status NOT IN (5,0) AND assigned > 0  '.$where);
                
//            }else{
//                $summary['total_tasks'] = total_rows(db_prefix() . 'tickets', 'status NOT IN (5,0) AND assigned > 0');
//            }
        }elseif($status['id'] == 1){
            $CI = & get_instance();
            
                $summary_result =  $CI->db->query('SELECT 
                                            tbltickets.ticketid as ticket_number, 
                                            tbltickets.priority as priority, 
                                            CASE priority
                                              WHEN 1 THEN tblsla_manager_setting.low_resolution
                                              WHEN 2 THEN tblsla_manager_setting.medium_resolution
                                              WHEN 3 THEN tblsla_manager_setting.high_resolution
                                              ELSE 48
                                              END as expose,
                                            TIME_TO_SEC(TIMEDIFF((now()),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours 

                                             FROM tbltickets 
                                             LEFT JOIN tblstaff ON tblstaff.staffid = tbltickets.assigned 
                                             LEFT JOIN tblsla_manager_setting ON tblsla_manager_setting.client_id = tbltickets.assigned
                                             '.$join.'
                                             WHERE tbltickets.status = 1 
                                             '.$where.'
                                             GROUP BY tbltickets.ticketid
                                             HAVING resolve_hours>expose
                                             ORDER BY tbltickets.ticketid
                                             ');
            
                $summary_data = $summary_result->num_rows();
            
            $summary['total_tasks'] = $summary_data;
            
        }elseif($status['id'] == 2){
            $CI = & get_instance();
            
                $summary_result =  $CI->db->query('SELECT 
                                    tbltickets.ticketid as ticket_number, 
                                    tbltickets.priority as priority, 
                                    CASE priority
                                      WHEN 1 THEN tblsla_manager_setting.low_resolution
                                      WHEN 2 THEN tblsla_manager_setting.medium_resolution
                                      WHEN 3 THEN tblsla_manager_setting.high_resolution
                                      ELSE 48
                                      END as expose,
                                      tbltickets_activity_log.date as activity_date
                                     FROM tbltickets 
                                     LEFT JOIN tblstaff ON tblstaff.staffid = tbltickets.assigned 
                                     LEFT JOIN tblsla_manager_setting ON tblsla_manager_setting.client_id = tbltickets.assigned
                                     LEFT JOIN tbltickets_activity_log ON tbltickets_activity_log.ticket_id = tbltickets.ticketid AND tbltickets_activity_log.status_id = 1
                                     '.$join.'
                                     WHERE tbltickets.status = 1 
                                     '.$where.'
                                     GROUP BY tbltickets.ticketid
                                     HAVING DATE_FORMAT(DATE_ADD(activity_date, INTERVAL +expose HOUR), "%Y-%m-%d") = CURDATE()
                                     ORDER BY tbltickets.ticketid');
                
                $summary_data = $summary_result->num_rows();
                    
            $summary['total_tasks'] = $summary_data;
            
        }elseif ($status['id'] == 5) {
            
                $summary_result =  $CI->db->query('SELECT 
                                            tbltickets.ticketid as ticket_number
                                            FROM tbltickets 
                                            '.$join.'
                                                WHERE tbltickets.status NOT IN (5,0) AND tbltickets.assigned = 0
                                                '.$where.'
                                            ');
                
                $summary_data = $summary_result->num_rows();
                $summary['total_tasks'] = $summary_data;
           // $ticket_where['assigned'] = 0;
           // $summary['total_tasks'] = total_rows(db_prefix() . 'tickets', ' assigned = 0  '.$where);
        }
//        else{
//        $summary['total_tasks'] = total_rows(db_prefix() . 'tickets', $ticket_where);
//        }
        //$summary['total_my_tasks'] = total_rows(db_prefix() . 'stock', $tasks_my_where);
        $summary['color'] = $status['color'];
        $summary['name'] = $status['name'];
        $summary['status_id'] = $status['id'];
        $tasks_summary[] = $summary;
    }
   
    return $tasks_summary;
}
/*** End New Code Add New Fuction For Ems Dashboard Summary Data */
/*** New Code For Overdue ticket count for EMS dashboard */
function overdue_tickets_details($customer_id = null, $group_id = null,$departments_id = null,$province = null){
        $CI = &get_instance();
        $CI->load->model('clients_model');
        $statuses =  $CI->clients_model->get_groups();
        
        $b = array(array('id'=>'null', "name"=> "Unassigned"));
        $statuses = array_merge($statuses, $b); 
        
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d');
        
        /*** Start New Code For find OverDue Today */
        foreach ($statuses as $key=>$value){
            $where = '';
            $join ='';
            if($customer_id != ''){
                $where .= ' AND tbltickets.company_id ='.$customer_id.'';
             
            }
            if($group_id){
               $where .= ' AND tbltickets.group_id ='.$group_id.''; 
             
            }
            if($departments_id){
               $where .= ' AND tbltickets.department ='.$departments_id.''; 
             
            }
            if($province != ''){
                $join .= 'LEFT JOIN tblclients ON tblclients.userid = tbltickets.company_id ';
                        
               $where .= ' AND tblclients.state ="'.$province.'"'; 
               //$ticket_where['department'] = $departments_id;
            }
            if ($value['id'] != 'null') {
            $summary_result = $CI->db->query('SELECT 
                                            tbltickets.ticketid as ticket_number, 
                                            tbltickets.priority as priority, 
                                            CASE priority
                                              WHEN 1 THEN tblsla_manager_setting.low_resolution
                                              WHEN 2 THEN tblsla_manager_setting.medium_resolution
                                              WHEN 3 THEN tblsla_manager_setting.high_resolution
                                              ELSE 48
                                              END as expose,
                                            TIME_TO_SEC(TIMEDIFF((now()),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours 

                                             FROM tbltickets 
                                             LEFT JOIN tblstaff ON tblstaff.staffid = tbltickets.assigned 
                                             LEFT JOIN tblsla_manager_setting ON tblsla_manager_setting.client_id = tbltickets.assigned
                                             ' . $join . '
                                             WHERE tbltickets.status = 1 AND tbltickets.group_id = ' . $value['id'] . '
                                                 ' . $where . ' 
                                             GROUP BY tbltickets.ticketid
                                             HAVING resolve_hours>expose
                                             ORDER BY tbltickets.ticketid');
        }else{
            $summary_result = $CI->db->query('SELECT 
                                            tbltickets.ticketid as ticket_number, 
                                            tbltickets.priority as priority, 
                                            CASE priority
                                              WHEN 1 THEN tblsla_manager_setting.low_resolution
                                              WHEN 2 THEN tblsla_manager_setting.medium_resolution
                                              WHEN 3 THEN tblsla_manager_setting.high_resolution
                                              ELSE 48
                                              END as expose,
                                            TIME_TO_SEC(TIMEDIFF((now()),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours 

                                             FROM tbltickets 
                                             LEFT JOIN tblstaff ON tblstaff.staffid = tbltickets.assigned 
                                             LEFT JOIN tblsla_manager_setting ON tblsla_manager_setting.client_id = tbltickets.assigned
                                             ' . $join . '
                                             WHERE tbltickets.status = 1 AND tbltickets.group_id IS NULL
                                                 ' . $where . ' 
                                             GROUP BY tbltickets.ticketid
                                             HAVING resolve_hours>expose
                                             ORDER BY tbltickets.ticketid');
            
        }
        
            $q = $summary_result->num_rows();
            if ($value['id'] != 'null') {
            $summary_result_today =  $CI->db->query('SELECT 
                                    tbltickets.ticketid as ticket_number, 
                                    tbltickets.priority as priority, 
                                    CASE priority
                                      WHEN 1 THEN tblsla_manager_setting.low_resolution
                                      WHEN 2 THEN tblsla_manager_setting.medium_resolution
                                      WHEN 3 THEN tblsla_manager_setting.high_resolution
                                      ELSE 48
                                      END as expose,
                                      tbltickets_activity_log.date as activity_date
                                     FROM tbltickets 
                                     LEFT JOIN tblstaff ON tblstaff.staffid = tbltickets.assigned 
                                     LEFT JOIN tblsla_manager_setting ON tblsla_manager_setting.client_id = tbltickets.assigned
                                     LEFT JOIN tbltickets_activity_log ON tbltickets_activity_log.ticket_id = tbltickets.ticketid AND tbltickets_activity_log.status_id = 1
                                     '.$join.'
                                     WHERE tbltickets.status = 1 AND tbltickets.group_id = '.$value['id'].'
                                    '.$where.' 
                                    GROUP BY tbltickets.ticketid
                                     HAVING DATE_FORMAT(DATE_ADD(activity_date, INTERVAL +expose HOUR), "%Y-%m-%d") = CURDATE()
                                     ORDER BY tbltickets.ticketid');
            }else{
                $summary_result_today =  $CI->db->query('SELECT 
                                    tbltickets.ticketid as ticket_number, 
                                    tbltickets.priority as priority, 
                                    CASE priority
                                      WHEN 1 THEN tblsla_manager_setting.low_resolution
                                      WHEN 2 THEN tblsla_manager_setting.medium_resolution
                                      WHEN 3 THEN tblsla_manager_setting.high_resolution
                                      ELSE 48
                                      END as expose,
                                      tbltickets_activity_log.date as activity_date
                                     FROM tbltickets 
                                     LEFT JOIN tblstaff ON tblstaff.staffid = tbltickets.assigned 
                                     LEFT JOIN tblsla_manager_setting ON tblsla_manager_setting.client_id = tbltickets.assigned
                                     LEFT JOIN tbltickets_activity_log ON tbltickets_activity_log.ticket_id = tbltickets.ticketid AND tbltickets_activity_log.status_id = 1
                                     '.$join.'
                                     WHERE tbltickets.status = 1 AND tbltickets.group_id IS NULL
                                    '.$where.' 
                                    GROUP BY tbltickets.ticketid
                                     HAVING DATE_FORMAT(DATE_ADD(activity_date, INTERVAL +expose HOUR), "%Y-%m-%d") = CURDATE()
                                     ORDER BY tbltickets.ticketid');
            }
            $q_today = $summary_result_today->num_rows();
            
            
            $CI->db->select('COUNT(ticketid) as Overdue');
            $CI->db->from(db_prefix() . 'tickets');
            $CI->db->where('status',5);
            $CI->db->where('group_id',$value['id']);
            if($customer_id != ''){
                $CI->db->where('company_id',$customer_id);
            }
            $Overdue = $CI->db->get()->row();
            
            $summary['name'] = $value['name'];
            $summary['Overdue_today'] = $q_today;
            $summary['Overdue'] = $q;
            $tasks_summary[] = $summary;
        }
        /*** End New Code For find OverDue Today */
       return $tasks_summary;
    }
/*** End New Code For Overdue ticket count for EMS dashboard */    
    
/*** New Code Service Level EMS dashboard */
function get_service_level_details($customer_id = null, $group_id = null,$departments_id = null,$province = null){
    
    $CI = &get_instance();
    $CI->load->model('tickets_model');
    $tasks_summary = [];
    $statuses = $CI->tickets_model->get_priority();
    
    foreach ($statuses as $status) {
        
        $where = '';
        $join = '';
            if($customer_id != ''){
                $where .= ' AND tbltickets.company_id ='.$customer_id.'';
                $ticket_where['company_id'] = $customer_id;
            }
            if($group_id){
               $where .= ' AND tbltickets.group_id ='.$group_id.''; 
               $ticket_where['group_id'] = $group_id;
            }
            if($departments_id){
               $where .= ' AND tbltickets.department ='.$departments_id.''; 
               $ticket_where['department'] = $departments_id;
            }
            if($province != ''){
                $join .= 'LEFT JOIN tblclients ON tblclients.userid = tbltickets.company_id ';
                $where .= ' AND tblclients.state ="'.$province.'"'; 
               
            }
                $summary_result = $CI->db->query('SELECT 
                                                    tbltickets.ticketid as ticket_number,
                                                    tbltickets.priority as priority,
                                                    tbltickets.company_id as company_id,
                                                    TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours,
                                                    TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours
                                                    FROM tbltickets
                                                    '.$join.'
                                                    where tbltickets.status != 1 AND tbltickets.priority = '.$status['priorityid'].' '.$where.'
                                                    GROUP BY tbltickets.ticketid
                                                    ORDER BY tbltickets.ticketid');
                
                $summary_data = $summary_result->result();
                $CI->load->helper('ems_report_helper');
                $response_hours_array =array();
                $resolve_hours_array = array();
                if(!empty($summary_data)){
                    foreach ($summary_data as $data_value){
                        
                        $hold_time = get_on_hold_time($data_value->ticket_number);
                        if($hold_time == ''){
                            $hold_time = 0;
                        }
                        $response_hours_array[] = round(get_response_percentage($data_value->company_id,$data_value->priority,'response',$data_value->response_hours),2); 
                        
                        $resolve_hours_array[] = round(get_response_percentage($data_value->company_id,$data_value->priority,'resolution',($data_value->resolve_hours - $hold_time)),2); 
                    }
                }
                
                $count_data = count($summary_data);
               // $resolve_hours = array_sum(array_column($summary_data,'resolve_hours'));
                //$response_hours = array_sum(array_column($summary_data,'response_hours'));
//              
                
                $resolve_hours = !empty($resolve_hours_array) ? array_sum($resolve_hours_array) : 0;
                $response_hours = !empty($response_hours_array) ? array_sum($response_hours_array) : 0;
            $summary['priority'] = $status['priorityid'];
            $summary['count_data'] = $count_data;
            $summary['resolve_hours'] = $resolve_hours;
            $summary['response_hours'] = $response_hours;
            
            $tasks_summary[] = $summary;
        
    }
    
    return $tasks_summary;

}
  /*** End New Code Service Level EMS dashboard */

/**** New code for ind ticket details for user **/
function  get_user_ticket_details($customer_id = null){
    if($customer_id != ''){
        
       $CI = &get_instance();
       $CI->db->select('COUNT(t.ticketid) as ticket_count,ts.name,ts.ticketstatusid');
            $CI->db->from(db_prefix() . 'tickets_status as ts');
            $CI->db->join(db_prefix() . 'tickets as t', 'ts.ticketstatusid = t.status AND t.company_id = "'.$customer_id.'"', 'left');
            $CI->db->group_by('ts.ticketstatusid');
            $CI->db->order_by("ts.statusorder", "asc");
            return $CI->db->get()->result();
        
    }
}
/**
 * For html5 form accepted attributes
 * This function is used for the tickets form attachments
 * @return string
 */
function get_ticket_form_accepted_mimes()
{
    $ticket_allowed_extensions  = get_option('ticket_attachments_file_extensions');
    $_ticket_allowed_extensions = explode(',', $ticket_allowed_extensions);
    $all_form_ext               = $ticket_allowed_extensions;

    if (is_array($_ticket_allowed_extensions)) {
        foreach ($_ticket_allowed_extensions as $ext) {
            $all_form_ext .= ',' . get_mime_by_extension($ext);
        }
    }

    return $all_form_ext;
}

function ticket_message_save_as_predefined_reply_javascript()
{
    if (!is_admin() && get_option('staff_members_save_tickets_predefined_replies') == '0') {
        return false;
    } ?>
    <div class="modal fade" id="savePredefinedReplyFromMessageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo _l('predefined_replies_dt_name'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo render_input('name', 'predefined_reply_add_edit_name'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="button" class="btn btn-info" id="saveTicketMessagePredefinedReply"><?php echo _l('submit'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <script>
        $(function(){
            var editorMessage = tinymce.get('message');
            if(typeof(editorMessage) != 'undefined') {
                editorMessage.on('change',function(){
                    if(editorMessage.getContent().trim() != '') {
                        if($('#savePredefinedReplyFromMessage').length == 0){
                            $('[app-field-wrapper="message"] [role="menubar"] .mce-container-body:first').append("<a id=\"savePredefinedReplyFromMessage\" data-toggle=\"modal\" data-target=\"#savePredefinedReplyFromMessageModal\" class=\"save_predefined_reply_from_message pointer\" href=\"#\"><?php echo _l('save_message_as_predefined_reply'); ?></a>");
                            }
                            // For open is handled on contact select
                            if($('#single-ticket-form').length > 0) {
                                var contactIDSelect = $('#contactid');
                                if(contactIDSelect.data('no-contact') == undefined && contactIDSelect.data('ticket-emails') == '0') {
                                   show_ticket_no_contact_email_warning($('input[name="userid"]').val(), contactIDSelect.val());
                                } else {
                                   clear_ticket_no_contact_email_warning();
                                }
                            }
                    } else {
                        $('#savePredefinedReplyFromMessage').remove();
                        clear_ticket_no_contact_email_warning();
                    }
                });
            }
            $('body').on('click','#saveTicketMessagePredefinedReply',function(e){
                e.preventDefault();
                var data = {}
                data.message = editorMessage.getContent();
                data.name = $('#savePredefinedReplyFromMessageModal #name').val();
                data.ticket_area = true;
                $.post(admin_url+'tickets/predefined_reply',data).done(function(response){
                    response = JSON.parse(response);
                    if(response.success == true) {
                        var predefined_reply_select = $('#insert_predefined_reply');
                        predefined_reply_select.find('option:first').after('<option value="'+response.id+'">'+data.name+'</option>');
                        predefined_reply_select.selectpicker('refresh');
                    }
                    $('#savePredefinedReplyFromMessageModal').modal('hide');
                });
            });
        });
    </script>
    <?php
}
