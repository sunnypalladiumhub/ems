<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget relative" id="widget-<?php echo basename(__FILE__, ".php"); ?>" data-name="<?php echo _l('quick_stats'); ?>">
    <div class="widget-dragger"></div>

    <div class="panel_s">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-1 col-xs-1 col-md-1 total-column"></div>
                <?php $this->load->helper('tickets_helper'); ?>
                <?php foreach(ticket_ems_dashboard_summary_data((isset($customer_id) ? $customer_id : null),(isset($rel_type) ? $rel_type : null)) as $summary){ ?>
                <div class="col-md-2 col-xs-6 mbot15 border-right">
<!--                    <div class="panel_s" style="margin-bottom:0;">
                           <div class="panel-body">-->
                               <h3 class="bold no-mtop"><?php echo $summary['total_tasks']; ?></h3>
                                <p style="color:<?php echo $summary['color']; ?>" class="font-medium no-mbot">
                                  <?php echo $summary['name']; ?>
                                </p>
<!--                           </div>
                        </div>-->
                     </div>
                <?php } ?>
                
            </div>
        </div>
    </div>

</div>
