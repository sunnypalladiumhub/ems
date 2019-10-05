<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('menu_customer_sub_sla_manager'); ?></h4>
<div id="contact_data"></div>
<div id="consent_data">
    <div class="row">
        <div class="col-md-12"><h4>High</h4></div>
        
        <div class="col-md-6">
                   <?php echo render_input('high_resolution', 'client_sla_mager_resolution', '', 'text'); ?>
                   <?php echo render_input('high_response', 'client_sla_mager_response', '', 'text'); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h4>Medium</h4></div>
        
        <div class="col-md-6">
                   <?php echo render_input('medium_resolution', 'client_sla_mager_resolution', '', 'text'); ?>
                   <?php echo render_input('medium_response', 'client_sla_mager_response', '', 'text'); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h4>Low</h4></div>
        
        <div class="col-md-6">
                   <?php echo render_input('low_resolution', 'client_sla_mager_resolution', '', 'text'); ?>
                   <?php echo render_input('low_response', 'client_sla_mager_response', '', 'text'); ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
        
    </div>
</div>
