<?php

include('../include/dbcon.php');

$q = "show tables from ".$databasename;

$result = mysqli_query($conn, $q); 




while($table = mysqli_fetch_array($result))
{
    $tablename = $table[0];
    
    if (strpos($tablename, 'admin') !== false) {
            $tablenameforadminlogin = $tablename;
        }
    
}



$qc = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$databasename."' AND TABLE_NAME = '".$tablenameforadminlogin."'";

$rc = mysqli_query($conn, $qc);

$usernamecolumn = "";
$passwordcolumn = "";

while($rowqc = mysqli_fetch_array($rc, MYSQLI_ASSOC))
{
    if (strpos($rowqc['COLUMN_NAME'], 'email') !== false) {
           echo $usernamecolumn = $rowqc['COLUMN_NAME'];
        }
        
        
        
    if (strpos($rowqc['COLUMN_NAME'], 'password') !== false) {
           echo $passwordcolumn = $rowqc['COLUMN_NAME'];
        }    
}





$cssstring = ".register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
}\n
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}\n
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}\n
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}\n
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}\n
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}\n
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}\n
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}\n
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}\n
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}\n
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}\n
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}\n
.register .nav-tabs .nav-link:hover{
    border: none;
}\n
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}\n
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}";

$dir = "../style";
if( is_dir($dir) === false )
{
    mkdir($dir);
}

$stylegenerator = fopen("../style/style.css", "w");

fwrite($stylegenerator, $cssstring);








$textheader = "<?php include(\"include/dbcon.php\"); 
if(isset(\$_SESSION['admin_session_email']))
{
    header(\"Location: dashboard.php\");
    
}

?> \n <!Doctype HTML> \n
<html> \n
    <head> \n
        <title>Admin Panel</title> \n
        <link href=\"//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css\" rel=\"stylesheet\" id=\"bootstrap-css\"> \n
        <link href=\"style/style.css\" rel=\"stylesheet\">\n
        <script src=\"//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script> \n
        <script src=\"//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script> \n
    </head> \n \n";
    
$myfile2 = fopen("../include/headerreg.php", "w");

fwrite($myfile2, $textheader);










$loginstring = "<?php \n include(\"include/headerreg.php\");  \n ?> \n \n \n <div class=\"container register\">
                <div class=\"row\">
                
                
                
                    <div class=\"col-md-3 register-left\">
                        <img src=\"https://image.ibb.co/n7oTvU/logo_white.png\" alt=\"\"/>
                        <h3>Welcome</h3>
                        <p>To the admin panel</p>
                        <a href=\"register.php\" class=\"btnRegister\" style=\"background:#ffffff; color: #255CC2;\">Register</a><br/>
                    </div>
                    
                    <div class=\"col-md-9 register-right\">
                    <form action=\"login.php\" method=\"post\">
                        <div class=\"tab-content\" id=\"myTabContent\">
                            <div class=\"tab-pane fade show active\" id=\"home\" role=\"tabpanel\" aria-labelledby=\"home-tab\">
                                <h3 class=\"register-heading\">Login Page</h3>
                                <div class=\"row register-form\">
                                    <div class=\"col-md-12\">
                                        <div class=\"form-group\">
                                            <input type=\"email\" class=\"form-control\" placeholder=\"Enter Email ID *\" name=\"useremail\" value=\"\" />
                                        </div>
                                        <div class=\"form-group\">
                                            <input type=\"password\" name=\"userpassword\" class=\"form-control\" placeholder=\"Password *\" value=\"\" />
                                        </div>
                                        
                                        
                                        <div class=\"row\">
                                        <div class=\"col-md-6\"></div>
                                        <div class=\"col-md-6\">
                                            <input type=\"submit\" class=\"btnRegister\"  value=\"Login\"/>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class=\"row\">
                    <div class=\"col-md-12\">
                    <center>
                        <?php
                        
                        if(\$_REQUEST['msg'] != \"\")
                        {
                            echo \"<span style='color:#ff0000'>\".\$_REQUEST['msg'].\"</span>\";
                        }
                        
                        ?>
                    </center>
                    </div>
                    </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    
                </div>

            </div> \n \n \n <?php \n \n include(\"include/headerreg.php\");  \n \n ?> ";


$myfile1 = fopen("../index.php", "w");

fwrite($myfile1, $loginstring);











$stringfooter = "</body>
</html>";

$myfile3 = fopen("../include/footerreg.php", "w");

fwrite($myfile3, $stringfooter);






$stringloginbackendcode = "<?php \n include(\"include/dbcon.php\"); \n 
session_start(); \n
\$emailid = \$_POST['useremail']; \n
\$password = \$_POST['userpassword']; \n

echo \$qctualquery = \"SELECT * FROM `$tablenameforadminlogin` WHERE `$usernamecolumn` = '\$emailid' and `$passwordcolumn` = '\$password' \";

\$query = mysqli_query(\$conn, \$qctualquery); \n

\$numrows = mysqli_num_rows(\$query); \n

if(\$numrows > 0) \n
{ \n
    \$msg = \"Login Successful\"; \n
     
    \$row = mysqli_fetch_array(\$query, MYSQLI_ASSOC); \n
    
    \$_SESSION['admin_session_email'] = \$emailid; \n
    
    header(\"Location: dashboard.php\");
    
} \n
else{ \n
    \$msg = \"Username or password is wrong ... \"; \n
    header(\"Location: index.php?msg=\".\$msg);
} \n

\$response = array(\"status\" => \"failed\", \"msg\" => \$msg);

echo json_encode(\$response);


?>";

$myfile4 = fopen("../login.php", "w");

fwrite($myfile4, $stringloginbackendcode);







header("Location: dashboardgenerator.php");

    
    
?>



