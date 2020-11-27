<!doctype html>
<html>
 <head>
  <script type="text/javascript" src="html2canvas-master/dist/html2canvas.js"></script>
 </head>
 <body>
  <h1>Take screenshot of webpage with html2canvas</h1>
  <div class="container" id='container' >
    <img src="http://10.101.2.100:8080/video" id="video" width="300" height="300" />
    <img src="images/image1.jpg" id="video1" width="300" height="300" />
  </div>
  <input type='button' id='but_screenshot' value='Take screenshot' onclick='screenshot();'><br/>

  <!-- Script -->
  <script type='text/javascript'>
  function screenshot(){
    html2canvas(document.getElementById("video1"), {scale: 2}).then(function(canvas) {
    document.body.appendChild(canvas);
   });
  }
  </script>

 </body>
</html>