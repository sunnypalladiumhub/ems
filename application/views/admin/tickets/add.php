<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'new_ticket_form')); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-6">

                                <?php if (!isset($project_id) && !isset($contact)) { ?>
                                    <a href="#" id="ticket_no_contact"><span class="label label-default">
                                            <i class="fa fa-envelope"></i> <?php echo _l('ticket_create_no_contact'); ?>
                                        </span>
                                    </a>
                                    <a href="#" class="hide" id="ticket_to_contact"><span class="label label-default">
                                            <i class="fa fa-user-o"></i> <?php echo _l('ticket_create_to_contact'); ?>
                                        </span>
                                    </a>
                                    <div class="mbot1" style="margin-bottom: 55px;"></div>
                                <?php } ?>

                                <?php echo render_select('department', $departments, array('departmentid', 'name'), 'ticket_settings_departments', (count($departments) == 1) ? $departments[0]['departmentid'] : '', array('required' => 'true')); ?>
                                <!-- Start new Code For System -->                                
                                <?php echo render_select('group_id', $company_groups, array('id', 'name'), 'ticket_drp_grp_type', (count($company_groups) == 1) ? $company_groups[0]['id'] : '', array('required' => 'true')); ?>
                                <!-- End new Code For System -->                                
<!--                                    <div class="form-group select-placeholder">
                                    <label for="contactid"><?php echo _l('ticket_drp_company_name'); ?></label>
                                    <select name="company_id" required="true" id="company_id" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php if (isset($company_name)) { ?>
                                            <option value="<?php echo $company_name['userid']; ?>" selected><?php echo $company_name['company'] ; ?></option>
                                        <?php } ?>
                                        <option value=""></option>
                                    </select>
                                   
                                </div>-->
                                <!-- Start new Code For Company -->                                
                                <div id="company_id_div">
                                    <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                        <label for="company_id" class="control-label">Company Name</label>
                                        <select id="company_id" name="company_id" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                            <option value=""></option>
                                            <option value="<?php echo UNASSIGNED; ?>">Unassigned</option>
                                        </select>
                                    </div>                                      
                                </div>
                                <!-- End new Code For Company -->                                
                                <?php //echo render_select('company_id', $company_name, array('userid', 'company'), 'ticket_drp_company_name', (count($company_name) == 1) ? $company_name[0]['userid'] : '', array('required' => 'true')); ?>

                                <div class="form-group select-placeholder" id="ticket_contact_w">
                                    <label for="contactid"><?php echo _l('contact'); ?></label>
                                    <select name="contactid" required="true" id="contactid" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php if (isset($contact)) { ?>
                                            <option value="<?php echo $contact['id']; ?>" selected><?php echo $contact['firstname'] . ' ' . $contact['lastname']; ?></option>
                                        <?php } ?>
                                        <option value=""></option>
                                    </select>
                                    <?php echo form_hidden('userid'); ?>
                                </div>

                                <?php echo render_input('subject', 'ticket_settings_subject', '', 'text', array('required' => 'true')); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                                    <input type="text" class="tagsinput" id="tags" name="tags" data-role="tagsinput">
                                </div>
                                <!-- Start new Code For Category and sub category -->                                
                                <div id="service_div">
                                    <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                        <label for="service" class="control-label">Category</label>
                                        <select id="service" name="service" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                            <option value=""></option>
                                        </select>
                                    </div>                                      
                                </div>
                                <div id="sub_service_div">
                                    <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                        <label for="sub_category" class="control-label"><?php echo _l('tickets_sub_category_name'); ?></label>
                                        <select id="sub_category" name="sub_category" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                            <option value=""></option>
                                        </select>
                                    </div>                                      
                                </div>
                                <!-- End new Code For Category and sub category -->                                
                                <?php
                                if (is_admin() || get_option('staff_members_create_inline_ticket_services') == '1') {
                                   // echo render_select_with_input_group('service', $services, array('serviceid', 'name'), 'ticket_settings_category', '', '<a href="#" onclick="new_service();return false;"><i class="fa fa-plus"></i></a>');
                                } else {
                                   // echo render_select('service', $services, array('serviceid', 'name'), 'ticket_settings_category');
                                }
                                ?>
                                <!-- Start new Code For Meter number -->                                
                                <div id="meter_number_msg"></div>
                                <div id="meter_number_div">
                                <?php
                                
                                    echo render_select_with_input_group('meter_number', $meter_number, array('id', 'number'), 'ticket_meter_number', '', '<a href="#" onclick="new_meter_number();return false;"><i class="fa fa-plus"></i></a>');
                                ?>
                                </div>
                                <div id="notice_number_div" style="display: none;">
                                    <?php echo render_input('notice_number', 'notice_number_ticket', '', 'text'); ?>
                                </div>
                                <!-- End new Code For Meter number -->                                
                                <?php //echo render_custom_fields('meter_number'); ?>
                                <?php //echo render_custom_fields('channel_type'); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo render_select('channel_type_id', $channel_type, array('id', 'name'), 'ticket_drp_channel_type', (count($channel_type) == 1) ? $channel_type[0]['id'] : '', array('required' => 'true')); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php $priorities['callback_translate'] = 'ticket_priority_translate';
                                                echo render_select('priority', $priorities, array('priorityid','name'), 'ticket_settings_priority', hooks()->apply_filters('new_ticket_priority_selected', 1), array('required'=>'true')); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo render_input('name', 'ticket_settings_to_new', '', 'text', array('disabled' => true)); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo render_input('email', 'ticket_settings_email', '', 'email', array('disabled' => true)); ?>
                                    </div>
                                </div>

                                <div class="form-group select-placeholder">
                                    <label for="assigned" class="control-label">
                                        <?php echo _l('ticket_settings_assign_to'); ?>
                                    </label>
                                    <select name="assigned" id="assigned" class="form-control selectpicker" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" data-width="100%">
                                        <option value=""><?php echo _l('ticket_settings_none_assigned'); ?></option>
                                        <?php foreach ($staff as $member) { ?>
                                            <option value="<?php echo $member['staffid']; ?>" <?php
                                            if ($member['staffid'] == get_staff_user_id()) {
                                                echo 'selected';
                                            }
                                            ?>>
                                                        <?php echo $member['firstname'] . ' ' . $member['lastname']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                                <!-- Start new Code For Message -->                                
                            <div class="col-md-12">
                                <?php// echo render_custom_fields('tickets_des'); ?>
                                <?php echo render_textarea('description','Description','',array(),array(),'',''); ?>
                            </div>
                            <!-- End new Code For Message -->                                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel_s">
                            <div class="panel-heading" style="font-size: 2em;">
                                <?php echo _l('ticket_add_body'); ?>
                            </div>
                            <div class="panel-body">
                                <div class="btn-bottom-toolbar text-right">
                                    <button type="submit" data-form="#new_ticket_form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info"><?php echo _l('open_ticket'); ?></button>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mbot20 before-ticket-message">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select id="insert_predefined_reply" data-width="100%" data-live-search="true" class="selectpicker" data-title="<?php echo _l('ticket_single_insert_predefined_reply'); ?>">
                                                    <?php foreach ($predefined_replies as $predefined_reply) { ?>
                                                        <option value="<?php echo $predefined_reply['id']; ?>"><?php echo $predefined_reply['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php if (get_option('use_knowledge_base') == 1) { ?>
                                                <div class="visible-xs">
                                                    <div class="mtop15"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php $groups = get_all_knowledge_base_articles_grouped(); ?>
                                                    <select id="insert_knowledge_base_link" data-width="100%" class="selectpicker" data-live-search="true" onchange="insert_ticket_knowledgebase_link(this);" data-title="<?php echo _l('ticket_single_insert_knowledge_base_link'); ?>">
                                                        <option value=""></option>
                                                        <?php foreach ($groups as $group) { ?>
                                                            <?php if (count($group['articles']) > 0) { ?>
                                                                <optgroup label="<?php echo $group['name']; ?>">
                                                                    <?php foreach ($group['articles'] as $article) { ?>
                                                                        <option value="<?php echo $article['articleid']; ?>">
                                                                            <?php echo $article['subject']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </optgroup>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>


                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php echo render_textarea('message', '', '', array(), array(), '', 'tinymce'); ?>
                            </div>
                            <div class="panel-footer attachments_area">
                                <div class="row attachments">
                                    <div class="attachment">
                                        <div class="col-md-4 col-md-offset-4 mbot15">
                                            <div class="form-group">
                                                <label for="attachment" class="control-label"><?php echo _l('ticket_add_attachments'); ?></label>
                                                <div class="input-group">
                                                    <input type="file" extension="<?php echo str_replace('.', '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success add_more_attachments p8-half" data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>" type="button"><i class="fa fa-plus"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <?php $this->load->view('admin/tickets/services/service'); ?>
    <?php $this->load->view('admin/tickets/meter_number/service'); ?>
    <?php init_tail(); ?>
    <?php hooks()->do_action('new_ticket_admin_page_loaded'); ?>
        <!-- Start new Code -->                                
    <script>
        $(function () {
            $('#meter_number_div').hide();
$('body').on('change','#company_id',function (){
    var contactid = $(this).val();
            init_ajax_search('contact', '#contactid.ajax-search', {
                tickets_contacts: true,
                contact_userid: contactid
                   
            });
            validate_new_ticket_form();

<?php if (isset($project_id) || isset($contact)) { ?>
                $('body.ticket select[name="contactid"]').change();
<?php } ?>

<?php if (isset($project_id)) { ?>
                $('body').on('selected.cleared.ajax.bootstrap.select', 'select[data-auto-project="true"]', function (e) {
                    $('input[name="userid"]').val('');
                    $(this).parents('.projects-wrapper').addClass('hide');
                    $(this).prop('disabled', false);
                    $(this).removeAttr('data-auto-project');
                    $('body.ticket select[name="contactid"]').change();
                });
<?php } ?>
          
     });
     
     
$('#group_id').on('change',function (){
    var group_id = $(this).val();
    
            $.ajax({
                url: admin_url + 'tickets/get_contact_list_by_group',
                type: 'POST',
                data: {group_id: group_id},
                success: function (data) {
                    var data = $.parseJSON(data);
                    if (data.status == 1) {
                        $('#company_id_div').html(data.result);
                        var group = $('select#company_id');
                        group.selectpicker('refresh');
                    }
                }

            });

        
        });
        $('#department').on('change',function (){
            $('#sub_service_div').html('<div class="select-placeholder form-group" app-field-wrapper="company_id"><label for="sub_category" class="control-label">Sub Category Name</label><select id="sub_category" name="sub_category" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true"><option value=""></option></select></div>');
            var groupsub = $('select#sub_category');
            groupsub.selectpicker('refresh');
            var department_id = $(this).val();
            var department_text = $( "#department option:selected" ).text();
            if(department_text.toLowerCase() == 'networks' || department_text.toLowerCase() == 'network'){
                $('#meter_number_div').show();
                $('#notice_number_div').hide();
            }else{
                $('#meter_number_div').hide();
                $('#notice_number_div').show();
                var groupmeter_number = $('select#meter_number');
                groupmeter_number.selectpicker('val','');
            }
            
            $.ajax({
                url: admin_url + 'tickets/get_category_list_by_department',
                type: 'POST',
                data: {department_id: department_id},
                success: function (data) {
                    var data = $.parseJSON(data);
                    if (data.status == 1) {
                        $('#service_div').html(data.result);
                        var group = $('select#service');
                        group.selectpicker('refresh');
                    }
                }

            });

        
        });
        
        $('body').on('change','#service',function (){
            var service_id = $(this).val();
            
            $.ajax({
                url: admin_url + 'tickets/get_sub_category_by_service_id',
                type: 'POST',
                data: {service_id: service_id},
                success: function (data) {
                    var data = $.parseJSON(data);
                    if (data.status == 1) {
                        $('#sub_service_div').html(data.result);
                        var group = $('select#sub_category');
                        group.selectpicker('refresh');
                    }
                }

            });

        
        });
});
     
      
         
    </script>
    <!-- End new Code -->                                
</body>
</html>
