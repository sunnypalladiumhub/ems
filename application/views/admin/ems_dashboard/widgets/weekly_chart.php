<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="panel_s">
        <div class="panel-body">
            <div class="widget-dragger ui-sortable-handle"></div>
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left mtop5"> <?php echo _l('home_weekend_ticket_opening_statistics'); ?></p>
                </div>
                <div class="col-md-12">
                    <hr class="hr-panel-heading-dashboard">
                </div>
                </div>
            <div class="relative" style="max-height: 350px">
              <canvas class="chart" id="weekly-ticket-openings-chart" height="350"></canvas>
            </div>
        </div>
    </div>
</div>
