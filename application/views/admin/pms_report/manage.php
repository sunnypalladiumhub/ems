<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
//echo '<pre>';
//print_r($fields);
//die;
?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row _buttons">
                            <div class="col-md-8">
                                
                              
                            </div>
                            <div class="col-md-4">
                               <div class="btn-group pull-right mleft4 btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-filter" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right width300">
                                        <li>
                                            <a href="#" data-cview="today" onclick="dt_custom_view('today', '.table-<?php echo $table; ?>', 'today'); return false;">Today</a>
                                        </li>
                                        <li>
                                            <a href="#" data-cview="this_week" onclick="dt_custom_view('this_week', '.table-<?php echo $table; ?>', 'this_week'); return false;">This week</a>
                                        </li>
                                        <li>
                                            <a href="#" data-cview="this_month" onclick="dt_custom_view('this_month', '.table-<?php echo $table; ?>', 'this_month'); return false;">This month</a>
                                        </li>
                                        <li>
                                            <a href="#" data-cview="ytd" onclick="dt_custom_view('ytd', '.table-<?php echo $table; ?>', 'ytd'); return false;">YTD</a>
                                        </li>
                                        <li class="dropdown-submenu pull-left">
                                            <a href="#" tabindex="-1">Custom dates</a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                <li>
                                                    <div class="input-group date">
                                                        <input type="text" id="start_date" name="start_date" data-cview="start_date" placeholder="start date"  class="form-control datepicker" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : '' ?>" autocomplete="off" aria-invalid="false">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar calendar-icon"></i>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group date">
                                                        <input type="text" id="end_date" name="end_date" data-cview="end_date"  placeholder="end date" class="form-control datepicker" value="" autocomplete="off" aria-invalid="false"><div class="input-group-addon">
                                                            <i class="fa fa-calendar calendar-icon"></i>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <input type="submit" data-cview="custome_date" onclick="dt_custom_view('custome_date', '.table-<?php echo $table; ?>', 'custome_date'); return false;" class="btn btn-success" value="search">
                                                </li>

                                            </ul>
                                        </li>

                                    </ul>
                                </div>

                          
                            </div>
                        </div>
                        <hr class="hr-panel-heading hr-10" />
                        <p id="stocktable_msg"></p>
                        <div class="clearfix"></div>
                        
                            <?php //$this->load->view('admin/stock/_summary', array('table' => '.table-stocks')); ?>
                            <a href="#" data-toggle="modal" data-target="#stock_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-stocks"><?php echo _l('bulk_actions'); ?></a>
                            <a href="#" data-toggle="modal" data-target="#search_serial_numberModel" class="hide bulk-actions-btn table-btn" data-table=".table-stocks">Search by serial number</a>
                            <div class="_hidden_inputs _filters <?php echo '_'.$table.'_filters'; ?>">
                                <?php
                                    echo form_hidden('table',$table);
                                    echo form_hidden('all');
                            echo form_hidden('today');
  echo form_hidden('this_week');
  echo form_hidden('this_month');
  echo form_hidden('ytd');
  echo form_hidden('start_date');
  echo form_hidden('end_date');
  echo form_hidden('custome_date');
                                    echo form_hidden('comapany',$comapany);
                                    if(isset($permision_department) && !empty($permision_department)){
                                        foreach ($permision_department as $key=>$value){
                                            echo form_hidden($value,$value);
                                        }
                                    }
                                  //  echo form_hidden('permision_department',$permision_department);
                                ?>
                            </div>
                            <?php $this->load->view('admin/pms_report/_table', array('bulk_actions' => true)); ?>
                            <?php //$this->load->view('admin/stock/_bulk_actions'); ?>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
