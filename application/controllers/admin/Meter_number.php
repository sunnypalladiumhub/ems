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
        $data['meter']  = $this->tickets_model->get_MeterNumber();
        $this->load->view('admin/meter_number/manage', $data);
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
            
            $ids           = $this->input->post('ids');
            $type     = $this->input->post('type');
            $machine_id     = $this->input->post('machine_id');
            $building_id     = $this->input->post('building_id');
            $accessible     = $this->input->post('accessible');
            $location     = $this->input->post('location');
            $serial_number     = $this->input->post('serial_number');
            $seals_on_arrival     = $this->input->post('seals_on_arrival');
            $meter_type     = $this->input->post('meter_type');
            $manufacturer     = $this->input->post('manufacturer');
            $phase     = $this->input->post('phase');
            $trip_test_done     = $this->input->post('trip_test_done');
            $trip_test_results     = $this->input->post('trip_test_results');
            $meter_condition     = $this->input->post('meter_condition');
            $other_illegal_connection     = $this->input->post('other_illegal_connection');
            $sgc_number     = $this->input->post('sgc_number');
            $new_seals_fitted     = $this->input->post('new_seals_fitted');
            $new_seal_numbers     = $this->input->post('new_seal_numbers');
            
            $is_admin = is_admin();
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($this->input->post('mass_delete')) {
                        if ($is_admin) {
                            if ($this->tickets_model->delete_meter_number($id)) {
                                $total_deleted++;
                            }
                        }
                    } else {
                        if ($type) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'type' => $type,
                            ]);
                        }
                        if ($machine_id) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'machine_id' => $machine_id,
                            ]);
                        }
                        if ($building_id) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'building_type' => $building_id,
                            ]);
                        }

                        if ($accessible) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'meter_accessible' => $accessible,
                            ]);
                        }
                        if ($location) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'meter_location' => $location,
                            ]);
                        }
                        if ($serial_number) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'meter_serial_number' => $serial_number,
                            ]);
                        }
                        if ($seals_on_arrival) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'seals_on_arrival' => $seals_on_arrival,
                            ]);
                        }
                        if ($meter_type) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'meter_type' => $meter_type,
                            ]);
                        }
                        if ($manufacturer) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'meter_manufacturer' => $manufacturer,
                            ]);
                        }
                        if ($phase) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'phase' => $phase,
                            ]);
                        }
                        if ($trip_test_done) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'trip_test_done' => $trip_test_done,
                            ]);
                        }
                        if ($trip_test_results) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'trip_test_results' => $trip_test_results,
                            ]);
                        }
                        if ($meter_condition) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'meter_condition' => $meter_condition,
                            ]);
                        }
                        if ($other_illegal_connection) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'other_illegal_connection' => $other_illegal_connection,
                            ]);
                        }
                        if ($sgc_number) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'sgc_number' => $sgc_number,
                            ]);
                        }
               
                        if ($new_seals_fitted) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'new_seals_fitted' => $new_seals_fitted,
                            ]);
                        }
               
                        if ($new_seal_numbers) {
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'meter_number', [
                                'new_seal_numbers' => $new_seal_numbers,
                            ]);
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
