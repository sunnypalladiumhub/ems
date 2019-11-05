<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
        <div class="row">
            <form action="<?php echo base_url() . 'admin/dashboard/ems_dashboard' ?>" method="post" >
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="col-md-12 mtop30 ui-sortable" data-container="top-12">
                    <div class="widget relative" id="widget-top_stats" data-name="Quick Statistics">
                        <div class="widget-dragger ui-sortable-handle"></div>
                        <div class="panel_s">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-sm-1">

                                    </div>
                                    <div class="form-group col-md-2">
                                        <?php echo render_select('department_id', $departments_results, array('departmentid', 'name'), 'ticket_settings_departments', isset($departments_id) ? $departments_id : '' ); ?>
<!--                                        <select id="department_id" name="department_id" class="form-control">
                                            <option value="">-- All Departments --  </option>
                                            <?php foreach ($departments_results as $key => $value) { ?>
                                                <option value="<?php echo $value['departmentid']; ?>" <?php echo (isset($departments_id) && $departments_id == $value['departmentid']) ? "selected='selected'" : ''; ?> ><?php echo $value['name']; ?></option>
                                            <?php } ?>
                                        </select>-->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <?php echo render_select('group_id', $groups_results, array('id', 'name'), 'ticket_drp_grp_type', isset($group_id) ? $group_id : '' ); ?>
<!--                                        <select id="group_id" name="group_id" class="form-control">
                                            <option value="">-- All Groups --  </option>
                                            <?php foreach ($groups_results as $key => $value) { ?>
                                                <option value="<?php echo $value['id']; ?>" <?php echo (isset($group_id) && $group_id == $value['id']) ? "selected='selected'" : ''; ?> ><?php echo $value['name']; ?></option>
                                            <?php } ?>
                                        </select>-->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <?php echo render_select('province_id', $province_results, array('name', 'name'), 'ticket_contact_province', isset($province) ? $province : '' ); ?>
<!--                                        <select id="province_id" name="province_id" class="form-control">
                                            <option value="">-- All Province --  </option>
                                            <?php foreach ($province_results as $key => $value) { ?>
                                                <option value="<?php echo $value['name']; ?>" <?php echo (isset($province) && $province == $value['name']) ? "selected='selected'" : ''; ?> ><?php echo $value['name']; ?></option>
                                            <?php } ?>
                                        </select>-->
                                    </div>
                                    <div class="form-group col-md-3">
                                        
                                        <?php echo render_select_for_company_name('customer_id', $customer_results, array('userid', array('company','vat')), 'ticket_drp_company_name', isset($customer_id) ? $customer_id : '' ); ?>
<!--                                        <select id="customer_id" name="customer_id" class="form-control">
                                            <option value="">-- All Customer --  </option>
                                            <?php foreach ($customer_results as $key => $value) { ?>
                                                <option value="<?php echo $value['userid']; ?>" <?php echo (isset($customer_id) && $customer_id == $value['userid']) ? "selected='selected'" : ''; ?> ><?php echo $value['company']; ?></option>
                                            <?php } ?>
                                        </select>-->
                                    </div>
                                    
                                    
                                    <div class="col-md-2">
                                        
                                        <button type="submit" class="btn btn-default" style="margin-top: 18%;" id="sub_customer">Submit</button>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div class="clearfix"></div>

            <div class="col-md-12 mtop30 ui-sortable" data-container="top-12">
                <?php render_ems_dashboard_widgets('top-12'); ?>
            </div>


            <!--            <div class="col-md-12" data-container="top-12">
            <?php //render_ems_dashboard_widgets('top-12'); ?>
                        </div>-->
            <div class="col-md-8" data-container="left-8">
                <?php render_ems_dashboard_widgets('left-8'); ?>
            </div>
            <div class="col-md-4" data-container="right-4">
                <?php render_ems_dashboard_widgets('right-4'); ?>
            </div>
            <div class="col-md-12" data-container="bottom-12">
                <?php //render_ems_dashboard_widgets('bottom-12'); ?>
            </div>
            <div class="clearfix"></div>

            <?php hooks()->do_action('after_dashboard'); ?>
        </div>

    </div>
</div>
<!--<script>
    app.calendarIDs = '<?php //echo json_encode($google_ids_calendars);  ?>';
</script>-->
<?php init_tail(); ?>
<?php // $this->load->view('admin/utilities/calendar_template'); ?>
<?php $this->load->view('admin/ems_dashboard/dashboard_js'); ?>
</body>
</html>
