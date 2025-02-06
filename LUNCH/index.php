<html>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="icon" sizes="192x192" href="https://raunak1089.github.io/Required-files/favicon.ico">
  <script src="https://raunak1089.github.io/all_scripts/fontawesome.js"></script> 
  <link rel="stylesheet" href=".\style.css">

<head>
  <title>QR Scanner</title>
</head>
<body>
<img src="images/rkm.png" alt="">
<div id="bg"></div>


<div class="container">
    <video id="video"></video>
    <canvas id="canvas" style="display: none;"></canvas>
    <br>
    <form action="save.php" method="post">
    <input id="result" name="regID">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>

    <div id="details"></div>

</div>



</body>
<script>
      const video = document.getElementById('video');
      const canvas = document.getElementById('canvas');
      const result = document.getElementById('result');
      
      const constraints = {
         video: { width: 2040, height: 2040,facingMode: 'environment', zoom: 2.5 } // use rear camera
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
        if ("vibrate" in navigator) {
          window.navigator.vibrate(100);
        }

          // video.pause();
          // setTimeout(()=>{video.play()},2000)

        document.querySelectorAll('form')[0].submit();
        
        }
      }, 500);

</script>
</html>
