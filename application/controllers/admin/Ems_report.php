<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ems_report extends AdminController
{
    /**
     * Codeigniter Instance
     * Expenses detailed report filters use $ci
     * @var object
     */
    private $ci;

    public function __construct()
    {
        parent::__construct();
        if (!ems_report_access()) {
            access_denied('reports');
        }
        $this->ci = &get_instance();
        $this->load->model('reports_model');
        $this->load->helper('ems_report');
    }

    /* No access on this url */
    public function index()
    {
        redirect(admin_url());
    }
    public function table($clientid = '') {
        if($this->input->post('table')){
            $this->app->get_table_data('ems_report', [
                'table_name' => $this->input->post('table'),
            ]);
        }else{
            access_denied('reports');
        }
    }


    public function full_report(){
        if(has_report_permission('full_report', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'full_report';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function network(){
        if(has_report_permission('network', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'network';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function trafic_road_safety(){
        if(has_report_permission('trafic_road_safety', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'trafic_road_safety';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function paycity(){
        if(has_report_permission('paycity', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'paycity';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function paycitySLA(){
        if(has_report_permission('paycitySLA', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'paycitySLA';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function trafic_road_safetySLA(){
        if(has_report_permission('trafic_road_safetySLA', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'trafic_road_safetySLA';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function networkSLA(){
        if(has_report_permission('networkSLA', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'networkSLA';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
    public function full_reportSLA(){
        if(has_report_permission('full_reportSLA', '', '')){
            $data = array();
            $data_table = get_ems_table_records();
            $data['table'] = 'full_reportSLA';
            $data['table_data_array'] = $data_table;
            
        }else{
            access_denied('reports');
        }
        $this->load->view('admin/ems_report/manage', $data);
    }
}
