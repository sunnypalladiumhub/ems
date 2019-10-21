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
    <tr>
  <?php 
      $department = array()  ;
      if(!empty($report)){
          $index = 0;
          foreach($report as $key=>$value){
              if($index == 0){ ?>
                  <th>#</th>
                  <?php foreach($value as $key1 => $value1){ ?>
                    <th style="padding: 5px;"><?php echo $key1; ?></th>
                  <?php $index++; }
              }
          }
      } ?>
    </tr>
      <?php foreach ($report as $key=>$value){
  
          ?>
    <tr><td ><b><?php echo $key ?></b></td>
      <?php foreach ($value as $data_key=>$data){ ?>
      
      <td style="padding: 10px;"><?php echo $data ?></td>
      
      <?php } ?>
  </tr>
<?php } ?>
</table>


<br /><br />Kind Regards, <br /><br />(This is an automated email, so please don't reply to this email address)



</body>
</html>
