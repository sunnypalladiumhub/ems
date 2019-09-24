<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php set_ticket_open($ticket->adminread,$ticket->ticketid); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">
                  <div class="horizontal-scrollable-tabs">
                     <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                     <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                     <div class="horizontal-tabs">
                        <ul class="nav nav-tabs no-margin nav-tabs-horizontal" role="tablist">
                           <li role="presentation" class="<?php if(!$this->session->flashdata('active_tab')){echo 'active';} ?>">
                              <a href="#addreply" aria-controls="addreply" role="tab" data-toggle="tab">
                                 <?php echo _l('ticket_single_add_reply'); ?>
                              </a>
                           </li>
                           <li role="presentation">
                              <a href="#note" aria-controls="note" role="tab" data-toggle="tab">
                                 <?php echo _l('ticket_single_add_note'); ?>
                              </a>
                           </li>
                           <li role="presentation">
                              <a href="#tab_reminders" onclick="initDataTable('.table-reminders', admin_url + 'misc/get_reminders/' + <?php echo $ticket->ticketid ;?> + '/' + 'ticket', undefined, undefined, undefined,[1,'asc']); return false;" aria-controls="tab_reminders" role="tab" data-toggle="tab">
                                 <?php echo _l('ticket_reminders'); ?>
                                 <?php
                                 $total_reminders = total_rows(db_prefix().'reminders',
                                  array(
                                   'isnotified'=>0,
                                   'staff'=>get_staff_user_id(),
                                   'rel_type'=>'ticket',
                                   'rel_id'=>$ticket->ticketid
                                )
                               );
                                 if($total_reminders > 0){
                                  echo '<span class="badge">'.$total_reminders.'</span>';
                               }
                               ?>
                            </a>
                         </li>
                         <li role="presentation">
                           <a href="#othertickets" onclick="init_table_tickets(true);" aria-controls="othertickets" role="tab" data-toggle="tab">
                              <?php echo _l('ticket_single_other_user_tickets'); ?>
                           </a>
                        </li>
                        <li role="presentation">
                           <a href="#tasks" onclick="init_rel_tasks_table(<?php echo $ticket->ticketid; ?>,'ticket'); return false;" aria-controls="tasks" role="tab" data-toggle="tab">
                              <?php echo _l('tasks'); ?>
                           </a>
                        </li>
                        <li role="presentation" class="<?php if($this->session->flashdata('active_tab_settings')){echo 'active';} ?>">
                           <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">
                              <?php echo _l('ticket_single_settings'); ?>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel_s">
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-8">
                     <h3 class="mtop4 mbot20 pull-left">
                        <span id="ticket_subject">
                           #<?php echo $ticket->ticketid; ?> - <?php echo $ticket->subject; ?>
                        </span>
                        <?php if($ticket->project_id != 0){
                           echo '<br /><small>'._l('ticket_linked_to_project','<a href="'.admin_url('projects/view/'.$ticket->project_id).'">'.get_project_name_by_id($ticket->project_id).'</a>') .'</small>';
                        } ?>
                     </h3>
                     <?php echo '<div class="label mtop5 mbot15'.(is_mobile() ? ' ' : ' mleft15 ').'p8 pull-left single-ticket-status-label" style="background:'.$ticket->statuscolor.'">'.ticket_status_translate($ticket->ticketstatusid).'</div>'; ?>
                     <div class="clearfix"></div>
                  </div>
                  <div class="col-md-4 text-right">
                     <div class="row">
                        <div class="col-md-6 col-md-offset-6">
                           <?php echo render_select('status_top',$statuses,array('ticketstatusid','name'),'',$ticket->status,array(),array(),'no-mbot','',false); ?>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane <?php if(!$this->session->flashdata('active_tab')){echo 'active';} ?>" id="addreply">
                     <hr class="no-mtop" />
                     <?php $tags = get_tags_in($ticket->ticketid,'ticket'); ?>
                     <?php if(count($tags) > 0){ ?>
                        <div class="row">
                           <div class="col-md-12">
                              <?php echo '<b><i class="fa fa-tag" aria-hidden="true"></i> ' . _l('tags') . ':</b><br /><br /> ' . render_tags($tags); ?>
                              <hr />
                           </div>
                        </div>
                     <?php } ?>
                     <?php if(sizeof($ticket->ticket_notes) > 0){ ?>
                        <div class="row">
                           <div class="col-md-12 mbot15">
                              <h4 class="bold"><?php echo _l('ticket_single_private_staff_notes'); ?></h4>
                              <div class="ticketstaffnotes">
                                 <div class="table-responsive">
                                    <table>
                                       <tbody>
                                          <?php foreach($ticket->ticket_notes as $note){ ?>
                                             <tr>
                                                <td>
                                                   <span class="bold">
                                                      <?php echo staff_profile_image($note['addedfrom'],array('staff-profile-xs-image')); ?> <a href="<?php echo admin_url('staff/profile/'.$note['addedfrom']); ?>"><?php echo _l('ticket_single_ticket_note_by',get_staff_full_name($note['addedfrom'])); ?>
                                                   </a>
                                                </span>
                                                <?php
                                                if($note['addedfrom'] == get_staff_user_id() || is_admin()){ ?>
                                                   <div class="pull-right">
                                                      <a href="#" class="btn btn-default btn-icon" onclick="toggle_edit_note(<?php echo $note['id']; ?>);return false;"><i class="fa fa-pencil-square-o"></i></a>
                                                      <a href="<?php echo admin_url('misc/delete_note/'.$note["id"]); ?>" class="mright10 _delete btn btn-danger btn-icon">
                                                         <i class="fa fa-remove"></i>
                                                      </a>
                                                   </div>
                                                <?php } ?>
                                                <hr class="hr-10" />
                                                <div data-note-description="<?php echo $note['id']; ?>">
                                                   <?php echo check_for_links($note['description']); ?>
                                                </div>
                                                <div data-note-edit-textarea="<?php echo $note['id']; ?>" class="hide inline-block full-width">
                                                   <textarea name="description" class="form-control" rows="4"><?php echo clear_textarea_breaks($note['description']); ?></textarea>
                                                   <div class="text-right mtop15">
                                                      <button type="button" class="btn btn-default" onclick="toggle_edit_note(<?php echo $note['id']; ?>);return false;"><?php echo _l('cancel'); ?></button>
                                                      <button type="button" class="btn btn-info" onclick="edit_note(<?php echo $note['id']; ?>);"><?php echo _l('update_note'); ?></button>
                                                   </div>
                                                </div>
                                                <small class="bold">
                                                   <?php echo _l('ticket_single_note_added',_dt($note['dateadded'])); ?>
                                                </small>
                                             </td>
                                          </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php } ?>
                  <div>
                     <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'single-ticket-form','novalidate'=>true)); ?>
                     <a href="<?php echo admin_url('tickets/delete/'.$ticket->ticketid); ?>" class="btn btn-danger _delete btn-ticket-label mright5">
                        <i class="fa fa-remove"></i>
                     </a>
                     <?php if(!empty($ticket->priority_name)){ ?>
                        <span class="ticket-label label label-default inline-block">
                           <?php echo _l('ticket_single_priority',ticket_priority_translate($ticket->priorityid)); ?>
                        </span>
                     <?php } ?>
                     <?php if(!empty($ticket->service_name)){ ?>
                        <span class="ticket-label label label-default inline-block">
                           <?php echo _l('service'). ': ' . $ticket->service_name; ?>
                        </span>
                     <?php } ?>
                     <?php echo form_hidden('ticketid',$ticket->ticketid); ?>
                     <span class="ticket-label label label-default inline-block">
                        <?php echo _l('department') . ': '. $ticket->department_name; ?>
                     </span>
                     <?php if($ticket->assigned != 0){ ?>
                        <span class="ticket-label label label-info inline-block">
                           <?php echo _l('ticket_assigned'); ?>: <?php echo get_staff_full_name($ticket->assigned); ?>
                        </span>
                     <?php } ?>
                     <?php if($ticket->lastreply !== NULL){ ?>
                        <span class="ticket-label label label-success inline-block" data-toggle="tooltip" title="<?php echo _dt($ticket->lastreply); ?>">
                           <span class="text-has-action">
                              <?php echo _l('ticket_single_last_reply',time_ago($ticket->lastreply)); ?>
                           </span>
                        </span>
                     <?php } ?>
                     <div class="mtop15">
                        <?php
                        $use_knowledge_base = get_option('use_knowledge_base');
                        ?>
                        <div class="row mbot15">
                           <div class="col-md-6">
                              <select data-width="100%" id="insert_predefined_reply" data-live-search="true" class="selectpicker" data-title="<?php echo _l('ticket_single_insert_predefined_reply'); ?>">
                                 <?php foreach($predefined_replies as $predefined_reply){ ?>
                                    <option value="<?php echo $predefined_reply['id']; ?>"><?php echo $predefined_reply['name']; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <?php if($use_knowledge_base == 1){ ?>
                              <div class="visible-xs">
                                 <div class="mtop15"></div>
                              </div>
                              <div class="col-md-6">
                                 <?php $groups = get_all_knowledge_base_articles_grouped(); ?>
                                 <select data-width="100%" id="insert_knowledge_base_link" class="selectpicker" data-live-search="true" onchange="insert_ticket_knowledgebase_link(this);" data-title="<?php echo _l('ticket_single_insert_knowledge_base_link'); ?>">
                                    <option value=""></option>
                                    <?php foreach($groups as $group){ ?>
                                       <?php if(count($group['articles']) > 0){ ?>
                                          <optgroup label="<?php echo $group['name']; ?>">
                                             <?php foreach($group['articles'] as $article) { ?>
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
                        <?php echo render_textarea('message','','',array(),array(),'','tinymce'); ?>
                     </div>
                     <div class="panel_s ticket-reply-tools">
                        <div class="btn-bottom-toolbar text-right">
                           <button type="submit" class="btn btn-info" data-form="#single-ticket-form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>">
                              <?php echo _l('ticket_single_add_response'); ?>
                           </button>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-5">
                                 <?php echo render_select('status',$statuses,array('ticketstatusid','name'),'ticket_single_change_status',get_option('default_ticket_reply_status'),array(),array(),'','',false); ?>
                                 <?php echo render_input('cc','CC'); ?>
                                 <?php if($ticket->assigned !== get_staff_user_id()){ ?>
                                    <div class="checkbox">
                                       <input type="checkbox" name="assign_to_current_user" id="assign_to_current_user">
                                       <label for="assign_to_current_user"><?php echo _l('ticket_single_assign_to_me_on_update'); ?></label>
                                    </div>
                                 <?php } ?>
                                 <div class="checkbox">
                                    <input type="checkbox" <?php echo hooks()->apply_filters('ticket_add_response_and_back_to_list_default','checked'); ?> name="ticket_add_response_and_back_to_list" value="1" id="ticket_add_response_and_back_to_list">
                                    <label for="ticket_add_response_and_back_to_list"><?php echo _l('ticket_add_response_and_back_to_list'); ?></label>
                                 </div>
                              </div>
                           </div>
                           <hr />
                           <div class="row attachments">
                              <div class="attachment">
                                 <div class="col-md-5 mbot15">
                                    <div class="form-group">
                                       <label for="attachment" class="control-label">
                                          <?php echo _l('ticket_single_attachments'); ?>
                                       </label>
                                       <div class="input-group">
                                          <input type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                          <span class="input-group-btn">
                                             <button class="btn btn-success add_more_attachments p8-half" data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>" type="button"><i class="fa fa-plus"></i></button>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php echo form_close(); ?>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="note">
                  <hr class="no-mtop" />
                  <div class="form-group">
                     <label for="note_description"><?php echo _l('ticket_single_note_heading'); ?></label>
                     <textarea class="form-control" name="note_description" rows="5"></textarea>
                  </div>
                  <a class="btn btn-info pull-right add_note_ticket"><?php echo _l('ticket_single_add_note'); ?></a>
               </div>
               <div role="tabpanel" class="tab-pane" id="tab_reminders">
                  <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target=".reminder-modal-ticket-<?php echo $ticket->ticketid; ?>"><i class="fa fa-bell-o"></i> <?php echo _l('ticket_set_reminder_title'); ?></a>
                  <hr />
                  <?php render_datatable(array( _l( 'reminder_description'), _l( 'reminder_date'), _l( 'reminder_staff'), _l( 'reminder_is_notified')), 'reminders'); ?>
               </div>
               <div role="tabpanel" class="tab-pane" id="othertickets">
                  <hr class="no-mtop" />
                  <div class="_filters _hidden_inputs hidden tickets_filters">
                     <?php echo form_hidden('filters_ticket_id',$ticket->ticketid); ?>
                     <?php echo form_hidden('filters_email',$ticket->email); ?>
                     <?php echo form_hidden('filters_userid',$ticket->userid); ?>
                  </div>
                  <?php echo AdminTicketsTableStructure(); ?>
               </div>
               <div role="tabpanel" class="tab-pane" id="tasks">
                  <hr class="no-mtop" />
                  <?php init_relation_tasks_table(array('data-new-rel-id'=>$ticket->ticketid,'data-new-rel-type'=>'ticket')); ?>
               </div>
               <div role="tabpanel" class="tab-pane <?php if($this->session->flashdata('active_tab_settings')){echo 'active';} ?>" id="settings">
                  <hr class="no-mtop" />
                  <div class="row">
                     <div class="col-md-6">
                         <?php echo render_select('department',$departments,array('departmentid','name'),'ticket_settings_departments',$ticket->department); ?>
                         <?php echo render_select('group_id', $company_groups, array('id', 'name'), 'ticket_drp_grp_type',$ticket->group_id ); ?>
                         <?php echo render_select('company_id', $company_name, array('userid', 'company'), 'ticket_drp_company_name', $ticket->company_id); ?>
                        <?php if($ticket->userid > 0 ){ ?>
                         <div class="form-group select-placeholder">
                           <label for="contactid" class="control-label"><?php echo _l('contact'); ?></label>
                           <select name="contactid" id="contactid" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"<?php if(!empty($ticket->from_name) && !empty($ticket->ticket_email)){echo ' data-no-contact="true"';} else {echo ' data-ticket-emails="'.$ticket->ticket_emails.'"';} ?>>
                              <?php
                              $rel_data = get_relation_data('contact',$ticket->contactid);
                              $rel_val = get_relation_values($rel_data,'contact');
                              echo '<option value="'.$rel_val['id'].'" selected data-subtext="'.$rel_val['subtext'].'">'.$rel_val['name'].'</option>';
                              ?>
                           </select>
                           <?php echo form_hidden('userid',$ticket->userid); ?>
                        </div>
                        <?php }else{ ?>
                            <div class="row">
                                    <div class="col-md-6">
                                        <?php echo render_input('name', 'ticket_settings_to', $ticket->from_name, 'text', array('disabled' => true)); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo render_input('email', 'ticket_settings_email',  $ticket->ticket_email, 'email', array('disabled' => true)); ?>
                                    </div>
                                </div>

                       <?php } ?>
                        <?php echo render_input('subject','ticket_settings_subject',$ticket->subject); ?>
                        
                        
                      
                   </div>
                   <div class="col-md-6">
                     <div class="form-group mbot20">
                        <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                        <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo prep_tags_input(get_tags_in($ticket->ticketid,'ticket')); ?>" data-role="tagsinput">
                     </div>
                    <?php
                    if(is_admin() || get_option('staff_members_create_inline_ticket_services') == '1'){
                        echo render_select_with_input_group('service',$services,array('serviceid','name'),'ticket_settings_service',$ticket->service,'<a href="#" onclick="new_service();return false;"><i class="fa fa-plus"></i></a>');
                     } else {
                        echo render_select('service',$services,array('serviceid','name'),'ticket_settings_service',$ticket->service);
                     }
                    ?>
                       <?php
                                    echo render_select_with_input_group('meter_number', $meter_number, array('id', 'number'), 'ticket_meter_number',$ticket->meter_number, '<a href="#" onclick="new_meter_number();return false;"><i class="fa fa-plus"></i></a>');
                                ?>
                                
                       <?php // echo render_custom_fields('meter_number',$ticket->ticketid); ?>
                       <div class="row">
                            <div class="col-md-6">
                                <?php echo render_select('channel_type_id', $channel_type, array('id', 'name'), 'ticket_drp_channel_type',$ticket->channel_type_id); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                           $priorities['callback_translate'] = 'ticket_priority_translate';
                           echo render_select('priority',$priorities,array('priorityid','name'),'ticket_settings_priority',$ticket->priority); ?>
                            </div>
                        </div>

                     <div class="form-group select-placeholder">
                        <label for="assigned" class="control-label">
                           <?php echo _l('ticket_settings_assign_to'); ?>
                        </label>
                        <select name="assigned" data-live-search="true" id="assigned" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                           <option value=""><?php echo _l('ticket_settings_none_assigned'); ?></option>
                           <?php foreach($staff as $member){
                              if($member['active'] == 0 && $ticket->assigned != $member['staffid']) {
                                 continue;
                              }
                              ?>
                              <option value="<?php echo $member['staffid']; ?>" <?php if($ticket->assigned == $member['staffid']){echo 'selected';} ?>>
                                 <?php echo $member['firstname'] . ' ' . $member['lastname'] ; ?>
                              </option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <?php //echo render_custom_fields('tickets_des',$ticket->ticketid); ?>
                      <?php echo render_textarea('description','Description',$ticket->description,array(),array(),'',''); ?>
                  </div>
               </div>
                  <div class="panel_s mtop20">
                 <div class="panel-body" style="padding: 0;">
                     <div class="row"  style="margin: 0;">
                         <div id="accordion">
                             <div class="card">
                                 <div class="card-header" id="headingTwo">
                                     <h5 class="m-0" style="margin: 0;background: #f7f9fa;">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#CustomerContact" aria-expanded="false" aria-controls="collapseTwo">
                                             <h3 class="mtop4 mbot20 pull-left"><?php echo _l('ticket_customer_contact_info'); ?></h3>
                                         </button>
                                     </h5>
                                 </div>
                                 <div id="CustomerContact" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="padding: 3%;">
                                     <?php if ($ticket->userid == 0) { ?>
                                         <div class="card-body">
                                             <div class="row">
                                                <div class="col-md-6">
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                 <?php echo render_input('name', 'ticket_contact_name', $ticket->from_name, 'text'); ?>
                                                             </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                <?php echo render_input('surname', 'ticket_contact_surname', $ticket->surname, 'text'); ?>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                <?php echo render_input('landline', 'ticket_contact_landline', $ticket->landline, 'number'); ?>
                                                                 
                                                             </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                 <?php echo render_input('mobile', 'ticket_contact_mobile', $ticket->mobile, 'number'); ?>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-12">
                                                             <div class="form-group">
                                                                <?php echo render_input('email', 'ticket_contact_email', $ticket->ticket_email, 'email'); ?>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                 <?php echo render_input('contact_id', 'ticket_contact_id', $ticket->contact_id, 'text'); ?>
                                                                 
                                                             </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                 <?php echo render_input('passport', 'ticket_contact_passport', $ticket->passport, 'text'); ?>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                     <?php echo render_input('alternativecontact_name', 'ticket_contact_alt_name', $ticket->alternativecontact_name, 'text'); ?>
                                                                 
                                                             </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                     <?php echo render_input('alternativecontact_number', 'ticket_contact_alt_number', $ticket->alternativecontact_number, 'text'); ?>
                                                                 
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-12">
                                                             <div class="form-group">
                                                                     <?php echo render_input('booking_date', 'ticket_contact_booking_date', $ticket->booking_date, 'text'); ?>
                                                                 
                                                             </div>
                                                         </div>
<!--                                                         <div class="col-md-6">
                                                             <div class="form-group">
                                                                 <label for="attachment" class="control-label">
                                                                     <?php // echo _l('ticket_contact_mobile'); ?>
                                                                 </label>
                                                                 <input type="text" class="form-control" id="ticket_contact_name" name="ticket_contact_name" value="">
                                                             </div>
                                                         </div>-->
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="row">
                                                         <div class="col-md-12">
                                                             <div class="form-group">
                                                                 <?php echo render_input('primary_address', 'ticket_contact_primary_address', $ticket->primary_address, 'text'); ?>
                                                                 
                                                             </div>
                                                             <div class="form-group">
                                                                 <?php echo render_input('alternative_address', 'ticket_contact_alt_address', $ticket->alternative_address, 'text'); ?>
                                                                 
                                                             </div>
                                                             <div class="form-group">
                                                                 <?php echo render_input('city', 'ticket_contact_city', $ticket->city, 'text'); ?>
                                                                 
                                                             </div>
                                                             <div class="form-group">
                                                                 <?php echo render_input('province', 'ticket_contact_province', $ticket->province, 'text'); ?>
                                                                 
                                                                 
                                                             </div>
                                                             <div class="form-group">
                                                                 <?php echo render_input('postal_code', 'ticket_contact_post_code', $ticket->postal_code, 'number'); ?>
                                                             </div>
                                                             <div class="form-group">
                                                                  <?php echo render_input('country', 'ticket_contact_country', $ticket->country, 'text'); ?>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="panel_s mtop20" id="paycity" <?php echo strtolower($ticket->department_name) != 'paycity' ? "style='display:none;'" : ''; ?>>
                 <div class="panel-body" style="padding: 0;">
                     <div class="row" style="margin: 0;">
                         <div id="accordion">
                             <div class="card">
                                 <div class="card-header" id="headingTwo">
                                     <h5 class="mb-0"  style="margin: 0;background: #f7f9fa;">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#payCitySection" aria-expanded="false" aria-controls="collapseTwo">
                                             <h3 class="mtop4 mbot20 pull-left"><?php echo _l('ticket_contact_paycity_title'); ?></h3>
                                         </button>
                                     </h5>
                                 </div>
                                 <div id="payCitySection" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="padding: 3%;">
                                     <div class="card-body">

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     <div class="col-md-12">
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_local_fines'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_notice_number'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_bill_payments'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_paycity_consumer'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     <div class="col-md-12">
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_infringements'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_local_bill'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_paycity_business'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
                                                         </div>
                                                         <div class="form-group">
                                                             <label for="attachment" class="control-label">
                                                                 <?php echo _l('ticket_contact_payment_options'); ?>
                                                             </label>
                                                             <input type="text" class="form-control" id="" name="" value="">
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
                 </div>
             </div>
             
             <div class="panel_s mtop20" id="networks" <?php echo strtolower($ticket->department_name) != 'networks' ? "style='display:none;'" : ''; ?>>
                 <div class="panel-body" style="padding: 0;">
                     <div class="row" style="margin: 0;">
                         <div id="accordion">
                             <div class="card">
                                 <div class="card-header" id="headingTwo">
                                     <h5 class="mb-0"  style="margin: 0;background: #f7f9fa;">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#networksSection" aria-expanded="false" aria-controls="collapseTwo">
                                             <h3 class="mtop4 mbot20 pull-left"><?php echo _l('ticket_contact_networks_title'); ?></h3>
                                         </button>
                                     </h5>
                                 </div>
                                 <div id="networksSection" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="padding: 3%;">
                                     <div class="card-body">

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     
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
             <div class="panel_s mtop20" id="road_safety" <?php echo strtolower($ticket->department_name) != 'road safety' ? "style='display:none;'" : ''; ?>>
                 <div class="panel-body" style="padding: 0;">
                     <div class="row" style="margin: 0;">
                         <div id="accordion">
                             <div class="card">
                                 <div class="card-header" id="headingTwo">
                                     <h5 class="mb-0"  style="margin: 0;background: #f7f9fa;">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#road_safetySection" aria-expanded="false" aria-controls="collapseTwo">
                                             <h3 class="mtop4 mbot20 pull-left"><?php echo _l('ticket_contact_road_safety_title'); ?></h3>
                                         </button>
                                     </h5>
                                 </div>
                                 <div id="road_safetySection" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="padding: 3%;">
                                     <div class="card-body">

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     
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
             <div class="panel_s mtop20" id="traffic" <?php echo strtolower($ticket->department_name) != 'traffic' ? "style='display:none;'" : ''; ?>>
                 <div class="panel-body" style="padding: 0;">
                     <div class="row" style="margin: 0;">
                         <div id="accordion">
                             <div class="card">
                                 <div class="card-header" id="headingTwo">
                                     <h5 class="mb-0"  style="margin: 0;background: #f7f9fa;">
                                         <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#trafficSection" aria-expanded="false" aria-controls="collapseTwo">
                                             <h3 class="mtop4 mbot20 pull-left"><?php echo _l('ticket_contact_traffic_title'); ?></h3>
                                         </button>
                                     </h5>
                                 </div>
                                 <div id="trafficSection" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="padding: 3%;">
                                     <div class="card-body">

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="row">
                                                     
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
               <div class="row">
                  <div class="col-md-12 text-center">
                     <hr />
                     <a href="#" class="btn btn-info save_changes_settings_single_ticket">
                        <?php echo _l('submit'); ?>
                     </a>
                  </div>
               </div>
                  
                  
                  
            </div>
         </div>
      </div>
   </div>
             
   <div class="panel_s mtop20">
      <div class="panel-body <?php if($ticket->admin == NULL){echo 'client-reply';} ?>">
         <div class="row">
            <div class="col-md-3 border-right ticket-submitter-info ticket-submitter-info">
               <p>
                  <?php if($ticket->admin == NULL || $ticket->admin == 0){ ?>
                     <?php if($ticket->userid != 0){ ?>
                        <a href="<?php echo admin_url('clients/client/'.$ticket->userid.'?contactid='.$ticket->contactid); ?>"
                           ><?php echo $ticket->submitter; ?>
                        </a>
                     <?php } else {
                        echo $ticket->submitter;
                        ?>
                        <br />
                        <a href="mailto:<?php echo $ticket->ticket_email; ?>"><?php echo $ticket->ticket_email; ?></a>
                        <hr />
                        <?php
                        if(total_rows(db_prefix().'spam_filters',array('type'=>'sender','value'=>$ticket->ticket_email,'rel_type'=>'tickets')) == 0){ ?>
                         <button type="button" data-sender="<?php echo $ticket->ticket_email; ?>" class="btn btn-danger block-sender btn-xs">     <?php echo _l('block_sender'); ?>
                      </button>
                      <?php
                   } else {
                      echo '<span class="label label-danger">'._l('sender_blocked').'</span>';
                   }
                }
             } else {  ?>
               <a href="<?php echo admin_url('profile/'.$ticket->admin); ?>"><?php echo $ticket->opened_by; ?></a>
            <?php } ?>
         </p>
         <p class="text-muted">
            <?php if($ticket->admin !== NULL || $ticket->admin != 0){
               echo _l('ticket_staff_string');
            } else {
               if($ticket->userid != 0){
                echo _l('ticket_client_string');
             }
          }
          ?>
       </p>
       <?php if(has_permission('tasks','','create')){ ?>
         <a href="#" class="btn btn-default btn-xs" onclick="convert_ticket_to_task(<?php echo $ticket->ticketid; ?>,'ticket'); return false;"><?php echo _l('convert_to_task'); ?></a>
      <?php } ?>
   </div>
   <div class="col-md-9">
      <div class="row">
         <div class="col-md-12 text-right">
            <?php if(!empty($ticket->message)) { ?>
               <a href="#" onclick="print_ticket_message(<?php echo $ticket->ticketid; ?>, 'ticket'); return false;" class="mright5"><i class="fa fa-print"></i></a>
            <?php } ?>
            <a href="#" onclick="edit_ticket_message(<?php echo $ticket->ticketid; ?>,'ticket'); return false;"><i class="fa fa-pencil-square-o"></i></a>
         </div>
      </div>
      <div data-ticket-id="<?php echo $ticket->ticketid; ?>" class="tc-content">
         <?php echo check_for_links($ticket->message); ?>
      </div>
      <?php if(count($ticket->attachments) > 0){
         echo '<hr />';
         foreach($ticket->attachments as $attachment){

          $path = get_upload_path_by_type('ticket').$ticket->ticketid.'/'.$attachment['file_name'];
          $is_image = is_image($path);

          if($is_image){
           echo '<div class="preview_image">';
        }
        ?>
        <a href="<?php echo site_url('download/file/ticket/'. $attachment['id']); ?>" class="display-block mbot5"<?php if($is_image){ ?> data-lightbox="attachment-ticket-<?php echo $ticket->ticketid; ?>" <?php } ?>>
         <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i> <?php echo $attachment['file_name']; ?>
         <?php if($is_image){ ?>
            <img class="mtop5" src="<?php echo site_url('download/preview_image?path='.protected_file_url_by_path($path).'&type='.$attachment['filetype']); ?>">
         <?php } ?>
      </a>
      <?php if($is_image){
         echo '</div>';
      }
      if(is_admin() || (!is_admin() && get_option('allow_non_admin_staff_to_delete_ticket_attachments') == '1')){
         echo '<a href="'.admin_url('tickets/delete_attachment/'.$attachment['id']).'" class="text-danger _delete">'._l('delete').'</a>';
      }
      echo '<hr />';
      ?>
   <?php }
} ?>
</div>
</div>
</div>
<div class="panel-footer">
   <?php echo _l('ticket_posted',_dt($ticket->date)); ?>
</div>
</div>
<?php foreach($ticket_replies as $reply){ ?>
   <div class="panel_s">
      <div class="panel-body <?php if($reply['admin'] == NULL){echo 'client-reply';} ?>">
         <div class="row">
            <div class="col-md-3 border-right ticket-submitter-info">
               <p>
                  <?php if($reply['admin'] == NULL || $reply['admin'] == 0){ ?>
                     <?php if($reply['userid'] != 0){ ?>
                        <a href="<?php echo admin_url('clients/client/'.$reply['userid'].'?contactid='.$reply['contactid']); ?>"><?php echo $reply['submitter']; ?></a>
                     <?php } else { ?>
                        <?php echo $reply['submitter']; ?>
                        <br />
                        <a href="mailto:<?php echo $reply['reply_email']; ?>"><?php echo $reply['reply_email']; ?></a>
                     <?php } ?>
                  <?php }  else { ?>
                     <a href="<?php echo admin_url('profile/'.$reply['admin']); ?>"><?php echo $reply['submitter']; ?></a>
                  <?php } ?>
               </p>
               <p class="text-muted">
                  <?php if($reply['admin'] !== NULL || $reply['admin'] != 0){
                     echo _l('ticket_staff_string');
                  } else {
                     if($reply['userid'] != 0){
                      echo _l('ticket_client_string');
                   }
                }
                ?>
             </p>
             <hr />
             <a href="<?php echo admin_url('tickets/delete_ticket_reply/'.$ticket->ticketid .'/'.$reply['id']); ?>" class="btn btn-danger pull-left _delete mright5 btn-xs"><?php echo _l('delete_ticket_reply'); ?></a>
             <div class="clearfix"></div>
             <?php if(has_permission('tasks','','create')){ ?>
               <a href="#" class="pull-left btn btn-default mtop5 btn-xs" onclick="convert_ticket_to_task(<?php echo $reply['id']; ?>,'reply'); return false;"><?php echo _l('convert_to_task'); ?>
            </a>
            <div class="clearfix"></div>
         <?php } ?>
      </div>
      <div class="col-md-9">
         <div class="row">
            <div class="col-md-12 text-right">
               <?php if(!empty($reply['message'])) { ?>
                  <a href="#" onclick="print_ticket_message(<?php echo $reply['id']; ?>, 'reply'); return false;" class="mright5"><i class="fa fa-print"></i></a>
               <?php } ?>
               <a href="#" onclick="edit_ticket_message(<?php echo $reply['id']; ?>,'reply'); return false;"><i class="fa fa-pencil-square-o"></i></a>
            </div>
         </div>
         <div class="clearfix"></div>
         <div data-reply-id="<?php echo $reply['id']; ?>" class="tc-content">
            <?php echo check_for_links($reply['message']); ?>
         </div>
         <?php if(count($reply['attachments']) > 0){
            echo '<hr />';
            foreach($reply['attachments'] as $attachment){
             $path = get_upload_path_by_type('ticket').$ticket->ticketid.'/'.$attachment['file_name'];
             $is_image = is_image($path);

             if($is_image){
              echo '<div class="preview_image">';
           }
           ?>
           <a href="<?php echo site_url('download/file/ticket/'. $attachment['id']); ?>" class="display-block mbot5"<?php if($is_image){ ?> data-lightbox="attachment-reply-<?php echo $reply['id']; ?>" <?php } ?>>
            <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i> <?php echo $attachment['file_name']; ?>
            <?php if($is_image){ ?>
               <img class="mtop5" src="<?php echo site_url('download/preview_image?path='.protected_file_url_by_path($path).'&type='.$attachment['filetype']); ?>">
            <?php } ?>
         </a>
         <?php if($is_image){
            echo '</div>';
         }
         if(is_admin() || (!is_admin() && get_option('allow_non_admin_staff_to_delete_ticket_attachments') == '1')){
            echo '<a href="'.admin_url('tickets/delete_attachment/'.$attachment['id']).'" class="text-danger _delete">'._l('delete').'</a>';
         }
         echo '<hr />';
      }
   } ?>
</div>
</div>
</div>
<div class="panel-footer">
   <span><?php echo _l('ticket_posted',_dt($reply['date'])); ?></span>
</div>
</div>
<?php } ?>
</div>
</div>
<div class="btn-bottom-pusher"></div>
<?php if(count($ticket_replies) > 1){ ?>
   <a href="#top" id="toplink">↑</a>
   <a href="#bot" id="botlink">↓</a>
<?php } ?>
</div>
</div>
<!-- The reminders modal -->
<?php $this->load->view('admin/includes/modals/reminder',array(
   'id'=>$ticket->ticketid,
   'name'=>'ticket',
   'members'=>$staff,
   'reminder_title'=>_l('ticket_set_reminder_title'))
); ?>
<!-- Edit Ticket Messsage Modal -->
<div class="modal fade" id="ticket-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <?php echo form_open(admin_url('tickets/edit_message')); ?>
      <div class="modal-content">
         <div id="edit-ticket-message-additional"></div>
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo _l('ticket_message_edit'); ?></h4>
         </div>
         <div class="modal-body">
            <?php echo render_textarea('data','','',array(),array(),'','tinymce-ticket-edit'); ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
         </div>
      </div>
      <?php echo form_close(); ?>
   </div>
</div>
<script>
   var _ticket_message;
</script>
<?php $this->load->view('admin/tickets/services/service'); ?>
<?php $this->load->view('admin/tickets/meter_number/service'); ?>
<?php init_tail(); ?>
<?php hooks()->do_action('ticket_admin_single_page_loaded',$ticket); ?>
<script>
   $(function(){
       $('#booking_date').datetimepicker({
        });
       $('#department').on('change',function (){
          var value = $('#department :selected').text(); 
          show_selected_department(value);
       });
      $('#single-ticket-form').appFormValidator();
      init_ajax_search('contact','#contactid.ajax-search',{tickets_contacts:true});
      init_ajax_search('project', 'select[name="project_id"]', {
         customer_id: function() {
            return $('input[name="userid"]').val();
         }
      });
      $('body').on('shown.bs.modal', '#_task_modal', function() {
         if(typeof(_ticket_message) != 'undefined') {
            // Init the task description editor
            if(!is_mobile()){
              $(this).find('#description').click();
           } else {
            $(this).find('#description').focus();
         }
         setTimeout(function(){
            tinymce.get('description').execCommand('mceInsertContent', false, _ticket_message);
            $('#_task_modal input[name="name"]').val($('#ticket_subject').text().trim());
         },100);
      }
   });
   });


   var Ticket_message_editor;
   var edit_ticket_message_additional = $('#edit-ticket-message-additional');

   function edit_ticket_message(id, type){
      edit_ticket_message_additional.empty();
      // type is either ticket or reply
      _ticket_message = $('[data-'+type+'-id="'+id+'"]').html();
      init_ticket_edit_editor();
      tinyMCE.activeEditor.setContent(_ticket_message);
      $('#ticket-message').modal('show');
      edit_ticket_message_additional.append(hidden_input('type',type));
      edit_ticket_message_additional.append(hidden_input('id',id));
      edit_ticket_message_additional.append(hidden_input('main_ticket',$('input[name="ticketid"]').val()));
   }
   function show_selected_department(string){
       var text = string.toLowerCase();
       if(text == 'paycity'){
           $('#paycity').show();
       }else{
           $('#paycity').hide();
       }
       if(text == 'networks'){
           $('#networks').show();
       }else{
           $('#networks').hide();
       }
       if(text == 'road safety'){
           $('#road_safety').show();
       }else{
           $('#road_safety').hide();
       }
       if(text == 'traffic'){
           $('#traffic').show();
       }else{
           $('#traffic').hide();
       }
   }

   function init_ticket_edit_editor(){
      if(typeof(Ticket_message_editor) !== 'undefined'){
         return true;
      }
      Ticket_message_editor = init_editor('.tinymce-ticket-edit');
   }
   <?php if(has_permission('tasks','','create')){ ?>
      function convert_ticket_to_task(id, type){
         if(type == 'ticket'){
            _ticket_message = $('[data-ticket-id="'+id+'"]').html();
         } else {
            _ticket_message = $('[data-reply-id="'+id+'"]').html();
         }
         var new_task_url = admin_url + 'tasks/task?rel_id=<?php echo $ticket->ticketid; ?>&rel_type=ticket&ticket_to_task=true';
         new_task(new_task_url);
      }
   <?php } ?>

</script>
</body>
</html>
