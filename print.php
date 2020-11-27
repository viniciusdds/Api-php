<?php 
	$ip = $_SERVER["REMOTE_ADDR"];
?>
<!DOCTYPE HTML>
<html >
<head>
<meta charset="utf-8">
<title>Tirar Fotos</title>
<!--<script type="text/javascript" src="html2canvas-master/dist/html2canvas.js"></script>-->

<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
</head>
<body >
<div>
<img id="foto" src="images/image2.jpg" width="640" height="480" />
   <div><img  src="http://10.101.10.100/mjpg/video.mjpg" id="video" name="video" width="640"  height="480" /></div>
		
	<div><button id="snap">Tirar Foto</button></div>
	<div><button onclick="buscarFoto();">Capturar Foto</button></div>
  	
	<canvas id="myCanvas" width="640" height="480" >
	
	<div id="demo"></div>
	
	
	
<script>
//Identificação do usuário
var ip = '<?php echo $ip; ?>'; 		
		
//Tira a foto e salvar no banco e armazena a foto em uma pasta no servidor
document.getElementById("snap").addEventListener("click", function(event) { 


	var c = document.getElementById("myCanvas");
  	var ctx = c.getContext("2d");
  	var img = document.getElementById("video");
  	ctx.drawImage(img, 0, 0, 640, 480);
	
	window.open(c.toDataURL('image/png'))
	
	//alert(image);
	//console.log(dataURL);
	
	/*
	fetch('salvarFoto.php',{
		method: 'POST',
		headers: {'Content-Type':'application/x-www-form-urlencoded'},
		body: 'action=salvar&ip='+ip
	}).then(function(response){
		response.text()
		.then(function(result){
			//alert(result);
			buscarFoto(result);
		});
	});
	*/
});

//Buscar na base a foto que foi tirada por último e mostra na tela 
function buscarFoto(){
	
	//var canvas = document.getElementById('myCanvas');
	//var canvas = document.getElementById('myCanvas');

	//var image = canvas.toDataURL();
	var dataURL = document.getElementById("foto").src = myCanvas.toDataURL(); //"images/image3.jpg";
	downloadImage(dataURL, 'my-canvas.jpeg');
alert('teste');	
}

//Carrega as fotos ao atualizar
function loadFoto(){
	fetch('salvarFoto.php',{
		method: 'POST',
		headers: {'Content-Type':'application/x-www-form-urlencoded'},
		body: 'action=load&ip='+ip
	}).then(function(response){
		response.text()
		.then(function(result){
			
			//alert(result.match(/;/gi).length);
			var fotos = result.split(';');
			var qtd = result.match(/;/gi).length;
			
			for(var i=0; i < qtd; i++){	
				//alert(fotos[i]);
				var img = document.createElement("img");
				img.setAttribute("src", fotos[i]);
				img.setAttribute("id", "foto_"+i);
				img.setAttribute("name", "foto_"+i);
				img.setAttribute("width", "304");
				img.setAttribute("height", "228");
				img.setAttribute("alt", ip);
				img.setAttribute("style", "border-style: solid; border-color: yellow");
				document.body.appendChild(img);
			}
		});
	});
}
</script>    
</body>
</html>