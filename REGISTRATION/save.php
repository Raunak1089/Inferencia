<?php
$ip = $_SERVER['REMOTE_ADDR'];
$regID = $_POST['regID'];
$nam = $_POST['name'];
$clg = $_POST['college'];
$dpt = $_POST['department'];

$sql = "INSERT INTO `participants`  (`RegID`, `sName`, `College_name`, `Dept`) VALUES ('$regID', '$nam', '$clg', '$dpt');";


include 'db_connect.php';
mysqli_query($conn, $sql);

$sql = "SELECT * FROM participants";

// $res = "<table><tr><th>Sl no.</th><th>RegID</th><th>sName</th><th>College_name</th> <th>Dept</th></tr></table>";
$regIDs = '';

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    while ($row = mysqli_fetch_assoc($result)){
        // $res = $res . '<table><tr><td>';
        // $res = $res . $row['Sl no.'];
        // $res = $res . '</td><td>'.$row['RegID'];
        $regIDs = $regIDs."'".$row['RegID']."', ";
        // $res = $res . '</td><td>'.$row['sName'];
        // $res = $res . '</td><td>'.$row['College_name'];
        // $res = $res . '</td><td>'.$row['Dept'];
        // $res = $res . '</td></tr></table>';
    }
}

// echo $res;
echo '<span hidden id="regIDs_arr">['.$regIDs.']</span>';

mysqli_close($conn);


?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" sizes="192x192" href="https://raunak1089.github.io/Required-files/favicon.ico">
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://raunak1089.github.io/all_scripts/fontawesome.js"></script> 
</head>

<title>Successfully registered!</title>

<h2>Registration Successful!</h2>
<div id="instr">
<i class="fa fa-triangle-exclamation" style="
    font-size: 2em; 
    color: #ffcb00;
"></i><br>
    You need to produce the QR code 
    shown below on your mobile phone 
    on the day of the event to confirm 
    your presence there. 
    Please download and keep it 
    safely in your storage.
</div>

<div class="container">
    <canvas id="canvas"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>

    <div id="show_ID"></div>
</div>

<div id="download-btn">Download QR</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap');
@import url('https://fonts.googleapis.com/css?family=Comfortaa:400,500,600,700&display=swap');
@import url('https://fonts.googleapis.com/css?family=Abril Fatface:400,500,600,700&display=swap');


*{
    margin: 20px;
}
#instr{
    width: 90%;
    max-width: 300px;
    font-family: Comfortaa;
    text-align: center;
}
body, .container{
    display: flex;
    flex-direction: column;
    align-items: center;
}
#show_ID{
    font-weight: bold;
}
#download-btn{
    margin-top: 20px;
    width: fit-content;
    padding: 10px;
    border: none;
    font-family: Comfortaa;
    background-color: #2196f3;
    text-transform: uppercase;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}
</style>
<script>
const this_ID = eval(document.querySelector('#regIDs_arr').innerHTML)[eval(document.querySelector('#regIDs_arr').innerHTML).length-1];
function generateQR() {
const inputText = this_ID;
const qr = qrcode(0, 'M');
qr.addData(inputText);
qr.make();

const canvas = document.getElementById('canvas');
canvas.width = qr.getModuleCount() * 10;
canvas.height = qr.getModuleCount() * 10;
const context = canvas.getContext('2d');

// Draw the QR code on the canvas
for (let i = 0; i < qr.getModuleCount(); i++) {
    for (let j = 0; j < qr.getModuleCount(); j++) {
    context.fillStyle = qr.isDark(i, j) ? '#000000' : '#ffffff';
    context.fillRect(i * 10, j * 10, 10, 10);
    }
}

// Use the jsQR library to decode the QR code from the canvas
const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
const code = jsQR(imageData.data, imageData.width, imageData.height, {
    inversionAttempts: 'dontInvert',
});

// If a QR code is detected, log the decoded text in the console
if (code) {
    console.log('Generated text:', code.data);
}
}

console.log(this_ID);
generateQR();
document.querySelector('#show_ID').innerHTML='Registration ID: '+this_ID;


// DOWNLOAD IMAGE BUTTON ______________________

const downloadBtn = document.getElementById("download-btn");
const mydiv = document.querySelectorAll(".container")[0];

downloadBtn.addEventListener("click", () => {
  html2canvas(mydiv).then(canvas => {
    const link = document.createElement("a");
    link.download = "qrcode.png";
    link.href = canvas.toDataURL("image/png");
    link.click();
  });
});

</script>