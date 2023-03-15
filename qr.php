<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/asset/css/page_styles.css">
    <script type="text/javascript" src="asset/js/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
        </script>
    <script>
        $(function () {
            $("#header").load("header.html");
        });
    </script>

    <title>QRcode</title>
</head>
<body>
    <div id="header"></div>

    <?php
        include('./server_setting.php');
        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);

        $conn = mysqli_connect($host, $user, $pass, $database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $null_check = 0;

        $sql = "SELECT *,CAST(register_date AS DATE) AS stamp FROM durianDB.durianID WHERE ID = '".$params['ID']."'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if($row["location"] == "NULL" || $row["specie"] == "NULL" || $row["bloom_date"] == "0000-00-00") $null_check = 1;
    ?>

    <div class="container">
        <ul class="list" style="align-items: center;">
            <li><div id="qrcode" style="padding: 5px;background-color: white;"></div></li>
            <?php if($null_check != 0) echo "<form action=\"update.php?ID=".$params['ID']."&path=qr\" method=\"post\">" ?>
            <li><label style="color: var(--primary);">ชื่อสวน</label></li>
            <?php
                if($row["location"] == "NULL"){
                    echo "<li style=\"margin-top: 15px;\"><input type=\"text\" name=\"location\" id=\"location\" class=\"auto-fill\" placeholder=\"ชื่อสวน\"></li>";
                }
                else{
                    echo "<li style=\"margin-top: 0;\"><label class=\"display-text\">" . $row["location"] . "</label></li>";
                }
            ?>
            
            <li><label style="color: var(--primary);">สายพันธุ์</label></li>
            <?php
                if($row["specie"] == "NULL"){
                    echo "<li style=\"margin-top: 15px;\"><input type=\"text\" name=\"species\" id=\"species\" class=\"auto-fill\" placeholder=\"สายพันธุ์\"></li>";
                }
                else{
                    echo "<li style=\"margin-top: 0;\"><label class=\"display-text\">" . $row["specie"] . "</label></li>";
                }
            ?>

            <li><label style="color: var(--primary);">วันที่เริ่มออกดอก</label></li>
            <?php
                if($row["bloom_date"] == "0000-00-00"){
                    echo "<li style=\"display:flex;flex-direction: row;width:90%;justify-content: space-between;margin-top: 15px;\">";
                    echo "<input type=\"text\" name=\"date\" id=\"date\" class=\"auto-fill\" style=\"width:22%;\" placeholder=\"วัน  ( 1-31 )\">";
                    echo "<input type=\"text\" name=\"month\" id=\"month\" class=\"auto-fill\" style=\"width:35%;\" placeholder=\"เดือน  ( 1-12 )\">";
                    echo "<input type=\"text\" name=\"years\" id=\"years\" class=\"auto-fill\" style=\"width:22%;\" placeholder=\"ปี  ค.ศ.\">";
                    echo "</li>" ;
                }
                else{
                    list($year, $month, $day) = explode("-",$row["bloom_date"]);
                    echo "<li style=\"margin-top: 0;\"><label class=\"display-text\">".$day." / ".$month." / ".$year."</label></li>";
                }
            ?>
            
            <li><label style="color: var(--primary);">วันที่ลงทะเบียน</label></li>
            <?php list($year, $month, $day) = explode("-",$row["stamp"]); ?>
            <li style="margin-top: 0;"><label class="display-text"><?php echo $day?> / <?php echo $month?> / <?php echo $year?></label></li>
            <li>
                <?php
                    if($null_check != 0) echo "<input type=\"submit\" value=\"ลงทะเบียน\">&nbsp;";
                ?>
                <a href="index.html"><button>กลับ</button></a>
            </li>
            <?php if($null_check != 0) echo "</form>"?>
        </ul>
    </div>

    <?php
        }
        mysqli_close($conn);
    ?>

    <script type="text/javascript" src="asset/js/qr_gen.js"></script>
</body>
</html>