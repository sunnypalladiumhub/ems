<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="ticket-service-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('tickets/service'),array('id'=>'ticket-service-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('ticket_service_edit'); ?></span>
                    <span class="add-title"><?php echo _l('new_category'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
<!--                   Start New Code For Add 2 New Filed -->
                        <div id="additional"></div>
                        
                        <div id="service_sub_div">
                            <?php echo render_select('parentid', $parent_services, array('serviceid', 'name'), 'parent_category_services', ''); ?>
                        </div>
                        
                        
                        <?php echo render_input('name','category_add_edit_name'); ?>
                    </div>
                    <div class="col-md-12">
                        <div id="departmentid_div">
                            <?php echo render_select('departmentid', $departments, array('departmentid', 'name'), 'ticket_settings_departments', (count($departments) == 1) ? $departments[0]['departmentid'] : '', array('required' => 'true')); ?>
                        </div>
                        
                    </div>
<!--                   End New Code For Add 2 New Filed -->
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
        appValidateForm($('#ticket-service-form'),{name:'required'},manage_ticket_services);
        $('#ticket-service-modal').on('hidden.bs.modal', function(event) {
            $('#additional').html('');
            $('#ticket-service-modal input[name="name"]').val('');
            $('.add-title').removeClass('hide');
            $('.edit-title').removeClass('hide');
        });
    });
//    Start New code Changes for two new filed
    function manage_ticket_services(form) {
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
                var group = $('select#service');
                if(response.parentid > 0){
                    group.selectpicker('val',response.parentid);
                    group.selectpicker('refresh');
                    var sub_category = $('select#sub_category');
                    sub_category.find('option:first').after('<option value="'+response.id+'">'+response.name+'</option>');
                    sub_category.selectpicker('val',response.id);
                    sub_category.selectpicker('refresh');
                }else{
                    group.find('option:first').after('<option value="'+response.id+'">'+response.name+'</option>');
                    group.selectpicker('val',response.id);
                    group.selectpicker('refresh');
                }
            }
            $('#ticket-service-modal').modal('hide');
        } else {
            window.location.reload();
        }
    });
        return false;
    }
    function new_service(departmentid = 0){
        
        if(departmentid > 0 ){
            
            var group = $('#ticket-service-modal select#departmentid');
            group.selectpicker('val',departmentid);
            group.selectpicker('refresh');
            group.attr('disabled',true);
            $.ajax({
                url: admin_url + 'tickets/get_category_list_by_department',
                type: 'POST',
                data: {department_id: departmentid,service:1},
                success: function (data) {
                    var data = $.parseJSON(data);
                    if (data.status == 1) {
                        $('#service_sub_div').html(data.result);
                        var groupparentid = $('select#parentid');
                        groupparentid.selectpicker('refresh');
                    }
                }

            });
        }
        $('#ticket-service-modal').modal('show');
        $('.edit-title').addClass('hide');
    }
    function edit_service(invoker,id){
        var name = $(invoker).data('name');
        var departmentid = $(invoker).data('departmentid');
        var parentid = $(invoker).data('parentid');
        
        $('#additional').append(hidden_input('id',id));
        $('#ticket-service-modal input[name="name"]').val(name);
        var group = $('#ticket-service-modal select#departmentid');
        group.selectpicker('val',departmentid);
        group.selectpicker('refresh');
        
        var groupparent = $('#ticket-service-modal select#parentid');
        groupparent.selectpicker('val',parentid);
        groupparent.selectpicker('refresh');
        $('#ticket-service-modal').modal('show');
        $('.add-title').addClass('hide');
    }
//    End New code Changes for two new filed
    </script>
