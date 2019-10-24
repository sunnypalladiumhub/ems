<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="pull-left mtop5"><?php echo _l('ems_dash_overdue_tickets'); ?></p>
                        <a href="<?php echo admin_url('tickets'); ?>" class="pull-right mtop5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                    </div>
                    <div class="col-md-12">
                        
                        <hr class="hr-panel-heading-dashboard">
                     
                    </div>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 70%;">Campaign </th>
                                <th scope="col" style="width: 15%;color: red;">Overdue</th>
                                <th scope="col"  style="width: 15%; color: orange;">Due Today</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $data_groups =  overdue_tickets_details((isset($customer_id) ? $customer_id : null),(isset($group_id) ? $group_id : null),(isset($departments_id) ? $departments_id : null)); 
                                foreach ($data_groups as $key=>$value){
                            ?>
                            <tr>
                                <td><?php echo $value['name']; ?></td>
                                <td style="color: red;"><?php echo $value['Overdue']; ?></td>
                                <td style="color: orange;"><?php echo $value['Overdue_today']; ?></td>
                            </tr>
                                <?php } ?>
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
