<?php
//echo<"<pre>";
//print_r($_POST);
//echo<"</pre>";
//exit();

require_once "./connect.php";

session_start();
foreach($_POST as $key => $value)
{
if(empty($value))
{
    $_SESSION["error"] = "Wypelnij wszystkie pola!";
    echo "<script>history.back();</script>";
    exit();
}
}
$error = 0;

//regulamin

if(!isset($_POST["terms"]))
{
    $error = 1;
    $_SESSION[" error"] = "Zapomniales o regulaminie 1";
}


//plec
if(!isset($_POST["gender"]))
{
    $error = 1;
    $_SESSION[" error"] = "Zapomniales o zaznaczeniu plci";
}

//haslo

if($_POST["password1"] != $_POST["password2"]){
    $error = 1;
    $_SESSION["error"] = "Hasla sa rozne";
}

//mail

if($_POST["email1"] != $_POST["email2"]){
    $error = 1;
    $_SESSION["error"] = "Adresy email sa rozne";
}

//czy jest duplikacja adresu email | wersja tomka
require_once "./connect.php";
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $_POST["email1"]);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0)
{
    $_SESSION["error"] = "Adres email juz jest w bazie";
    $error++;
}

/*pana wersja
$result = $stmt->get_result();

if($result->num_rows != 0)
{
    $_SESSION["error"] = "Adres $_POST[email1] jest zajety";
    echo "<script>history.back();</script>";
    exit();
}


*/
if($error !=0)
{
   echo "<script>history.back();</script>";
    exit();

}




//hashowanie hasla
$stmt= $conn->prepare("INSERT INTO `users` ( `email`, `city_id`, `firstName`, `lastName`, `dataUrodzenia`, `gender`, `avatar`, `password`, `created_at`) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, current_timestamp());");

$pass = password_hash('$_POST["password1"]', PASSWORD_ARGON2ID);  

$avatar = ($_POST["gender"] == 'm') ? './jpg/man.png' : './jpg/woman.png';

$stmt->bind_param('sissssss', $_POST["email1"], $_POST["city_id"], $_POST["firstName"], $_POST["lastName"], $_POST["dataUrodzenia"], $_POST["gender"], $avatar,  $pass);

$stmt->execute();

if($stmt->affected_rows == 1)
{
    $_SESSION["success"] = "Dodano uzykownika $_POST[firstName] $_POST[lastName]";

}
else
{
    $_SESSION["error"] = "Nie udalo sie dodac uzytkownika";

}
header("location:../pages/register.php");



//password hash, szyfrowanie, example#4 - random znaki haslo, argon2id


