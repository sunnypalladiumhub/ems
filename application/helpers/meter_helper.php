<?php

defined('BASEPATH') or exit('No direct script access allowed');

function handle_meter_fields_post($rel_id, $data, $is_cf_items = false)
{
   
    $affectedRows = 0;
    $CI           = & get_instance();
    if(isset($data['time_stamp']) && $data['time_stamp'] != ''){
        $data['time_stamp'] = date('Y-m-d H:i:s',strtotime($data['time_stamp']));
    }
    
    if($rel_id > 0){
        $CI->db->where('id', $rel_id);
        $CI->db->update(db_prefix() . 'meter_number', $data);
        
           $insert_id = $rel_id; 
        
    }else{
        $CI->db->insert(db_prefix() . 'meter_number', $data);
        $insert_id = $CI->db->insert_id();
    }
    if ($insert_id > 0) {
        return true;
    }

    return false;
}

