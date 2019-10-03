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
                    
                    <?php $total_box_answers = total_rows(db_prefix().'form_results',array('rel_type'=>'survey')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <span class="bold">Extremely Satisfied</span>
                                </div>
                                <?php
                                    $total_box_description_answers = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>1,'rel_type'=>'survey'));
                                    $percent = ($total_box_description_answers > 0 ? number_format(($total_box_description_answers * 100) / $total_box_answers,2) : 0);
                                ?>
                                <div class="col-md-4 text-right">
                                    <?php echo $total_box_description_answers; ?> / <?php echo $total_box_answers; ?>                                        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;" data-percent="<?php echo $percent; ?>"><?php echo $percent; ?>%</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <span class="bold">Moderately Satisfied</span>
                                </div>
                                <?php
                                    $total_box_Moderately = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>4,'rel_type'=>'survey'));
                                    $percent_Moderately = ($total_box_Moderately > 0 ? number_format(($total_box_Moderately * 100) / $total_box_answers,2) : 0);
                                ?>
                                <div class="col-md-4 text-right">
                                    <?php echo $total_box_Moderately; ?> / <?php echo $total_box_answers; ?>                                        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent_Moderately; ?>%;" data-percent="<?php echo $percent_Moderately; ?>"><?php echo $percent_Moderately; ?>%</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <span class="bold">Not happy at all</span>
                                </div>
                                <?php
                                    $total_box_not = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>5,'rel_type'=>'survey'));
                                    $percent_not = ($total_box_not > 0 ? number_format(($total_box_not * 100) / $total_box_answers,2) : 0);
                                ?>
                                <div class="col-md-4 text-right">
                                    <?php echo $total_box_not; ?> / <?php echo $total_box_answers; ?>                                        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent_not; ?>%;" data-percent="<?php echo $percent_not; ?>"><?php echo $percent_not; ?>%</div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-6" style="text-align: center;">
                        <p>Response Received</p>
                        
                        <h3><?php //echo $total_box_answers; ?></h3>
                    </div>-->
<!--                    <div class="col-md-6" style="text-align: center;">
                        <p> Extremely Satisfied </p>
                        <?php
                            //$total_box_description_answers = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>1,'rel_type'=>'survey'));
                           // $percent = ($total_box_description_answers > 0 ? number_format(($total_box_description_answers * 100) / $total_box_answers,2) : 0);
                        ?>
                        <h3><?php //echo $percent; ?>%</h3>
                    </div>-->
<!--                    <div class="col-md-6" style="text-align: center;">
                        <p> Moderately Satisfied </p>
                        <?php
                           // $total_box_Moderately = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>4,'rel_type'=>'survey'));
                           // $percent_Moderately = ($total_box_Moderately > 0 ? number_format(($total_box_Moderately * 100) / $total_box_answers,2) : 0);
                        ?>
                        <h3><?php // echo $percent_Moderately; ?>%</h3>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <p> Not happy at all </p>
                        <?php
                            //$total_box_not = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>5,'rel_type'=>'survey'));
                            //$percent_not = ($total_box_not > 0 ? number_format(($total_box_not * 100) / $total_box_answers,2) : 0);
                        ?>
                        <h3><?php // echo $percent_not; ?>%</h3>
                    </div>-->
                        
                    
                </div>

            </div>
        </div>
    </div>
</div>
