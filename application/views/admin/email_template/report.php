<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
}
</style>
</head>
<body>

Dear <?php echo $staff_first_name; ?> <?php echo $staff_last_name; ?><br /><br />


<table>
  <?php 
      foreach ($report as $key=>$value){
  
          ?>
    <tr><th colspan="12"><?php echo $key ?></th></tr>
  <tr>
      <?php foreach ($value as $data_key=>$data){ ?>
      
      <td style="padding: 10px;"><?php echo $data_key ?> -- <?php echo $data ?></td>
      
      <?php } ?>
  </tr>
<?php          
      }
      ?>
</table>


<br /><br />Kind Regards, <br /><br />(This is an automated email, so please don't reply to this email address)



</body>
</html>
