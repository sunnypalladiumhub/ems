<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Meter Details</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_number') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->number) ? $meter->number : '' ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_type') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->type) ? $meter->type : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_time_stamp') ?></label>
                                </div>
                                <p > <?php echo isset($meter->time_stamp) ? $meter->time_stamp : '' ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_user') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->user_id) ? $meter->user_id : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_building_type') ?></label>
                                </div>
                                <p > <?php echo isset($meter->building_type) ? $meter->building_type : '' ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_accessible') ?></label>
                                </div>
                                <?php 
                                $meter_accessible = isset($meter->meter_accessible) ? $meter->meter_accessible : '';
                                if($meter_accessible == '1'){
                                    $meter_accessible_text = 'Yes';
                                }elseif($meter_accessible == '0'){
                                    $meter_accessible_text = 'No';
                                }else{
                                    $meter_accessible_text = '';
                                }
                                ?>
                                <p >  <?php echo $meter_accessible_text; ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_location') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->meter_location) ? $meter->meter_location : '' ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_serial_number') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->meter_serial_number) ? $meter->meter_serial_number : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_seals_on_arrival') ?></label>
                                </div>
                                
	<?php 
                                $seals_on_arrival = isset($meter->seals_on_arrival) ? $meter->seals_on_arrival : '';
                                if($seals_on_arrival == '1'){
                                    $seals_on_arrival_text = 'Yes';
                                }elseif($seals_on_arrival == '0'){
                                    $seals_on_arrival_text = 'No';
                                }else{
                                    $seals_on_arrival_text = '';
                                }
                                ?>
                                <p >  <?php echo $seals_on_arrival_text; ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_type') ?></label>
                                </div>
                                <p > <?php echo isset($meter->meter_type) ? $meter->meter_type : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_manufacturer') ?></label>
                                </div>
                                <p > <?php echo isset($meter->meter_manufacturer) ? $meter->meter_manufacturer : '' ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_reading') ?></label>
                                </div>
                                <p > <?php echo isset($meter->meter_reading) ? $meter->meter_reading : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_phase') ?></label>
                                </div>
                                <p > <?php echo isset($meter->phase) ? $meter->phase .' PHASE' : '' ?>   </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_trip_test_done') ?></label>
                                </div>
                                
	<?php 
                                $trip_test_done = isset($meter->trip_test_done) ? $meter->trip_test_done : '';
                                if($trip_test_done == '1'){
                                    $trip_test_done_text = 'Yes';
                                }elseif($trip_test_done == '2'){
                                    $trip_test_done_text = 'No';
                                }else{
                                    $trip_test_done_text = '';
                                }
                                ?>
                                <p >  <?php echo $trip_test_done_text; ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_trip_test_results') ?></label>
                                </div>
                                                                
	<?php 
                                $trip_test_results = isset($meter->trip_test_results) ? $meter->trip_test_results : '';
                                if($trip_test_results == '1'){
                                    $trip_test_results_text = 'Successful';
                                }elseif($trip_test_results == '0'){
                                    $trip_test_results_text = 'Cancel';
                                }else{
                                    $trip_test_results_text = '';
                                }
                                ?>
                                <p > <?php echo isset($meter->trip_test_results) ? $meter->trip_test_results : '' ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_meter_condition') ?></label>
                                </div>
                                                              
	<?php 
                                $meter_condition = isset($meter->meter_condition) ? $meter->meter_condition : '';
                                if($meter_condition == '2'){
                                    $meter_condition_text = 'Good';
                                }elseif($meter_condition == '1'){
                                    $meter_condition_text = 'Average';
                                }
                                elseif($meter_condition == '0'){
                                    $meter_condition_text = 'Bad';
                                }else{
                                    $meter_condition_text = '';
                                }
                                ?>
                                <p > <?php echo $meter_condition_text; ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_other_illegal_connection') ?></label>
                                </div>
                                
	<?php 
                                $other_illegal_connection = isset($meter->other_illegal_connection) ? $meter->other_illegal_connection : '';
                                if($other_illegal_connection == '1'){
                                    $other_illegal_connection_text = 'Yes';
                                }elseif($other_illegal_connection == '0'){
                                    $other_illegal_connection_text = 'No';
                                }else{
                                    $other_illegal_connection_text = '';
                                }
                                ?>
                                <p >  <?php echo $other_illegal_connection_text; ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_sgc_number') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->sgc_number) ? $meter->sgc_number : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_new_seals_fitted') ?></label>
                                </div>
                                
	<?php 
                                $new_seals_fitted = isset($meter->new_seals_fitted) ? $meter->new_seals_fitted : '';
                                if($new_seals_fitted == '1'){
                                    $new_seals_fitted_text = 'Yes';
                                }elseif($new_seals_fitted == '0'){
                                    $new_seals_fitted_text = 'No';
                                }else{
                                    $new_seals_fitted_text = '';
                                }
                                ?>
                                <p >  <?php echo $new_seals_fitted_text; ?>  </p>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_new_seal_numbers') ?></label>
                                </div>
                                <p >  <?php echo isset($meter->new_seal_numbers) ? $meter->new_seal_numbers : '' ?>  </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label><?php echo _l('meter_section_visit') ?></label>
                                </div>
                                <p > <?php echo isset($meter->visit) ? $meter->visit : '' ?>  </p>
                            </div>
                            
                        </div>
                            
                    </div>

                </div>
            </div>

        </div>
    </div>
</body>
</html>
