<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    '1', // bulk actions
    db_prefix() . 'tickets.ticketid',
    'subject',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'tickets.ticketid and rel_type="ticket" ORDER by tag_order ASC) as tags',
    /*** Start New code for add Comapny name */
    'CONCAT(' . db_prefix() . 'clients.company, \' \', ' . db_prefix() . 'clients.vat) as company_name',
    /*** End New code for add Comapny name */
    db_prefix() . 'departments.name as department_name',
    db_prefix() . 'services.name as service_name',
    'CONCAT(' . db_prefix() . 'contacts.firstname, \' \', ' . db_prefix() . 'contacts.lastname) as contact_full_name',
    'status',
    'priority',
    'lastreply',
    db_prefix() . 'tickets.date',
    /*** Start New code for add Meter number and channel Type */
  //  db_prefix() .'meter_number.number as meter_number',
    'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assign',
    db_prefix() .'tickets_channel_type.name as channel_type',
    /*** End New code for add Meter number and channel Type */
    ];
/*** Start New code Change conatct column number */
$contactColumn = 7;
/*** End New code Change conatct column number */
$tagsColumns   = 3;

$additionalSelect = [
    'adminread',
    db_prefix() . 'tickets.userid',
    'statuscolor',
    db_prefix() . 'tickets.name as ticket_opened_by_name',
    db_prefix() . 'tickets.email',
    db_prefix() . 'tickets.userid',
    'assigned',
    db_prefix() . 'clients.company',
    ];

$join = [
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'tickets.contactid',
    'LEFT JOIN ' . db_prefix() . 'services ON ' . db_prefix() . 'services.serviceid = ' . db_prefix() . 'tickets.service',
    'LEFT JOIN ' . db_prefix() . 'departments ON ' . db_prefix() . 'departments.departmentid = ' . db_prefix() . 'tickets.department',
    'LEFT JOIN ' . db_prefix() . 'tickets_status ON ' . db_prefix() . 'tickets_status.ticketstatusid = ' . db_prefix() . 'tickets.status',
    'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'tickets.assigned',
    /*** Start New code for add Comapny name */
    'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = IF(' . db_prefix() . 'tickets.company_id > 0 ,  '. db_prefix() . 'tickets.company_id,-1 ) ',
    /*** End New code for add Comapny name */
    'LEFT JOIN ' . db_prefix() . 'tickets_priorities ON ' . db_prefix() . 'tickets_priorities.priorityid = ' . db_prefix() . 'tickets.priority',
    /*** Start New code for add Meter number and channel Type */
    'LEFT JOIN ' . db_prefix() . 'meter_number ON ' . db_prefix() . 'meter_number.id = ' . db_prefix() . 'tickets.meter_number',
     'LEFT JOIN ' . db_prefix() . 'tickets_channel_type ON ' . db_prefix() . 'tickets_channel_type.id = ' . db_prefix() . 'tickets.channel_type_id',
    /*** End New code for add Meter number and channel Type */
    ];

$custom_fields = get_table_custom_fields('meter_number');
foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'tickets.ticketid = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where  = [];
$filter = [];
if ($this->ci->input->post('custome_date')) {
    array_push($where, 'AND tbltickets.date BETWEEN "' .date("Y-m-d", strtotime($this->ci->input->post('start_date'))) .'" AND "'.date("Y-m-d", strtotime($this->ci->input->post('end_date'))).'"'  );
}
elseif ($this->ci->input->post('ytd')) {
    array_push($where, 'AND YEAR(tbltickets.date) = YEAR(CURRENT_DATE())'  );
}
elseif ($this->ci->input->post('this_month')) {
    array_push($where, 'AND (MONTH(tbltickets.date) = MONTH(CURRENT_DATE())
                        AND YEAR(tbltickets.date) = YEAR(CURRENT_DATE()))'  );
}
elseif ($this->ci->input->post('this_week')) {
    array_push($where, 'AND YEARWEEK(tbltickets.date,1) = YEARWEEK(CURRENT_DATE(),1)');
}
elseif ($this->ci->input->post('today')) {
    array_push($where, 'AND DATE(tbltickets.date) = CURRENT_DATE()');
}
if (isset($userid) && $userid != '') {
    /*** Start New code for add ticket in End User If Ticket Created by without contact */
    if($userid == ENDUSER_ID){
        array_push($where, 'AND (' . db_prefix() . 'tickets.userid = ' . $userid.' OR ' . db_prefix() . 'tickets.userid = NULL OR ' . db_prefix() . 'tickets.userid = 0 )');
    }else{
        array_push($where, 'AND ' . db_prefix() . 'tickets.company_id = ' . $userid);
    }
    /*** End New code for add ticket in End User If Ticket Created by without contact */
} elseif (isset($by_email)) {
    array_push($where, 'AND ' . db_prefix() . 'tickets.email = "' . $by_email . '"');
}
if (isset($where_not_ticket_id)) {
    array_push($where, 'AND ' . db_prefix() . 'tickets.ticketid != ' . $where_not_ticket_id);
}
if ($this->ci->input->post('project_id')) {
    array_push($where, 'AND project_id = ' . $this->ci->input->post('project_id'));
}

$statuses  = $this->ci->tickets_model->get_ticket_status();
$_statuses = [];
foreach ($statuses as $__status) {
    if ($this->ci->input->post('ticket_status_' . $__status['ticketstatusid'])) {
        array_push($_statuses, $__status['ticketstatusid']);
    }
}
if (count($_statuses) > 0) {
    array_push($filter, 'AND status IN (' . implode(', ', $_statuses) . ')');
}

if ($this->ci->input->post('my_tickets')) {
    array_push($where, 'OR assigned = ' . get_staff_user_id());
}


$assignees  = $this->ci->tickets_model->get_tickets_assignes_disctinct();
$_assignees = [];
foreach ($assignees as $__assignee) {
    if ($this->ci->input->post('ticket_assignee_' . $__assignee['assigned'])) {
        array_push($_assignees, $__assignee['assigned']);
    }
}
if (count($_assignees) > 0) {
    array_push($filter, 'AND assigned IN (' . implode(', ', $_assignees) . ')');
}

if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}
// If userid is set, the the view is in client profile, should be shown all tickets
if (!is_admin()) {
    if (get_option('staff_access_only_assigned_departments') == 1) {
        $this->ci->load->model('departments_model');
        $staff_deparments_ids = $this->ci->departments_model->get_staff_departments(get_staff_user_id(), true);
        $departments_ids      = [];
        if (count($staff_deparments_ids) == 0) {
            $departments = $this->ci->departments_model->get();
            foreach ($departments as $department) {
                array_push($departments_ids, $department['departmentid']);
            }
        } else {
            $departments_ids = $staff_deparments_ids;
        }
        if (count($departments_ids) > 0) {
            array_push($where, 'AND department IN (SELECT departmentid FROM ' . db_prefix() . 'staff_departments WHERE departmentid IN (' . implode(',', $departments_ids) . ') AND staffid="' . get_staff_user_id() . '")');
        }
    }
}
if($_POST['overdue_lsit'] == 'true'){
    $where  = [];
        $data = ticket_ems_dashboard_summary_data_ticket();
        $overdue = array_column($data['overdue'], 'ticket_number');
        $overdue_today = array_column($data['overdue_today'], 'ticket_number');
        $data_id = implode(",",$overdue_today);
        $ids_string = '12,13,15';
        if($data_id != '' && $ids_string == ''){
            $ids_string .= $data_id;
        }elseif($data_id != ''){
            $ids_string .= ','.$data_id;
        }
        $ids = implode(",",$overdue);
        if($ids != '' && $ids_string == ''){
            $ids_string .= $ids;
        }elseif($ids != ''){
            $ids_string .= ','.$ids;
        }
       
        array_push($where, 'AND ticketid IN (' .$ids_string.')' );
        
        
    }
$sIndexColumn = 'ticketid';
$sTable       = db_prefix() . 'tickets';

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    for ($i = 0; $i < count($aColumns); $i++) {
        
            if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
                $_data = $aRow[strafter($aColumns[$i], 'as ')];
            } else {
                $_data = $aRow[$aColumns[$i]];
            }
        
        if ($aColumns[$i] == '1') {
            $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow[db_prefix() . 'tickets.ticketid'] . '"><label></label></div>';
        } elseif ($aColumns[$i] == 'lastreply') {
            if ($aRow[$aColumns[$i]] == null) {
                $_data = _l('ticket_no_reply_yet');
            } else {
                $_data = _dt($aRow[$aColumns[$i]]);
            }
        } elseif ($aColumns[$i] == 'subject' || $aColumns[$i] == db_prefix() . 'tickets.ticketid') {
            // Ticket is assigned
            if ($aRow['assigned'] != 0) {
                if ($aColumns[$i] != db_prefix() . 'tickets.ticketid') {
                    $_data .= '<a href="' . admin_url('profile/' . $aRow['assigned']) . '" data-toggle="tooltip" title="' . get_staff_full_name($aRow['assigned']) . '" class="pull-left mright5">' . staff_profile_image($aRow['assigned'], [
                        'staff-profile-image-xs',
                        ]) . '</a>';
                }
            }
            $url   = admin_url('tickets/ticket/' . $aRow[db_prefix() . 'tickets.ticketid']);
            $_data = '<a href="' . $url . '?tab=settings" class="valign">' . $_data . '</a>';
            if ($aColumns[$i] == 'subject') {
                $_data .= '<div class="row-options">';
                $_data .= '<a href="' . $url . '?tab=mail">' . _l('view') . '</a>';
                $_data .= ' <span class="text-dark"> | </span><a href="' . $url . '?tab=settings">' . _l('ticket_table_edit_btn') . '</a>';
                $_data .= ' <span class="text-dark"> | </span><a href="' . admin_url('tickets/delete/' . $aRow[db_prefix() . 'tickets.ticketid']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                $_data .= '</div>';
            }
        } elseif ($i == $tagsColumns) {
            $_data = render_tags($_data);
        } elseif ($i == $contactColumn) {
            if ($aRow['userid'] != 0) {
                $_data = '<a href="' . admin_url('clients/client/' . $aRow['userid'] . '?group=contacts') . '">' . $aRow['contact_full_name'];
                if (!empty($aRow['company'])) {
                    $_data .= ' (' . $aRow['company'] . ')';
                }
                $_data .= '</a>';
            } else {
                $_data = $aRow['ticket_opened_by_name'];
            }
        } elseif ($aColumns[$i] == 'status') {
            $_data = '<span class="label inline-block" style="border:1px solid ' . $aRow['statuscolor'] . '; color:' . $aRow['statuscolor'] . '">' . ticket_status_translate($aRow['status']) . '</span>';
        } elseif ($aColumns[$i] == db_prefix() . 'tickets.date') {
            $_data = _dt($_data);
        } elseif ($aColumns[$i] == 'priority') {
            $_data = ticket_priority_translate($aRow['priority']);
        } else {
            if (strpos($aColumns[$i], 'date_picker_') !== false) {
                $_data = (strpos($_data, ' ') !== false ? _dt($_data) : _d($_data));
            }
        }

        $row[] = $_data;

        if ($aRow['adminread'] == 0) {
            $row['DT_RowClass'] = 'text-danger';
        }
    }

    if (isset($row['DT_RowClass'])) {
        $row['DT_RowClass'] .= ' has-row-options';
    } else {
        $row['DT_RowClass'] = 'has-row-options';
    }

    $output['aaData'][] = $row;
}
