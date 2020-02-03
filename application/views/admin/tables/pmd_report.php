<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    ];

$this->ci->load->helper('ems_report_helper');
$data_table_array = get_pms_table_records();
$table_field_list = $data_table_array[$table_name];

foreach ($table_field_list as $key=>$value){
    if($value['field'] != ''){
        array_push($aColumns,$value['field']); 
    }else{
        array_push($aColumns,'2'); 
    }
   
}
$parent_Category_col_number = 0;
$sub_parent_Category_col_number = 10;
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

if(!empty($_POST['comapany'])){
    array_push($where, 'AND ' . db_prefix() . 'tickets.company_id = '. $_POST['comapany']  . '');
}
$filter = [];
$statusIds = [];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,[],'GROUP BY '.db_prefix() . 'tickets.ticketid');

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
        }
        else{
        if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
            $_data = $aRow[strafter($aColumns[$i], 'as ')];
        } else {
            $_data = $aRow[$aColumns[$i]];
        }
        }
       
        
        $row[] = $_data;
    }
    
    $output['aaData'][] = $row;
}
