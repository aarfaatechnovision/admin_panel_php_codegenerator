<?php

function my_db_connection($hostname, $username, $password, $dbname)
{
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    return $conn; 
}

function select_query($conn, $tablename, $where_fields, $where_conditions, $limit, $order_by_field, $order_by)
{
    $whereconditions = "";
    $query = "SELECT * FROM ".$tablename;
    
    for($i = 0; $i < sizeof($where_fields); $i++)
    {
        if($i == 0)
        {
            if (strpos($where_conditions[$i], '~') !== false) {
               $mcondition = str_replace("~","",$where_conditions[$i]);
                $whereconditions = " WHERE `".$where_fields[$i]."` != ".$mcondition."";
            }
            else{
                $whereconditions = " WHERE `".$where_fields[$i]."` = '".$where_conditions[$i]."'";
            }
        }
        else{
            if (strpos($where_conditions[$i], '~') !== false) {
                $mcondition = str_replace("~","",$where_conditions[$i]);
                $whereconditions = $whereconditions." AND `".$where_fields[$i]."` != ".$mcondition."";
            }
            else{
                $whereconditions = $whereconditions." AND `".$where_fields[$i]."` = '".$where_conditions[$i]."'";
            }
        
        }
    }
    
    if($order_by_field == '')
    {
        $order_by_call = "";
    }
    else
    {
        if($order_by == 0)
        {
            $order_by_call = " ORDER BY ".$order_by_field." ASC ";
        }
        else{
            $order_by_call = " ORDER BY ".$order_by_field." DESC ";
        }
    }
    
    if($limit > 0)
    {
        $limitcall = " LIMIT ".$limit;
    }
    else{
       $limitcall = ""; 
    }
    
   $finalQuery = $query."".$whereconditions."".$order_by_call."".$limitcall;
   // exit();
    $result = mysqli_query($conn, $finalQuery);
    
    $get_column_names = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='".$tablename."';";
    $result_column_names = mysqli_query($conn, $get_column_names);
    $cnamesarray = array();
    while($rowcname = mysqli_fetch_array($result_column_names, MYSQLI_ASSOC))
    {
        $columnnames = array("COLUMN_NAME", $rowcname['COLUMN_NAME']);
        array_push($cnamesarray, $columnnames);
        
    }
    
   // $finalarrayforcnames = json_encode($cnamesarray);
   
   $a3 = array();
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $a2 = array();
        for($j = 0; $j < sizeof($cnamesarray); $j++)
        { 
          $a0 = array($cnamesarray[$j][1] => $row[$cnamesarray[$j][1]]);
          
          $a2 = array_merge($a2, $a0);
        }
        array_push($a3, $a2);
    }
    
    $response = array("status" => "success", "row_count" => mysqli_num_rows($result) ,"data" => $a3 );
    $finalresult = json_encode($response);
    
    $d = json_decode($finalresult);

    
    return $d;
    
}







function insert_query($conn, $tablename, $fields, $values)
{
    
    
$fielsForInsert = "";
$valuesForInsert = "";
    for($i = 0; $i < sizeof($fields); $i++)
    {
        if($i == (sizeof($fields)-1))
        {
        $fielsForInsert = $fielsForInsert."`".$fields[$i]."`";
        $valuesForInsert = $valuesForInsert."'".$values[$i]."'";            
        }
        else{
        $fielsForInsert = $fielsForInsert."`".$fields[$i]."`, ";
        $valuesForInsert = $valuesForInsert."'".$values[$i]."', ";
        }
    }
    $insertquery = "INSERT INTO ".$tablename." (".$fielsForInsert.") VALUES (".$valuesForInsert.")";
    $result = mysqli_query($conn, $insertquery);
    
    

    $response = array("status" => "success", "insertId" => mysqli_insert_id($conn));
    $finalresult = json_encode($response);
    
    $d = json_decode($finalresult);

    
    return $d;
    
}







function update_query($conn, $table_name, $update_fields, $update_values, $where_fields, $where_condition)
{
    
    $updatequery = "UPDATE ".$table_name." SET ";
    
    for($i =0; $i < sizeof($update_fields); $i++)
    {
        if($i == 0)
        {
            $updatequery = $updatequery." ".$update_fields[$i]."=".$update_values[$i];
        }
        else{
            $updatequery = $updatequery.", ".$update_fields[$i]."=".$update_values[$i];
        }
    }
    
    $whereStatement = "";
    
    for($i = 0; $i < sizeof($where_fields); $i++)
    {
        if($i == 0)
        {
            $whereStatement = $whereStatement." WHERE ".$where_fields[$i]."=".$where_condition[$i];
        }
        else{
            $whereStatement = $whereStatement." AND ".$where_fields[$i]."=".$where_condition[$i];
        }
    }
    
    $finalquery = $updatequery."".$whereStatement;
    //exit();
    $result = mysqli_query($conn, $finalquery);
    
    $response = array("status" => "success", "msg" => "Data Updated");
    $finalresult = json_encode($response);
    
    $d = json_decode($finalresult);

    
    return $d;
    
    
}







function create_table($conn, $table_name, $column_names_for_table, $respective_column_names_from_db, $where_fields, $where_conditions, $order_by_field, $orderby_condition, $limit, $delete_action_display, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $redirect_page)
{
    
    
    
    
    
   ?>
   
   
   
<!--
=========================================================
 Material Dashboard - v2.1.1
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    AARFAA TABLE FUNCTION
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
  
</head>


  <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Table</h4>
                  <p class="card-category" style="float:right;"><span id="add_button_from_js"></span></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                      <thead class="text-primary">
                        <th>
                          ID
                        </th>

<?php

for($i = 0; $i < sizeof($column_names_for_table); $i++)
{
    ?>
    <th><?php echo $column_names_for_table[$i]; ?></th>
<?php }

if($delete_action_display == 1)
{

?>
<th>Action <i class="material-icons fontsize" style="font-size:32px;">delete</i></th>
<?php
}
?>

                      </thead>
                      <tbody>
                        
                            <?php

                            $data = select_query($conn, $table_name, $where_fields, $where_conditions, $limit, $order_by_field, $orderby_condition);
                            
                            for($i=0; $i<$data->row_count; $i++)
                            {
                             
                                ?>
                                <tr>
                                    <td><?php echo $i + 1;?></td>
                                   <?php
                                    for($j = 0; $j < sizeof($respective_column_names_from_db); $j++)
                                    {
                                       $nameofcolumndisplay = $respective_column_names_from_db[$j];
                                       // print_r($data->data[$i]->$name);
                                        ?>
                                        
                                        <td><?php echo $data->data[$i]->$nameofcolumndisplay;?></td>
                                        
                                        <?php
                                    }
                                    
                                    if($delete_action_display == 1)
                                    {
                                    ?>
                                    
                                   
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo $redirect_page; ?>?call=called&pkid=<?php echo $data->data[$i]->$tables_primary_key_name; ?>"><i class="material-icons fontsize" style="font-size:32px;">delete</i></a>
                                    </td>
                                    
                                    
                                    
                                    <?php
                                    
                                    
                                    
                                    
                                    }
                                    ?>
                                    
                                </tr>
                                <?php
                                
                            }
                            
                            ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   


   <footer class="footer">
        <div class="container-fluid">
          
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by 
            <a href="https://aarfaatechnovision.com/" target="_blank">AARFAA TECHNOVISION</a>.
          </div>
        </div>
      </footer>
   


  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ]
    } );
} );
</script>
  
  

</html>

   
   
   <?php
    
     function abc($conn, $table_name, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $pkid)
    {
        update_query($conn, $table_name, $delete_updation_column_name, $update_contionds_for_deletion, [$tables_primary_key_name], [$pkid]);
    }
    
    
    if(isset($_REQUEST['call']))
    {
        abc($conn, $table_name, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $_REQUEST['pkid']);
        
        ?>
        <script>window.location.replace("<?php echo $redirect_page; ?>");</script>
        <?php
    }
    
}





function join_tables($conn, $tablenames, $join_on_conditions ,$where_fields, $where_conditions, $limit, $order_by_field, $order_by)
{
    $whereconditions = "";
    $query = "SELECT * FROM ".$tablenames[0]." t0 inner join ".$tablenames[1]." t1 on t0.".$join_on_conditions[0]." = t1.".$join_on_conditions[1];
    
    
    $incrementid = 0;
    
    for($i = 2; $i < sizeof($tablenames); $i++)
    {
        $query = $query." inner join ".$tablenames[$i]." t".$i." on t".($i-1).".".$join_on_conditions[($i + $incrementid)]." = t".$i.".".$join_on_conditions[$i+$incrementid+1];
        $incrementid = $incrementid + 1;
    }
    
    
    
    
    
    for($i = 0; $i < sizeof($where_fields); $i++)
    {
        if($i == 0)
        {
        $whereconditions = " WHERE `".$where_fields[$i]."` = '".$where_conditions[$i]."'";
        }
        else{
        $whereconditions = $whereconditions." AND `".$where_fields[$i]."` = '".$where_conditions[$i]."'";    
        }
    }
    
    if($order_by_field == '')
    {
        $order_by_call = "";
    }
    else
    {
        if($order_by == 0)
        {
            $order_by_call = " ORDER BY ".$order_by_field." ASC ";
        }
        else{
            $order_by_call = " ORDER BY ".$order_by_field." DESC ";
        }
    }
    
    if($limit > 0)
    {
        $limitcall = " LIMIT ".$limit;
    }
    else{
       $limitcall = ""; 
    }
    
    $finalQuery = $query."".$whereconditions."".$order_by_call."".$limitcall;
    
    $result = mysqli_query($conn, $finalQuery);
    
    $cnamesarray = array();
    
    for($n = 0; $n < sizeof($tablenames); $n++)
    {
    $get_column_names = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='".$tablenames[$n]."';";
    $result_column_names = mysqli_query($conn, $get_column_names);
    
    while($rowcname = mysqli_fetch_array($result_column_names, MYSQLI_ASSOC))
    {
        $columnnames = array("COLUMN_NAME", $rowcname['COLUMN_NAME']);
        array_push($cnamesarray, $columnnames);
    }
    
    }
    
   // $finalarrayforcnames = json_encode($cnamesarray);
   
   $a3 = array();
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $a2 = array();
        for($j = 0; $j < sizeof($cnamesarray); $j++)
        { 
          $a0 = array($cnamesarray[$j][1] => $row[$cnamesarray[$j][1]]);
          
          $a2 = array_merge($a2, $a0);
        }
        array_push($a3, $a2);
    }
    
    $response = array("status" => "success", "row_count" => mysqli_num_rows($result) ,"data" => $a3 );
    $finalresult = json_encode($response);
    
    $d = json_decode($finalresult);

    
    return $d;
    
}






function create_table_by_join($conn, $table_names, $join_on_columns, $column_names_for_table, $respective_column_names_from_db, $where_fields, $where_conditions, $order_by_field, $orderby_condition, $limit, $delete_action_display, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $redirect_page, $table_name_update)
{
    
   ?>
   
   
   
<!--
=========================================================
 Material Dashboard - v2.1.1
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    AARFAA TABLE FUNCTION
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
  
</head>


  <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Table</h4>
                  <p class="card-category" style="float:right;"><span id="add_button_from_js"></span></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                      <thead class="text-primary">
                        <th>
                          ID
                        </th>

<?php

for($i = 0; $i < sizeof($column_names_for_table); $i++)
{
    ?>
    <th><?php echo $column_names_for_table[$i]; ?></th>
<?php }

if($delete_action_display == 1)
{

?>
<th>Action <i class="material-icons fontsize" style="font-size:32px;">delete</i></th>
<?php
}
?>

                      </thead>
                      <tbody>
                        
                            <?php

                            $data =  join_tables($conn, $table_names, $join_on_columns, $where_fields, $where_conditions, $limit, $order_by_field, $orderby_condition);
                            
                            for($i=0; $i<$data->row_count; $i++)
                            {
                             
                                ?>
                                <tr>
                                    <td><?php echo $i + 1;?></td>
                                   <?php
                                    for($j = 0; $j < sizeof($respective_column_names_from_db); $j++)
                                    {
                                       $nameofcolumndisplay = $respective_column_names_from_db[$j];
                                       // print_r($data->data[$i]->$name);
                                        ?>
                                        
                                        <td><?php echo $data->data[$i]->$nameofcolumndisplay;?></td>
                                        
                                        <?php
                                    }
                                    
                                    if($delete_action_display == 1)
                                    {
                                    ?>
                                    
                                   
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo $redirect_page; ?>?call=called&pkid=<?php echo $data->data[$i]->$tables_primary_key_name; ?>"><i class="material-icons fontsize" style="font-size:32px;">delete</i></a>
                                    </td>
                                    
                                    
                                    
                                    <?php
                                    
                                    
                                    
                                    
                                    }
                                    ?>
                                    
                                </tr>
                                <?php
                                
                            }
                            
                            ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   


   <footer class="footer">
        <div class="container-fluid">
          
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by 
            <a href="https://aarfaatechnovision.com/" target="_blank">AARFAA TECHNOVISION</a>.
          </div>
        </div>
      </footer>
   


  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ]
    } );
} );
</script>
  
  

</html>

   
   
   <?php
    
     function abc($conn, $table_name_update, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $pkid)
    {
        update_query($conn, $table_name_update, $delete_updation_column_name, $update_contionds_for_deletion, [$tables_primary_key_name], [$pkid]);
    }
    
    
    if(isset($_REQUEST['call']))
    {
        abc($conn, $table_name_update, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $_REQUEST['pkid']);
        
        ?>
        <script>window.location.replace("<?php echo $redirect_page; ?>");</script>
        <?php
    }
    
}










function join_tables_new($conn, $tablenames, $join_on_conditions ,$where_fields, $where_conditions, $limit, $order_by_field, $order_by)
{
    $whereconditions = "";

    $query = "";
    for($i = 0; $i < sizeof($tablenames); $i++)
    {
        if($i == 0)
        {
        $query = "SELECT * FROM ".$tablenames[$i][0]." t".$i."0 inner join ".$tablenames[$i][1]." t".$i."1 on t".$i."0.".$join_on_conditions[$i][0]." = t".$i."1.".$join_on_conditions[$i][1];
            
        }
        else{
            
            $tablepositionfind = explode($tablenames[$i][0]." ", $query);
            $tablenamefind = explode(" ", $tablepositionfind[1]);
            
        $query = $query." inner join ".$tablenames[$i][1]." t".$i."0 on t".$i."0.".$join_on_conditions[$i][1]." = ".$tablenamefind[0].".".$join_on_conditions[$i][0];    
        }
        
    }

    for($i = 0; $i < sizeof($where_fields); $i++)
    {
        if($i == 0)
        {
        if(strpos($where_conditions[$i], '>') !== false)
        {
            $whereconditions = " WHERE `".$where_fields[$i]."` > '".$where_conditions[$i]."'";
        }
        else if(strpos($where_conditions[$i], '<') !== false){
            $whereconditions = " WHERE `".$where_fields[$i]."` < '".$where_conditions[$i]."'";
        }
        else if(strpos($where_conditions[$i], '>=') !== false)
        {
            $whereconditions = " WHERE `".$where_fields[$i]."` >= '".$where_conditions[$i]."'";
        }
        else if(strpos($where_conditions[$i], '<=') !== false)
        {
            $whereconditions = " WHERE `".$where_fields[$i]."` <= '".$where_conditions[$i]."'";
        }
        else if (strpos($where_conditions[$i], '~') !== false) {
            $whereconditions = " WHERE `".$where_fields[$i]."` != '".$where_conditions[$i]."'";
        }
        else{
            $whereconditions = " WHERE `".$where_fields[$i]."` = '".$where_conditions[$i]."'";    
        }
        
        
        }
        else{
            
            if(strpos($where_conditions[$i], '>') !== false)
        {
            $whereconditions = $whereconditions." AND `".$where_fields[$i]."` > '".$where_conditions[$i]."'";
        }
        else if(strpos($where_conditions[$i], '<') !== false){
            $whereconditions = $whereconditions." AND `".$where_fields[$i]."` < '".$where_conditions[$i]."'";
        }
        else if(strpos($where_conditions[$i], '>=') !== false)
        {
            $whereconditions = $whereconditions." AND `".$where_fields[$i]."` >= '".$where_conditions[$i]."'";
        }
        else if(strpos($where_conditions[$i], '<=') !== false)
        {
            $whereconditions = $whereconditions." AND `".$where_fields[$i]."` <= '".$where_conditions[$i]."'";
        }
        else if (strpos($where_conditions[$i], '~') !== false) {
            $whereconditions = $whereconditions." AND `".$where_fields[$i]."` != '".$where_conditions[$i]."'";
        }
        else{
            $whereconditions = $whereconditions." AND `".$where_fields[$i]."` = '".$where_conditions[$i]."'";
        }
            
            
        }
    }
    
    if($order_by_field == '')
    {
        $order_by_call = "";
    }
    else
    {
        if($order_by == 0)
        {
            $order_by_call = " ORDER BY ".$order_by_field." ASC ";
        }
        else{
            $order_by_call = " ORDER BY ".$order_by_field." DESC ";
        }
    }
    
    if($limit > 0)
    {
        $limitcall = " LIMIT ".$limit;
    }
    else{
       $limitcall = ""; 
    }
    
    $finalQuery = $query."".$whereconditions."".$order_by_call."".$limitcall;
    
    $result = mysqli_query($conn, $finalQuery);
    
    $cnamesarray = array();
    
    $cnamesgettablesarray = array();
    for($n = 0; $n < sizeof($tablenames); $n++)
    {
    
    for($mn = 0; $mn < 2; $mn++)
    {
    $getcolumnnamesfromtable = $tablenames[$n][$mn];
    
    if (!in_array($getcolumnnamesfromtable, $cnamesgettablesarray)) {
        array_push($cnamesgettablesarray, $getcolumnnamesfromtable);
    
    
    $get_column_names = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='".$getcolumnnamesfromtable."';";
    
    
    $result_column_names = mysqli_query($conn, $get_column_names);
    
    while($rowcname = mysqli_fetch_array($result_column_names, MYSQLI_ASSOC))
    {
        $columnnames = array("COLUMN_NAME", $rowcname['COLUMN_NAME']);
        array_push($cnamesarray, $columnnames);
    }
    
    }
    }
    
    }
    
   // $finalarrayforcnames = json_encode($cnamesarray);
   
   $a3 = array();
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $a2 = array();
        for($j = 0; $j < sizeof($cnamesarray); $j++)
        { 
          $a0 = array($cnamesarray[$j][1] => $row[$cnamesarray[$j][1]]);
          
          $a2 = array_merge($a2, $a0);
        }
        array_push($a3, $a2);
    }
    
    $response = array("status" => "success", "row_count" => mysqli_num_rows($result) ,"data" => $a3 );
    $finalresult = json_encode($response);
    
    $d = json_decode($finalresult);

    return $d;
    
}














function create_table_by_join_new($conn, $table_names, $join_on_columns, $column_names_for_table, $respective_column_names_from_db, $where_fields, $where_conditions, $order_by_field, $orderby_condition, $limit, $delete_action_display, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $redirect_page, $table_name_update)
{
    
   ?>
   
   
   
<!--
=========================================================
 Material Dashboard - v2.1.1
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    AARFAA TABLE FUNCTION
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
  
</head>


  <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Table</h4>
                  <p class="card-category" style="float:right;"><span id="add_button_from_js"></span></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                      <thead class="text-primary">
                        <th>
                          ID
                        </th>

<?php

for($i = 0; $i < sizeof($column_names_for_table); $i++)
{
    ?>
    <th><?php echo $column_names_for_table[$i]; ?></th>
<?php }

if($delete_action_display == 1)
{

?>
<th>Action <i class="material-icons fontsize" style="font-size:32px;">delete</i></th>
<?php
}
?>

                      </thead>
                      <tbody>
                        
                            <?php

                            $data =  join_tables_new($conn, $table_names, $join_on_columns, $where_fields, $where_conditions, $limit, $order_by_field, $orderby_condition);
                            
                            for($i=0; $i<$data->row_count; $i++)
                            {
                             
                                ?>
                                <tr>
                                    <td><?php echo $i + 1;?></td>
                                   <?php
                                    for($j = 0; $j < sizeof($respective_column_names_from_db); $j++)
                                    {
                                       $nameofcolumndisplay = $respective_column_names_from_db[$j];
                                       // print_r($data->data[$i]->$name);
                                        ?>
                                        
                                        <td><?php echo $data->data[$i]->$nameofcolumndisplay;?></td>
                                        
                                        <?php
                                    }
                                    
                                    if($delete_action_display == 1)
                                    {
                                    ?>
                                    
                                   
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo $redirect_page; ?>?call=called&pkid=<?php echo $data->data[$i]->$tables_primary_key_name; ?>"><i class="material-icons fontsize" style="font-size:32px;">delete</i></a>
                                    </td>
                                    
                                    
                                    
                                    <?php
                                    
                                    
                                    
                                    
                                    }
                                    ?>
                                    
                                </tr>
                                <?php
                                
                            }
                            
                            ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   


   <footer class="footer">
        <div class="container-fluid">
          
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by 
            <a href="https://aarfaatechnovision.com/" target="_blank">AARFAA TECHNOVISION</a>.
          </div>
        </div>
      </footer>
   


  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ]
    } );
} );
</script>
  
  

</html>

   
   
   <?php
    
     function abc($conn, $table_name_update, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $pkid)
    {
        update_query($conn, $table_name_update, $delete_updation_column_name, $update_contionds_for_deletion, [$tables_primary_key_name], [$pkid]);
    }
    
    
    if(isset($_REQUEST['call']))
    {
        abc($conn, $table_name_update, $delete_updation_column_name, $update_contionds_for_deletion, $tables_primary_key_name, $_REQUEST['pkid']);
        
        ?>
        <script>window.location.replace("<?php echo $redirect_page; ?>");</script>
        <?php
    }
    
}






?>




