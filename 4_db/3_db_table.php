<?php
session_start ();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/table.css">
    <title>użytkownicy</title>
</head>
<body>
    <h4>użytkownicy</h4>
    <?php
    echo <<< USERTABLE
    <table>
        <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Data Urodzenia</th>
            <th>Miasto</th>
            <th>Wojewodztwo</th>
            <th>Panstwo</th>
        </tr>
        
    USERTABLE;
        if (isset($_SESSION["error"])){
            echo $_SESSION["error"];
            unset ($_SESSION["error"]);

        }

        require_once "../scripts/connect.php";
        $sql = "SELECT users.id, `users`.`firstName`, `users`.`lastName`, `users`.`dataUrodzenia`,
        `cities`.`city`, `states`.`state`, `countries`.`country`
         FROM `users`
        INNER JOIN `cities` ON `users`.`city_id` = `cities`.`id`
         INNER JOIN `states` ON `cities`.`state_id`=`states`.`id` 
         INNER JOIN `countries` ON `states`.`id_country`=`countries`.`id`";

        $result = $conn->query($sql);
        
        if($result-> num_rows > 0){
            while($user = $result->fetch_assoc()){
                echo <<< USERS
                <tr>
                    <td>$user[firstName]</td>
                    <td>$user[lastName]</td>
                    <td>$user[dataUrodzenia]</td>
                    <td>$user[city]</td>
                    <td>$user[state]</td>
                    <td>$user[country]</td>
                    <td><a href = "../scripts/delete_user.php?deleteUserId=$user[id]">Usun</a></td>
                    <td><a href = "./3_db_table.php?updateUserId=$user[id]">Edytuj</a></td>
                    
                </tr>
                
                USERS;
            }
        }
            else
            {
                echo <<< USERS
                <tr>
                    <td colspan ="6">Brak rekordow do wyswietlenia</td>
                    
                </tr>
                
                USERS;
            }
        
        
        echo "</table>";
            
        

        if(isset($_GET['deleteUser'])){
        if ($_GET["deleteUser"] != 0) {
            echo "<hr>Usunieto uzytkownika  o id = $_GET[deleteUser]";


        }
        else
        {
            echo "<hr>Nieusunieto uzytkownika"; 
        }
    }

    //echo " <a href= "../scripts/show_states.php">Pokaz tabele</a>";
    //zamiast state  id nazwa wojewodztwa
    
    
        if(isset($_GET["addUserForm"])){
            echo <<< ADDUSERFORM
            <h4>Dodawanie uzytkownika</h4>
            <form action="../scripts/adduser.php" method="post">
                <input type="text" name="firstName" placeholder="Podaj imie" autofocus><br><br>
                <input type="text" name="lastName" placeholder="Podaj nazwisko"><br><br>
                <select name = "city">
ADDUSERFORM;

                $sql = "SELECT * FROM cities ";
                $result = $conn->query($sql);
                while($city = $result->fetch_assoc()){
                    echo "<option value=$city[id]>$city[city]</option>";
                }
                echo <<< ADDUSERFORM
                </select><br><br>
                <input type="date" name="dataUrodzenia">Data urodzenia<br><br>
                
                <input type="checkbox" name="term" checked>Regulamin<br><br>
                <input type="submit" value="Dodaj uzytkownika">
                

            </form>
ADDUSERFORM;
            

        }
       else
        {
            echo '<a href="./3_db_table.php?addUserForm=1">Dodaj uzytkownika</a>';
        }


        //aktualizowanie uzytkownika
        if(isset($_GET["updateUserId"])) 
        {
            $sql = "SELECT *FROM `users` where `id` = $_GET[updateUserId]";
            $result = $conn->query($sql);
            $updateUser = $result->fetch_assoc();
                 echo <<< UPDATEUSERFORM
                     <h4>Aktualizowanie uzytkownika</h4>
                     <form action="../scripts/updateuser.php" method="post">
                     <input type="text" name="firstName" placeholder="Podaj imie" value="$updateUser[firstName]" autofocus><br><br>
                     <input type="text" name="lastName" placeholder="Podaj nazwisko" value="$updateUser[lastName]"><br><br>
                     <select name = "city">
                     UPDATEUSERFORM;
     
                     $sql = "SELECT * FROM cities";
                     $result = $conn->query($sql);
                     while($city = $result->fetch_assoc()){
                         if($updateUser["city_id"] == $city["id"]){
                            echo "<option selected value=$city[id]>$city[city]</option>";
                        }
                         else
                         {
                             echo "<option value=$city[id]>$city[city]</option>";
                         }
                     }
                     echo <<< UPDATEUSERFORM
                     </select><br><br>
                     <input type="date" name="dataUrodzenia" value ="$updateUser[dataUrodzenia]">Data urodzenia<br><br>
                     <input type="submit" value="Aktualizuj uzytkownika">
                     
     
                 </form>
                 UPDATEUSERFORM;
                }
        $conn->close();
        ?>
    
    
</body>

</html>
