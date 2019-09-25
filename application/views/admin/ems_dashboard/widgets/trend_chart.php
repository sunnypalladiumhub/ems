<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row home-summary">
                    <div class="col-12">
                        <h4 class="pull-left padding-5" style="margin: 0;">
                            <?php echo _l('ems_dash_today_trends'); ?>
                        </h4>
                        <a href="#" class="pull-right padding-5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                    </div>
<!--                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>-->
                    <canvas id="canvas"></canvas>
                </div>
                
            </div>
        </div>
    </div>
</div>
