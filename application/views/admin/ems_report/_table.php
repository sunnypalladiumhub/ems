<?php
defined('BASEPATH') or exit('No direct script access allowed');

$table_data = [
];
$table_field_list = $table_data_array[$table];

foreach ($table_field_list as $key=>$value){
   array_push($table_data,$value['title']); 
}

//array_unshift($table_data, [
//    'name'     => '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="stocks"><label></label></div>',
//    'th_attrs' => ['class' => (isset($bulk_actions) ? '' : 'not_visible')],
//]);


render_datatable($table_data, $table, [], [
        'data-last-order-identifier' => $table,
        'data-default-order'         => get_table_last_order($table),
]);
