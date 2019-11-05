<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    '1', // bulk actions
    db_prefix() . 'meter_number.number as number',
    db_prefix() . 'meter_number.type as type',
    db_prefix() . 'meter_number.machine_id as machine_id',
    db_prefix() . 'meter_number.building_type as building_type',
    db_prefix() . 'meter_number.meter_accessible as meter_accessible',
    db_prefix() . 'meter_number.meter_location as meter_location',
    db_prefix() . 'meter_number.meter_serial_number as meter_serial_number',
    db_prefix() . 'meter_number.seals_on_arrival as seals_on_arrival',
    db_prefix() . 'meter_number.meter_type as meter_type',
    db_prefix() . 'meter_number.meter_manufacturer as meter_manufacturer',
    db_prefix() . 'meter_number.meter_reading as meter_reading',
    db_prefix() . 'meter_number.phase as phase',
    db_prefix() . 'meter_number.trip_test_done as trip_test_done',
    db_prefix() . 'meter_number.trip_test_results as trip_test_results',
    db_prefix() . 'meter_number.meter_condition as meter_condition',
    db_prefix() . 'meter_number.other_illegal_connection as other_illegal_connection',
    db_prefix() . 'meter_number.sgc_number as sgc_number',
    db_prefix() . 'meter_number.new_seals_fitted as new_seals_fitted',
    db_prefix() . 'meter_number.new_seal_numbers as new_seal_numbers',
    db_prefix() . 'meter_number.time_stamp as time_stamp',
    ];

$contactColumn = 6;
$tagsColumns   = 3;

$additionalSelect = [
    db_prefix() . 'meter_number.id',
    ];

$join = [
    
    ];

//$custom_fields = get_table_custom_fields('meter_number');
//foreach ($custom_fields as $key => $field) {
//    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
//    array_push($customFieldsColumns, $selectAs);
//    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
//    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'tickets.ticketid = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
//}

$where  = [];
$filter = [];


$sIndexColumn = 'id';
$sTable       = db_prefix() . 'meter_number';
$custom_fields = array();
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
        
            // Ticket is assigned
            if ($aColumns[$i] == '1') {
                //. $aRow[db_prefix() . 'tickets.ticketid'] .
                $_data = '<div class="checkbox"><input type="checkbox" value="'.$aRow['id'].'"><label></label></div>';
            } else if($aColumns[$i] == 'tblmeter_number.building_type as building_type') {
                if($aRow['building_type'] == 'residential' && $aRow['building_type'] != ''){
                    $_data = 'Residential';
                } else if($aRow['building_type'] == 'commercial' && $aRow['building_type'] != ''){
                    $_data = 'Commercial';
                } else if($aRow['building_type'] == 'industrial' && $aRow['building_type'] != ''){
                    $_data = 'Industrial';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.meter_accessible as meter_accessible') {
                if($aRow['meter_accessible'] == 1 && $aRow['meter_accessible'] != ''){
                    $_data = 'Yes';
                } else if($aRow['meter_accessible'] == 0 && $aRow['meter_accessible'] != ''){
                    $_data = 'No';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.meter_location as meter_location') {
                if($aRow['meter_location'] == 'inside' && $aRow['meter_location'] != ''){
                    $_data = 'Inside';
                } else if($aRow['meter_location'] == 'outside' && $aRow['meter_location'] != ''){
                    $_data = 'Outside';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.meter_type as meter_type'){
                if($aRow['meter_type'] == 'prepaid' && $aRow['meter_type'] != ''){
                    $_data = 'Prepaid';
                } else if($aRow['meter_type'] == 'postpaid' && $aRow['meter_type'] != ''){
                    $_data = 'Postpaid';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.seals_on_arrival as seals_on_arrival'){
                if($aRow['seals_on_arrival'] == 1 && $aRow['seals_on_arrival'] != ''){
                    $_data = 'Yes';
                } else if($aRow['seals_on_arrival'] == 0 && $aRow['seals_on_arrival'] != ''){
                    $_data = 'No';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.phase as phase'){
                if($aRow['phase'] == 1 && $aRow['phase'] != ''){
                    $_data = '1 Phase';
                } else if($aRow['phase'] == 2 && $aRow['phase'] != ''){
                    $_data = '2 Phase';
                } else if($aRow['phase'] == 3 && $aRow['phase'] != ''){
                    $_data = '3 Phase';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.trip_test_done as trip_test_done'){
                if($aRow['trip_test_done'] == 1 && $aRow['trip_test_done'] != ''){
                    $_data = 'Yes';
                } else if($aRow['trip_test_done'] == 0 && $aRow['trip_test_done'] != ''){
                    $_data = 'No';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.trip_test_results as trip_test_results'){
                if($aRow['trip_test_results'] == 1 && $aRow['trip_test_results'] != ''){
                    $_data = 'Success';
                } else if($aRow['trip_test_results'] == 0 && $aRow['trip_test_results'] != ''){
                    $_data = 'Cancel';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.meter_condition as meter_condition'){
                if($aRow['meter_condition'] == 1 && $aRow['meter_condition'] != ''){
                    $_data = 'Average';
                } else if($aRow['meter_condition'] == 2 && $aRow['meter_condition'] != ''){
                    $_data = 'Good';
                } else if($aRow['meter_condition'] == 0 && $aRow['meter_condition'] != ''){
                    $_data = 'Bad';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.other_illegal_connection as other_illegal_connection'){
                if($aRow['other_illegal_connection'] == 1 && $aRow['other_illegal_connection'] != ''){
                    $_data = 'Yes';
                } else if($aRow['other_illegal_connection'] == 0 && $aRow['other_illegal_connection'] != ''){
                    $_data = 'No';
                } else{
//                    $_data = 'NULL';
                }
            } else if($aColumns[$i] == 'tblmeter_number.new_seals_fitted as new_seals_fitted'){
                if($aRow['new_seals_fitted'] == 1 && $aRow['new_seals_fitted'] != ''){
                    $_data = 'Yes';
                } else if($aRow['new_seals_fitted'] == 0 && $aRow['new_seals_fitted'] != ''){
                    $_data = 'No';
                } else{
//                    $_data = 'NULL';
                }
            }
            $url   = admin_url('meter_number/view/'.$aRow['id']);
            if ($i == 1) {
                $_data .= '<div class="row-options">';
//                $_data .= '<a href="' . $url . '?tab=settings">' . _l('view') . '</a>';
                $_data .= ' <span class="text-dark">  </span><a href="' . $url . '"> View </a>';
                $_data .= '</div>';
            }
        //elseif ($i == $tagsColumns) {
//            $_data = render_tags($_data);
//        } elseif ($i == $contactColumn) {
//            if ($aRow['userid'] != 0) {
//                $_data = '<a href="' . admin_url('clients/client/' . $aRow['userid'] . '?group=contacts') . '">' . $aRow['contact_full_name'];
//                if (!empty($aRow['company'])) {
//                    $_data .= ' (' . $aRow['company'] . ')';
//                }
//                $_data .= '</a>';
//            } else {
//                $_data = $aRow['ticket_opened_by_name'];
//            }
//        } elseif ($aColumns[$i] == 'status') {
//            $_data = '<span class="label inline-block" style="border:1px solid ' . $aRow['statuscolor'] . '; color:' . $aRow['statuscolor'] . '">' . ticket_status_translate($aRow['status']) . '</span>';
//        } elseif ($aColumns[$i] == db_prefix() . 'tickets.date') {
//            $_data = _dt($_data);
//        } elseif ($aColumns[$i] == 'priority') {
//            $_data = ticket_priority_translate($aRow['priority']);
//        } else {
//            if (strpos($aColumns[$i], 'date_picker_') !== false) {
//                $_data = (strpos($_data, ' ') !== false ? _dt($_data) : _d($_data));
//            }
//        }

        $row[] = $_data;

    }


    $output['aaData'][] = $row;
}
