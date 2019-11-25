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
                              <?php echo _l('ticket_single_settings_new'); ?>
                           </a>
                        </li>
                        <li role="presentation">
                           <a href="#mail" aria-controls="mail" role="tab" data-toggle="tab">
                              Mail
                           </a>
                        </li>
                        <!-- Start new Code For Calculation  Ticket AGE -->                                
                        <?php
                        

                        $now = time(); // or your date as well
                        $your_date = strtotime($ticket->date);
                        $datediff = $now - $your_date;

                        $day = round($datediff / (60 * 60 * 24));


                        ?>
                        <p style="float: right;position: absolute;right: 25px;top: 30px;font-size: large;color: #82c426;">Ticket AGE : <?php echo $day; ?> Days</p>
                        <!-- End new Code For Calculation Ticket AGE -->                                
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
                         <div id="company_id_div">
                             <?php echo render_select('company_id', $company_name, array('userid', 'company'), 'ticket_drp_company_name', $ticket->company_id); ?>
                         </div>
                         
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
                                        <?php echo render_input('name', 'ticket_settings_to_new', $ticket->from_name, 'text', array('disabled' => true)); ?>
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
                       <!-- Start new code for service and sub service list -->
                       <div id="service_div">
                    <?php
                    if(is_admin() || get_option('staff_members_create_inline_ticket_services') == '1'){
                        echo render_select('service',$services,array('serviceid','name'),'ticket_settings_category', isset($service_detals->service_id) ? $service_detals->service_id : '');
                     } else {
                        echo render_select('service',$services,array('serviceid','name'),'ticket_settings_category',$service_detals->service_id);
                     }
                    ?>
                           </div>
                       <div id="sub_service_div">
                           <?php echo render_select('sub_category',$sub_category,array('serviceid','name'),'tickets_sub_category_name', isset($service_detals->sub_category) ? $service_detals->sub_category : ''); ?>
                       </div>
                       <!-- Start new code for service and sub service list -->
                       <!-- Start new code for Meter number -->
                       <div id="meter_number_msg"></div>
                       <div id="meter_number_div">
                       <?php
                                    echo render_select_with_input_group('meter_number', $meter_number, array('id', 'number'), 'ticket_meter_number',$ticket->meter_number, '<a href="#" onclick="new_meter_number();return false;"><i class="fa fa-plus"></i></a>');
                                ?>
                                </div>
                        <div id="notice_number_div" style="display: none;">
                            <?php echo render_input('notice_number', 'notice_number_ticket', $ticket->notice_number, 'text'); ?>
                        </div>
                       <!-- End new code for Meter number -->
                       <?php // echo render_custom_fields('meter_number',$ticket->ticketid); ?>
                       <div class="row">
                            <div class="col-md-6">
                                <!-- Start new code for channel type -->
                                <?php echo render_select('channel_type_id', $channel_type, array('id', 'name'), 'ticket_drp_channel_type',$ticket->channel_type_id); ?>
                                <!-- Start new code for channel type -->
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
                      <!-- Start new code for description -->
                     <?php //echo render_custom_fields('tickets_des',$ticket->ticketid); ?>
                      <?php echo render_textarea('description','Description',$ticket->description,array(),array(),'',''); ?>
                      <!-- End new code for description -->
                  </div>
               </div>
                  <!-- Start new code for Sub Tab pannel for customer and other -->
                  
                  <div class="panel-group" role="tablist" aria-multiselectable="false">
                      <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingclickatell">
                              <h4 class="panel-title">
                                  <a role="button" data-toggle="collapse"  href="#CustomerContact" aria-expanded="false" aria-controls="sms_clickatell" class="collapsed">
                                      <?php echo _l('ticket_customer_contact_info'); ?> <span class="pull-right"><i class="fa fa-sort-down"></i></span>
                                  </a>
                              </h4>
                          </div>
                          <div id="CustomerContact" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingclickatell" aria-expanded="false" style="height: 0px;">
                              <div class="panel-body no-br-tlr no-border-color">

                                  <?php if ($ticket->userid == 0) { ?>
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <div class="form-group">
                                                              <?php echo render_input('name', 'ticket_settings_to_new', $ticket->from_name .''. $ticket->surname, 'text'); ?>
                                                          </div>
                                                      </div>
<!--                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <?php //echo render_input('surname', 'ticket_contact_surname', $ticket->surname, 'text'); ?>
                                                          </div>
                                                      </div>-->
                                                  </div>
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <?php echo render_input('landline', 'ticket_contact_landline', $ticket->landline, 'number',array('onkeypress'=>'return isNumberKey(event)')); ?>

                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <?php echo render_input('mobile', 'ticket_contact_mobile', $ticket->mobile, 'number',array('onkeypress'=>'return isNumberKey(event)')); ?>
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
                                                              <?php echo render_input('postal_code', 'ticket_contact_post_code', $ticket->postal_code, 'number',array('onkeypress'=>'return isNumberKey(event)')); ?>
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
                      
                      <div class="panel panel-default" id="networks" <?php echo strtolower($ticket->department_name) != 'networks' ? "style='display:none;'" : ''; ?>>
                          <div class="panel-heading" role="tab" id="headingmsg92">
                              <h4 class="panel-title">
                                  <a role="button" data-toggle="collapse" href="#networksSection" aria-expanded="false" aria-controls="sms_msg91" class="collapsed">
                                      <?php echo _l('ticket_contact_networks_title'); ?> <span class="pull-right"><i class="fa fa-sort-down"></i></span>
                                  </a>
                              </h4>
                          </div>
                          <div id="networksSection" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingmsg92" aria-expanded="false">
                              <div class="panel-body no-br-tlr no-border-color">
                                  <div class="card-body">
                                      <div class="horizontal-scrollable-tabs">
                                          <div class="horizontal-tabs">
                                              <ul class="nav nav-tabs no-margin nav-tabs-horizontal" role="tablist">
                                                  <li role="presentation" class="active">
                                                      <a href="#meter_details_tab" aria-controls="meter_details_tab" role="tab" data-toggle="tab" aria-expanded="false">
                                                         Meter details        </a>
                                                  </li>
                                                  <li role="presentation">
                                                      <a href="#terminals_tab" aria-controls="terminals_tab" role="tab" data-toggle="tab">
                                                          Terminals           </a>
                                                  </li>
                                              </ul>
                                          </div>
                                      </div>
                                      <div class="tab-content">
                                          <div role="tabpanel" class="tab-pane active" id="meter_details_tab">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <h3>Meter details</h3>
                                                      <hr>

                                                      <div class="row">
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <input type="hidden" id="meter_section[id]" name="meter_section[id]" value="<?php echo isset($meter) ? $meter->id : '' ?>" >
                                                                  <?php echo render_input('meter_section[number]', 'meter_section_number', isset($meter) ? $meter->number : '', 'text'); ?>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_type" class="control-label"><?php echo _l('meter_section_type'); ?></label>
                                                                      <select id="meter_section_type" name="meter_section[type]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="Electricity" <?php echo isset($meter) && $meter->type == 'Electricity' ? 'selected' : '' ?>>Electricity</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <!--<div class="form-group">-->
                                                              <?php //echo render_input('meter_section[time_stamp]', 'meter_section_time_stamp', '', 'text'); ?>
                                                              <!--                                                      </div>-->
                                                              <div class="form-group" app-field-wrapper="meter_section[time_stamp]">
                                                                  <label for="meter_section[time_stamp]" class="control-label">TimeStamp</label>
                                                                  <input type="text" id="meter_section_time_stamp" name="meter_section[time_stamp]" class="form-control" value="<?php echo isset($meter) ? $meter->time_stamp : '' ?>">
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_machine" class="control-label"><?php echo _l('meter_section_machine'); ?></label>
                                                                      <select id="meter_section_machine" name="meter_section[machine_id]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->machine_id == '1' ? 'selected' : '' ?>>1</option>
                                                                          <option value="2" <?php echo isset($meter) && $meter->machine_id == '2' ? 'selected' : '' ?>>2</option>
                                                                          <option value="3" <?php echo isset($meter) && $meter->machine_id == '3' ? 'selected' : '' ?>>3</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_building_type" class="control-label"><?php echo _l('meter_section_building_type'); ?></label>
                                                                      <select id="meter_section_building_type" name="meter_section[building_type]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="residential" <?php echo isset($meter) && $meter->building_type == 'residential' ? 'selected' : '' ?>>Residential</option>
                                                                          <option value="commercial" <?php echo isset($meter) && $meter->building_type == 'commercial' ? 'selected' : '' ?>>Commercial</option>
                                                                          <option value="industrial" <?php echo isset($meter) && $meter->building_type == 'industrial' ? 'selected' : '' ?>>Industrial</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_meter_accessible" class="control-label"><?php echo _l('meter_section_meter_accessible'); ?></label>
                                                                      <select id="meter_section_meter_accessible" name="meter_section[meter_accessible]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->meter_accessible == '1' ? 'selected' : '' ?>>Yes</option>
                                                                          <option value="0" <?php echo isset($meter) && $meter->meter_accessible == '0' ? 'selected' : '' ?>>No</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_meter_location" class="control-label"><?php echo _l('meter_section_meter_location'); ?></label>
                                                                      <select id="meter_section_meter_location" name="meter_section[meter_location]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="inside" <?php echo isset($meter) && $meter->meter_location == 'inside' ? 'selected' : '' ?>>Inside</option>
                                                                          <option value="outside" <?php echo isset($meter) && $meter->meter_location == 'outside' ? 'selected' : '' ?>>Outside</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_meter_serial_number" class="control-label"><?php echo _l('meter_section_meter_serial_number'); ?></label>
                                                                      <select id="meter_section_meter_serial_number" name="meter_section[meter_serial_number]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>

                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_seals_on_arrival" class="control-label"><?php echo _l('meter_section_seals_on_arrival'); ?></label>
                                                                      <select id="meter_section_seals_on_arrival" name="meter_section[seals_on_arrival]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->seals_on_arrival == '1' ? 'selected' : '' ?>>Yes</option>
                                                                          <option value="0" <?php echo isset($meter) && $meter->seals_on_arrival == '0' ? 'selected' : '' ?>>No</option>

                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_meter_type" class="control-label"><?php echo _l('meter_section_meter_type'); ?></label>
                                                                      <select id="meter_section_meter_type" name="meter_section[meter_type]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="prepaid" <?php echo isset($meter) && $meter->meter_type == 'prepaid' ? 'selected' : '' ?>>Prepaid</option>
                                                                          <option value="postpaid" <?php echo isset($meter) && $meter->meter_type == 'postpaid' ? 'selected' : '' ?>>Postpaid</option>
                                                                      </select>
                                                                  </div>
                                                              </div>

                                                          </div>




                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_meter_manufacturer" class="control-label"><?php echo _l('meter_section_meter_manufacturer'); ?></label>
                                                                      <select id="meter_section_meter_manufacturer" name="meter_section[meter_manufacturer]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="E Kard" <?php echo isset($meter) && $meter->meter_manufacturer == 'E Kard' ? 'selected' : '' ?>>E Kard</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <?php echo render_input('meter_section[meter_reading]', 'meter_section_meter_reading', isset($meter) ? $meter->meter_reading : '', 'text'); ?>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_phase" class="control-label"><?php echo _l('meter_section_phase'); ?></label>
                                                                      <select id="meter_section_phase" name="meter_section[phase]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->phase == '1' ? 'selected' : '' ?>>1 Phase</option>
                                                                          <option value="2" <?php echo isset($meter) && $meter->phase == '2' ? 'selected' : '' ?>>2 Phase</option>
                                                                          <option value="3" <?php echo isset($meter) && $meter->phase == '3' ? 'selected' : '' ?>>3 Phase</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_trip_test_done" class="control-label"><?php echo _l('meter_section_trip_test_done'); ?></label>
                                                                      <select id="meter_section_trip_test_done" name="meter_section[trip_test_done]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->trip_test_done == '1' ? 'selected' : '' ?>>Yes</option>
                                                                          <option value="2" <?php echo isset($meter) && $meter->trip_test_done == '2' ? 'selected' : '' ?>>No</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_trip_test_results" class="control-label"><?php echo _l('meter_section_trip_test_results'); ?></label>
                                                                      <select id="meter_section_trip_test_results" name="meter_section[trip_test_results]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->trip_test_results == '1' ? 'selected' : '' ?>>Successful</option>
                                                                          <option value="0" <?php echo isset($meter) && $meter->trip_test_results == '0' ? 'selected' : '' ?>>Cancel</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_meter_condition" class="control-label"><?php echo _l('meter_section_meter_condition'); ?></label>
                                                                      <select id="meter_section_meter_condition" name="meter_section[meter_condition]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="2" <?php echo isset($meter) && $meter->meter_condition == '2' ? 'selected' : '' ?>>Good</option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->meter_condition == '1' ? 'selected' : '' ?>>Average</option>
                                                                          <option value="0" <?php echo isset($meter) && $meter->meter_condition == '0' ? 'selected' : '' ?>>Bad</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_other_illegal_connection" class="control-label"><?php echo _l('meter_section_other_illegal_connection'); ?></label>
                                                                      <select id="meter_section_other_illegal_connection" name="meter_section[other_illegal_connection]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="0" <?php echo isset($meter) && $meter->other_illegal_connection == '0' ? 'selected' : '' ?>>No</option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->other_illegal_connection == '1' ? 'selected' : '' ?>>Yes</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_sgc_number" class="control-label"><?php echo _l('meter_section_sgc_number'); ?></label>
                                                                      <select id="meter_section_sgc_number" name="meter_section[sgc_number]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="402" <?php echo isset($meter) && $meter->sgc_number == '402' ? 'selected' : '' ?>>402</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_new_seals_fitted" class="control-label"><?php echo _l('meter_section_new_seals_fitted'); ?></label>
                                                                      <select id="meter_section_new_seals_fitted" name="meter_section[new_seals_fitted]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="1" <?php echo isset($meter) && $meter->new_seals_fitted == '1' ? 'selected' : '' ?>>Yes</option>
                                                                          <option value="0" <?php echo isset($meter) && $meter->new_seals_fitted == '0' ? 'selected' : '' ?>>No</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group">
                                                                  <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                                                      <label for="meter_section_new_seal_numbers" class="control-label"><?php echo _l('meter_section_new_seal_numbers'); ?></label>
                                                                      <select id="meter_section_new_seal_numbers" name="meter_section[new_seal_numbers]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                                                          <option value=""></option>
                                                                          <option value="MQ0032978" <?php echo isset($meter) && $meter->new_seal_numbers == 'MQ0032978' ? 'selected' : '' ?>>MQ0032978</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>


                                                      </div>
                                                  </div>

                                              </div>
                                          </div>
                                          <div role="tabpanel" class="tab-pane" id="terminals_tab">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <h3>Terminals</h3>
                                                      <hr>

                                                      
                                                  </div>

                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                      </div>
                          
                      <div class="panel panel-default" id="paycity" <?php echo strtolower($ticket->department_name) != 'paycity' ? "style='display:none;'" : ''; ?>>
                          <div class="panel-heading" role="tab">
                              <h4 class="panel-title">
                                  <a role="button" data-toggle="collapse" href="#payCitySection" aria-expanded="false" aria-controls="sms_msg91" class="collapsed">
                                      <?php echo _l('ticket_contact_paycity_title'); ?> <span class="pull-right"><i class="fa fa-sort-down"></i></span>
                                  </a>
                              </h4>
                          </div>
                          <div id="payCitySection" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingmsg91" aria-expanded="false">
                              <div class="panel-body no-br-tlr no-border-color">
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
                      <div class="panel panel-default" id="road_safety" <?php echo strtolower($ticket->department_name) != 'road safety' ? "style='display:none;'" : ''; ?>>
                          <div class="panel-heading" role="tab" id="headingmsg93">
                              <h4 class="panel-title">
                                  <a role="button" data-toggle="collapse" href="#road_safetySection" aria-expanded="false" class="collapsed">
                                      <?php echo _l('ticket_contact_road_safety_title'); ?> <span class="pull-right"><i class="fa fa-sort-down"></i></span>
                                  </a>
                              </h4>
                          </div>
                          <div id="road_safetySection" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingmsg93" aria-expanded="false">
                              <div class="panel-body no-br-tlr no-border-color">

                                </div>
                          </div>
                      </div>
                      <div class="panel panel-default" id="traffic" <?php echo strtolower($ticket->department_name) != 'traffic' ? "style='display:none;'" : ''; ?>>
                          <div class="panel-heading" role="tab" id="headingmsg94">
                              <h4 class="panel-title">
                                  <a role="button" data-toggle="collapse" href="#trafficSection" aria-expanded="false" class="collapsed">
                                      <?php echo _l('ticket_contact_traffic_title'); ?> <span class="pull-right"><i class="fa fa-sort-down"></i></span>
                                  </a>
                              </h4>
                          </div>
                          <div id="trafficSection" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingmsg94" aria-expanded="false">
                              <div class="panel-body no-br-tlr no-border-color">

                                </div>
                          </div>
                      </div>
                      <hr>

               <div class="row">
                  <div class="col-md-12 text-center">
                    <a href="#" class="btn btn-info save_changes_settings_single_ticket">
                        <?php echo _l('submit'); ?>
                     </a>
                  </div>
               </div>
                  
                  
                  
            </div>
                  
                  <!-- End new code for Sub Tab pannel for customer and other -->
                  
         </div>
        <div role="tabpanel" class="tab-pane <?php if(!$this->session->flashdata('active_tab')){echo 'active';} ?>" id="mail">
            
            <div class="row">
                           <div class="col-md-12 text-right _buttons">
                              <a href="#" class="btn btn-default" data-target="#contract_send_to_client_modal" data-toggle="modal"><span class="btn-with-tooltip" data-toggle="tooltip" data-title="<?php echo _l('contract_send_to_email'); ?>" data-placement="bottom">
                              <i class="fa fa-envelope"></i></span>
                              </a>
                              
                           </div>
                             <div class="col-md-12">
                                 <?php $contract_merge_fields = $this->app_merge_fields->get_flat('ticket', ['other'], '{email_signature}'); ?>
                              <?php if(isset($contract_merge_fields)){ ?>
                              <hr class="hr-panel-heading" />
                              <p class="bold mtop10 text-right"><a href="#" onclick="slideToggle('.avilable_merge_fields'); return false;"><?php echo _l('available_merge_fields'); ?></a></p>
                              <div class=" avilable_merge_fields mtop15 hide">
                                 <ul class="list-group">
                                    <?php
                                       foreach($contract_merge_fields as $field){
                                           foreach($field as $f){
                                              echo '<li class="list-group-item"><b>'.$f['name'].'</b>  <a href="#" class="pull-right" onclick="insert_merge_field(this); return false">'.$f['key'].'</a></li>';
                                          }
                                       }
                                    ?>
                                 </ul>
                              </div>
                              <?php } ?>
                           </div>
                           
                        </div>
                        <hr class="hr-panel-heading" />
                        <?php
                $this->load->view('admin/includes/ticket_emails_tracking',array(
                  'tracked_emails'=>
                  get_tracked_emails($ticket->ticketid, 'ticket'))
                );
            ?>
                        <div class="editable tc-content" style="border:1px solid #d2d2d2;min-height:70px; border-radius:4px;">
                           <?php
                              if(empty($ticket->content)){
                               echo hooks()->apply_filters('new_contract_default_content', '<span class="text-danger text-uppercase mtop15 editor-add-content-notice"> ' . _l('click_to_add_content') . '</span>');
                              } else {
                               echo $ticket->content;
                              }
                              
                              ?>
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
<?php $this->load->view('admin/tickets/send_to_client'); ?>
<?php init_tail(); ?>
<?php hooks()->do_action('ticket_admin_single_page_loaded',$ticket); ?>
<script>
   $(function(){
      
tinymce.init({
  selector: 'div.editable ',
  height: 200,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount',
    'table'
  ],
  toolbar: 'undo redo | formatselect | ' +
  ' bold italic backcolor | alignleft aligncenter ' +
  ' alignright alignjustify | bullist numlist outdent indent |' +
  'table |table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol'+
  ' removeformat | help',
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tiny.cloud/css/codepen.min.css'
  ],
  setup: function (editor) {

          editor.addCommand('mceSave', function () {
             save_contract_content(true);
          });

          editor.on('MouseLeave blur', function () {
             if (tinymce.activeEditor.isDirty()) {
                save_contract_content();
             }
          });
        }
});

     var department_name = '<?php echo $ticket->department; ?>';
     if(department_name == <?php echo NETWORKS; ?>){
         $('#notice_number_div').hide();
         $('#meter_number_div').show();
     }else{
         $('#notice_number_div').show();
         $('#meter_number_div').hide();
     }
       $('body').on('change','#company_id',function (){
            var contactid = $(this).val();
            init_ajax_search('contact', '#contactid.ajax-search', {
                tickets_contacts: true,
                contact_userid: contactid
                   
            });
           
     });
     // Start New Code 
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
            $('#sub_service_div').html('<div class="select-placeholder form-group" app-field-wrapper="company_id"><label for="sub_category" class="control-label">Sub category</label><select id="sub_category" name="sub_category" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true"><option value=""></option></select></div>');
            var groupsub = $('select#sub_category');
            groupsub.selectpicker('refresh');
            var department_id = $(this).val();
            var department_text = $( "#department option:selected" ).text();
            if(department_id == <?php echo NETWORKS; ?>){
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


       $('#booking_date').datetimepicker({
        });
        $('#meter_section_time_stamp').datetimepicker({
        });
        
       $('#department').on('change',function (){
          //var value = $('#department :selected').text(); 
          var value = $('#department :selected').val(); 
          show_selected_department(value);
       });
       
       // End New Code
      $('#single-ticket-form').appFormValidator();
      //init_ajax_search('contact','#contactid.ajax-search',{tickets_contacts:true});
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

 function save_contract_content(manual) {
    var editor = tinyMCE.activeEditor;
    var data = {};
    data.ticketid = "<?php echo $ticket->ticketid; ?>";
    data.content = editor.getContent();
    $.post(admin_url + 'tickets/save_tickets_mail_data', data).done(function (response) {
       response = JSON.parse(response);
       if (typeof (manual) != 'undefined') {
          // Show some message to the user if saved via CTRL + S
          alert_float('success', response.message);
       }
       // Invokes to set dirty to false
       editor.save();
    }).fail(function (error) {
       var response = JSON.parse(error.responseText);
       alert_float('danger', response.message);
    });
   }
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
   // Start New Code 
   function show_selected_department(string){
       var text = string;
       if(text == <?php echo PAYCITY; ?>){
           $('#paycity').show();
       }else{
           $('#paycity').hide();
       }
       if(text == <?php echo NETWORKS; ?>){
           $('#networks').show();
       }else{
           $('#networks').hide();
       }
       if(text == <?php echo ROADSAFETY; ?>){
           $('#road_safety').show();
       }else{
           $('#road_safety').hide();
       }
       if(text == <?php echo TRAFFIC; ?>){
           $('#traffic').show();
       }else{
           $('#traffic').hide();
       }
   }
// End New Code 
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
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>
</body>
</html>
