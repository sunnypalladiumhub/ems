<?php

defined('BASEPATH') or exit('No direct script access allowed');

function get_ems_table_records(){
    $data = array();
    $data['full_report'] = array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Subject','field'=>'tbltickets.subject as subject'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Meter number','field'=>'tblmeter_number.number as meter_number'),
        array('title'=>'Infringement #','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
//        array('title'=>'Networks','field'=>''),
//        array('title'=>'Trafic/Road Safety','field'=>''),
//        array('title'=>'PayCity','field'=>''),
        );
    $data['network'] = array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Subject','field'=>'tbltickets.subject as subject'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        
        
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        
        
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        
        
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Meter number','field'=>'tblmeter_number.number as meter_number'),
        
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
//        array('title'=>'Networks','field'=>''),
        );
    
    
    $data['trafic_road_safety']=array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Subject','field'=>'tbltickets.subject as subject'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Infringement #','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
//        array('title'=>'Trafic/Road Safety','field'=>''),
        );
    
    
    $data['paycity']=array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Subject','field'=>'tbltickets.subject as subject'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Infringement #','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
//        array('title'=>'PayCity','field'=>''),
        );
    
    
    $data['paycitySLA']=array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
        //array('title'=>'PayCity','field'=>''),
        );
    
    $data['trafic_road_safetySLA']=array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
        //array('title'=>'Trafic/Road Safety','field'=>''),
        );
    
    $data['networkSLA']=array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
        //array('title'=>'Networks','field'=>''),
        );
    
    
    $data['full_reportSLA']=array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
        );
    $data['unassigned_companies'] = array(
        array('title'=>'Ticket Number','field'=>'tbltickets.ticketid as ticket_number'),
        array('title'=>'Department (Campaign)','field'=>'tbldepartments.name as department'),
        array('title'=>'Company Name','field'=>'tblclients.company as company'),
        array('title'=>'Service (Category)','field'=> 'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid)) as parent_name'),
        array('title'=>'Subject','field'=>'tbltickets.subject as subject'),
        array('title'=>'Province (State)','field'=>'tblclients.state as state'),
        array('title'=>'Priority','field'=>'tbltickets.priority as priority'),
        array('title'=>'Time to Respond SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id IN(2,3,4) ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as response_hours'),
        array('title'=>'Time to Resolve SLA','field'=>'TIME_TO_SEC(TIMEDIFF((select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 5 ORDER BY tas.date DESC LIMIT 1),(select date from tbltickets_activity_log as tas where tas.ticket_id = tbltickets.ticketid AND tas.status_id = 1 ORDER BY tas.date ASC LIMIT 1)))/3600 as resolve_hours'),
        array('title'=>'Channel','field'=>'tbltickets_channel_type.name as channel_name'),
        array('title'=>'Status','field'=>'tbltickets_status.name as status'),
        array('title'=>'Unique ID','field'=>'tblclients.vat as unique_id'),
        array('title'=>'Company Group Type','field'=>'tblcustomers_groups.name as group_type'),
        array('title'=>'Sub Category Name','field'=>'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.serviceid), "") as sub_parent_name'),
        array('title'=>'Contact','field'=>'tbltickets.email as email'),
        array('title'=>'Created Date','field'=>'tbltickets.date as created_data'),
        array('title'=>'First Answered Date','field'=>'tbltickets.lastreply as ans_date'),
        array('title'=>'Date Closed Date','field'=>'tbltickets.lastreply as close_date'),
        array('title'=>'On Hold Duration','field'=>''),
        array('title'=>'Meter number','field'=>'tblmeter_number.number as meter_number'),
        array('title'=>'Assigned Ticket','field'=>'CONCAT(' . db_prefix() . 'staff.firstname, \' \', ' . db_prefix() . 'staff.lastname) as assigned_name'),
        );
    
    
   return $data; 
}

function get_response_percentage($client_id,$priority,$type,$hours){
    $result_per = 0;
    if($client_id > 0){
        if($priority == 3){
            $option = 'high_'.$type;
        }elseif ($priority == 2) {
            $option = 'medium_'.$type;
        } elseif ($priority == 1) {
            $option = 'low_'.$type;
        }
        $CI          = &get_instance();
        $CI->db->where('client_id', $client_id);
        $result = $CI->db->get(db_prefix() . 'sla_manager_setting')->row_array();
        
        if(!empty($result) && isset($result[$option])){
            $set_time = $result[$option];
            
            $taken_time = $hours;
           
            $result_per = ($hours * 100) / $set_time;
        }
    }
    return $result_per;
}
