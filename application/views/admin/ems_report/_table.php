<?php
defined('BASEPATH') or exit('No direct script access allowed');

$table_data = [
];
$table_field_list = $table_data_array[$table];

foreach ($table_field_list as $key=>$value){
   array_push($table_data,$value['title']); 
}

render_datatable($table_data, $table, [], [
        'data-last-order-identifier' => $table,
        'data-default-order'         => get_table_last_order($table),
]);
