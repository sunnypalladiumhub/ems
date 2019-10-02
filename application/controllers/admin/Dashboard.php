<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('tickets_model');
    }

    /* This is admin dashboard view */

    public function index() {
        close_setup_menu();
        $this->load->model('departments_model');
        $this->load->model('todo_model');
        $data['departments'] = $this->departments_model->get();

        $data['todos'] = $this->todo_model->get_todo_items(0);
        // Only show last 5 finished todo items
        $this->todo_model->setTodosLimit(5);
        $data['todos_finished'] = $this->todo_model->get_todo_items(1);
        $data['upcoming_events_next_week'] = $this->dashboard_model->get_upcoming_events_next_week();
        $data['upcoming_events'] = $this->dashboard_model->get_upcoming_events();
        $data['title'] = _l('dashboard_string');
        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['activity_log'] = $this->misc_model->get_activity_log();
        // Tickets charts
        $tickets_awaiting_reply_by_status = $this->dashboard_model->tickets_awaiting_reply_by_status();
        $tickets_awaiting_reply_by_department = $this->dashboard_model->tickets_awaiting_reply_by_department();

        $data['tickets_reply_by_status'] = json_encode($tickets_awaiting_reply_by_status);
        $data['tickets_awaiting_reply_by_department'] = json_encode($tickets_awaiting_reply_by_department);

        $data['tickets_reply_by_status_no_json'] = $tickets_awaiting_reply_by_status;
        $data['tickets_awaiting_reply_by_department_no_json'] = $tickets_awaiting_reply_by_department;

        $data['projects_status_stats'] = json_encode($this->dashboard_model->projects_status_stats());
        $data['leads_status_stats'] = json_encode($this->dashboard_model->leads_status_stats());
        $data['google_ids_calendars'] = $this->misc_model->get_google_calendar_ids();
        $data['bodyclass'] = 'dashboard invoices-total-manual';
        $this->load->model('announcements_model');
        $data['staff_announcements'] = $this->announcements_model->get();
        $data['total_undismissed_announcements'] = $this->announcements_model->get_total_undismissed_announcements();

        $this->load->model('projects_model');
        $data['projects_activity'] = $this->projects_model->get_activity('', hooks()->apply_filters('projects_activity_dashboard_limit', 20));
        add_calendar_assets();
        $this->load->model('utilities_model');
        $this->load->model('estimates_model');
        $data['estimate_statuses'] = $this->estimates_model->get_statuses();

        $this->load->model('proposals_model');
        $data['proposal_statuses'] = $this->proposals_model->get_statuses();

        $wps_currency = 'undefined';
        if (is_using_multiple_currencies()) {
            $wps_currency = $data['base_currency']->id;
        }
        $data['weekly_payment_stats'] = json_encode($this->dashboard_model->get_weekly_payments_statistics($wps_currency));

        $data['dashboard'] = true;

        $data['user_dashboard_visibility'] = get_staff_meta(get_staff_user_id(), 'dashboard_widgets_visibility');

        if (!$data['user_dashboard_visibility']) {
            $data['user_dashboard_visibility'] = [];
        } else {
            $data['user_dashboard_visibility'] = unserialize($data['user_dashboard_visibility']);
        }
        $data['user_dashboard_visibility'] = json_encode($data['user_dashboard_visibility']);

        $data = hooks()->apply_filters('before_dashboard_render', $data);
        $this->load->view('admin/dashboard/dashboard', $data);
    }

    public function ems_dashboard() {
        $data=array();
        add_admin_chat_js_assets();
        $this->load->model('tickets_model');
        $today_hours_records = $this->tickets_model->ticket_detail_by_time('0');
        $yesterday_hours_records = $this->tickets_model->ticket_detail_by_time('1');
        $today_array = array();
        $yesterday_array = array();
        for ($x = 0; $x <= 23; $x++) {
            $today_array[$x]=0;
            $yesterday_array[$x]=0;
        }
        if(!empty($today_hours_records)){
            foreach ($today_hours_records as $key=>$value){
                $today_array[$value['the_hour']] = $value['number_of_ticket'];
            }
        }
        if(!empty($yesterday_hours_records)){
            foreach ($yesterday_hours_records as $key=>$value){
                $yesterday_array[$value['the_hour']] = $value['number_of_ticket'];
            }
        }
        
        $data['today_tickets'] = implode(',',$today_array);
        $data['yesterday_tickets'] = implode(',',$yesterday_array);
        $this->load->view('admin/ems_dashboard/dashboard', $data);
    }

    /* Chart weekly payments statistics on home page / ajax */

    public function weekly_payments_statistics($currency) {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->dashboard_model->get_weekly_payments_statistics($currency));
            die();
        }
    }

}
