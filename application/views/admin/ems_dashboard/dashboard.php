<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    
    <div class="content">
        <div class="row">

            <div class="clearfix"></div>

            <div class="col-md-12 mtop30 ui-sortable" data-container="top-12">
                <?php render_ems_dashboard_widgets('top-12'); ?>
            </div>


            <div class="col-md-8" data-container="left-8">
                <?php render_ems_dashboard_widgets('left-8'); ?>
            </div>
            <div class="col-md-4" data-container="right-4">
                <?php render_ems_dashboard_widgets('right-4'); ?>
            </div>

            <div class="clearfix"></div>
            
            <?php hooks()->do_action('after_dashboard'); ?>
        </div>
    </div>
</div>
<!--<script>
    app.calendarIDs = '<?php //echo json_encode($google_ids_calendars); ?>';
</script>-->
<?php init_tail(); ?>
<?php // $this->load->view('admin/utilities/calendar_template'); ?>
<?php  $this->load->view('admin/ems_dashboard/dashboard_js'); ?>
</body>
</html>
