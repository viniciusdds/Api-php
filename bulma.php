<!DOCTYPE html> 
<html> 

<head> 
	<title> 
		How to take screenshot of 
		a div using JavaScript? 
	</title> 

	<!-- Include from the CDN -->
	<script src= 
"https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"> 
	</script> 

	<!-- Include locally otherwise -->
	<!-- <script src='html2canvas.js'></script> -->

	<style> 
		#photo { 
			border: 4px solid green; 
			padding: 4px; 
		} 
	</style> 
</head> 

<body> 
	<div id="photo"> 
		<input type="image" src="https://10.101.2.100:8080/video" id="video" name="video" width="300"  height="300" /></div>	
	</div> 
	<button onclick="takeshot()"> 
			Take Screenshot 
		</button> 
	<h1>Screenshot:</h1> 
	<div id="output"></div> 
	
	<img id="photo" src="" alt=""> 

	<script type="text/javascript"> 

		// Define the function 
		// to screenshot the div 
		function takeshot() { 
			let div = 
				document.getElementById('video'); 

			// Use the html2canvas 
			// function to take a screenshot 
			// and append it 
			// to the output div 
			html2canvas(div).then( 
				function (canvas) { 
					document 
					.getElementById('output') 
					.appendChild(canvas); 
					
					var teste = canvas.toDataURL("image/png");
					alert(teste);
					photo.src = teste;
				}) 
			
		} 
	</script> 
</body> 

</html> 
