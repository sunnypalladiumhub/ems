<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row home-summary">
                    <div class="col-md-12">
                        <h4 class="pull-left padding-5" style="margin: 0;">
                            <?php echo _l('ems_dash_service_level'); ?>
                        </h4>
                        <a href="#" class="pull-right padding-5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                    </div>
                    
                    <br>
                    <hr>
                    <br>
                    
                    <div class="col-md-6" style="text-align: center;">
                        <p>BRONZE</p>
                        <h3  style="color: orange;">60%</h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p>SILVER</p>
                        <h3  style="color: orange;">49%</h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p>GOLD</p>
                        <h3  style="color: greenyellow;">92%</h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p>PLATINUM</p>
                        <h3 style="color: red;">4%</h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
