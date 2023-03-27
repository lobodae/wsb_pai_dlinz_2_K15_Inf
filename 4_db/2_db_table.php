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
        $sql = "SELECT * FROM `users` 
        INNER JOIN `cities` ON `users`.`city_id` = `cities`.`id`
         INNER JOIN `states` ON `cities`.`state_id`=`states`.`id` 
         INNER JOIN `countries` ON `states`.`id_country`=`countries`.`id`";

        $result = $conn->query($sql);
        
        
        while($user = $result->fetch_assoc()){
            echo <<< USERS
            <tr>
                <td>$user[firstName]</td>
                <td>$user[lastName]</td>
                <td>$user[dataUrodzenia]</td>
                <td>$user[city]</td>
                <td>$user[state]</td>
                <td>$user[country]</td>
                


            </tr>
            
            USERS;
        }
        echo "</table>";
        ?>

</body>

</html>
