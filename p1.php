<?php

include('../include/dbcon.php');









$q = "show tables from ".$databasename;

$result = mysqli_query($conn, $q); 

$tablewiselist = "";

while($table = mysqli_fetch_array($result))
{
    $tablename = $table[0];
    
    $jointables = array();
    
    array_push($jointables, $tablename);
    
   $tablewiselist = $tablewiselist ."<li>
            <a href=\"".str_replace(' ', '', $tablename).".php\" class=\"dropdown-toggle no-arrow\" id=\"".str_replace(' ', '', $tablename)."\">
              <span class=\"fa fa-calendar-o\"></span><span class=\"mtext\">".ucwords(str_replace('_', ' ', $tablename))."</span>
            </a>
          </li>";
         
    
         $gettabledetails = "DESCRIBE `".str_replace(' ', '', $tablename)."`";
         $resulttabledetails = mysqli_query($conn, $gettabledetails);
         
         $createpageforonetable3 = "";
         
         
         $arrayofcolumnnames = array();
         
         
    $createpageforonetable1 = "<?php 
\n
include('include/admin_header.php'); 
include('callback_functions/quries.php');
\n
?>
\n
<div class=\"main-container\">
		<div class=\"pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10\">
			<div class=\"min-height-200px\">
				<div class=\"page-header\">
					<div class=\"row\">
						<div class=\"col-md-12 col-sm-12\">
							<div class=\"title\">
								<h4>Dashboard</h4>
							</div>
							<nav aria-label=\"breadcrumb\" role=\"navigation\">
								<ol class=\"breadcrumb\">
									<li class=\"breadcrumb-item\"><a href=\"index.php\">Home</a></li>
									<li class=\"breadcrumb-item active\" aria-current=\"page\">".ucwords(str_replace('_', ' ', str_replace(' ', '', $tablename)))."</li>
								</ol>
							</nav>
						</div>
						<div class=\"col-md-6 col-sm-12 text-right\">
							
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class=\"pd-20 bg-white border-radius-4 box-shadow mb-30\">
					<div class=\"clearfix mb-20\">
						<div class=\"\">
							<h5 class=\"text-blue\">Data of ".ucwords(str_replace('_', ' ', str_replace(' ', '', $tablename)))."</h5>
							<a class=\"btn btn-danger\" href=\"add_".str_replace(' ', '', $tablename).".php?edit=0\" style=\"float: right !important;\"> <span class=\"fa fa-plus\"></span> Add ".ucwords(str_replace('_', ' ', str_replace(' ', '', $tablename)))." Data</a>
						
						</div>
					</div>
					<div class=\"row\">
						<div class=\"table-responsive\">
                    <table class=\"table table-bordered stripe hover multiple-select-row data-table-export nowrap\" id=\"example1\">
                      <thead class=\" text-primary\">";
                            
                    while($rowtabledetails = mysqli_fetch_array($resulttabledetails, MYSQLI_ASSOC))
                    {
                        
                        if($rowtabledetails['Key'] == "PRI")
                        {
                           $pkcolumname = $rowtabledetails['Field'];
                        }
                        
                        
                        
                        array_push($arrayofcolumnnames, $rowtabledetails['Field']);
                        
                        
                          
                        if($rowtabledetails['Key'] == "MUL")
                        {
                            
                            
                            $relatedcolumnnamechk = $rowtabledetails['Field'];
                            
                            
                           $arrayofcolumnnamesretrunm = mygetdata($arrayofcolumnnames, $conn, $tablename, $relatedcolumnnamechk, $jointables);
                           
                           $arrayofcolumnnames = $arrayofcolumnnamesretrunm[0];
                           $jointables = $arrayofcolumnnamesretrunm[1];
                           
                            
                        }
                        
                          
                    }
                    
                    
                    for($nim = 0; $nim < sizeof($arrayofcolumnnames); $nim++)
                    {
                        $createpageforonetable3 = $createpageforonetable3."<th>".ucwords(str_replace('_', ' ',$arrayofcolumnnames[$nim]))."</th> \n";
                        
                        if($nim == 0)
                        {
                        $arrayofcolumnnamesstring = $arrayofcolumnnames[$nim]; 
                        }
                        else{
                            $arrayofcolumnnamesstring = $arrayofcolumnnamesstring.",".$arrayofcolumnnames[$nim];
                        }
                    }
                    
                    

                            $tablebody = "";
                      $createpageforonetable4 = $createpageforonetable3."<th>Action</th> \n </thead> \n
                      <tbody>";
                      
                      if(sizeof($jointables) == 1)
                      {
                          
                          $tablebody1 = "<?php  \n  
                          \$tname = \"".$jointables[0]."\";\n
                          \$where_fields = array(); \n
                          \$where_conditions = array();\n
                          \$limit = 0;\n
                          \$order_by_field = null;\n
                          \$orderby_condition = 0;\n
                          \$pkcolumname = \"".$pkcolumname."\"; \n
                          \$arrayofcolumnnamesstring = \"".$arrayofcolumnnamesstring."\"; \n
                          \$arrayofcolumnnames = explode(\",\",\$arrayofcolumnnamesstring); \n
                          \n
                          \$data = select_query(\$conn, \$tname, \$where_fields, \$where_conditions, \$limit, \$order_by_field, \$orderby_condition); \n ?> \n\n\n   
                          
                          <?php 
                          \n
                          \n
                          for(\$i = 0; \$i < \$data->row_count; \$i++)
                          {
                          \n
                          ?>
                                <tr>";
                            
                                $arrayofcolumnnamestd = explode(",",$arrayofcolumnnamesstring);
                            
                                $tablebody1 = $tablebody1."<td><?php echo \$i + 1; ?></td> \n";
                            
                                for($aim = 1; $aim < sizeof($arrayofcolumnnamestd); $aim++)
                                {
                                    $ai = $arrayofcolumnnamestd[$aim];
                                
                                
                                        $tablebody1 = $tablebody1."<td><?php echo \$data->data[\$i]->$ai; ?></td> \n";
                                    
                                }
                                
                                $tablebody1 = $tablebody1."\n <td>
										<div class=\"dropdown\">
											<a class=\"btn btn-outline-primary dropdown-toggle\" href=\"#\" role=\"button\" data-toggle=\"dropdown\">
												<i class=\"fa fa-ellipsis-h\"></i>
											</a>
											<div class=\"dropdown-menu dropdown-menu-right\">
												<a class=\"dropdown-item\" href=\"add_".str_replace(' ', '', $tablename).".php?edit=1&id=<?php echo \$data->data[\$i]->\$pkcolumname; ?>\"><i class=\"fa fa-pencil\"></i> Edit</a>
												<a class=\"dropdown-item\" href=\"delete_".str_replace(' ', '', $tablename).".php?id=<?php echo \$data->data[\$i]->\$pkcolumname; ?>\"><i class=\"fa fa-trash\"></i> Delete</a>
											</div>
										</div>
								</td>
                               </tr>
                         <?php
                          }
                          ?>
                          ";
                          $tablebody = $tablebody1;
                          
                      }
                      else{
                            $tablebody1 = "<?php  \n  
                          \$tname = \"".$jointables[0]."\";\n
                          \$where_fields = array(); \n
                          \$where_conditions = array();\n
                          \$limit = 0;\n
                          \$order_by_field = null;\n
                          \$orderby_condition = 0;\n
                          \$pkcolumname = \"".$pkcolumname."\"; \n
                          \$arrayofcolumnnamesstring = \"".$arrayofcolumnnamesstring."\"; \n
                          \$arrayofcolumnnames = explode(\",\",\$arrayofcolumnnamesstring); \n
                          \n
                          \$data = select_query(\$conn, \$tname, \$where_fields, \$where_conditions, \$limit, \$order_by_field, \$orderby_condition); \n ?> \n\n\n   
                          
                          <?php for(\$i = 0; \$i < \$data->row_count; \$i++)
                          {
                          ?>
                                <tr>";
                            
                            $arrayofcolumnnamestd = explode(",",$arrayofcolumnnamesstring);
                            
                                $tablebody1 = $tablebody1."<td><?php echo \$i + 1; ?></td>";
                            
                                for($aim = 1; $aim < sizeof($arrayofcolumnnamestd); $aim++)
                                {
                                    $ai = $arrayofcolumnnamestd[$aim];
                                
                                
                                        $tablebody1 = $tablebody1."<td><?php echo \$data->data[\$i]->$ai; ?></td>";
                                    
                                }
                            
                                
                                
                                    
                                
                                
                                $tablebody1 = $tablebody1."<td>
										<div class=\"dropdown\">
											<a class=\"btn btn-outline-primary dropdown-toggle\" href=\"#\" role=\"button\" data-toggle=\"dropdown\">
												<i class=\"fa fa-ellipsis-h\"></i>
											</a>
											<div class=\"dropdown-menu dropdown-menu-right\">
												<a class=\"dropdown-item\" href=\"add_".str_replace(' ', '', $tablename).".php?edit=1&id=<?php echo \$data->data[\$i]->\$pkcolumname; ?>\"><i class=\"fa fa-pencil\"></i> Edit</a>
												<a class=\"dropdown-item\" href=\"delete_".str_replace(' ', '', $tablename).".php?id=<?php echo \$data->data[\$i]->\$pkcolumname; ?>\"><i class=\"fa fa-trash\"></i> Delete</a>
											</div>
										</div>
								</td>
                               </tr>
                         <?php
                          }
                          ?>
                          ";
                          $tablebody = $tablebody1;
                      }
                      
                      
                      $createpageforonetable2 = $createpageforonetable4." ".$tablebody."</tbody>
                    </table>
                  </div>
					</div>
				</div>
				<!-- Export Datatable End -->
			</div>
			<?php include('include/admin_footer.php'); ?>
		</div>
	</div>








<script>
        document.getElementById(\"".str_replace(' ', '', $tablename)."\").classList.add(\"active\");
    </script>
  \n  
    ";     

$createpageforonetable = $createpageforonetable1." ".$createpageforonetable2;

        
    
    $myfile = fopen("../".str_replace(' ', '', $tablename).".php", "w");

    fwrite($myfile, $createpageforonetable);
    
    
    
    
    
    
    
    
    
    $createpageforonetableadd1 = "<?php 
\n
include('include/admin_header.php'); 
include('callback_functions/quries.php');

\$pagetype = \$_REQUEST['edit'];

if(\$pagetype == 1)
{
    \$id = \$_REQUEST['id'];
    
                          \$tname = \"".$jointables[0]."\";\n
                          \$where_fields = array('".$pkcolumname."'); \n
                          \$where_conditions = array(\$id);\n
                          \$limit = 0;\n
                          \$order_by_field = null;\n
                          \$orderby_condition = 0;\n
                          \$pkcolumname = \"".$pkcolumname."\"; \n
                          \$arrayofcolumnnamesstring = \"".$arrayofcolumnnamesstring."\"; \n
                          \$arrayofcolumnnames = explode(\",\",\$arrayofcolumnnamesstring); \n
    
                
    
    \$data = select_query(\$conn, \$tname, \$where_fields, \$where_conditions, \$limit, \$order_by_field, \$orderby_condition); \n  \n\n\n   
                          
                           
}
else{
    \$id = 0;
}

\n
?>
\n
<div class=\"main-container\">
		<div class=\"pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10\">
			<div class=\"min-height-200px\">
				<div class=\"page-header\">
					<div class=\"row\">
						<div class=\"col-md-12 col-sm-12\">
							<div class=\"title\">
								<h4>".ucwords(str_replace('_', ' ', str_replace(' ', '', $tablename)))."</h4>
							</div>
							<nav aria-label=\"breadcrumb\" role=\"navigation\">
								<ol class=\"breadcrumb\">
									<li class=\"breadcrumb-item\"><a href=\"index.php\">Home</a></li>
									<li class=\"breadcrumb-item\" href=\"".str_replace(' ', '', $tablename).".php\">".ucwords(str_replace('_', ' ', str_replace(' ', '', $tablename)))."</li>
									<li class=\"breadcrumb-item active\" aria-current=\"page\">Add ".ucwords(str_replace('_', ' ', str_replace(' ', '', $tablename)))."</li>
								</ol>
							</nav>
						</div>
						<div class=\"col-md-6 col-sm-12 text-right\">
							
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class=\"pd-20 bg-white border-radius-4 box-shadow mb-30\">
					<div class=\"clearfix mb-20\">
						<div class=\"\">
							<h5 class=\"text-blue\">Add Data of ".str_replace(' ', '', $tablename)."</h5>
						</div>
					</div>
				
				<?php
				
				\$arrayofcolumnnamesdisplay = [];
				\$arrayofcolumnnamesvalue = [];
				
				
                        
				
				        for(\$i = 0; \$i < \$data->row_count; \$i++)
                          {
                          
                                for(\$aim = 0; \$aim < sizeof(\$arrayofcolumnnames); \$aim++)
                                {
                                    
                                    \$ai = \$arrayofcolumnnames[\$aim];
                                    
                                    array_push(\$arrayofcolumnnamesdisplay, \$ai);
                                
                                    \$colvalue = \$data->data[\$i]->\$ai.\"<br>\"; 
                                    array_push(\$arrayofcolumnnamesvalue, \$colvalue);
                                    
                                    
                                }
                                
                          }
                          
                          
                          print_r(\$arrayofcolumnnamesdisplay);
                          print_r(\$arrayofcolumnnamesvalue);
                          
                          
				?>
				    <!--  form goes here-->
				    
				    
				    
	
	   
    <form action=\"save_".str_replace(' ', '', $tablename).".php\" method=\"post\">
       
                
            
            

	<div class=\"form-group\">
		<label>Text</label>
		<input class=\"form-control\" type=\"text\" placeholder=\"Johnny Brown\">
	</div>
	
	
	<div class=\"form-group\">
		<label>Email</label>
		<input class=\"form-control\" value=\"bootstrap@example.com\" type=\"email\">
	</div>
	
	
	<div class=\"form-group\">
		<label>URL</label>
		<input class=\"form-control\" value=\"https://getbootstrap.com\" type=\"url\">
	</div>
	
	
	
	<div class=\"form-group\">
		<label>Telephone</label>
		<input class=\"form-control\" value=\"1-(111)-111-1111\" type=\"tel\">
	</div>
	
	
	
	<div class=\"form-group\">
		<label>Password</label>
		<input class=\"form-control\" value=\"password\" type=\"password\">
	</div>
	
	
	<div class=\"form-group\">
		<label>Readonly input</label>
		<input class=\"form-control\" type=\"text\" placeholder=\"Readonly input here…\" readonly=\"\">
	</div>
	
	
	<div class=\"form-group\">
		<label>Disabled input</label>
		<input type=\"text\" class=\"form-control\" placeholder=\"Disabled input\" disabled=\"\">
	</div>
	
	
	<div class=\"form-group\">
		<div class=\"row\">
			<div class=\"col-md-6 col-sm-12\">
				<label class=\"weight-600\">Custom Checkbox</label>
				<div class=\"custom-control custom-checkbox mb-5\">
					<input type=\"checkbox\" class=\"custom-control-input\" id=\"customCheck1-1\">
					<label class=\"custom-control-label\" for=\"customCheck1-1\">Check this custom checkbox</label>
				</div>
				<div class=\"custom-control custom-checkbox mb-5\">
					<input type=\"checkbox\" class=\"custom-control-input\" id=\"customCheck2-1\">
					<label class=\"custom-control-label\" for=\"customCheck2-1\">Check this custom checkbox</label>
				</div>
				
				
				<div class=\"custom-control custom-checkbox mb-5\">
					<input type=\"checkbox\" class=\"custom-control-input\" id=\"customCheck3-1\">
					<label class=\"custom-control-label\" for=\"customCheck3-1\">Check this custom checkbox</label>
				</div>
				
				<div class=\"custom-control custom-checkbox mb-5\">
					<input type=\"checkbox\" class=\"custom-control-input\" id=\"customCheck4-1\">
					<label class=\"custom-control-label\" for=\"customCheck4-1\">Check this custom checkbox</label>
				</div>
			</div>
			
			<div class=\"col-md-6 col-sm-12\">
				<label class=\"weight-600\">Custom Radio</label>
				<div class=\"custom-control custom-radio mb-5\">
					<input type=\"radio\" id=\"customRadio4\" name=\"customRadio\" class=\"custom-control-input\">
					<label class=\"custom-control-label\" for=\"customRadio4\">Toggle this custom radio</label>
				</div>
				
				<div class=\"custom-control custom-radio mb-5\">
					<input type=\"radio\" id=\"customRadio5\" name=\"customRadio\" class=\"custom-control-input\">
					<label class=\"custom-control-label\" for=\"customRadio5\">Or toggle this other custom radio</label>
				</div>
				
				<div class=\"custom-control custom-radio mb-5\">
					<input type=\"radio\" id=\"customRadio6\" name=\"customRadio\" class=\"custom-control-input\">
					<label class=\"custom-control-label\" for=\"customRadio6\">Or toggle this other custom radio</label>
				</div>
			</div>
		</div>
	</div>
	<div class=\"form-group\">
		<label>Disabled select menu</label>
		<select class=\"form-control\" disabled=\"\">
			<option>Disabled select</option>
		</select>
	</div>
	
	<div class=\"form-group\">
		<label>input plaintext</label>
		<input type=\"text\" readonly=\"\" class=\"form-control-plaintext\" value=\"email@example.com\">
	</div>
	<div class=\"form-group\">
		<label>Textarea</label>
		<textarea class=\"form-control\"></textarea>
	</div>
	<div class=\"form-group\">
		<label>Help text</label>
		<input type=\"text\" class=\"form-control\">
		<small class=\"form-text text-muted\">
		  Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
		</small>
	</div>
	<div class=\"form-group\">
		<label>Example file input</label>
		<input type=\"file\" class=\"form-control-file form-control height-auto\">
	</div>
	<div class=\"form-group\">
		<label>Custom file input</label>
		<div class=\"custom-file\">
			<input type=\"file\" class=\"custom-file-input\">
			<label class=\"custom-file-label\">Choose file</label>
		</div>
	</div>
	
	
	
	<div class=\"form-group\">
		<?php
		if(\$pagetype == 1)
        {
		?>
			<button type=\"submit\" class=\"btn btn-primary form-control\">Edit</button>
			<input type=\"hidden\" name=\"edit\" value=\"1\">
			<input type=\"hidden\" name=\"edit_id\" value=\"<?php echo \$id; ?>\">
		<?php
        }
        else{
		?>
		<button type=\"submit\" class=\"btn btn-primary form-control\">Add</button>
		<input type=\"hidden\" name=\"edit\" value=\"0\">
		<?php
        }
		?>
			
	</div>
	
	
</form>

				    
				    
				    
				    
				</div>
				
				<!-- Export Datatable End -->
			</div>
			<?php include('include/admin_footer.php'); ?>
		</div>
	</div>
  \n  
    ";     


        
    
    $myfileadd = fopen("../add_".str_replace(' ', '', $tablename).".php", "w");

    fwrite($myfileadd, $createpageforonetableadd1);
    
    
    
    
    $savedatapage = "<?php 
\n
include('include/dbcon.php'); 
include('callback_functions/quries.php');

\$pagetype = \$_REQUEST['edit'];

print_r(\$_POST);

if(\$pagetype == 1)
{
    \$id = \$_REQUEST['edit_id'];
    
    //go for update query
    
}
else{
    \$id = 0;
    
    //go for add query
}
    
    
    ?>
    ";
    
    $savedatamyfile = fopen("../save_".str_replace(' ', '', $tablename).".php", "w");
    fwrite($savedatamyfile, $savedatapage);
    
    
    
    
    
    
    
    
    $deletepage = "<?php 
\n
include('include/dbcon.php');
include('callback_functions/quries.php');



    \$id = \$_REQUEST['id'];
    
    echo \$deletequery = \"Delete From ".str_replace(' ', '', $tablename)." WHERE ".$pkcolumname." = \$id\";
    \$result = mysqli_query(\$conn, \$deletequery);
    
    header(\"Location: ".str_replace(' ', '', $tablename).".php\");
    
\n
?>
\n";


$myfiledelete = fopen("../delete_".str_replace(' ', '', $tablename).".php", "w");

    fwrite($myfiledelete, $deletepage);
    
    
    
         
}










$headerforadmin = "

<?php 
\n
session_start();
\n
include('include/dbcon.php');
\n 

if(!isset(\$_SESSION['admin_session_email']))
{
    header(\"Location: index.php\");
    
}
?>

<!DOCTYPE html>
<html lang=\"en\">

	<!-- Basic Page Info -->
	<meta charset=\"utf-8\">
	<title>DeskApp Dashboard</title>

	<!-- Site favicon -->
	<!-- <link rel=\"shortcut icon\" href=\"images/favicon.ico\"> -->

	<!-- Mobile Specific Metas -->
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">

	<!-- Google Font -->
	<link href=\"https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700\" rel=\"stylesheet\">
	<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700\" rel=\"stylesheet\">
	<!-- CSS -->
	<link rel=\"stylesheet\" href=\"vendors/styles/style.css\">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-119386393-1\"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-119386393-1');
	</script>



	<link rel=\"stylesheet\" type=\"text/css\" href=\"src/plugins/datatables/media/css/jquery.dataTables.css\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"src/plugins/datatables/media/css/dataTables.bootstrap4.css\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"src/plugins/datatables/media/css/responsive.dataTables.css\">


<body class=\"dark-edition\">
	<div class=\"pre-loader\"></div>
	<div class=\"header clearfix\">
		<div class=\"header-right\">
			<div class=\"brand-logo\">
				<a href=\"index.php\">
					<img src=\"https://aarfaatechnovision.com/img/aarfaa.png\" style=\"height: 150px;\" alt=\"\" class=\"mobile-logo\">
				</a>
			</div>
			<div class=\"menu-icon\">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class=\"user-info-dropdown\">
				<div class=\"dropdown\">
					<a class=\"dropdown-toggle\" href=\"#\" role=\"button\" data-toggle=\"dropdown\">
						<span class=\"user-icon\"><i class=\"fa fa-user-o\"></i></span>
						<span class=\"user-name\">Johnny Brown</span>
					</a>
					<div class=\"dropdown-menu dropdown-menu-right\">
						<a class=\"dropdown-item\" href=\"profile.php\"><i class=\"fa fa-user-md\" aria-hidden=\"true\"></i> Profile</a>
						<a class=\"dropdown-item\" href=\"logout.php\"><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i> Log Out</a>
					</div>
				</div>
			</div>
		</div>
	</div>



      	<div class=\"left-side-bar\">
		<div class=\"brand-logo\">
			<a href=\"index.php\">
				<img src=\"https://aarfaatechnovision.com/img/aarfaa.png\" alt=\"\" style=\"height: 150px;\">
			</a>
		</div>
		<div class=\"menu-block customscroll\">
			<div class=\"sidebar-menu\">
				<ul id=\"accordion-menu\">
					<!-- <li class=\"dropdown\">
						<a href=\"javascript:;\" class=\"dropdown-toggle\">
							<span class=\"fa fa-home\"></span><span class=\"mtext\">Home</span>
						</a>
						<ul class=\"submenu\">
							<li><a href=\"index.php\">Dashboard style 1</a></li>
							<li><a href=\"index2.php\">Dashboard style 2</a></li>
						</ul>
					</li> -->
					
					<li>
						<a href=\"dashboard.php\" class=\"dropdown-toggle no-arrow\">
							<span class=\"fa fa-calendar-o\"></span><span class=\"mtext\">Dashnoard</span>
						</a>
					</li>
					
					
          
         $tablewiselist
         
         
                </ul>
			</div>
		</div>
	</div>
      <!-- End Navbar -->
";


$myfile1 = fopen("../include/admin_header.php", "w");

fwrite($myfile1, $headerforadmin);








$adminfooter = "  	<div class=\"footer-wrap bg-white pd-20 mb-20 border-radius-5 box-shadow\">
		Admin Template By <a href=\"https://aarfaatechnovision.com/\" target=\"_blank\">AARFAA TECHNOVISION PVT LTD</a>
	</div>
</body>
	<!-- js -->
	<script src=\"vendors/scripts/script.js\"></script>
		<?php include('include/script.php'); ?>
	<script src=\"src/plugins/datatables/media/js/jquery.dataTables.min.js\"></script>
	<script src=\"src/plugins/datatables/media/js/dataTables.bootstrap4.js\"></script>
	<script src=\"src/plugins/datatables/media/js/dataTables.responsive.js\"></script>
	<script src=\"src/plugins/datatables/media/js/responsive.bootstrap4.js\"></script>
	<!-- buttons for Export datatable -->
	<script src=\"src/plugins/datatables/media/js/button/dataTables.buttons.js\"></script>
	<script src=\"src/plugins/datatables/media/js/button/buttons.bootstrap4.js\"></script>
	<script src=\"src/plugins/datatables/media/js/button/buttons.print.js\"></script>
	<script src=\"src/plugins/datatables/media/js/button/buttons.html5.js\"></script>
	<script src=\"src/plugins/datatables/media/js/button/buttons.flash.js\"></script>
	<script src=\"src/plugins/datatables/media/js/button/pdfmake.min.js\"></script>
	<script src=\"src/plugins/datatables/media/js/button/vfs_fonts.js\"></script>
	<script>
		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: \"datatable-nosort\",
					orderable: false,
				}],
				\"lengthMenu\": [[10, 25, 50, -1], [10, 25, 50, \"All\"]],
				\"language\": {
					\"info\": \"_START_-_END_ of _TOTAL_ entries\",
					searchPlaceholder: \"Search\"
				},
			});
			$('.data-table-export').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: \"datatable-nosort\",
					orderable: false,
				}],
				\"lengthMenu\": [[10, 25, 50, -1], [10, 25, 50, \"All\"]],
				\"language\": {
					\"info\": \"_START_-_END_ of _TOTAL_ entries\",
					searchPlaceholder: \"Search\"
				},
				dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
				]
			});
			var table = $('.select-row').DataTable();
			$('.select-row tbody').on('click', 'tr', function () {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
			var multipletable = $('.multiple-select-row').DataTable();
			$('.multiple-select-row tbody').on('click', 'tr', function () {
				$(this).toggleClass('selected');
			});
		});
	</script>

    \n

</html>";



$myfile3 = fopen("../include/admin_footer.php", "w");

fwrite($myfile3, $adminfooter);




$dashboard = "
<?php 
\n
include('include/admin_header.php'); 
include('callback_functions/quries.php'); 
\n
?>
\n




<div class=\"main-container\">
		<div class=\"pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10\">
			<div class=\"min-height-200px\">
				<div class=\"page-header\">
					<div class=\"row\">
						<div class=\"col-md-12 col-sm-12\">
							<div class=\"title\">
								<h4>Dashboard</h4>
							</div>
							<nav aria-label=\"breadcrumb\" role=\"navigation\">
								<ol class=\"breadcrumb\">
									<li class=\"breadcrumb-item\"><a href=\"index.php\">Home</a></li>
									<li class=\"breadcrumb-item active\" aria-current=\"page\">Dashboard</li>
								</ol>
							</nav>
						</div>
						<div class=\"col-md-6 col-sm-12 text-right\">
							
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class=\"pd-20 bg-white border-radius-4 box-shadow mb-30\">
					<div class=\"clearfix mb-20\">
						<div class=\"pull-left\">
							<h5 class=\"text-blue\">Data Table Simple</h5>
						
						</div>
					</div>
					<div class=\"row\">
						
					</div>
				</div>
				<!-- Export Datatable End -->
			</div>
			<?php include('include/admin_footer.php'); ?>
		</div>
	</div>

";

$myfile5 = fopen("../dashboard.php", "w");

fwrite($myfile5, $dashboard);



$logoutpage = "<?php

session_start();
session_destroy();

header(\"Location: index.php\");

?>";


$myfilelogoutpage = fopen("../logout.php", "w");

fwrite($myfilelogoutpage, $logoutpage);




function mygetdata($arrayfull, $conn, $tablename, $relatedcolumnnamechk, $jointables)
{
    $qmain1 = "select * from INFORMATION_SCHEMA.KEY_COLUMN_USAGE where TABLE_NAME = '".$tablename."'";
                            $rmain = mysqli_query($conn, $qmain1);
                            while($rowmain = mysqli_fetch_array($rmain, MYSQLI_ASSOC))
                            {
                                
                                //print_r($rowmain);
                                
                                if($relatedcolumnnamechk == $rowmain['COLUMN_NAME'])
                                {
                                    
                                    $relatedtablename = $rowmain['REFERENCED_TABLE_NAME'];
                                    
                                    $queryforcombine = "DESCRIBE `".str_replace(' ', '', $relatedtablename)."`";
                                    
                                    array_push($jointables, $relatedtablename);
                                    
                                    $resultqueryforcombine = mysqli_query($conn, $queryforcombine);
                                    while($rowqueryforcombine = mysqli_fetch_array($resultqueryforcombine, MYSQLI_ASSOC))
                                    {
                                        if($rowqueryforcombine['Key'] != "PRI")
                                        {
                                            array_push($arrayfull, $rowqueryforcombine['Field']);
                                        }
                                        
                                        if($rowqueryforcombine['Key'] == "MUL")
                                        {
                                            
                                            
                                            $relatedcolumnnamechk = $rowqueryforcombine['Field'];
                                            
                                            
                                           $arrayofcolumnnamesretrun1 = mygetdata($arrayfull, $conn, $tablename, $relatedcolumnnamechk, $jointables);
                                           $arrayfull = $arrayofcolumnnamesretrun1[0];
                                           $jointables = $arrayofcolumnnamesretrun1[1];
                                           
                                            
                                        }
                                        
                                        
                                    }
                                }
                            }
                            
                            
                            $arrayofreturnmultidata = [$arrayfull, $jointables];
                            
        return $arrayofreturnmultidata;                    
}



?>