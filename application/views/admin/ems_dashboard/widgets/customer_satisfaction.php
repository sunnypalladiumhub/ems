<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row home-summary">
                    <div class="col-12">
                        <h4 class="pull-left padding-5" style="margin: 0;">
                            <?php echo _l('ems_dash_cus_sat'); ?>
                        </h4>
                        <a href="#" class="pull-right padding-5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                    </div>
                    
                    <br>
                    <hr>
                    <br>

                    <div class="col-md-6" style="text-align: center;">
                        <p>Response Received</p>
                        <?php $total_box_answers = total_rows(db_prefix().'form_results',array('rel_type'=>'survey')); ?>
                        <h3><?php echo $total_box_answers; ?></h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p> Extremely Satisfied </p>
                        <?php
                            $total_box_description_answers = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>1,'rel_type'=>'survey'));
                            $percent = ($total_box_description_answers > 0 ? number_format(($total_box_description_answers * 100) / $total_box_answers,2) : 0);
                        ?>
                        <h3><?php echo $percent; ?>%</h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p> Moderately Satisfied </p>
                        <?php
                            $total_box_Moderately = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>4,'rel_type'=>'survey'));
                            $percent_Moderately = ($total_box_Moderately > 0 ? number_format(($total_box_Moderately * 100) / $total_box_answers,2) : 0);
                        ?>
                        <h3><?php echo $percent_Moderately; ?>%</h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p> Not happy at all </p>
                        <?php
                            $total_box_not = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>5,'rel_type'=>'survey'));
                            $percent_not = ($total_box_not > 0 ? number_format(($total_box_not * 100) / $total_box_answers,2) : 0);
                        ?>
                        <h3><?php echo $percent_not; ?>%</h3>
                    </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
</div>
