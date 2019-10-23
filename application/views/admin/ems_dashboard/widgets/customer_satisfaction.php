<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row home-summary">
                    <div class="col-md-12">
                        <p class="pull-left mtop5"> <?php echo _l('ems_dash_cus_sat'); ?></p>
                        <!--<a href="#" class="pull-right mtop5">&nbsp;<?php //echo _l('ems_dash_view_details'); ?></a>-->
                    </div>
                    <br>
                    <div class="col-md-12">
                        
                        <hr class="hr-panel-heading-dashboard">
                     
                    </div>
                    
                    <?php $total_box_answers = total_rows(db_prefix().'form_results',array('rel_type'=>'survey')); ?>
                    <div class="col-md-12">
                        <?php
                            $total_box_description_answers = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>1,'rel_type'=>'survey'));
                            $percent = ($total_box_description_answers > 0 ? number_format(($total_box_description_answers * 100) / $total_box_answers,2) : 0);
                        ?>
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                               Extremely Satisfied  </a>
                            </div>
                            
<!--                        <div class="col-md-3 text-right">
                            <?php //echo $total_box_description_answers; ?> / <?php //echo $total_box_answers; ?>
                        </div>-->
                        </div>
                        
                        <div class="text-right progress-finance-status">
                           <?php echo $percent; ?>%
                           <div class="progress no-margin progress-bar-mini">
                              <div class="progress-bar progress-bar-success  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="<?php echo $percent; ?>" style="width: <?php echo $percent; ?>%;" data-percent="<?php echo $percent; ?>">
                              </div>
                           </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <?php
                            $total_box_Moderately = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>4,'rel_type'=>'survey'));
                            $percent_Moderately = ($total_box_Moderately > 0 ? number_format(($total_box_Moderately * 100) / $total_box_answers,2) : 0);
                        ?>
                        
                        <div class=" text-stats-wrapper">
                            <div class=" text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                               Moderately Satisfied  </a>
                            </div>
                            
<!--                        <div class="col-md-3 text-right">
                            <?php //echo $total_box_Moderately; ?> / <?php //echo $total_box_answers; ?>
                        </div>-->
                        </div>
                        
                        <div class=" text-right progress-finance-status">
                           <?php echo $percent_Moderately; ?>%
                           <div class="progress no-margin progress-bar-mini">
                              <div class="progress-bar progress-bar-warning  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $percent_Moderately; ?>" aria-valuemin="0" aria-valuemax="<?php echo $percent_Moderately; ?>" style="width: <?php echo $percent_Moderately; ?>%;" data-percent="<?php echo $percent_Moderately; ?>">
                              </div>
                           </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php
                            $total_box_not = total_rows(db_prefix().'form_results',array('boxdescriptionid'=>5,'rel_type'=>'survey'));
                            $percent_not = ($total_box_not > 0 ? number_format(($total_box_not * 100) / $total_box_answers,2) : 0);
                        ?>
                            
                        <div class=" text-stats-wrapper">
                            <div class=" text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                               Not happy at all  </a>
                            </div>
                            
<!--                        <div class="col-md-3 text-right">
                           <?php //echo $total_box_not; ?> / <?php //echo $total_box_answers; ?>
                        </div>-->
                        </div>
                        
                        <div class=" text-right progress-finance-status">
                           <?php echo $percent_not; ?>%
                           <div class="progress no-margin progress-bar-mini">
                              <div class="progress-bar progress-bar-danger  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $percent_not; ?>" aria-valuemin="0" aria-valuemax="<?php echo $percent_not; ?>" style="width: <?php echo $percent_not; ?>%;" data-percent="<?php echo $percent_not; ?>">
                              </div>
                           </div>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>
