<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="ticket-meter-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('tickets/meter_number'),array('id'=>'ticket-meter-number-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('ticket_edit_meter_number'); ?></span>
                    <span class="add-title"><?php echo _l('ticket_add_meter_number'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('number','meter_add_edit_name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    window.addEventListener('load',function(){
        appValidateForm($('#ticket-meter-number-form'),{name:'required'},manage_meter_number_services);
        $('#ticket-meter-modal').on('hidden.bs.modal', function(event) {
            $('#additional').html('');
            $('#ticket-meter-modal input[name="name"]').val('');
            $('.add-title').removeClass('hide');
            $('.edit-title').removeClass('hide');
        });
    });
    function manage_meter_number_services(form) {
        var data = $(form).serialize();
        var url = form.action;
        var ticketArea = $('body').hasClass('ticket');
        if(ticketArea) {
            data+='&ticket_area=true';
        }
        $.post(url, data).done(function(response) {
            if(ticketArea) {
               response = JSON.parse(response);
               if(response.success == true && typeof(response.id) != 'undefined'){
                var group = $('select#meter_number');
                group.find('option:first').after('<option value="'+response.id+'">'+response.name+'</option>');
                group.selectpicker('val',response.id);
                group.selectpicker('refresh');
            }else if (response.success == false) {
                var group = $('select#meter_number');
                group.selectpicker('val',response.id);
                $('#meter_number_msg').css('color','red');
                $('#meter_number_msg').html(response.msg);
                setTimeout(function(){
                    $('#meter_number_msg').html('');
                }, 5000);
            }

            $('#ticket-meter-modal').modal('hide');
        } else {
            window.location.reload();
        }
    });
        return false;
    }
    function new_meter_number(){
        $('#ticket-meter-modal').modal('show');
        $('.edit-title').addClass('hide');
    }
    function edit_service(invoker,id){
        var name = $(invoker).data('name');
        $('#additional').append(hidden_input('id',id));
        $('#ticket-meter-modal input[name="name"]').val(name);
        $('#ticket-meter-modal').modal('show');
        $('.add-title').addClass('hide');
    }
</script>
