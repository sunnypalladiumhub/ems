<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade email-template" data-editor-id=".<?php echo 'tinymce-'.$ticket->ticketid; ?>" id="contract_send_to_client_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <?php echo form_open('admin/tickets/send_to_email/'.$ticket->ticketid); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo _l('contract_send_to_client_modal_heading'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $contacts = array();
                             echo render_input('sent_to[]', 'ticket_contact_email', $ticket->ticket_email, 'email'); 
                            ?>
                        </div>
                        <?php echo render_input('cc','CC'); ?>
                        <hr />
                        <div class="checkbox checkbox-primary">
                           <input type="checkbox" <?php if(empty($ticket->content)){echo 'disabled';} else {echo 'checked';} ?> name="attach_pdf" id="attach_pdf">
                            <label for="attach_pdf"><?php echo _l('contract_send_to_client_attach_pdf'); ?></label>
                        </div>
                        <h5 class="bold"><?php echo _l('contract_send_to_client_preview_template'); ?></h5>
                        <hr />
                        <?php
                        
                        $data_data = prepare_mail_preview_data('Ticket_msg_from_staff',$ticket->ticket_email); 
                        ?>
                        <?php echo render_textarea('email_template_custom','',$data_data['template']->message,array(),array(),'','tinymce-'.$ticket->ticketid); ?>
<!--                        $template->message-->
                        <?php echo form_hidden('template_name',$data_data['template_name']); ?>
                    </div>
                </div>
                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                        <button type="submit" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info"><?php echo _l('send'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
