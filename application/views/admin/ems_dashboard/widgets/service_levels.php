<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="pull-left mtop5"> <?php echo _l('ems_dash_service_level'); ?></p>
                        <!--<a href="#" class="pull-right mtop5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>-->
                    </div>
                    
                    <br>
                    <hr>
                    <br>
                    <?php $results =  get_service_level_details((isset($customer_id) ? $customer_id : null),(isset($group_id) ? $group_id : null),(isset($departments_id) ? $departments_id : null),(isset($province) ? $province : null)); ?>
                    <?php 
                        if(!empty($results)){
                            foreach ($results as $result){ ?>
                        <div class="col-md-12">
                            <div class="text-left">
                                <?php  if($result['priority'] == 3){ ?>
                                     <b>HIGH</b>
                               <?php }elseif($result['priority'] == 2){ ?> 
                                     <b>MEDIUM</b>
                                   <?php }elseif($result['priority'] == 1){ ?>
                                <b>LOW</b>
                                   <?php } ?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <?php $time_resolve_per = $result['resolve_hours'] > 0 ? round($result['resolve_hours'] / $result['count_data']) : 0;
                            if($time_resolve_per > 100){
                                $time_resolve_per = 100;
                            }
                            if($time_resolve_per > 50){
                                $resolve_color = 'success';
                            }elseif($time_resolve_per > 20 && $time_resolve_per < 50){
                                $resolve_color = 'warning';
                            }else{
                                $resolve_color = 'danger';
                            }
                              $time_response_per = $result['response_hours'] > 0 ? round($result['response_hours'] / $result['count_data']) : 0;
                              if($time_response_per > 100){
                                  $time_response_per = 100;
                              }
                              if($time_response_per > 50){
                                $response_color = 'success';
                            }elseif($time_response_per > 20 && $time_response_per < 50){
                                $response_color = 'warning';
                            }else{
                                $response_color = 'danger';
                            }
                        ?>
                        <div class="col-md-12">
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                                    <?php echo _l('ems_dash_responed'); ?>  </a>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            <?php echo $time_response_per; ?>%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-<?php echo $response_color; ?>  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $time_response_per; ?>" aria-valuemin="0" aria-valuemax="<?php echo $time_response_per; ?>" style="width: <?php echo $time_response_per; ?>%;" data-percent="<?php echo $time_response_per; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                                    <?php echo _l('ems_dash_resolve'); ?>  </a>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            <?php echo $time_resolve_per; ?>%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-<?php echo $resolve_color; ?>  no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $time_resolve_per; ?>" aria-valuemin="0" aria-valuemax="<?php echo $time_resolve_per; ?>" style="width: <?php echo $time_resolve_per; ?>%;" data-percent="<?php echo $time_resolve_per; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <?php   }
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
