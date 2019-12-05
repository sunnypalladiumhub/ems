<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    db_prefix() . 'departments.name as name',
    db_prefix() . 'department_email.email as email',
    db_prefix() . 'department_email.calendar_id as calendar_id',
    ];
$sIndexColumn = 'departmentid';
$sTable       = db_prefix().'department_email';
$join = [
    'LEFT JOIN ' . db_prefix() . 'departments ON ' . db_prefix() . 'departments.departmentid = ' . db_prefix() . 'department_email.departmentid',
    ];
/**** This new code for multi department email ***/
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [db_prefix() . 'department_email.email', db_prefix() . 'department_email.hidefromclient', db_prefix() . 'department_email.host', db_prefix() . 'department_email.encryption', db_prefix() . 'department_email.password', db_prefix() . 'department_email.delete_after_import', db_prefix() . 'department_email.imap_username', db_prefix() . 'department_email.departmentid']);

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
       // $_data = $aRow[$aColumns[$i]];
        $ps    = '';
        if (!empty($aRow['password'])) {
            $ps = $this->ci->encryption->decrypt($aRow['password']);
        }
        if ($aColumns[$i] == 'name') {
         //   $_data = '<a href="#" onclick="edit_department(this,' . $aRow['id'] . '); return false" data-name="' . $aRow['name'] . '">' . $_data . '</a>';
             $_data = '<a href="#" onclick="edit_department(this,' . $aRow['id'] . '); return false" data-name="' . $aRow['name'] . '" data-departmentid="'.$aRow['departmentid'].'" data-calendar-id="' . $aRow['calendar_id'] . '" data-email="' . $aRow['email'] . '" data-hide-from-client="' . $aRow['hidefromclient'] . '" data-host="' . $aRow['host'] . '" data-password="' . $ps . '" data-imap_username="' . $aRow['imap_username'] . '" data-encryption="' . $aRow['encryption'] . '" data-delete-after-import="' . $aRow['delete_after_import'] . '">' . $_data . '</a>';
        }
        $row[] = $_data;
    }

    $options = icon_btn('departments/department/' . $aRow['id'], 'pencil-square-o', 'btn-default', [
        //'onclick' => 'edit_department(this,' . $aRow['id'] . '); return false', 'data-name' => $aRow['name'],
        'onclick' => 'edit_department(this,' . $aRow['id'] . '); return false', 'data-name' => $aRow['name'],'data-departmentid'=>$aRow['departmentid'], 'data-calendar-id' => $aRow['calendar_id'], 'data-email' => $aRow['email'], 'data-hide-from-client' => $aRow['hidefromclient'], 'data-host' => $aRow['host'], 'data-password' => $ps, 'data-encryption' => $aRow['encryption'], 'data-imap_username' => $aRow['imap_username'], 'data-delete-after-import' => $aRow['delete_after_import'],
        ]);
    $row[] = $options .= icon_btn('departments/email_delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
