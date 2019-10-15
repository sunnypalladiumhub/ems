<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="panel_s">
        <div class="panel-body">
            <div class="widget-dragger ui-sortable-handle"></div>
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left mtop5"> <?php echo _l('ems_dash_today_trends'); ?></p>
                    <a href="#" class="pull-right mtop5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                </div>
                <div class="col-md-12">
                    <hr class="hr-panel-heading-dashboard">
                </div>
                </div>
            <div class="relative">
              <canvas class="chart" id="canvas" height="350"></canvas>
            </div>
        </div>
    </div>
</div>