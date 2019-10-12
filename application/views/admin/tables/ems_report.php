<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    1,
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

if($table_name == 'network' || $table_name == 'trafic_road_safety' || $table_name == 'paycity'){
    $response_hours = 21;
    $resolve_hours = 22;    
}elseif ($table_name == 'full_report') {
    $response_hours = 24;
    $resolve_hours = 25;    
}elseif ($table_name == 'paycitySLA' || $table_name == 'trafic_road_safetySLA' || $table_name == 'networkSLA') {
    $response_hours = 19;
    $resolve_hours = 20;    
}elseif ($table_name == 'full_reportSLA') {
    $response_hours = 18;
    $resolve_hours = 19;    
}
$parent_Category_col_number = 8;
    $sub_parent_Category_col_number = 9;
if($table_name == 'paycitySLA' || $table_name == 'trafic_road_safetySLA' || $table_name == 'networkSLA' || $table_name == 'full_reportSLA'){
    $parent_Category_col_number = 7;
    $sub_parent_Category_col_number = 8;
}
$department_id=[];
if($table_name == 'network' || $table_name == 'networkSLA'){
    array_push($department_id,NETWORKS); 
    
}elseif($table_name == 'trafic_road_safety' || $table_name == 'trafic_road_safetySLA'){
    array_push($department_id,TRAFFIC); 
    array_push($department_id,ROADSAFETY); 
}elseif($table_name == 'paycity' || $table_name == 'paycitySLA'){
    array_push($department_id,PAYCITY); 
}
$additionalSelect = [
    'adminread',
    db_prefix() . 'tickets.userid',
    db_prefix() . 'tickets.company_id',
    'statuscolor',
    db_prefix() . 'tickets.name as ticket_opened_by_name',
    db_prefix() . 'tickets.email',
    db_prefix() . 'tickets.userid',
    'assigned',
    db_prefix() . 'clients.company',
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
    ];


$where  = [];
$filter = [];
$statusIds = [];
if(!empty($department_id)){
    array_push($where, 'AND ' . db_prefix() . 'tickets.department IN (' . implode(',',$department_id)  . ')');
}
 
foreach ($this->ci->projects_model->get_project_statuses() as $status) {
    if ($this->ci->input->post('project_status_' . $status['id'])) {
        array_push($statusIds, $status['id']);
    }
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,$additionalSelect);
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
            
            $_data = round(get_response_percentage($aRow['company_id'],$aRow['priority'],'response',$aRow['response_hours']), 2).'%';
        }elseif ($i == $resolve_hours) {
            
            $_data = round(get_response_percentage($aRow['company_id'],$aRow['priority'],'resolution',$aRow['resolve_hours']),2).'%'; 
            
        }
        else{
        if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
            $_data = $aRow[strafter($aColumns[$i], 'as ')];
        } else {
            $_data = $aRow[$aColumns[$i]];
        }
        }
        if ($aColumns[$i] == '1') {
            $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['ticket_number'] . '"><label></label></div>';
        }elseif($aColumns[$i] == '2'){
            $_data = '';
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
