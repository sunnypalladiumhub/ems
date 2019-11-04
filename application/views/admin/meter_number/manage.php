<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
        <div class="panel_s">
         <div class="panel-body">
          
        
        
        <a href="#" data-toggle="modal" data-target="#meter_bulk_actions" class="bulk-actions-btn table-btn hide" data-table=".meter_number-table"><?php echo _l('bulk_actions'); ?></a>
        <div class="clearfix"></div>
        <?php echo AdminMeterNumberStructure('', true); ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<div class="modal fade bulk_actions" id="meter_bulk_actions" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
            </div>
            <div class="modal-body">
                <?php if (is_admin()) { ?>
                    <div class="checkbox checkbox-danger">
                        <input type="checkbox" name="mass_delete" id="mass_delete">
                        <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
                    </div>
                    <hr class="mass_delete_separator" />
                <?php } ?>
                <div class="row">
                    <div id="bulk_change">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_type_bulk" class="control-label"><?php echo _l('meter_section_type'); ?></label>
                                    <select id="move_to_type_bulk" name="move_to_type_bulk" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="Electricity">Electricity</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
<!--                        <div class="col-md-6">
                            TIMESTAMP
                            <div class="form-group" app-field-wrapper="move_to_time_stamp_bulk">
                                <label for="move_to_time_stamp_bulk" class="control-label">TimeStamp</label>
                                <input type="text" id="move_to_time_stamp_bulk" name="move_to_time_stamp_bulk" class="form-control" value="">
                            </div>
                        </div>-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_machine_id_bulk" class="control-label"><?php echo _l('meter_section_machine'); ?></label>
                                    <select id="move_to_machine_id_bulk" name="move_to_machine_id_bulk" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option value="3" >3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_building_type" class="control-label"><?php echo _l('meter_section_building_type'); ?></label>
                                    <select id="move_to_building_type" name="move_to_building_type" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="residential" >Residential</option>
                                        <option value="commercial" >Commercial</option>
                                        <option value="industrial" >Industrial</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_accessible" class="control-label"><?php echo _l('meter_section_meter_accessible'); ?></label>
                                    <select id="move_to_accessible" name="move_to_accessible" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >Yes</option>
                                        <option value="0" >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_location" class="control-label"><?php echo _l('meter_section_meter_location'); ?></label>
                                    <select id="move_to_location" name="move_to_location" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="inside" >Inside</option>
                                        <option value="outside">Outside</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_serial_number" class="control-label"><?php echo _l('meter_section_meter_serial_number'); ?></label>
                                    <select id="move_to_serial_number" name="move_to_serial_number" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_seals_on_arrival" class="control-label"><?php echo _l('meter_section_seals_on_arrival'); ?></label>
                                    <select id="move_to_seals_on_arrival" name="move_to_seals_on_arrival" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >Yes</option>
                                        <option value="0" >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_meter_type" class="control-label"><?php echo _l('meter_section_meter_type'); ?></label>
                                    <select id="move_to_meter_type" name="move_to_meter_type" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="prepaid" >Prepaid</option>
                                        <option value="postpaid" >Postpaid</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_manufacturer" class="control-label"><?php echo _l('meter_section_meter_manufacturer'); ?></label>
                                    <select id="move_to_manufacturer" name="move_to_manufacturer" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="E Kard" >E Kard</option>
                                    </select>
                                </div>
                            </div>
                        </div>
<!--                        <div class="col-md-6">
                            <?php // echo render_select('move_to_reading_bulk', $meter, array('id','meter_reading'), 'meter_section_meter_reading'); ?>
                        </div>-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_phase" class="control-label"><?php echo _l('meter_section_phase'); ?></label>
                                    <select id="move_to_phase" name="move_to_phase" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >1 Phase</option>
                                        <option value="2" >2 Phase</option>
                                        <option value="3" >3 Phase</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_trip_test_done" class="control-label"><?php echo _l('meter_section_trip_test_done'); ?></label>
                                    <select id="move_to_trip_test_done" name="move_to_trip_test_done" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >Yes</option>
                                        <option value="2" >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_trip_test_results" class="control-label"><?php echo _l('meter_section_trip_test_results'); ?></label>
                                    <select id="move_to_trip_test_results" name="move_to_trip_test_results" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >Successful</option>
                                        <option value="0" >Cancel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_meter_condition" class="control-label"><?php echo _l('meter_section_meter_condition'); ?></label>
                                    <select id="move_to_meter_condition" name="move_to_meter_condition" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="2" >Good</option>
                                        <option value="1" >Average</option>
                                        <option value="0" >Bad</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_other_illegal_connection" class="control-label"><?php echo _l('meter_section_other_illegal_connection'); ?></label>
                                    <select id="move_to_other_illegal_connection" name="move_to_other_illegal_connection" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="0" >No</option>
                                        <option value="1" >Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_sgc_number" class="control-label"><?php echo _l('meter_section_sgc_number'); ?></label>
                                    <select id="move_to_sgc_number" name="move_to_section[sgc_number]" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="402" >402</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_new_seals_fitted" class="control-label"><?php echo _l('meter_section_new_seals_fitted'); ?></label>
                                    <select id="move_to_new_seals_fitted" name="move_to_new_seals_fitted" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="1" >Yes</option>
                                        <option value="0" >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="select-placeholder form-group" app-field-wrapper="company_id">
                                    <label for="move_to_new_seal_numbers" class="control-label"><?php echo _l('meter_section_new_seal_numbers'); ?></label>
                                    <select id="move_to_new_seal_numbers" name="move_to_new_seal_numbers" class="selectpicker" required="true" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true">
                                        <option value=""></option>
                                        <option value="MQ0032978" >MQ0032978</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <a href="#" class="btn btn-info" onclick="meter_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script>
    function meter_bulk_action(event) {
    if (confirm_delete()) {
        var mass_delete = $('#mass_delete').prop('checked');
        var ids = [];
        var data = {};
        if (mass_delete == false || typeof(mass_delete) == 'undefined') {
           
            data.type = $('#move_to_type_bulk').val();
            data.machine_id = $('#move_to_machine_id_bulk').val();
            data.building_id = $('#move_to_building_type').val();
            data.accessible = $('#move_to_accessible').val();
            data.location = $('#move_to_location').val();
            data.serial_number = $('#move_to_serial_number').val();
            data.seals_on_arrival = $('#move_to_seals_on_arrival').val();
            data.meter_type = $('#move_to_meter_type').val();
            data.manufacturer = $('#move_to_manufacturer').val();
            //data.reading_bulk = $('#move_to_reading_bulk').val();
            data.phase = $('#move_to_phase').val();
            data.trip_test_done = $('#move_to_trip_test_done').val();
            data.trip_test_results = $('#move_to_trip_test_results').val();
            data.meter_condition = $('#move_to_meter_condition').val();
            data.other_illegal_connection = $('#move_to_other_illegal_connection').val();
            data.sgc_number = $('#move_to_sgc_number').val();
            data.new_seals_fitted = $('#move_to_new_seals_fitted').val();
            data.new_seal_numbers = $('#move_to_new_seal_numbers').val();
//            if (data.number == '' && data.type == '' && data.time_stamp == '' && data.machine_id == '' && data.building_id == '' && data.accessible == '' && data.location == '' && data.serial_number == '' && data.seals_on_arrival == '' && data.meter_type == '' && data.manufacturer == '') {
//                return;
//            }
        } else {
            data.mass_delete = true;
        }
        var rows = $('.table-meter_number').find('tbody tr');
        $.each(rows, function() {
            var checkbox = $($(this).find('td').eq(0)).find('input');
            if (checkbox.prop('checked') == true) {
                ids.push(checkbox.val());
            }
        });
        data.ids = ids;
        $(event).addClass('disabled');
        setTimeout(function() {
            $.post(admin_url + 'meter_number/bulk_action', data).done(function() {
                window.location.reload();
            });
        }, 50);
    }
}
</script>
</body>
</html>
