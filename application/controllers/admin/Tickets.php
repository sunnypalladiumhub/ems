<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tickets extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        if (get_option('access_tickets_to_none_staff_members') == 0 && !is_staff_member()) {
            redirect(admin_url());
        }
        $this->load->model('tickets_model');
    }
    
    public function index($status = '', $userid = '')
    {
        close_setup_menu();

        if (!is_numeric($status)) {
            $status = '';
        }

        if ($this->input->is_ajax_request()) {
            if (!$this->input->post('filters_ticket_id')) {
                $tableParams = [
                    'status' => $status,
                    'userid' => $userid,
                ];
            } else {
                // request for othes tickets when single ticket is opened
                $tableParams = [
                'userid'              => $this->input->post('filters_userid'),
                'where_not_ticket_id' => $this->input->post('filters_ticket_id'),
            ];
                
                if ($tableParams['userid'] == 0) {
                    unset($tableParams['userid']);
                    $tableParams['by_email'] = $this->input->post('filters_email');
                }
            }

            $this->app->get_table_data('tickets', $tableParams);
        }

        $data['chosen_ticket_status']              = $status;
        $data['weekly_tickets_opening_statistics'] = json_encode($this->tickets_model->get_weekly_tickets_opening_statistics());
        $data['title']                             = _l('support_tickets');
        $this->load->model('departments_model');
        $data['statuses']             = $this->tickets_model->get_ticket_status();
        $data['staff_deparments_ids'] = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
        $data['departments']          = $this->departments_model->get();
        $data['priorities']           = $this->tickets_model->get_priority();
        $data['services']             = $this->tickets_model->get_service();
        $data['ticket_assignees']     = $this->tickets_model->get_tickets_assignes_disctinct();
        $data['bodyclass']            = 'tickets-page';
        add_admin_tickets_js_assets();
        $data['default_tickets_list_statuses'] = hooks()->apply_filters('default_tickets_list_statuses', [1, 2, 4]);
        $this->load->view('admin/tickets/list', $data);
    }
    /*********Start New Code For get droupdown Contact name by group ********/
    public function get_contact_list_by_group(){
        if ($this->input->post()) {
            $company_name  = $this->clients_model->get_customer_by_group_id($this->input->post('group_id'));
            $dropdown = render_select_for_company_name('company_id', $company_name, array('userid', array('company','vat')), 'ticket_drp_company_name', '', array('required' => 'true')); 
            $data['status']=1;
            $data['result'] = $dropdown;
        }
        echo json_encode($data);
    }
    /*********End New Code For get droupdown Contact name by group ********/
    public function add($userid = false)
    {
        if ($this->input->post()) {
            $data            = $this->input->post();
            $data['message'] = $this->input->post('message', false);
            /*********Start New Code For Check Sub category is isset or not ********/
            if(isset($data['sub_category']) && $data['sub_category'] != ''){
                $data['service'] = $data['sub_category'];
                unset($data['sub_category']);
            }
            if(isset($data['sub_category']) && $data['sub_category'] == ''){
                unset($data['sub_category']);
            }
            /*********End New Code For Check Sub category is isset or not ********/
            $id              = $this->tickets_model->add($data, get_staff_user_id());
            if ($id) {
                set_alert('success', _l('new_ticket_added_successfully', $id));
                redirect(admin_url('tickets/ticket/' . $id.'?tab=settings'));
            }
        }
        if ($userid !== false) {
            $data['userid'] = $userid;
            $data['client'] = $this->clients_model->get($userid);
        }
        // Load necessary models
        $this->load->model('knowledge_base_model');
        $this->load->model('departments_model');

        $data['departments']        = $this->departments_model->get();
        /*********Start New Code For Ticket  company group name ********/
        $data['company_groups']     = $this->clients_model->get_groups();
        $data['company_name']     = $this->clients_model->get();
        /*********End New Code For Ticket  company group name ********/ 
        $data['predefined_replies'] = $this->tickets_model->get_predefined_reply();
        $data['priorities']         = $this->tickets_model->get_priority();
        /*********Start New Code For Ticket  Channel type,meter number,services and parent services ********/
        $data['channel_type']       = $this->tickets_model->get_channel_type();
        $data['services']           = $this->tickets_model->get_service();
        $data['meter_number']       = $this->tickets_model->get_MeterNumber();
        $data['parent_services']    = $this->tickets_model->get_services_list();
        /*********End New Code For Ticket  Channel type,meter number,services and parent services ********/
        $whereStaff                 = [];
        if (get_option('access_tickets_to_none_staff_members') == 0) {
            $whereStaff['is_not_staff'] = 0;
        }
        $data['staff']     = $this->staff_model->get('', $whereStaff);
        $data['articles']  = $this->knowledge_base_model->get();
        $data['bodyclass'] = 'ticket';
        $data['title']     = _l('new_ticket');

        if ($this->input->get('project_id') && $this->input->get('project_id') > 0) {
            // request from project area to create new ticket
            $data['project_id'] = $this->input->get('project_id');
            $data['userid']     = get_client_id_by_project_id($data['project_id']);
            if (total_rows(db_prefix().'contacts', ['active' => 1, 'userid' => $data['userid']]) == 1) {
                $contact = $this->clients_model->get_contacts($data['userid']);
                if (isset($contact[0])) {
                    $data['contact'] = $contact[0];
                }
            }
        } elseif ($this->input->get('contact_id') && $this->input->get('contact_id') > 0 && $this->input->get('userid')) {
            $contact_id = $this->input->get('contact_id');
            if (total_rows(db_prefix().'contacts', ['active' => 1, 'id' => $contact_id]) == 1) {
                $contact = $this->clients_model->get_contact($contact_id);
                if ($contact) {
                    $data['contact'] = (array) $contact;
                }
            }
        }
        add_admin_tickets_js_assets();
        $this->load->view('admin/tickets/add', $data);
    }

    public function delete($ticketid)
    {
        if (!$ticketid) {
            redirect(admin_url('tickets'));
        }
        if (is_admin() || (!is_admin() && get_option('allow_non_admin_staff_to_delete_ticket') == '1')) {
        $response = $this->tickets_model->delete($ticketid);
        }else{
           set_alert('danger', "You are not allow to delete ticket.");
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($response == true) {
            set_alert('success', _l('deleted', _l('ticket')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_lowercase')));
        }

        if (strpos($_SERVER['HTTP_REFERER'], 'tickets/ticket') !== false) {
            redirect(admin_url('tickets'));
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete_attachment($id)
    {
        if (is_admin() || (!is_admin() && get_option('allow_non_admin_staff_to_delete_ticket_attachments') == '1')) {
            if (get_option('staff_access_only_assigned_departments') == 1 && !is_admin()) {
                $attachment = $this->tickets_model->get_ticket_attachment($id);
                $ticket     = $this->tickets_model->get_ticket_by_id($attachment->ticketid);

                $this->load->model('departments_model');
                $staff_departments = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                if (!in_array($ticket->department, $staff_departments)) {
                    set_alert('danger', _l('ticket_access_by_department_denied'));
                    redirect(admin_url('access_denied'));
                }
            }

            $this->tickets_model->delete_ticket_attachment($id);
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function ticket($id)
    {
        if (!$id) {
            redirect(admin_url('tickets/add'));
        }

        $data['ticket'] = $this->tickets_model->get_ticket_by_id($id);
        
        if (!$data['ticket']) {
            blank_page(_l('ticket_not_found'));
        }

        if (get_option('staff_access_only_assigned_departments') == 1) {
            if (!is_admin()) {
                $this->load->model('departments_model');
                $staff_departments = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                if (!in_array($data['ticket']->department, $staff_departments)) {
                    set_alert('danger', _l('ticket_access_by_department_denied'));
                    redirect(admin_url('access_denied'));
                }
            }
        }

        if ($this->input->post()) {
            $returnToTicketList = false;
            $data               = $this->input->post();

            if (isset($data['ticket_add_response_and_back_to_list'])) {
                $returnToTicketList = true;
                unset($data['ticket_add_response_and_back_to_list']);
            }

            $data['message'] = $this->input->post('message', false);
            $replyid         = $this->tickets_model->add_reply($data, $id, get_staff_user_id());

            if ($replyid) {
                set_alert('success', _l('replied_to_ticket_successfully', $id));
            }
            if (!$returnToTicketList) {
                redirect(admin_url('tickets/ticket/' . $id));
            } else {
                set_ticket_open(0, $id);
                redirect(admin_url('tickets'));
            }
        }
        // Load necessary models
        $this->load->model('knowledge_base_model');
        $this->load->model('departments_model');

        $data['statuses']                       = $this->tickets_model->get_ticket_status();
        $data['statuses']['callback_translate'] = 'ticket_status_translate';

        $data['departments']        = $this->departments_model->get();
        /*********Start New Code For Ticket Edit Form ********/
        $data['company_groups']     = $this->clients_model->get_groups();
        $data['company_name'] = array();
        /**** Start New Code For Add Unassigned **/
        if($data['ticket']->group_id > 0){
            $data['company_name']       = $this->clients_model->get_customer_by_group_id($data['ticket']->group_id);
            $temp_array = array('userid'=> UNASSIGNED,'company'=>'Unassigned');
            array_push($data['company_name'], $temp_array);
        }else{
            $temp_array = array('userid'=> UNASSIGNED,'company'=>'Unassigned');
            array_push($data['company_name'], $temp_array);
        }
        /**** End New Code For Add Unassigned **/
        $data['channel_type']       = $this->tickets_model->get_channel_type();
        $data['predefined_replies'] = $this->tickets_model->get_predefined_reply();
        $data['priorities']         = $this->tickets_model->get_priority();
        
        //$data['services']           = $this->tickets_model->get_service();
        $data['services']           = $this->tickets_model->get_service_by_department_id($data['ticket']->department);
        $data['service_detals']     = $this->tickets_model->get_service_details_by_id($data['ticket']->serviceid);
        $data['sub_category'] = array();
        if(isset($data['service_detals']->sub_category) && $data['service_detals']->sub_category > 0){
        $data['sub_category']       = $this->tickets_model->get_sub_category_by_service_id($data['service_detals']->service_id);
        
        }
        $data['meter_number']       = $this->tickets_model->get_MeterNumber();
        if(isset($data['ticket']->meter_number) && $data['ticket']->meter_number > 0){
            $data['meter']          = $this->tickets_model->get_MeterNumber($data['ticket']->meter_number);
            
        }
        /*********End New Code For Ticket Edit Form ********/
        $whereStaff                 = [];
        if (get_option('access_tickets_to_none_staff_members') == 0) {
            $whereStaff['is_not_staff'] = 0;
        }
        $data['staff']                = $this->staff_model->get('', $whereStaff);
        $data['articles']             = $this->knowledge_base_model->get();
        $data['ticket_replies']       = $this->tickets_model->get_ticket_replies($id);
        $data['bodyclass']            = 'top-tabs ticket single-ticket';
        $data['title']                = $data['ticket']->subject;
        $data['ticket']->ticket_notes = $this->misc_model->get_notes($id, 'ticket');
        add_admin_tickets_js_assets();
        $this->load->view('admin/tickets/single', $data);
    }

    public function edit_message()
    {
        if ($this->input->post()) {
            $data         = $this->input->post();
            $data['data'] = $this->input->post('data', false);

            if ($data['type'] == 'reply') {
                $this->db->where('id', $data['id']);
                $this->db->update(db_prefix().'ticket_replies', [
                    'message' => $data['data'],
                ]);
            } elseif ($data['type'] == 'ticket') {
                $this->db->where('ticketid', $data['id']);
                $this->db->update(db_prefix().'tickets', [
                    'message' => $data['data'],
                ]);
            }
            if ($this->db->affected_rows() > 0) {
                set_alert('success', _l('ticket_message_updated_successfully'));
            }
            redirect(admin_url('tickets/ticket/' . $data['main_ticket']));
        }
    }

    public function delete_ticket_reply($ticket_id, $reply_id)
    {
        if (!$reply_id) {
            redirect(admin_url('tickets'));
        }
        $response = $this->tickets_model->delete_ticket_reply($ticket_id, $reply_id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_reply')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_reply')));
        }
        redirect(admin_url('tickets/ticket/' . $ticket_id));
    }

    public function change_status_ajax($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->tickets_model->change_ticket_status($id, $status));
        }
    }

    public function update_single_ticket_settings()
    {
        if ($this->input->post()) {
            $this->session->mark_as_flash('active_tab');
            $this->session->mark_as_flash('active_tab_settings');
            $data = $this->input->post();
            if(isset($data['sub_category']) && $data['sub_category'] != ''){
                $data['service'] = $data['sub_category'];
                unset($data['sub_category']);
            }
            if(isset($data['sub_category']) && $data['sub_category'] == ''){
                unset($data['sub_category']);
            }
            
            $success = $this->tickets_model->update_single_ticket_settings($data);
            if ($success) {
                $this->session->set_flashdata('active_tab', true);
                $this->session->set_flashdata('active_tab_settings', true);
                if (get_option('staff_access_only_assigned_departments') == 1) {
                    $ticket = $this->tickets_model->get_ticket_by_id($this->input->post('ticketid'));
                    $this->load->model('departments_model');
                    $staff_departments = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                    if (!in_array($ticket->department, $staff_departments) && !is_admin()) {
                        set_alert('success', _l('ticket_settings_updated_successfully_and_reassigned', $ticket->department_name));
                        echo json_encode([
                            'success'               => $success,
                            'department_reassigned' => true,
                        ]);
                        die();
                    }
                }
                set_alert('success', _l('ticket_settings_updated_successfully'));
            } else {
                $success = 'Something went wrong, Ticket is not updated.';
            }
            echo json_encode([
                'success' => $success,
            ]);
            die();
        }
    }

    // Priorities
    /* Get all ticket priorities */
    public function priorities()
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        $data['priorities'] = $this->tickets_model->get_priority();
        $data['title']      = _l('ticket_priorities');
        $this->load->view('admin/tickets/priorities/manage', $data);
    }

    /* Add new priority od update existing*/
    public function priority()
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        if ($this->input->post()) {
            if (!$this->input->post('id')) {
                $id = $this->tickets_model->add_priority($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('ticket_priority')));
                }
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->tickets_model->update_priority($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('ticket_priority')));
                }
            }
            die;
        }
    }

    /* Delete ticket priority */
    public function delete_priority($id)
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        if (!$id) {
            redirect(admin_url('tickets/priorities'));
        }
        $response = $this->tickets_model->delete_priority($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('ticket_priority_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_priority')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_priority_lowercase')));
        }
        redirect(admin_url('tickets/priorities'));
    }

    /* List all ticket predefined replies */
    public function predefined_replies()
    {
        if (!is_admin()) {
            access_denied('Predefined Replies');
        }
        if ($this->input->is_ajax_request()) {
            $aColumns = [
                'name',
            ];
            $sIndexColumn = 'id';
            $sTable       = db_prefix().'tickets_predefined_replies';
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], [
                'id',
            ]);
            $output  = $result['output'];
            $rResult = $result['rResult'];
            foreach ($rResult as $aRow) {
                $row = [];
                for ($i = 0; $i < count($aColumns); $i++) {
                    $_data = $aRow[$aColumns[$i]];
                    if ($aColumns[$i] == 'name') {
                        $_data = '<a href="' . admin_url('tickets/predefined_reply/' . $aRow['id']) . '">' . $_data . '</a>';
                    }
                    $row[] = $_data;
                }
                $options            = icon_btn('tickets/predefined_reply/' . $aRow['id'], 'pencil-square-o');
                $row[]              = $options .= icon_btn('tickets/delete_predefined_reply/' . $aRow['id'], 'remove', 'btn-danger _delete');
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
            die();
        }
        $data['title'] = _l('predefined_replies');
        $this->load->view('admin/tickets/predefined_replies/manage', $data);
    }

    public function get_predefined_reply_ajax($id)
    {
        echo json_encode($this->tickets_model->get_predefined_reply($id));
    }

    public function ticket_change_data()
    {
        if ($this->input->is_ajax_request()) {
            $contact_id = $this->input->post('contact_id');
            echo json_encode([
                'contact_data'          => $this->clients_model->get_contact($contact_id),
                'customer_has_projects' => customer_has_projects(get_user_id_by_contact_id($contact_id)),
            ]);
        }
    }

    /* Add new reply or edit existing */
    public function predefined_reply($id = '')
    {
        if (!is_admin() && get_option('staff_members_save_tickets_predefined_replies') == '0') {
            access_denied('Predefined Reply');
        }
        if ($this->input->post()) {
            $data              = $this->input->post();
            $data['message']   = $this->input->post('message', false);
            $ticketAreaRequest = isset($data['ticket_area']);

            if (isset($data['ticket_area'])) {
                unset($data['ticket_area']);
            }

            if ($id == '') {
                $id = $this->tickets_model->add_predefined_reply($data);
                if (!$ticketAreaRequest) {
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('predefined_reply')));
                        redirect(admin_url('tickets/predefined_reply/' . $id));
                    }
                } else {
                    echo json_encode(['success' => $id ? true : false, 'id' => $id]);
                    die;
                }
            } else {
                $success = $this->tickets_model->update_predefined_reply($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('predefined_reply')));
                }
                redirect(admin_url('tickets/predefined_reply/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('predefined_reply_lowercase'));
        } else {
            $predefined_reply         = $this->tickets_model->get_predefined_reply($id);
            $data['predefined_reply'] = $predefined_reply;
            $title                    = _l('edit', _l('predefined_reply_lowercase')) . ' ' . $predefined_reply->name;
        }
        $data['title'] = $title;
        $this->load->view('admin/tickets/predefined_replies/reply', $data);
    }

    /* Delete ticket reply from database */
    public function delete_predefined_reply($id)
    {
        if (!is_admin()) {
            access_denied('Delete Predefined Reply');
        }
        if (!$id) {
            redirect(admin_url('tickets/predefined_replies'));
        }
        $response = $this->tickets_model->delete_predefined_reply($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('predefined_reply')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('predefined_reply_lowercase')));
        }
        redirect(admin_url('tickets/predefined_replies'));
    }

    // Ticket statuses
    /* Get all ticket statuses */
    public function statuses()
    {
        if (!is_admin()) {
            access_denied('Ticket Statuses');
        }
        $data['statuses'] = $this->tickets_model->get_ticket_status();
        $data['title']    = 'Ticket statuses';
        $this->load->view('admin/tickets/tickets_statuses/manage', $data);
    }

    /* Add new or edit existing status */
    public function status()
    {
        if (!is_admin()) {
            access_denied('Ticket Statuses');
        }
        if ($this->input->post()) {
            if (!$this->input->post('id')) {
                $id = $this->tickets_model->add_ticket_status($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('ticket_status')));
                }
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->tickets_model->update_ticket_status($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('ticket_status')));
                }
            }
            die;
        }
    }

    /* Delete ticket status from database */
    public function delete_ticket_status($id)
    {
        if (!is_admin()) {
            access_denied('Ticket Statuses');
        }
        if (!$id) {
            redirect(admin_url('tickets/statuses'));
        }
        $response = $this->tickets_model->delete_ticket_status($id);
        if (is_array($response) && isset($response['default'])) {
            set_alert('warning', _l('cant_delete_default', _l('ticket_status_lowercase')));
        } elseif (is_array($response) && isset($response['referenced'])) {
            set_alert('danger', _l('is_referenced', _l('ticket_status_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_status')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_status_lowercase')));
        }
        redirect(admin_url('tickets/statuses'));
    }

    /* List all ticket services */
    public function services()
    {
     
        if (!is_admin() && !is_manager()) {
            access_denied('Ticket Services');
        }
        /*********Start New Code For Ticket Services and sub services ********/
        if ($this->input->is_ajax_request()) {
            
            $aColumns = [
                db_prefix() . 'services.name as name',
                'IF('.db_prefix() .'services.parentid > 0, (SELECT name from tblservices as sub where sub.serviceid = tblservices.parentid), "Parent category") as parent_name',
                db_prefix() . 'departments.name as department_name',
                
            ];
            $join = [
                'LEFT JOIN ' . db_prefix() . 'departments ON ' . db_prefix() . 'departments.departmentid = ' . db_prefix() . 'services.departmentid',
                'LEFT JOIN ' . db_prefix() . 'services as b ON b.parentid = ' . db_prefix() . 'services.serviceid',
            ];


            $sIndexColumn = 'serviceid';
            $sTable       = db_prefix().'services';
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
                
                db_prefix() . 'services.serviceid',
                db_prefix() . 'services.departmentid',
                db_prefix() . 'services.parentid',
                
            ]);
            
            $output  = $result['output'];
            $rResult = $result['rResult'];
            foreach ($rResult as $aRow) {
                $row = [];
                for ($i = 0; $i < count($aColumns); $i++) {
                   // $_data = $aRow[$aColumns[$i]];
                    if($i == 1 ){
                      $_data = $aRow['parent_name'];  
                    }else{
                    if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
                        $_data = $aRow[strafter($aColumns[$i], 'as ')];
                    } else {
                        $_data = $aRow[$aColumns[$i]];
                    }
                    }
                    if ($aColumns[$i] == 'name') {
                        $_data = '<a href="#" onclick="edit_service(this,' . $aRow['serviceid'] . ');return false" data-name="' . $aRow['name'] . '">' . $_data . '</a>';
                    }
                    $row[] = $_data;
                }
                $options = icon_btn('#', 'pencil-square-o', 'btn-default', [
                    'data-name' => $aRow['name'],
                    'data-departmentid' => $aRow['departmentid'],
                    'data-parentid' => $aRow['parentid'],
                    'onclick'   => 'edit_service(this,' . $aRow['serviceid'] . '); return false;',
                ]);
                
                $row[]              = $options .= icon_btn('tickets/delete_service/' . $aRow['serviceid'], 'remove', 'btn-danger _delete');
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
            die();
        }
        $this->load->model('departments_model');
        $data['departments']        = $this->departments_model->get();
        $data['parent_services']        = $this->tickets_model->get_services_list();
        add_admin_tickets_js_assets();
        $data['title'] = _l('services');
        $this->load->view('admin/tickets/services/manage', $data);
        /*********End New Code For Ticket Services and sub services ********/
    }

    /* Add new service od delete existing one */
    public function service($id = '')
    {
        if (!is_admin() && get_option('staff_members_save_tickets_predefined_replies') == '0') {
            access_denied('Ticket Services');
        }

        if ($this->input->post()) {
            $post_data = $this->input->post();
            if (!$this->input->post('id')) {
                $requestFromTicketArea = isset($post_data['ticket_area']);
                if (isset($post_data['ticket_area'])) {
                    unset($post_data['ticket_area']);
                }
                
                $id = $this->tickets_model->add_service($post_data);
                if (!$requestFromTicketArea) {
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('service')));
                    }
                } else {
                    echo json_encode(['success' => $id ? true : false, 'parentid'=>$post_data['parentid'], 'id' => $id, 'name' => $post_data['name']]);
                }
            } else {
                $id = $post_data['id'];
                unset($post_data['id']);
                $success = $this->tickets_model->update_service($post_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('service')));
                }
            }
            die;
        }
    }

    /* Delete ticket service from database */
    public function delete_service($id)
    {
        if (!is_admin()) {
            access_denied('Ticket Services');
        }
        if (!$id) {
            redirect(admin_url('tickets/services'));
        }
        $response = $this->tickets_model->delete_service($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('service_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('service')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('service_lowercase')));
        }
        redirect(admin_url('tickets/services'));
    }

    public function block_sender()
    {
        if ($this->input->post()) {
            $this->load->model('spam_filters_model');
            $sender  = $this->input->post('sender');
            $success = $this->spam_filters_model->add(['type' => 'sender', 'value' => $sender], 'tickets');
            if ($success) {
                set_alert('success', _l('sender_blocked_successfully'));
            }
        }
    }

    public function bulk_action()
    {
        hooks()->do_action('before_do_bulk_action_for_tickets');
        if ($this->input->post()) {
            $total_deleted = 0;
            $ids           = $this->input->post('ids');
            $status        = $this->input->post('status');
            $department    = $this->input->post('department');
            /*** This is new code for Sub category **/
            $sub_service       = $this->input->post('sub_service');
            if($sub_service != ''){
                $service       = $sub_service;
            }else{
                $service       = $this->input->post('service');
            }
            /*** End This is new code for Sub category **/
            $priority      = $this->input->post('priority');
            $tags          = $this->input->post('tags');
            $is_admin      = is_admin();
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
                            $this->db->update(db_prefix().'tickets', [
                                'status' => $status,
                            ]);
                            if ($this->db->affected_rows() > 0) {
                                    $data_insert['ticket_id'] = $id;
                                    $data_insert['status_id'] = $status;
                                    $data_insert['user_id'] = get_staff_user_id();
                                    $data_insert['date'] = date('Y-m-d H:i:s');
                                    $data_insert['description'] = 'Status change of ticket id : '.$id.' New status set : '.$status;
                                    $this->db->insert(db_prefix() . 'tickets_activity_log',$data_insert);
                            }
                        }
                        if ($department) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
                                'department' => $department,
                            ]);
                        }
                        if ($priority) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
                                'priority' => $priority,
                            ]);
                        }

                        if ($service) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
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
    /* start new code  Add new Meter Number replece custome file to database entry */
    public function meter_number($id = '')
    {
        if ($this->input->post()) {
            $post_data = $this->input->post();
            if (!$this->input->post('id')) {
                $requestFromTicketArea = isset($post_data['ticket_area']);
                if (isset($post_data['ticket_area'])) {
                    unset($post_data['ticket_area']);
                }
                $record = $this->tickets_model->get_count_by_meter_number($post_data);
                if (!empty($record)) {
                   // set_alert('warning', _l('added_exited_record', _l('ticket_meter_number')));
                    echo json_encode(['success' => false, 'id' => $record->id, 'name' => $record->number,'msg'=>_l('added_exited_record', _l('ticket_meter_number'))]);
                } else {
                    $id = $this->tickets_model->add_meter_number($post_data);
                    if (!$requestFromTicketArea) {
                        if ($id) {
                            set_alert('success', _l('added_successfully', _l('ticket_meter_number')));
                        }
                    } else {
                        echo json_encode(['success' => $id ? true : false, 'id' => $id, 'name' => $post_data['number']]);
                    }
                }
            } else {
                $id = $post_data['id'];
                unset($post_data['id']);
                $success = $this->tickets_model->update_meter_number($post_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('ticket_meter_number')));
                }
            }
            die;
        }
    }
    /* End new code  Add new Meter Number replece custome file to database entry */
    /* Start new code  category list by department */
    public function get_category_list_by_department(){
        if ($this->input->post()) {
            $services  = $this->tickets_model->get_service_by_department_id($this->input->post('department_id'));
            if($this->input->post('service')){
                $dropdown = render_select('parentid', $services, array('serviceid', 'name'), 'ticket_settings_category', '', '');
            }else{
            $dropdown = render_select('service', $services, array('serviceid', 'name'), 'ticket_settings_category', '');
            }
            $data['status']=1;
            $data['result'] = $dropdown;
        }
        echo json_encode($data);
    }
    /* End new code  category list by department */
    public function get_category_list_by_department_bulk(){
        if ($this->input->post()) {
            $services  = $this->tickets_model->get_service_by_department_id($this->input->post('department_id'));
            
            $dropdown = render_select('move_to_service_tickets_bulk',$services,array('serviceid','name'),'Category');
            
            $data['status']=1;
            $data['result'] = $dropdown;
        }
        echo json_encode($data);
    }
    /* Start new code department by services */
    public function get_department_id_by_serviceid(){
        if ($this->input->post()) {
            $departments  = $this->tickets_model->get_department_data_by_service_id($this->input->post('serviceid'));
            $dropdown = render_select('departmentid', $departments, array('departmentid', 'name'), 'ticket_settings_departments', (count($departments) == 1) ? $departments[0]['departmentid'] : '', array('required' => 'true'));
            
            $data['status']=1;
            $data['result'] = $dropdown;
        }
        echo json_encode($data);
    }
    /* End new code  category list by department */
    /* Start new code for sub category by parent category */
    public function get_sub_category_by_service_id(){
        if ($this->input->post()) {
            $sub_category  = $this->tickets_model->get_sub_category_by_service_id($this->input->post('service_id'));
            $dropdown = render_select('sub_category', $sub_category, array('serviceid', 'name'), 'tickets_sub_category_name', (count($sub_category) == 1) ? $sub_category[0]['serviceid'] : '');
            $data['status']=1;
            $data['result'] = $dropdown;
        }
        echo json_encode($data);
    }
    /* End new code for sub category by parent category */
    /**** This is new code for email ticket */
    public function save_tickets_mail_data(){
        $success = false;
        $message = '';

        $this->db->where('ticketid', $this->input->post('ticketid'));
        $this->db->update(db_prefix().'tickets', [
                'content' => $this->input->post('content', false),
        ]);

        $success = $this->db->affected_rows() > 0;
        $message = _l('updated_successfully', _l('contract'));

        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }
    //this is new function for mail system to user
    public function send_to_email($id)
    {
        
        $success = $this->tickets_model->send_ticket_to_client($id, $this->input->post('attach_pdf'), $this->input->post('cc'));
        
        if ($success) {
            $tickets = $this->tickets_model->get($id);
            $data_ticket_replies['ticketid'] = $id;
            $data_ticket_replies['name'] = get_staff_full_name(get_staff_user_id());
            $data_ticket_replies['date'] = date('Y-m-d H:i:s');
            $data_ticket_replies['message'] = $tickets->content;
            $data_ticket_replies['admin'] = is_admin();
            $this->db->insert(db_prefix() . 'ticket_replies', $data_ticket_replies);
            
            $this->db->select('status');
            $this->db->where('ticketid', $id);
            $old_ticket_status = $this->db->get(db_prefix() . 'tickets')->row()->status;
            if($old_ticket_status == 5){
                $status = 5;
            }else{
                $status = 1;
            }
            $this->db->where('ticketid', $id);
            $this->db->update(db_prefix().'tickets', [
                    'content' => '',
                    'status'=> $status
            ]);
            
            set_alert('success', _l('ticket_sent_to_client_success'));
        } else {
            set_alert('danger', _l('ticket_sent_to_client_fail'));
        }
        redirect(admin_url('tickets/ticket/' . $id.'?tab=mail'));
    }
    //End of new function for mail system to user
}
