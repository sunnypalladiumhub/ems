<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'meter_number.number as number',
    db_prefix() . 'meter_number.type as type',
    db_prefix() . 'meter_number.building_type as building_type',
    db_prefix() . 'meter_number.meter_type as meter_type',
    db_prefix() . 'meter_number.phase as phase',
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
                
            $url   = admin_url('meter_number/view/'.$aRow['id']);
            if ($i == 0) {
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
