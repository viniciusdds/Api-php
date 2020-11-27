<script type="text/javascript" src="js/zxml.js"></script>
<script type="text/javascript" src="js/pos.js"></script>
<script type="text/javascript" src="js/activeX.js"></script>
<script type="text/javascript" src="js/slider.js"></script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script>

/* =================================== Continuous move (arrows) =================================== */
var newContMove = zXmlHttp.createRequest();
if( newContMove.overrideMimeType )
  newContMove.overrideMimeType( 'text/plain' );

var mouseUp;

function continousMove(action, val)
{
	//alert('continousMove');
  mouseUp = (val == "0,0" || val == "0");
  var theAction = "continuous";
  if (action == "pan" || action == "tilt") theAction += "pantiltmove=";
  else if (action == "zoom") theAction += "zoommove=";
  else if (action == "focus") theAction += "focusmove=";
  else if (action == "iris") theAction += "irismove=";
  else if (action == "brightness") theAction += "brightnessmove=";

  theAction += val;

  if (imagerotation != "")
    theAction += "&imagerotation=" + imagerotation;

  if (newContMove.readyState > 0 && newContMove.readyState < 4)
    newContMove.abort();

  var now = new Date();
  newContMove.open("GET", "http://10.101.10.100/axis-cgi/com/ptz.cgi?camera=1&"+theAction + "&timestamp=" + now.getTime(), true);
  newContMove.onreadystatechange = newContMove_onchange;
  update_sliders = false;
  newContMove.send("");
}

function newContMove_onchange()
{
	//alert('newContMove_onchange');
  if( ptzPosInterval )
    window.clearTimeout(ptzPosInterval);

  try {
    if(newContMove.status == 401) {
      return;
    }
  }
  catch(e) {}

  if (typeof(newContMove) == 'object' && newContMove.readyState == 4) {
    update_sliders = true;
    if (newContMove.responseText.length > 0) {
      if (!mouseUp) {
        // Don't show the pop-up on the mouse up event.
        var alertTxt = newContMove.responseText.replace(/<.*>/ig, "").trim();
        var panEnabled = true;
        var tiltEnabled = true;
        if (!((alertTxt.indexOf('pan') != -1 && !panEnabled) || (alertTxt.indexOf('tilt') != -1 && !tiltEnabled)))
          alert(alertTxt+" teste");
      }
    }
    ptzPosInterval = window.setTimeout(getPtzPositions, position_interval);
  }
}

/* =================================== PTZ slider functions =================================== */

  var maxPan = parseInt("180", 10);
  var minPan = parseInt("-180", 10);
  var panPos   = Math.round((minPan+maxPan)/2);
  var maxTilt = parseInt("0", 10);
  var minTilt = parseInt("-90", 10);
  var tiltPos  = Math.round((minTilt+maxTilt)/2);
  var maxZoom = parseInt("10909", 10);
    var minZoom = parseInt("1", 10);
  var zoomPos  = Math.round((minZoom+maxZoom)/2);
  var maxFocus = parseInt("9999", 10);
    var minFocus = maxFocus * (-1);
  var focusPos = Math.round((minFocus + maxFocus)/2);
  var maxIris = parseInt("9999", 10);
    var minIris = parseInt("1", 10);
  var irisPos  = Math.round((minIris+maxIris)/2);

var panSlider   = null;
var tiltSlider  = null;
var zoomSlider  = null;
var focusSlider = null;
var irisSlider  = null;

var theNewSliderValue;

var ptzPosInterval = null;
var initiateToolTip = true;

var ptzValues = zXmlHttp.createRequest();
if( ptzValues.overrideMimeType )
  ptzValues.overrideMimeType( 'text/plain' );

var isCtlStarted = false;

function getPtzPositions()
{
  if (ptzValues.readyState > 0 && ptzValues.readyState < 4)
    return;

  var now = new Date();
  var timestamp = now.getTime();
    var url = "/axis-cgi/com/ptz.cgi?query=position,limits&camera=1&html=no";
      if (imagerotation != "")
        url += "&imagerotation=" + imagerotation;
    url += "&timestamp=" + timestamp;
  ptzValues.open("GET", url, true);
  ptzValues.onreadystatechange = showPtzValues;
  try
  {
    ptzValues.send("");
  }
  catch(e)
  {}
}
</script>

	<script language="JavaScript">
<!--var ptzDefMaxOpticalZoomMag=29;
var ptzDefMaxDigitalZoomMag=12;
var ptzDefContSpeedZoom=100;
var ptzDefContSpeedFocus=20;
var ptzDefContSpeedIris=Number.NaN;

var ptzDefQueryInterval=300;

var ptzDefMinFocusList = [
  [1250, 10],
  [3750, 30],
  [6250, 100],
  [8750, 150],
];

var ptzDefMaxZoomList = [
  [358, 2],
  [715, 3],
  [1072, 4],
  [1429, 5],
  [1786, 6],
  [2143, 7],
  [2500, 8],
  [2857, 9],
  [3214, 10],
  [3571, 11],
  [3928, 12],
  [4285, 13],
  [4642, 14],
  [5000, 15],
  [5357, 16],
  [5714, 17],
  [6071, 18],
  [6428, 19],
  [6785, 20],
  [7142, 21],
  [7499, 22],
  [7856, 23],
  [8213, 24],
  [8570, 25],
  [8927, 26],
  [9284, 27],
  [9641, 28],
  [9999, 29],
  [10909, 58],
  [12727, 116],
  [14545, 174],
  [16363, 232],
  [18181, 290],
  [19999, 348],
];

var ptzDefContSpeedPan=100;
var ptzDefContSpeedTilt=100;

var ptzDefSpeedList = [
  [1, 0.20],
  [10, 0.50],
  [14, 1.00],
  [18, 2.00],
  [25, 5.00],
  [32, 10.00],
  [40, 20.00],
  [53, 45.00],
  [67, 90.00],
  [76, 135.00],
  [84, 180.00],
  [91, 225.00],
  [100, 300.00],
];

  var MoUpBtnStatTxt = "Move up";
  var MoDoBtnStatTxt = "Move down";
//-->
</script>
  Vertical
  <table  border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td valign="bottom" class="normalText">Up
        <script language="JavaScript">
        <!--
          if (typeof(ptzDefContSpeedTilt) != "number" || isNaN(ptzDefContSpeedTilt))
            var ptzDefContSpeedTilt = 70;
        -->
        </script>
        <img src="http://10.101.10.100/pics/up_14x13px.gif" width="14" height="13" onmousedown="continousMove('tilt', '0,'+ptzDefContSpeedTilt);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('tilt', '0,0');this.onmouseout=noAction; return false;">
        <span id="tilt-up"></span>
    
       <span id="zoombar1">
				<img src="http://10.101.10.100/pics/panbar_abs_268x14px.gif" width="200" height="13" id="zoom-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();">
			</span>
     
        <span id="tilt-down"></span>
        <img src="http://10.101.10.100/pics/down_14x13px.gif" width="14" height="13" onmousedown="continousMove('tilt', '0,-'+ptzDefContSpeedTilt);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('tilt', '0,0');this.onmouseout=noAction; return false;">
     Down</td>
    </tr>
  </table>	
       <script language="JavaScript">
    <!--var ptzDefMaxOpticalZoomMag=29;
var ptzDefMaxDigitalZoomMag=12;
var ptzDefContSpeedZoom=100;
var ptzDefContSpeedFocus=20;
var ptzDefContSpeedIris=Number.NaN;

var ptzDefQueryInterval=300;

var ptzDefMinFocusList = [
  [1250, 10],
  [3750, 30],
  [6250, 100],
  [8750, 150],
];

var ptzDefMaxZoomList = [
  [358, 2],
  [715, 3],
  [1072, 4],
  [1429, 5],
  [1786, 6],
  [2143, 7],
  [2500, 8],
  [2857, 9],
  [3214, 10],
  [3571, 11],
  [3928, 12],
  [4285, 13],
  [4642, 14],
  [5000, 15],
  [5357, 16],
  [5714, 17],
  [6071, 18],
  [6428, 19],
  [6785, 20],
  [7142, 21],
  [7499, 22],
  [7856, 23],
  [8213, 24],
  [8570, 25],
  [8927, 26],
  [9284, 27],
  [9641, 28],
  [9999, 29],
  [10909, 58],
  [12727, 116],
  [14545, 174],
  [16363, 232],
  [18181, 290],
  [19999, 348],
];

var ptzDefContSpeedPan=100;
var ptzDefContSpeedTilt=100;

var ptzDefSpeedList = [
  [1, 0.20],
  [10, 0.50],
  [14, 1.00],
  [18, 2.00],
  [25, 5.00],
  [32, 10.00],
  [40, 20.00],
  [53, 45.00],
  [67, 90.00],
  [76, 135.00],
  [84, 180.00],
  [91, 225.00],
  [100, 300.00],
];

          if (typeof(ptzDefContSpeedZoom) != "number" || isNaN(ptzDefContSpeedZoom))
            var ptzDefContSpeedZoom = 70;
    //-->
    </script>

     <td class="normalText"><b>ZOOM</b></td>
     <td class="normalText">&nbsp;Wide&nbsp;</td>
    <td align="center">
      <table cellpadding="1" cellspacing="1" border="1" height="17" >
        <tr>
          <td valign="middle">
            <span id="zoom-left"></span>
				<img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('zoom', -ptzDefContSpeedZoom);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('zoom', 0);this.onmouseout=noAction; return false;">
			<span id="zoombar1">
				<img src="http://10.101.10.100/pics/zoombar_268x14px.gif" width="268" height="14" id="zoom-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();">
			</span>
			<img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('zoom', ptzDefContSpeedZoom);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('zoom', 0);this.onmouseout=noAction; return false;">
			<span id="zoom-right"></span>
            <input type="hidden" name="zoomvalue" id="zoom" value="">
          </td>
         </tr>
       </table>
	   
	   Horizontal
	   <table cellpadding="1" cellspacing="1" border="1" height="17" >
			<tbody>
				<tr>
					<td valign="middle">
					  <span id="pan-left" style="cursor: pointer;"></span><img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('pan', -ptzDefContSpeedPan+',0');this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('pan', '0,0');this.onmouseout=noAction; return false;"><span id="panbar1"><img src="http://10.101.10.100/pics/panbar_abs_268x14px.gif" width="268" height="14" id="pan-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();" style="background-position: 0px 5px;"></span><img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('pan', ptzDefContSpeedPan+',0');this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('pan', '0,0');this.onmouseout=noAction; return false;"><span id="pan-right" style="cursor: pointer;"></span>
					  <input type="hidden" name="panvalue" id="pan" value="105">
					</td>
				</tr>
			</tbody>
		</table>
		
		Foco
		<table cellpadding="0" cellspacing="0" border="0" height="17" width="60%">
        <tbody><tr>
          <td valign="middle">
            <span id="focus-left" style="cursor: pointer;"></span><img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('focus', -ptzDefContSpeedFocus);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('focus', 0);this.onmouseout=noAction; return false;"><span id="focusbar1"><img src="http://10.101.10.100/pics/panbar_rel_nonlin_268x14px.gif" width="268" height="14" id="focus-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();" style="background-position: 0px 5px;"></span><img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('focus', ptzDefContSpeedFocus);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('focus', 0);this.onmouseout=noAction; return false;">
            <span id="focus-right" style="cursor: pointer;"></span>
            <input type="hidden" name="focusvalue" id="focus" value="0">
          </td>
         </tr>
       </tbody></table>
	   
<script>
	var undefinedVar;  //Workaround for IE5
var img = undefinedVar;  // The video stream image object
var cross = undefinedVar;  // The crosshair image object
var siPos;
var thedragbox;
var thedragarea;
if (browser != "IE")
  var boxdef = new Box(0,0,10,10);
var radius;
var mode = "center";

var imagerotation = "";
    imagerotation = "180"; //root_Image_I#_Appearance_Rotation
  var update_sliders = true;var ptzDefMaxOpticalZoomMag=29;
var ptzDefMaxDigitalZoomMag=12;
var ptzDefContSpeedZoom=100;
var ptzDefContSpeedFocus=20;
var ptzDefContSpeedIris=Number.NaN;

var ptzDefQueryInterval=300;

var ptzDefMinFocusList = [
  [1250, 10],
  [3750, 30],
  [6250, 100],
  [8750, 150],
];

var ptzDefMaxZoomList = [
  [358, 2],
  [715, 3],
  [1072, 4],
  [1429, 5],
  [1786, 6],
  [2143, 7],
  [2500, 8],
  [2857, 9],
  [3214, 10],
  [3571, 11],
  [3928, 12],
  [4285, 13],
  [4642, 14],
  [5000, 15],
  [5357, 16],
  [5714, 17],
  [6071, 18],
  [6428, 19],
  [6785, 20],
  [7142, 21],
  [7499, 22],
  [7856, 23],
  [8213, 24],
  [8570, 25],
  [8927, 26],
  [9284, 27],
  [9641, 28],
  [9999, 29],
  [10909, 58],
  [12727, 116],
  [14545, 174],
  [16363, 232],
  [18181, 290],
  [19999, 348],
];

var ptzDefContSpeedPan=100;
var ptzDefContSpeedTilt=100;

var ptzDefSpeedList = [
  [1, 0.20],
  [10, 0.50],
  [14, 1.00],
  [18, 2.00],
  [25, 5.00],
  [32, 10.00],
  [40, 20.00],
  [53, 45.00],
  [67, 90.00],
  [76, 135.00],
  [84, 180.00],
  [91, 225.00],
  [100, 300.00],
];

  var position_interval = ((typeof(ptzDefQueryInterval) != "number" || isNaN(ptzDefQueryInterval)) ? 1000 : ptzDefQueryInterval);

function noAction(event)
{
  return true;
}

function init()
{
  if ((browser != "IE") && (("".indexOf("/mjpg/") != -1) || (document.URL.indexOf("/view/view.shtml") == -1))) {
    img = document.getElementById("stream");
    cross = document.getElementById("crosshair");
    switchMode();
    // Center crosshair
    var si = document.getElementById("stream");
    var ch = document.getElementById("crosshair");
    siPos = getPos(si);
    ch.style.left = (si.width - ch.width)/2 + siPos.x;
    ch.style.top = (si.height - ch.height)/2 + siPos.y;
    thedragbox = document.getElementById("zoombox");
    thedragbox.style.visibility = 'hidden';
    if (mode == "center") {
      thedragarea = document.getElementById("stream");
      thedragarea.onmousedown = placeHandler;
      thedragarea.onmouseup = noAction;
      thedragarea.onmousemove = noAction;
        cross.onmousedown = placeHandler;
    }
  }
      getPtzPositions();
}
</script>