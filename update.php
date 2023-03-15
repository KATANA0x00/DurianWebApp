<?php
    include("./server_setting.php");
    $conn = mysqli_connect($host, $user, $pass, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);

    $sql = "UPDATE durianDB.durianID ";
    $flag = 0;
    if (isset($_POST['location'])){
    if( $_POST['location'] != "" ){
        $sql = $sql.($flag > 0 ? "," : "SET");
        $sql = $sql." location = '".$_POST['location']."'";
        $flag = $flag + 1;
    }}
    if (isset($_POST['species'])){
    if( $_POST['species'] != "" ){
        $sql = $sql.($flag > 0 ? "," : "SET");
        $sql = $sql." specie = '".$_POST['species']."'";
        $flag = $flag + 1;
    }}
    if (isset($_POST['date'],$_POST['month'],$_POST['years'])){
    if( $_POST['date'].$_POST['month'].$_POST['years'] != "" ){
        $sql = $sql.($flag > 0 ? "," : "SET");
        $sql = $sql." bloom_date = '".$_POST['years']."-".$_POST['month']."-".$_POST['date']."'";
        $flag = $flag + 1;
    }}
    $sql = $sql." WHERE ID = ".$params['ID'];

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    header("Location: ".$params['path'].".php?ID=".$params['ID']);
?>

                