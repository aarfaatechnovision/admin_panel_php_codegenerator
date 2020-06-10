<?php


$databasename = $_POST['databasename'];
$username = $_POST['username'];
$hostname = $_POST['hostname'];
$password = $_POST['password'];

$dir = "../include";

if( is_dir($dir) === false )
{
    mkdir($dir);
}

$myfile = fopen("../include/dbcon.php", "w");

$string = "<?php \n \n \n  \$databasename = \"$databasename\"; \n  \$conn = mysqli_connect(\"$hostname\", \"$username\", \"$password\", \"$databasename\");  \n \n \n ?>";

fwrite($myfile, $string);

header("Location: loginpagegenerator.php");

?>