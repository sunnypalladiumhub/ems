<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row home-summary">
                    <div class="col-md-12">
                        <p class="pull-left mtop5"> <?php echo _l('ems_dash_service_level'); ?></p>
                        <a href="#" class="pull-right mtop5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                    </div>
                    
                    <br>
                    <hr>
                    <br>
                    
<!--                    <div class="col-md-6" style="text-align: center;">
                        
                    </div>-->
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>BRONZE</p>
                               <h3 class="text-muted _total text-warning">60%</h3>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>SILVER</p>
                               <h3 class="text-muted _total text-warning">49%</h3>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>GOLD</p>
                               <h3 class="text-muted _total text-success">92%</h3>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>PLATINUM</p>
                               <h3 class="text-muted _total text-danger">4%</h3>
                           </div>
                        </div>
                     </div>
                </div>

            </div>
        </div>
    </div>
</div>
