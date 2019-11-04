<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('menu_customer_sub_sla_manager'); ?></h4>
<div id="contact_data"></div>
<div id="consent_data">
    <div class="row">
        <div class="col-md-6">
            <?php echo form_open(admin_url('clients/sla_manager/'.$client->userid)); ?>
    <input type="hidden" name="id" value="<?php echo isset($sla_manager) ? $sla_manager['id'] : ''; ?>">
    <div class="row">
        
        <div class="col-md-12"><h4>High</h4></div>
        
        <div class="col-md-12">
                   <?php echo render_input('high_resolution', 'client_sla_mager_resolution', isset($sla_manager) ? $sla_manager['high_resolution'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
                   <?php echo render_input('high_response', 'client_sla_mager_response', isset($sla_manager) ? $sla_manager['high_response'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h4>Medium</h4></div>
        
        <div class="col-md-12">
                   <?php echo render_input('medium_resolution', 'client_sla_mager_resolution', isset($sla_manager) ? $sla_manager['medium_resolution'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
                   <?php echo render_input('medium_response', 'client_sla_mager_response', isset($sla_manager) ? $sla_manager['medium_response'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h4>Low</h4></div>
        
        <div class="col-md-12">
                   <?php echo render_input('low_resolution', 'client_sla_mager_resolution', isset($sla_manager) ? $sla_manager['low_resolution'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
                   <?php echo render_input('low_response', 'client_sla_mager_response', isset($sla_manager) ? $sla_manager['low_response'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
        
    </div>
    <?php echo form_close(); ?>
        </div>
        <div class="col-md-6">
            <div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="row">
                <!-- <div class="col-md-12">
                        <p class="pull-left mtop5"> <?php echo _l('ems_dash_service_level'); ?></p>
                    </div>-->
                    <!--<br><hr><br>-->
                    <?php $results =  get_service_level_details((isset($sla_manager['id']) ? $sla_manager['id'] : null),(isset($group_id) ? $group_id : null),(isset($departments_id) ? $departments_id : null)); ?>
                    <?php 
                        if(!empty($results)){
                            foreach ($results as $result){ ?>
                        <div class="col-md-12">
                            <div class="text-left">
                                <?php  if($result['priority'] == 1){ ?>
                                     <h4>High</h4>
                               <?php }elseif($result['priority'] == 2){ ?> 
                                     <h4>Medium</h4>
                                   <?php }elseif($result['priority'] == 3){ ?>
                                     <h4>Low</h4>
                                   <?php } ?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <?php $time_resolve_per = $result['resolve_hours'] > 0 ? round($result['resolve_hours'] / $result['count_data']) : 0;
                            if($time_resolve_per > 50){
                                $resolve_color = 'success';
                            }elseif($time_resolve_per > 20 && $time_resolve_per < 50){
                                $resolve_color = 'warning';
                            }else{
                                $resolve_color = 'danger';
                            }
                              $time_response_per = $result['response_hours'] > 0 ? round($result['response_hours'] / $result['count_data']) : 0;
                              if($time_response_per > 50){
                                $response_color = 'success';
                            }elseif($time_response_per > 20 && $time_response_per < 50){
                                $response_color = 'warning';
                            }else{
                                $response_color = 'danger';
                            }
                        ?>
                        <div class="col-md-12">
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <label>
                                    <!--<a href="javascript:void(0)" class="text-muted inline-block mbot15">-->
                                    <?php echo _l('ems_dash_responed'); ?>
                                    <!--</a>-->
                                </label>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            <?php echo $time_response_per; ?>%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-<?php echo $response_color; ?>  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $time_response_per; ?>" aria-valuemin="0" aria-valuemax="<?php echo $time_response_per; ?>" style="width: <?php echo $time_response_per; ?>%;" data-percent="<?php echo $time_response_per; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                               <label>
                                   <!--<a href="javascript:void(0)" class="text-muted inline-block mbot15">-->
                                    <?php echo _l('ems_dash_resolve'); ?>
                                   <!--</a>-->
                               </label>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            <?php echo $time_resolve_per; ?>%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-<?php echo $resolve_color; ?>  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $time_resolve_per; ?>" aria-valuemin="0" aria-valuemax="<?php echo $time_resolve_per; ?>" style="width: <?php echo $time_resolve_per; ?>%;" data-percent="<?php echo $time_resolve_per; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <?php   }
                        }
                    ?>
                </div>

<!--            </div>
        </div>
    </div>-->
</div>
        </div>
    </div>
    
</div>
 <SCRIPT language=Javascript>
      
      function isNumberKey(evt,value)
      {
          if(value > 99){
              return false;
          }
          
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
      
   </SCRIPT>
</body>
</html>
