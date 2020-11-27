<!DOCTYPE html>
<html>
<head>
	<title>Gerar e salvar imagem com CANVAS</title>
	<meta charset="UTF-8"> 
	<script>
	function iniciarExemplo(){
		var c = document.getElementById("meucanvas");
		var ctx = c.getContext("2d");

		// Criar Gradiente
		var grd = ctx.createRadialGradient(75,50,5,90,60,100);
		grd.addColorStop(0,"red");
		grd.addColorStop(1,"white");

		// Efeito
		ctx.fillStyle = grd;
		ctx.fillRect(10,10,150,80);
	}
	function salvarImagem(a){
	   var meucanvas = document.getElementById('meucanvas');
	   var arquivo = document.getElementById('arquivo');
	   /*Comentário: a variavel "a" será o nome do arquivo, use aspas para chamar a função */
	   arquivo.download = a;
	   arquivo.href = meucanvas.toDataURL();
	}
	
	</script>
</head>
<body onload="iniciarExemplo()">
 
<canvas id="meucanvas" width="200" height="100">
Seu navegador não suporta CANVAS</canvas>
<hr>

<div><img src="https://10.101.2.100:8080/video" id="video" width="300" height="300" /></div>
    
<a id="arquivo" download="https://10.101.2.100:8080/video" onclick="salvarImagem('exemplo.png')">FAÇA O DOWNLOAD AQUI</a>
<div><button id="snap">Tirar Foto</button></div>
<script>
   
    document.getElementById("snap").addEventListener("click", function() { 
	    var meucanvas = document.getElementById("meucanvas");
		if(meucanvas.getContext){
			alert('teste');
			meucanvas.getContext("2d").drawImage(video, 0, 0, 640, 480);
            		
		}
		
		
		
    });
    
	
</script>   
</body>
</html>