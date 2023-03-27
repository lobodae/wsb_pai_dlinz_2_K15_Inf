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
                    <td><a href = "../scripts/show_states.php?
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

        ?>
</body>

</html>
