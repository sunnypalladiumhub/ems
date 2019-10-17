<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('menu_customer_sub_sla_manager'); ?></h4>
<div id="contact_data"></div>
<div id="consent_data">
    <?php echo form_open(admin_url('clients/sla_manager/'.$client->userid)); ?>
    <input type="hidden" name="id" value="<?php echo isset($sla_manager) ? $sla_manager['id'] : ''; ?>">
    <div class="row">
        
        <div class="col-md-12"><h4>High</h4></div>
        
        <div class="col-md-6">
                   <?php echo render_input('high_resolution', 'client_sla_mager_resolution', isset($sla_manager) ? $sla_manager['high_resolution'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
                   <?php echo render_input('high_response', 'client_sla_mager_response', isset($sla_manager) ? $sla_manager['high_response'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h4>Medium</h4></div>
        
        <div class="col-md-6">
                   <?php echo render_input('medium_resolution', 'client_sla_mager_resolution', isset($sla_manager) ? $sla_manager['medium_resolution'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
                   <?php echo render_input('medium_response', 'client_sla_mager_response', isset($sla_manager) ? $sla_manager['medium_response'] : '', 'number',array('onkeypress'=>'return isNumberKey(event,this.value)','maxlength'=>'3','min'=>"1", 'max'=>"999")); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h4>Low</h4></div>
        
        <div class="col-md-6">
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
