var mysql = require('mysql');

var con = mysql.createConnection({
    host: "aws-iot-station.czzjjyc4w6bz.ap-northeast-1.rds.amazonaws.com",
    user: "admin",
    password: "admin1234",
    database: "durianDB"
});

con.connect(function (err) {
    if (err) throw err;
    con.query("SELECT ID FROM durianDB.durianID", function (err, result, fields) {
        if (err) throw err;
        console.log(result);
    });
    con.end();
});//help
