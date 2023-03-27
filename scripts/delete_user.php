<?php

require_once "./connect.php";
$sql ="DELETE FROM users WHERE `users`.`id` = $_GET[deleteUserId]";
$conn->query($sql);

//echo $conn-> affceted_rows;

$deleteUser = 0;
if($conn->affected_rows != 0)
{
//echo "USunieto rekord";
$deleteUser =  $_GET["deleteUserId"];
}
else 
{
//echo "Nie usunieto rekorddu";
$deleteUser = 0 ;

}
header(header: "location: ../4_db/3_db_table.php?deleteUser=$deleteUser");
?>
<script>
    //history.back();
    </script>
