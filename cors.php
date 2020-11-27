<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.20/fabric.min.js"></script>
<body onload="executar();">
<div id="demo"></div>

<canvas  width="400" height="400" id="c"></canvas>
<img id="my-image" width="400" height="400" src="https://10.101.2.100:8080/video" style="border:2px solid;"/>
<a id="lnkDownload" href="#">Save image</a>
<script>
function executar(){
var canvas = new fabric.Canvas('c');
var imgElement = document.getElementById('my-image');
var imgInstance = new fabric.Image(imgElement, {
  left: 100,
  top: 100,
  angle: 30,
  opacity: 0.85
});
canvas.add(imgInstance);


var imageSaver = document.getElementById('lnkDownload');
imageSaver.addEventListener('click', saveImage, false);

function saveImage(e) {
    this.href = canvas.toDataURL({
        format: 'png',
        quality: 0.8
    });
    this.download = 'images/canvas.png'
}
	
 //var c = document.createElement("img"); 
   
 // c.setAttribute('crossOrigin','anonymous'); 
 // c.setAttribute('width','300'); 
 // c.setAttribute('height','300'); 
 // c.setAttribute('src','https://10.101.2.100:8080/video');
 // document.body.appendChild(c); 
/*
var canvas  = new fabric.Canvas('canvasContainer');
var rect = new fabric.Rect({
        left: 100,
        top: 100,
        fill:  "#FF0000",
        stroke: "black",
        width: 100,
        height: 100,
        strokeWidth: 10, 
    });
   
   
    canvas.add(rect);
     
canvas.renderAll();
var convertToImage = function(){
   alert('teste');
  canvas.deactivateAll().renderAll();  
  console.log(ten.toDataURL());
  //document.getElementById("ten2").src = canvas.toDataURL('png'); 
  var img2 = document.getElementById("ten2");
}

document.getElementById("ten2").src = canvas.toDataURL('png'); 
convertToImage();
*/
 
/*
function executar(){	
const URL_TO_FETCH = 'https://10.101.2.100:8080/video'; 
fetch(URL_TO_FETCH, { 
  mode: "no-cors",
  headers: {
	  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8" 
  },
  method: 'post' // opcional
})
.then(function(response) { 
  response.text()
  //response.json()
  console.log(response); 
  .then(function(result){ 
    alert(result);
    document.getElementById('demo').innerHTML   = result;
    console.log(result); 
  })
})
.catch(function(err) { 
  alert(err);
  console.log(err);
});
*/
}

</script>
</body>
