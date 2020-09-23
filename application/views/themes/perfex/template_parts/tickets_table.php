<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<table class="table dt-table table-tickets" data-order-col="<?php echo (get_option('services') == 1 ? 7 : 6); ?>" data-order-type="desc">
  <thead>
    <th width="10%" class="th-ticket-number"><?php echo _l('clients_tickets_dt_number'); ?></th>
    <th class="th-ticket-subject"><?php echo _l('clients_tickets_dt_subject'); ?></th>
    <?php if($show_submitter_on_table) { ?>
      <th class="th-ticket-submitter"><?php echo _l('ticket_dt_submitter'); ?></th>
    <?php } ?>
    <th class="th-ticket-department"><?php echo _l('clients_tickets_dt_department'); ?></th>
    <th class="th-ticket-project"><?php echo _l('project'); ?></th>
    <?php if(get_option('services') == 1){ ?>
      <th class="th-ticket-service"><?php echo _l('clients_tickets_dt_service'); ?></th>
      <?php if(get_client_user_id() == RECHARGER_CUSTOMER){ ?>
        <th class="th-ticket-service"><?php echo 'Sub Category'; ?></th>
      <?php } ?>
    <?php } ?>
    <th class="th-ticket-priority"><?php echo _l('priority'); ?></th>
    <th class="th-ticket-status"><?php echo _l('clients_tickets_dt_status'); ?></th>
    <th class="th-ticket-last-reply"><?php echo _l('clients_tickets_dt_last_reply'); ?></th>
    <th class="th-ticket-last-reply"><?php echo _l('ticket_meter_number'); ?></th>
    <th class="th-ticket-last-reply"><?php echo _l('ticket_drp_channel_type'); ?></th>
    <th class="th-ticket-last-reply"><?php echo _l('ticket_form_message'); ?></th>
    <?php
    $custom_fields = get_custom_fields('tickets',array('show_on_client_portal'=>1));
    foreach($custom_fields as $field){ ?>
      <!--<th><?php echo $field['name']; ?></th>-->
    <?php } ?>
  </thead>
  <tbody>
      
    <?php foreach($tickets as $ticket){ ?>
      <tr class="<?php if($ticket['clientread'] == 0){echo 'text-danger';} ?>">
        <td data-order="<?php echo $ticket['ticketid']; ?>">
          <a href="<?php echo site_url('clients/ticket/'.$ticket['ticketid']); ?>">
            #<?php echo $ticket['ticketid']; ?>
          </a>
        </td>
        <td>
          <a href="<?php echo site_url('clients/ticket/'.$ticket['ticketid']); ?>">
            <?php echo $ticket['subject']; ?>
          </a>
        </td>
        <?php if($show_submitter_on_table) { ?>
          <td>
            <?php echo $ticket['user_firstname'] . ' ' . $ticket['user_lastname'];  ?>
          </td>
        <?php } ?>
        <td>
          <?php echo $ticket['department_name']; ?>
        </td>
        <td>
          <?php
          if($ticket['project_id'] != 0){
            echo '<a href="'.site_url('clients/project/'.$ticket['project_id']).'">'.get_project_name_by_id($ticket['project_id']).'</a>';
          }
          ?>
        </td>
        <?php if(get_option('services') == 1){ ?>
        <?php if(get_client_user_id() == RECHARGER_CUSTOMER){ ?>
          <td>
            <?php echo get_services_name($ticket['parentid']);$ticket['service_name']; ?>
          </td>
          
          <td>
            <?php echo get_services_name($ticket['serviceid']); ?>
          </td>
          <?php }else{ ?>
          <td>
            <?php echo $ticket['service_name']; ?>
          </td>
          <?php } ?>
        <?php } ?>
        <td>
          <?php
          echo ticket_priority_translate($ticket['priority']);
          ?>
        </td>
        <td>
          <span class="label inline-block" style="background:<?php echo $ticket['statuscolor']; ?>">
            <?php echo ticket_status_translate($ticket['ticketstatusid']); ?></span>
          </td>
          <td data-order="<?php echo $ticket['lastreply']; ?>">
            <?php
            if ($ticket['lastreply'] == NULL) {
             echo _l('client_no_reply');
           } else {
             echo _dt($ticket['lastreply']);
           }
           ?>
         </td>
            <td>
                <?php echo $ticket['meter_number'] > 0 ? ticket_meter_number_name($ticket['meter_number']) : $ticket['notice_number']; ?>
             </td>
             <td>
                 
                <?php echo ticket_channel_type_name($ticket['channel_type_id']); ?>
             </td>
             <td>
                 
                <?php echo $ticket['description']; ?>
             </td>
             <?php foreach($custom_fields as $field){ ?>
          <!--<td>-->
            <?php //echo get_custom_field_value($ticket['ticketid'],$field['id'],'tickets'); ?>
          <!--</td>-->
        <?php } ?>
      </tr>
    <?php } ?>
  </tbody>
</table>
