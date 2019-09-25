<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget relative" id="widget-<?php echo basename(__FILE__, ".php"); ?>" data-name="<?php echo _l('quick_stats'); ?>">
    <div class="widget-dragger"></div>

    <div class="panel_s">
        <div class="panel-body">
            <div class="row">
                <?php
                $statuses = $this->tickets_model->get_ticket_status();
                ?>
                <div class="col-md-12">
                    <h4 class="no-margin"><?php echo _l('tickets_summary'); ?></h4>
                </div>
                <?php
                $where = '';

                foreach ($statuses as $status) {
                    $_where = '';
                    if ($where == '') {
                        $_where = 'status=' . $status['ticketstatusid'];
                    } else {
                        $_where = 'status=' . $status['ticketstatusid'] . ' ' . $where;
                    }
                    if (isset($project_id)) {
                        $_where = $_where . ' AND project_id=' . $project_id;
                    }
                    ?>
                    <div class="col-md-2 col-xs-6 mbot15 border-right">
                        <h3 class="bold"><?php echo total_rows(db_prefix() . 'tickets', $_where); ?></h3>
                        <span style="color:<?php echo $status['statuscolor']; ?>">
                            <?php echo ticket_status_translate($status['ticketstatusid']); ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>
