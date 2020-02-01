<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    ];

$data_table_array = get_ems_table_records();
$table_field_list = $data_table_array[$table_name];

foreach ($table_field_list as $key=>$value){
    if($value['field'] != ''){
        array_push($aColumns,$value['field']); 
    }else{
        array_push($aColumns,'2'); 
    }
   
}

if($table_name == 'network'|| $table_name == 'unassigned_companies' || $table_name == 'trafic_road_safety' || $table_name == 'paycity'){
    $assigned_name = 20;
    $onhold = 18;
    $close_date = 17;
    
}elseif($table_name == 'paycitySLA' || $table_name == 'trafic_road_safetySLA' || $table_name == 'networkSLA' || $table_name == 'full_reportSLA'){
    $assigned_name = 16;
        $onhold = 17;
        $close_date = 16;
}elseif($table_name == 'full_report'){
    $assigned_name = 21;
    $onhold = 18;
    $close_date = 17;
}
if($table_name == 'network'|| $table_name == 'unassigned_companies' || $table_name == 'trafic_road_safety' || $table_name == 'paycity'){
    $response_hours = 7;
    $resolve_hours = 8;    
    $response_hours_cell = 21;
    $resolve_hours_cell = 22;
}elseif ($table_name == 'full_report') {
    $response_hours = 7;
    $resolve_hours = 8;
    $response_hours_cell = 22;
    $resolve_hours_cell = 23;
}elseif ($table_name == 'paycitySLA' || $table_name == 'trafic_road_safetySLA' || $table_name == 'networkSLA') {
    $response_hours = 7;
    $resolve_hours = 8; 
    $response_hours_cell = 19;
    $resolve_hours_cell = 20;
}elseif ($table_name == 'full_reportSLA') {
    $response_hours = 7;
    $resolve_hours = 8;    
        $response_hours_cell = 19;
    $resolve_hours_cell = 20;
}
$parent_Category_col_number = 3;
    $sub_parent_Category_col_number = 13;
if($table_name == 'paycitySLA' || $table_name == 'trafic_road_safetySLA' || $table_name == 'networkSLA' || $table_name == 'full_reportSLA'){
    $parent_Category_col_number = 3;
    $sub_parent_Category_col_number = 12;
}
$department_id=[];
if($table_name == 'network' || $table_name == 'networkSLA'){
    array_push($department_id,NETWORKS); 
    
}elseif($table_name == 'trafic_road_safety' || $table_name == 'trafic_road_safetySLA'){
    array_push($department_id,TRAFFIC); 
    array_push($department_id,ROADSAFETY); 
}elseif($table_name == 'paycity' || $table_name == 'paycitySLA'){
    array_push($department_id,PAYCITY); 
}elseif ($table_name == 'unassigned_companies') {
    if(isset($network)){
       array_push($department_id,NETWORKS); 
    }
    if(isset($trafic_road_safety)){
        array_push($department_id,TRAFFIC); 
        array_push($department_id,ROADSAFETY); 
    }
    if(isset($paycity)){
        array_push($department_id,PAYCITY);  
    }
}

$additionalSelect = [
//    'adminread',
//    db_prefix() . 'tickets.userid',
    db_prefix() . 'tickets.company_id',
    'statuscolor',
//    db_prefix() . 'tickets.name as ticket_opened_by_name',
//    db_prefix() . 'tickets.email',
//    db_prefix() . 'tickets.userid',
//    'assigned',
//    db_prefix() . 'clients.company',
    ];
    
$sIndexColumn = 'ticketid';
$sTable       = db_prefix() . 'tickets';
$join = [
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'tickets.contactid',
    'LEFT JOIN ' . db_prefix() . 'services ON ' . db_prefix() . 'services.serviceid = ' . db_prefix() . 'tickets.service',
    'LEFT JOIN ' . db_prefix() . 'departments ON ' . db_prefix() . 'departments.departmentid = ' . db_prefix() . 'tickets.department',
    'LEFT JOIN ' . db_prefix() . 'tickets_status ON ' . db_prefix() . 'tickets_status.ticketstatusid = ' . db_prefix() . 'tickets.status',
    'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'tickets.company_id ',
    'LEFT JOIN ' . db_prefix() . 'tickets_priorities ON ' . db_prefix() . 'tickets_priorities.priorityid = ' . db_prefix() . 'tickets.priority',
    'LEFT JOIN ' . db_prefix() . 'meter_number ON ' . db_prefix() . 'meter_number.id = ' . db_prefix() . 'tickets.meter_number',
    'LEFT JOIN ' . db_prefix() . 'customers_groups ON ' . db_prefix() . 'customers_groups.id = ' . db_prefix() . 'tickets.group_id',
    'LEFT JOIN ' . db_prefix() . 'tickets_channel_type ON ' . db_prefix() . 'tickets_channel_type.id = ' . db_prefix() . 'tickets.channel_type_id',
    'LEFT JOIN ' . db_prefix() . 'services as b ON b.parentid = ' . db_prefix() . 'services.serviceid',
    'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'tickets.assigned',
    ];


$where  = [];
$filter = [];
$statusIds = [];
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

if(!empty($department_id)){
    array_push($where, 'AND ' . db_prefix() . 'tickets.department IN (' . implode(',',$department_id)  . ')');
}
if($table_name == 'unassigned_companies'){
    array_push($where, 'AND ' . db_prefix() . 'tickets.company_id = -1');
} 
//foreach ($this->ci->projects_model->get_project_statuses() as $status) {
//    if ($this->ci->input->post('project_status_' . $status['id'])) {
//        array_push($statusIds, $status['id']);
//    }
//}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,$additionalSelect,'GROUP BY '.db_prefix() . 'tickets.ticketid');

//var_dump($result);exit;

$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    
    
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        
        if($i == $parent_Category_col_number ){
            $_data = $aRow['parent_name'];  
        }elseif ($i == $sub_parent_Category_col_number) {
             $_data = $aRow['sub_parent_name'];  
        }elseif ($i== $response_hours) {
            $responsce_percentage = get_response_percentage(($aRow['company_id'] > 0) ? $aRow['company_id'] : -1  ,$aRow['priority'],'response',$aRow['response_hours']);
             
            $_data = ($responsce_percentage > 0)?round($responsce_percentage, 4).'%':''; 
        }elseif ($i == $resolve_hours) {
            $hold =  get_on_hold_time($aRow['ticket_number']); 
            $resolve_percentage = get_response_percentage(($aRow['company_id'] > 0) ? $aRow['company_id'] : -1,$aRow['priority'],'resolution',($aRow['resolve_hours'] - $hold));
            $_data = ($resolve_percentage > 0)?round($resolve_percentage,4).'%':''; 
            
        }elseif($i == $assigned_name){
            $_data = $aRow['assigned_name'];  
        }elseif ($i == $close_date) {
            $_data = $aRow['close_date']; 
        }
        else{
        if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
            $_data = $aRow[strafter($aColumns[$i], 'as ')];
        } else {
            $_data = $aRow[$aColumns[$i]];
        }
        }
        if($aColumns[$i] == '2'){
            if($i == $onhold){
              $_data =  get_on_hold_time($aRow['ticket_number']); 
            }elseif ($i == $response_hours_cell) {
                $_data = ($aRow['response_hours'] > 0)?round($aRow['response_hours'], 4) : '';
            }elseif ($i == $resolve_hours_cell) {
                $hold =  get_on_hold_time($aRow['ticket_number']); 
                if($aRow['status'] == 'Closed'){
                    if($aRow['resolve_hours'] > $hold){
                        $_data = round(($aRow['resolve_hours'] - $hold), 4);
                    } else {
                        $_data = round(($aRow['resolve_hours']), 4);
                    }
                } else {
                    $_data = '';
                }
            }
            else{
                $_data = '';
            }
        }elseif ($aColumns[$i] == 'ans_date' || $aColumns[$i] == db_prefix() . 'tickets.ticketid') {
            if ($aRow[$aColumns[$i]] == null) {
                $_data = _l('ticket_no_reply_yet');
            } else {
                $_data = _dt($aRow[$aColumns[$i]]);
            }
        }elseif ($aColumns[$i] == 'status' || $aColumns[$i] == db_prefix() . 'tickets_status.name as status') {
            $_data = '<span class="label inline-block" style="border:1px solid ' . $aRow['statuscolor'] . '; color:' . $aRow['statuscolor'] . '">' . $aRow['status'] . '</span>';
        } elseif ($aColumns[$i] == 'created_data') {
            $_data = _dt($_data);
        } elseif ($aColumns[$i] == 'priority' || $aColumns[$i] == db_prefix() . 'tickets.priority as priority') {
            $_data = ticket_priority_translate($aRow['priority']);
        }
        
        $row[] = $_data;
    }
    
    $output['aaData'][] = $row;
}
