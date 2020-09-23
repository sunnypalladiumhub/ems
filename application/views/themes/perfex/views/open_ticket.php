<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open_multipart('clients/open_ticket',array('id'=>'open-new-ticket-form')); ?>
<div class="row">
   <div class="col-md-12">

      <?php hooks()->do_action('before_client_open_ticket_form_start'); ?>

      <div class="panel_s">
         <div class="panel-heading text-uppercase open-ticket-subject">
            <?php echo _l('clients_ticket_open_subject'); ?>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-12">
                   <div class="col-md-12">
                  <div class="form-group open-ticket-subject-group">
                     <label for="subject"><?php echo _l('customer_ticket_subject'); ?></label>
                     <input type="text" class="form-control" name="subject" id="subject" value="<?php echo set_value('subject'); ?>">
                     <?php echo form_error('subject'); ?>
                  </div>
                       </div>
                  <?php if(total_rows(db_prefix().'projects',array('clientid'=>get_client_user_id())) > 0 && has_contact_permission('projects')){ ?>
                  <div class="form-group open-ticket-project-group">
                     <label for="project_id"><?php echo _l('project'); ?></label>
                     <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" name="project_id" id="project_id" class="form-control selectpicker">
                        <option value=""></option>
                        <?php foreach($projects as $project){ ?>
                        <option value="<?php echo $project['id']; ?>" <?php echo set_select('project_id',$project['id']); ?><?php if($this->input->get('project_id') == $project['id']){echo ' selected';} ?>><?php echo $project['name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <?php } ?>
                  <!--<div class="row">-->
                      <?php
                      if(get_client_user_id() == RECHARGER_CUSTOMER){ ?>
                        <input type="hidden" value="<?php echo RECHARGER_DEPARTMENT ?>" id="department" name="department">
                          <?php 
                      }else{
                      ?>
                     <div class="col-md-6">
                        <div class="form-group open-ticket-department-group">
                           <label for="department"><?php echo _l('clients_ticket_open_departments'); ?></label>
                           <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" name="department" id="department" class="form-control selectpicker">
                              <option value=""></option>
                              <?php foreach($departments as $department){ ?>
                              <option value="<?php echo $department['departmentid']; ?>" <?php echo set_select('department',$department['departmentid'],(count($departments) == 1 ? true : false)); ?>>
                                 <?php echo $department['name']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <?php echo form_error('department'); ?>
                        </div>
                     </div>
                      <?php } ?>
                     <div class="col-md-6">
                        <div class="form-group open-ticket-priority-group">
                           <label for="priority"><?php echo _l('clients_ticket_open_priority'); ?></label>
                           <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" name="priority" id="priority" class="form-control selectpicker">
                              <option value=""></option>
                              <?php foreach($priorities as $priority){ ?>
                              <option value="<?php echo $priority['priorityid']; ?>" <?php echo set_select('priority', $priority['priorityid'], hooks()->apply_filters('new_ticket_priority_selected', 2) == $priority['priorityid']); ?>>
                                    <?php echo ticket_priority_translate($priority['priorityid']); ?>
                                 </option>
                              <?php } ?>
                           </select>
                           <?php echo form_error('priority'); ?>
                        </div>
                     </div>
                  <!--</div>-->
                   <?php
                      if(get_client_user_id() == RECHARGER_CUSTOMER){ ?>
                        <!--<input type="hidden" value="<?php //echo RECHARGER_DEPARTMENT ?>" id="service" name="service">-->
                   <!--<div class="row">-->
                     <div class="col-md-6">
                           <div id="service_div">
                                       <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                          <label for="service" class="control-label">
                                             <small class="req text-danger">* </small>Category</label>
                                          <select id="service" name="service" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                             <option value=""></option>
                                          </select>
                                       </div>                                      
                                 </div>
                     </div>
                        <div class="col-md-6">
                           <div id="sub_service_div">
                                 <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                       <label for="sub_category" class="control-label">
                                          <small class="req text-danger">* </small><?php echo _l('tickets_sub_category_name'); ?></label>
                                       <select id="sub_category" name="sub_category" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                          <option value=""></option>
                                       </select>
                                 </div>                                      
                              </div>
                        </div>
                     <!--</div>-->
                                
                          <?php 
                      }else{
                      ?>
                        <?php
                        if(get_option('services') == 1 && count($services) > 0){ ?>
                     <div class="col-md-12">
                         <div id="service_div">
                                       <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                          <label for="service" class="control-label">
                                             <small class="req text-danger">* </small>Category</label>
                                          <select id="service" name="service" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                             <option value=""></option>
                                          </select>
                                       </div>                                      
                                 </div>
<!--                        <div class="form-group open-ticket-service-group">
                           <label for="service"><?php echo _l('clients_ticket_open_service'); ?></label>
                           <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" name="service" id="service" class="form-control selectpicker">
                              <option value=""></option>
                              <?php foreach($services as $service){ ?>
                              <option value="<?php echo $service['serviceid']; ?>" <?php echo set_select('service',$service['serviceid'],(count($services) == 1 ? true : false)); ?>><?php echo $service['name']; ?></option>
                              <?php } ?>
                           </select>
                        </div>-->
                         </div>
                        <?php } ?>
                      <?php } ?>
                   <!--<div class="row">-->
                       <div class="col-md-6">
                           <!-- Start new Code For Meter number -->                                
                            <div id="meter_number_msg"></div>
                            <div id="meter_number_div">
                            <?php

                                echo render_select('meter_number', $meter_number, array('id', 'number'), 'ticket_meter_number', '');
                            ?>
                            </div>
                            <div id="notice_number_div" style="display: none;">
                                <?php echo render_input('notice_number', 'notice_number_ticket', '', 'text'); ?>
                            </div>
                            <!-- End new Code For Meter number -->                                
                       </div>
                       <div class="col-md-6">
                            <?php echo render_select('channel_type_id', $channel_type, array('id', 'name'), 'ticket_drp_channel_type', (count($channel_type) == 1) ? $channel_type[0]['id'] : '', array('required' => 'true')); ?>
                        </div>
                   <!--</div>-->
<!--                   <div class="row">-->
                       <div class="col-md-12">
                           <?php echo render_textarea('description', 'Description', '', array(), array(), '', ''); ?>
                       </div>
<!--                   </div>-->
                   
                  <div class="custom-fields">
                     <?php //echo render_custom_fields('tickets','',array('show_on_client_portal'=>1)); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-12">
      <div class="panel_s">
         <div class="panel-body">
            <div class="form-group open-ticket-message-group">
               <label for=""><?php echo _l('clients_ticket_open_body'); ?></label>
               <textarea name="message" id="message" class="form-control" rows="15"><?php echo set_value('message'); ?></textarea>
            </div>
         </div>
         <div class="panel-footer attachments_area open-ticket-attachments-area">
            <div class="row attachments">
               <div class="attachment">
                  <div class="col-md-6 col-md-offset-3">
                     <div class="form-group">
                        <label for="attachment" class="control-label"><?php echo _l('clients_ticket_attachments'); ?></label>
                        <div class="input-group">
                           <input type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
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
   <div class="col-md-12 text-center mtop20">
      <button type="submit" class="btn btn-info" data-form="#open-new-ticket-form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
   </div>
</div>
<?php echo form_close(); ?>
<script>
   $(function(){
//       $('#department').on('change',function (){
//            var department_id = $(this).val();
//            if(department_id == <?php echo NETWORKS; ?> ){
//                $('#meter_number_div').show();
//                $('#notice_number_div').hide();
//            }else{
//                $('#meter_number_div').hide();
//                $('#notice_number_div').show();
//                var groupmeter_number = $('select#meter_number');
//                groupmeter_number.selectpicker('val','');
//            }
//        })

   $('#department').on('change',function (){
            $('#sub_service_div').html('<div class="select-placeholder form-group" app-field-wrapper="company_id"><label for="sub_category" class="control-label">Sub Category Name</label><select id="sub_category" name="sub_category" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true"><option value=""></option></select></div>');
            var groupsub = $('select#sub_category');
            groupsub.selectpicker('refresh');
            var department_id = $(this).val();
            var department_text = $( "#department option:selected" ).text();
            if(department_id == <?php echo NETWORKS; ?> ){
                $('#meter_number_div').show();
                $('#notice_number_div').hide();
            }else{
                $('#meter_number_div').hide();
                $('#notice_number_div').show();
                var groupmeter_number = $('select#meter_number');
                groupmeter_number.selectpicker('val','');
            }
            
            $.ajax({
                url: site_url  + 'clients/get_category_list_by_department',
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
   });
</script>
<?php 
if(get_client_user_id() == RECHARGER_CUSTOMER){ ?>
<script>
   $(function(){
      var channel_type = $('select[name="channel_type_id"]');
      channel_type.val('<?php echo RECHARGER_PORTAL ?>');
      channel_type.selectpicker('refresh');
      $('select[name="channel_type_id').parent().parent('.form-group').css('display','none');
      
      get_category(<?php echo RECHARGER_DEPARTMENT; ?>);
        $('#meter_number_div').hide();    
        $('#notice_number_div').show();
        var groupmeter_number = $('select#meter_number');
        groupmeter_number.selectpicker('val','');
     });
     
     function get_category(department_id){
      $.ajax({
                url: site_url + 'clients/get_category_list_by_department',
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
     }
     $('body').on('change','#service',function (){
            var service_id = $(this).val();
            
            $.ajax({
                url: site_url + 'clients/get_sub_category_by_service_id',
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
</script>
<?php 
} ?>

