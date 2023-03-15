const urlParams = new URLSearchParams(window.location.search);
const ID = urlParams.get('ID');
new QRCode(document.getElementById("qrcode"), window.location.host+"/qr_viewer.php?ID="+ID);