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
        $data['meter']  = $this->tickets_model->get_MeterNumber($data['ticket']->meter_number);
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

    public function bulk_action() {
        hooks()->do_action('before_do_bulk_action_for_meter');
        if ($this->input->post()) {
            $total_deleted = 0;
            $data = $this->input->post();
//            $ids = $this->input->post('ids');
//            $number = $this->input->post('number');
//            $type = $this->input->post('type');
//            $time_stamp = $this->input->post('time_stamp');
//            $machine_id = $this->input->post('machine_id');
            //////////////////////////////////////////
            $is_admin = is_admin();
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($this->input->post('mass_delete')) {
                        if ($is_admin) {
                            if ($this->tickets_model->delete($id)) {
                                $total_deleted++;
                            }
                        }
                    } else {
                        if ($status) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix() . 'tickets', [
                                'status' => $status,
                            ]);
                            if ($this->db->affected_rows() > 0) {
                                $data_insert['ticket_id'] = $id;
                                $data_insert['status_id'] = $status;
                                $data_insert['user_id'] = get_staff_user_id();
                                $data_insert['date'] = date('Y-m-d H:i:s');
                                $data_insert['description'] = 'Status change of ticket id : ' . $id . ' New status set : ' . $status;
                                $this->db->insert(db_prefix() . 'tickets_activity_log', $data_insert);
                            }
                        }
                        if ($department) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix() . 'tickets', [
                                'department' => $department,
                            ]);
                        }
                        if ($priority) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix() . 'tickets', [
                                'priority' => $priority,
                            ]);
                        }

                        if ($service) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix() . 'tickets', [
                                'service' => $service,
                            ]);
                        }
                        if ($tags) {
                            handle_tags_save($tags, $id, 'ticket');
                        }
                    }
                }
            }

            if ($this->input->post('mass_delete')) {
                set_alert('success', _l('total_tickets_deleted', $total_deleted));
            }
        }
    }

}
