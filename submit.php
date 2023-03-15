<?php
    include("./server_setting.php");
    $conn = mysqli_connect($host, $user, $pass, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO durianDB.durianID
                (location,specie,bloom_date) 
            VALUE ('"
            .($_POST['locations'] == "" ? "NULL" : $_POST['locations'])."','"
            .($_POST['species'] == "" ? "NULL" : $_POST['species'])."','"
            .($_POST['years'] == "" ? "0000" : $_POST['years'])."-"
            .($_POST['month'] == "" ? "00" : $_POST['month'])."-"
            .($_POST['date'] == "" ? "00" : $_POST['date'])."')";

            echo $sql;
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT ID FROM durianDB.durianID ORDER BY ID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    header("Location: qr.php?ID=".mysqli_fetch_assoc($result)['ID']);
?>

                