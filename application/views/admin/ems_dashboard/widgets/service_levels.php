<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-finance_overview" data-name="Finance Overview">
    <div class="finance-summary">
        <div class="panel_s">
            <div class="panel-body">
                <div class="widget-dragger ui-sortable-handle"></div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="pull-left mtop5"> <?php echo _l('ems_dash_service_level'); ?></p>
                        <a href="#" class="pull-right mtop5">&nbsp;<?php echo _l('ems_dash_view_details'); ?></a>
                    </div>
                    
                    <br>
                    <hr>
                    <br>
                    <div class="col-md-12">
                        <div class="text-left">
                            <b>HIGH</b>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                                    <?php echo _l('ems_dash_responed'); ?>  </a>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            100.00%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-success  no-percent-text not-dynamic" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100.00" style="width: 100.00%;" data-percent="100.00">
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
                            50.00%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-warning  no-percent-text not-dynamic" role="progressbar" aria-valuenow="50.00" aria-valuemin="0" aria-valuemax="50.00" style="width: 50.00%;" data-percent="50.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <div class="text-left">
                            <b>MEDIUM</b>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                                    <?php echo _l('ems_dash_responed'); ?>  </a>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            50.00%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-warning  no-percent-text not-dynamic" role="progressbar" aria-valuenow="50.00" aria-valuemin="0" aria-valuemax="50.00" style="width: 50.00%;" data-percent="50.00">
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
                            50.00%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-warning  no-percent-text not-dynamic" role="progressbar" aria-valuenow="50.00" aria-valuemin="0" aria-valuemax="50.00" style="width: 50.00%;" data-percent="50.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <div class="text-left">
                            <b>LOW</b>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        
                        <div class=" text-stats-wrapper">
                            <div class="text-left">
                                <a href="javascript:void(0)" class="text-muted inline-block mbot15">
                                    <?php echo _l('ems_dash_responed'); ?>  </a>
                            </div>

                        </div>

                        <div class="text-right progress-finance-status">
                            50.00%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-warning  no-percent-text not-dynamic" role="progressbar" aria-valuenow="50.00" aria-valuemin="0" aria-valuemax="50.00" style="width: 50.00%;" data-percent="50.00">
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
                            20.00%
                            <div class="progress no-margin progress-bar-mini">
                                <div class="progress-bar progress-bar-danger  no-percent-text not-dynamic" role="progressbar" aria-valuenow="20.00" aria-valuemin="0" aria-valuemax="20.00" style="width: 20.00%;" data-percent="20.00">
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>BRONZE</p>
                               <h3 class="text-muted _total text-warning">60%</h3>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>SILVER</p>
                               <h3 class="text-muted _total text-warning">49%</h3>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>GOLD</p>
                               <h3 class="text-muted _total text-success">92%</h3>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-6 col-xs-6 col-md-6 total-column">
                        <div class="panel_s">
                           <div class="panel-body">
                               <p>PLATINUM</p>
                               <h3 class="text-muted _total text-danger">4%</h3>
                           </div>
                        </div>
                     </div>-->
                </div>

            </div>
        </div>
    </div>
</div>
