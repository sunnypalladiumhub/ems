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
                                <?php //$this->load->view('admin/stock/tasks_filter_by', array('view_table_name' => '.table-stocks')); ?>
                          
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
                                    if(isset($permision_department) && !empty($permision_department)){
                                        foreach ($permision_department as $key=>$value){
                                            echo form_hidden($value,$value);
                                        }
                                    }
                                  //  echo form_hidden('permision_department',$permision_department);
                                ?>
                            </div>
                            <?php $this->load->view('admin/ems_report/_table', array('bulk_actions' => true)); ?>
                            <?php //$this->load->view('admin/stock/_bulk_actions'); ?>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
