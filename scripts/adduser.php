<?php
//print_r($_POST); stare
session_start();//wszystkie pliki maja start sesja

$error = 0;
foreach($_POST as $key => $value){
   // echo "$key: $value<br>";
   if(empty($value)){
    //echo"$key<br>";
    $_SESSION["error"] = "Wypelnij pola";
      //echo "<script>history.back();</script>";//jak puste to wraca na glowna strone
      //exit();//zatrzymanie w tym momencie kodu
   $error++;
   }
}

if(!isset($_POST["term"]))
{
   $_SESSION["error"] = "Zatwierdz regulamin!";
      //echo "<script>history.back();</script>";
      //exit();
      $error++;
}

require_once "./connect.php";
$sql = "INSERT INTO `users` (`id`, `city_id`, `firstName`, `lastName`, `dataUrodzenia`)
 VALUES (NULL, '$_POST[city]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[dataUrodzenia]');";
$conn->query($sql);

//echo $conn->affected_rows;
if($conn->affected_rows == 1)
{
//echo "Prawidlowo dodano rekord";
$_SESSION["error"] = "dodano rekord";

}
else
{
//echo "Nie dodano rekordu!";
$_SESSION["error"] = "nie dodano rekordu";
}

header("location: ../4_db/3_db_table.php");