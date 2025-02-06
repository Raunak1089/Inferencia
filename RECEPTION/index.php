<html>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="icon" sizes="192x192" href="https://raunak1089.github.io/Required-files/favicon.ico">
  <script src="https://raunak1089.github.io/all_scripts/fontawesome.js"></script> 
  <link rel="stylesheet" href="style.css">

<head>
  <title>Reception QR</title>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap');
@import url('https://fonts.googleapis.com/css?family=Comfortaa:400,500,600,700&display=swap');
@import url('https://fonts.googleapis.com/css?family=Abril Fatface:400,500,600,700&display=swap');

body {
	background: linear-gradient(lightgrey, grey);
	margin: 0;
	font-family: Comfortaa;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}

#video {
	height: 25vh;
}
.container{
	margin: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

img{
	position: absolute;
	z-index: 1;
}
#details{
    text-align: center;
    background: linear-gradient(125deg, maroon, transparent);
    padding: 10%;
    display: flex;
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 20px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.4), 0px 10px 20px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    flex-direction: column;
    align-items: center;
}

#icons > *{
	margin: 10px;
}

form > div > input{
	background: #007bff;
	color: white;
	text-align: center;
	border: none;
}

.btn{
	height: 100%;
	background: rgb(6, 122, 255);
	color: white;
	font-size: 1.5em;
	margin: auto 5px;
	padding: 7px 25px;
    cursor: pointer;
}
.btn:hover{
	filter: brightness(0.8);
}
table {
	font-family: Comfortaa;
	border-collapse: collapse;
	color: white;
  }
  
/* td, th {
	border: 1px solid black;
	text-align: center;
} */
  

</style>
<body>
<img src="images/rkm.png" style="width: 75;height: 75;top: 0;right: 0;" alt="">
<img src="images/logo.png" style="width: 87;height: 51;top: 10;left: 5;" alt="">

<div class="container">
    <video id="video"></video>
    <canvas id="canvas" style="display: none;"></canvas>
    <br>
    <form action="save.php" method="post">
        <div style="display:flex">
          <div class="btn" style="margin:0;padding:7;"><i class="fa-solid fa-lock"></i></div>
          <input id="result" name="regId">
          <div class="btn" onclick="let currentUrl = window.location.href;let lastPartIndex = currentUrl.lastIndexOf('/');let baseUrl = currentUrl.substring(0, lastPartIndex + 1);location.href=baseUrl;"><i class="fa-regular fa-refresh"></i></div>
          <div class="btn" onclick="document.querySelectorAll('form')[0].submit();"><i class="fa-regular fa-check"></i></div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>

    <div id="details">
      <i style="font-size:2em" class="fa-duotone fa-spinner-third fa-spin"></i>
    </div>
      

</div>


</body>
<script>
      const video = document.getElementById('video');
      const canvas = document.getElementById('canvas');
      const result = document.getElementById('result');
      
      const constraints = {
         video: { width: 720, height: 720,facingMode: 'environment', zoom: 1.5 } // use rear camera
         //video : true // use selfie camera
      };
      
      // Get the video stream and display it in the video element
      navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
          video.srcObject = stream;
          video.setAttribute('playsinline', true); // iOS specific
          video.play();
        })
        .catch(err => {
          console.error(err);
        });
        
      // Continuously scan the video stream for QR codes
      setInterval(() => {
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height);
        
        // Use the jsQR library to decode the QR code
        const code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: 'dontInvert',
        });
        
        // If a QR code is detected, log the decoded text in the console
        if (code) {
          result.value=code.data;
          // Check if the browser supports the vibrate method
        // if ("vibrate" in navigator) {
        //   window.navigator.vibrate(100);
        // }

          // video.pause();
          // setTimeout(()=>{video.play()},2000)

        // document.querySelectorAll('form')[0].submit();
        
        }
      }, 10);

</script>
</html>
