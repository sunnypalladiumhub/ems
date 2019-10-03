<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Meter_number extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('tickets_model');
    }

    /* Open also all taks if user access this /tasks url */

    public function index($id = '') {
        $data = array();
        $this->load->view('admin/meter_number/manage', $data);

        //        $this->list_tasks($id);
    }

    public function table($clientid = '') {
        $this->app->get_table_data('meter_number', [
            'clientid' => $clientid,
        ]);
    }
    public function view($meter_id){
        $data = array();
        $meter_details = $this->tickets_model->get_MeterNumber($meter_id);
        $data['meter'] = $meter_details;
        $this->load->view('admin/meter_number/view', $data);

    }

    

}
