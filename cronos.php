<style>
	* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	overflow: hidden;
}
body {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-wrap: wrap;
	width: 100vw;
	height: 100vh;
}
#screen {
	font-family: Calibri,Arial;
	font-weight: 300;
	font-size: 45px;
	width: 330px;
	height: 50px;
	color: gray;
	letter-spacing: 3px;
}
.buttons {
width: 330px;
height: 50px;
display: flex;
align-items: center;
justify-content: center;
}
.emerald {
	border-radius: 5px;
	width: 80px;

	height: 30px;
	margin: 5px;
	border: 1px solid #384049;
  color: white;
  cursor: pointer;
  font-family: Calibri,Arial;
  font-weight: 300;
  outline: none;
  text-shadow: 0px -1px 1px black;
  text-transform: uppercase;
  transition: all 0.2s ease;
}

.emerald{
   background-image: linear-gradient(#3aad02,#2c6f05);
}
.emerald:active{
   background-image: linear-gradient(#2c6f05,#3aad02);
   text-shadow:      0px 1px 1px black;
}
</style>
<body>
	<div class="chronometer">
		<div id="screen">00 : 00 : 00 : 00</div>
		<div class="buttons">
			<button class="emerald" onclick="start()">START &#9658;</button>
			<button class="emerald" onclick="stop()">STOP &#8718;</button>
			<button class="emerald" onclick="resume()" >RESUME &#8634;</button>
			<button class="emerald" onclick="reset()">RESET &#8635;</button>
		</div>
	</div>
</body>
<script>
window.onload = function() {
   pantalla = document.getElementById("screen");
}
var isMarch = false; 
var acumularTime = 0; 
function start () {
         if (isMarch == false) { 
            timeInicial = new Date();
            control = setInterval(cronometro,10);
            isMarch = true;
            }
         }
function cronometro () { 
         timeActual = new Date();
         acumularTime = timeActual - timeInicial;
         acumularTime2 = new Date();
         acumularTime2.setTime(acumularTime); 
         cc = Math.round(acumularTime2.getMilliseconds()/10);
         ss = acumularTime2.getSeconds();
         mm = acumularTime2.getMinutes();
         hh = acumularTime2.getHours()-18;
         if (cc < 10) {cc = "0"+cc;}
         if (ss < 10) {ss = "0"+ss;} 
         if (mm < 10) {mm = "0"+mm;}
         if (hh < 10) {hh = "0"+hh;}
         pantalla.innerHTML = hh+" : "+mm+" : "+ss+" : "+cc;
         }

function stop () { 
         if (isMarch == true) {
            clearInterval(control);
            isMarch = false;
            }     
         }      

function resume () {
         if (isMarch == false) {
            timeActu2 = new Date();
            timeActu2 = timeActu2.getTime();
            acumularResume = timeActu2-acumularTime;
            
            timeInicial.setTime(acumularResume);
            control = setInterval(cronometro,10);
            isMarch = true;
            }     
         }

function reset () {
         if (isMarch == true) {
            clearInterval(control);
            isMarch = false;
            }
         acumularTime = 0;
         pantalla.innerHTML = "00 : 00 : 00 : 00";
         }
</script>