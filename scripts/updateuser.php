<?php
//print_r($_POST); stare
session_start();//wszystkie pliki maja start sesja
print_r($_POST);

foreach($_POST as $key => $value){
   // echo "$key: $value<br>";
   if(empty($value)){
    //echo"$key<br>";
    $_SESSION["error"] = "Wypelnij pola";
    echo "<script>history.back();</script>";//jak puste to wraca na glowna strone
    exit();//zatrzymanie w tym momencie kodu
   }
}

require_once "./connect.php";
//$sql = "INSERT INTO `users` (`id`, `city_id`, `firstName`, `lastName`, `dataUrodzenia`)
// VALUES (NULL, '$_POST[city]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[dataUrodzenia]');";
//-------------ZMIANA POLECENIA NA UNIWERSALNE ----------
$sql = UPDATE `users` SET `city_id` = '2', `firstName` = 'Damian', `lastName` = 'Kowalski', `dataUrodzenia` = '2021-03-12' WHERE `users`.`id` = 10;
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

//header("location: ../4_db/3_db_table.php");