<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>




<meta http-equiv="Expires" content="Tue, 12 May 1962 1:00:00 GMT">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-type" CONTENT="text/html; charset=iso-8859-1">
<meta http-equiv="Content-language" CONTENT="en">
<title>PTZ Configuration/Preset Positions - AXIS P5532 Network Camera</title>

<noscript>Your browser has JavaScript turned off.<br>For the user interface to work, you must enable JavaScript in your browser and reload/refresh this page.
</noscript>

<!-- GLOBAL JAVASCRIPTS -->
<script language="JavaScript" type="text/javascript"><!--

String.prototype.trim = function() {
  return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
  return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
  return this.replace(/\s+$/,"");
}
String.prototype.crop = function(cropLength, cropMark) {
  if (typeof(cropMark) != "string")
    cropMark = "";

  if (this.length > cropLength && this.length > cropMark.length)
    return this.substr(0, cropLength - cropMark.length) + cropMark;
  else
    return this;
}

function launch(url) {
  var w = 480, h = 340;

  if (document.all) {
    /* the following is only available after onLoad */
    w = document.body.clientWidth;
    h = document.body.clientHeight;
  }
  else if (document.layers) {
    w = window.innerWidth;
    h = window.innerHeight;
  }

  var popW = 475, popH = 590;

  var leftPos = (w-popW)/2, topPos = (h-popH)/2;

  self.name = "opener";
  remote = open(url, 'helpWin', "resizable,scrollbars,status,width=" + popW + ",height="+popH+",left="+leftPos+",top="+topPos+"");

  //Fix for IE6 to solve problem with video stopping when opening help
  try {
    if ((typeof(useAMC) != "undefined")&&(useAMC == "yes") &&(navigator.appVersion.indexOf("MSIE 6") != -1) && (typeof(stopStartStream) == "function") && (typeof(imagepath) == "string"))
      stopStartStream(imagepath);
  } catch (e) {}
}

function openPopUp(thePage, theName, theWidth, theHeight)
{
  theWidth = Number( theWidth ) + 10;
  theHeight = Number( theHeight ) + 20;

  var someFeatures = 'scrollbars=yes,toolbar=0,location=no,directories=0,status=0,menubar=0,resizable=1,width=' + theWidth + ',height=' + theHeight;
  var aPopUpWin = window.open(thePage, theName, someFeatures);

  if (navigator.appName == "Netscape" && aPopUpWin != null) {
    aPopUpWin.focus();
  }
}

function showStatus(msg)
{
  window.status = msg
  return true
}
// -->
</script><script language="JavaScript">
<!--

function CSS ()
{
  if ((navigator.appVersion.indexOf("Mac") != -1) && (navigator.appName.indexOf("Netscape") != -1)) {
    document.write('<link rel="stylesheet" href="/css/mac_ns.css?version=142" type="text/css" />');

  } else if ((navigator.appVersion.indexOf("Mac") != -1) && (navigator.appName.indexOf("Microsoft Internet Explorer") != -1)) {
    document.write('<link rel="stylesheet" href="/css/mac_ie.css?version=142" type="text/css" />');

  } else if ((navigator.appVersion.indexOf("Win") != -1) && (navigator.appName.indexOf("Netscape") != -1)) {
    document.write('<link rel="stylesheet" href="/css/win_ns.css?version=142" type="text/css" />');

  } else if ((navigator.appVersion.indexOf("Win") != -1) && (navigator.appName.indexOf("Microsoft Internet Explorer") != -1)) {
    document.write('<link rel="stylesheet" href="/css/win_ie.css?version=142" type="text/css" />');

  } else if (navigator.appName.indexOf("Netscape") != -1) {
    // Unix or other system
    document.write('<link rel="stylesheet" href="/css/win_ns.css?version=142" type="text/css" />');
  } else {         
    document.write('<link rel="stylesheet" href="/css/other.css?version=142" type="text/css" />');
  }

  // Wrapper for old browsers which can't handle getElementById
  if(!document.getElementById) {
     document.getElementById = function(element)
     {
       return eval("document.all." + element);
     }
  }
}
// -->
</script>
<script language="JavaScript" type="text/javascript"><!--
CSS ();
// -->
</script>

<script language="JavaScript" type="text/javascript">
<!--
function SubmitForm()
{
  document.WizardForm.submit();
}
// -->
</script>

<!-- END GLOBAL JAVASCRIPTS -->


<SCRIPT LANGUAGE="JavaScript">
<!--

function CheckBoxClicked(theForm, theCheckBox, theVariable, theCheckValueEnable, theCheckValueDisable)
{
  if (theCheckBox.checked)
    theForm.elements[theVariable].value = theCheckValueEnable
  else
    theForm.elements[theVariable].value = theCheckValueDisable
}

function checkbounds(inputValue,maxValue,minValue)
{

 if(inputValue > maxValue)
   {
      inputValue = maxValue  
   } 
 
 if(inputValue < minValue)
   {
      inputValue = minValue  
   } 
   return inputValue
}


//-->
</SCRIPT>

<script type="text/javascript" src="http://10.101.10.100/incl/zxml.js"></script>
<script type="text/javascript" src="http://10.101.10.100/incl/pos.js"></script>
<script type="text/javascript" src="http://10.101.10.100/incl/activeX.js"></script>

<script language="JavaScript">
<!--//var lookup = new Array();
var aSortArray = new Array();

function createParamArray(f_parameter_array, f_sort_on, f_prefix, f_form, f_extra)
{
  // Create the item list
  
  var anItemArray = new Array();
  var processedID = new Array();
  var inputEntries = f_form.length;
  var j;
  var aLen;
  
  aSortArray = new Array();
  lookup = new Array();

  // Produce a f_lookuptable to get index of a parameter in the resulting array.
  // As example to get the index of Name (that is included in the f_parameter_array)
  // Write f_lookup["Name"]
  
  aLen = f_parameter_array.length;
  for (j = 0; j < aLen ; j++) {
     lookup[f_parameter_array[j]] = j;
  }
  lookup["ID"] = j++;

  // If any extra variables should be set for all entries, the extra variable is
  // an array like (theVarName, theValue) - pairs.
  if(f_extra) {
     for (i = 0 ; i < f_extra.length ; i = i + 2) {
        lookup[f_extra[i]] = j++;
     }
  }
  

  for (i = 0; i < inputEntries; i++) {
  // Get ID
     var aTempName = f_form.elements[i].name;
     var aPreStr = f_prefix.length + 1;
     var aPostStr = aTempName.indexOf("_", aPreStr);
     var ID = aTempName.substring(aPreStr + 1, aPostStr);
     var aGroupPrefix = aTempName.substring(aPreStr, aPreStr + 1);
     var aParamName = "";

     if(isNaN(ID) || (aTempName.substring(0, f_prefix.length) != f_prefix)) {
        continue;
     }

     for(j = 0 ; ((j < processedID.length) && (processedID[j] != ID)) ; j++);

     // Check if ID is already processed
     if(j < processedID.length) {
        continue;
     }

     processedID = processedID.concat(ID);

     var anItem = [];

     for(j = 0 ; j < f_parameter_array.length ; j++) {
        aParamName = f_prefix + "_" + aGroupPrefix + ID + "_" + f_parameter_array[j];
        if (f_form.elements[aParamName]) {
  	 anItem = anItem.concat(f_form.elements[aParamName].value);
        } else {
         anItem = anItem.concat("");
	}
     }
     
     anItem = anItem.concat(ID);

     if(f_extra) {
        for (i = 0 ; i < f_extra.length ; i = i + 2) {
           anItem = anItem.concat(f_extra[i + 1]);
        }
     }  

     anItemArray = anItemArray.concat([anItem]);
  }

  for (i = 0; i < anItemArray.length; i++)
  {
     var anItem = anItemArray[i];
     aSortArray = aSortArray.concat([[anItem[lookup[f_sort_on]], anItem]]); // Sorted by 'Name'
  }

  aSortArray.sort();
}

if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform != "MacPPC") && (navigator.platform != "Mac68k")) {
  var browser = "IE";
} else {
  var browser = "Netscape";
}

var currPresetId = -1;

function bodyOnLoad()
{
  init();
  disableGotoAndRemove();

    getPtzPositions();
}

function setCurrentPresetId()
{
    currPresetId = 0;
}

function getPreset()
{
  var select = document.getElementsByName("gotoserverpresetname")[0];
  return select.options[select.selectedIndex].value;
}

function getPresetNumber(val)
{
  var presetForm = document.presetForm;
  var num;

  setCurrentPresetId();

  for (i=0; i<((100 * 1)+1); i++) {
      if (presetForm['root_PTZ_Preset_P'+currPresetId+'_Position_P'+i+'_Name']) {
        if (presetForm['root_PTZ_Preset_P'+currPresetId+'_Position_P'+i+'_Name'].value == val) {
        num = i;
        break;
      }
    }
  }

  return num;
}

function gotoPreset()
{
  var url = "http://10.101.10.100/axis-cgi/com/ptz.cgi";
  var data = "camera=1&gotoserverpresetname="

  var val = getPreset();

  data += escape(val);

  sendPTZRequest(url, data, false);
}

function removePreset()
{
  var url = "http://10.101.10.100/axis-cgi/com/ptzconfig.cgi";
  var data = "camera=1&removeserverpresetname=";

  setCurrentPresetId();

  var val = getPreset();
  var num = getPresetNumber(val);

    if (isInGuardTour(num)) {
      alert("This position is used in a Guard Tour. Before it can be removed from \nthe available positions list, it has to be removed from the Guard Tour.");
      return;
    }

  if (isInSequenceMode(num)) {
    alert("This preset is used in sequence mode. Before the preset can\nbe removed, it has to be disabled on the Sequence Mode page.");
    return;
  }

  data += escape(val);

  sendPTZRequest(url, data, true);
}

  function commitRetTime(srcform)
  {
    var form = document.getElementById('settimeform');
    var time = parseInt(srcform.setTime.value, 10);
    if (isNaN(srcform.setTime.value) || time < 0 || time > 300) {
      alert("Invalid return time. Enter a valid integer between 0 and 300.");
      srcform.setTime.focus();
      srcform.setTime.select();
      return false;
    }

    form.root_PTZ_Various_V1_ReturnToOverview.value = time;
    form.submit();
  }

function isInSequenceMode(num)
{
  var form = document.sequenceForm;
  for (var i = 0; i < form.length; i++) {
    if (form['root_Sequence_S'+currPresetId+'_Source_S'+i+'_Type'])
      if (form['root_Sequence_S'+currPresetId+'_Source_S'+i+'_Type'].value == "Preset")
        if (form['root_Sequence_S'+currPresetId+'_Source_S'+i+'_Number'].value == num)
          return true;
  }
  return false;
}

  function isInGuardTour(num)
  {
    var guardTourForm = document.guardTourForm;

    for (var i = 0; i < guardTourForm.length; i++) {
      var aTempString = guardTourForm.elements[i].name;
      if (aTempString.lastIndexOf('_') == 17) {
        var guardNo = aTempString.substring(16, aTempString.lastIndexOf('_'));
      }
      if (aTempString.lastIndexOf('_') == 25) {
        var tourNo = aTempString.substring(24, aTempString.lastIndexOf('_'));
        if (guardTourForm['root_GuardTour_G'+ guardNo +'_Tour_T'+ tourNo +'_PresetNbr'].value == num) {
          return true;
        }
      }
    }

    return false;
  }

function getRadiobutton(theSelectElement)
{
  for (var i = 0 ; i < theSelectElement.length ; i++) {
    if (theSelectElement[i].checked == true) {
      return theSelectElement[i].value;
    }
  }
  return "";
}


function saveData()
{
  form.submit();
}

function auto(Path)
{
  parent.frames[1].location = Path;
}

//-->
</script>
<script language="JavaScript">

var statusPtz_count_id;

var statusPtz_periodicRequest;
var statusPtz_periodicRequest_timeout;
var statusPtz_periodicRequest_interval;

var statusPtz_request;
var statusPtz_request_control = "request";
var statusPtz_request_timeout;


var statusPtz_update_id;
var statusPtz_update_response;
  var statusPtz_update_min_period = parseInt(20*0.75); //(seconds)
var statusPtz_update_seconds = 0; //(seconds left)
var statusPtz_update_position = 0;
var statusPtz_update_error = "";

function setStatusParams(response)
{
  var re = /\"\-{0,1}\d*\"/g;
  var a = response.match(re);
  var reF = /\"/g;
  if (a != null) {
    statusPtz_update_position   = parseInt(a[0].replace(reF, ""), 10);
    statusPtz_update_seconds    = parseInt(a[1].replace(reF, ""), 10);
    statusPtz_update_min_period = parseInt(a[2].replace(reF, ""), 10);
    statusPtz_update_error      = "";
  } else {
    response = response.replace(/<.*?>|\n|\r/ig, " ").trim();
    response = response.replace(/\s+/ig, " ");
    setStatusParams_error(response);
  }
}

function setStatusParams_error(error)
{
  statusPtz_update_error = error;
    statusPtz_update_min_period    = parseInt(20*0.75);
  statusPtz_update_position      = 0;
  statusPtz_update_seconds       = 0;
}

function updateStatus()
{
  var form = document.ctlstatusform;
  var lbl = document.getElementsByName("label")[0];
  if (statusPtz_update_error.length == 0) {
    form.tleft.value = ((statusPtz_update_seconds == -1) ? "Unlimited" : statusPtz_update_seconds);
    if (statusPtz_update_position == "0") {
      lbl.value = "Request control";
      statusPtz_request_control = "request";
      form.pos.value = "";
      if (statusPtz_update_seconds == "0") {
        form.status.value = "No entry in queue with higher priority than yours.";
        //Restarts poll for position
        if (typeof(getPtzPositions) == "function" && !ptzPosInterval)
          getPtzPositions();
      } else {
        form.status.value = "Queue contains entry(s) with higher priority than yours.";
      }
    } else {
      form.pos.value = statusPtz_update_position;
      statusPtz_request_control = "drop";
      if (statusPtz_update_position == "1") {
        form.status.value = "You are possessing the control.";
        lbl.value = "Release control";
        //Restarts poll for position
        if (typeof(getPtzPositions) == "function" && !ptzPosInterval)
          getPtzPositions();
      } else {
        form.status.value = "You are in queue, please wait for your turn.";
        lbl.value = "Leave queue";
      }
    }
  }
  else
  {
    // some error has occurred
    if(form)
    {
      form.status.value = statusPtz_update_error;
      form.pos.value = "";
      form.tleft.value = "";
    }
    ctlStop();
  }
}


function ctlReq()
{
  switch(statusPtz_request_control)
  {
    case "request":
      sendStatusRequest("request")
      break;
    case "drop":
      sendStatusRequest("drop")
      break;
  }
}

function sendStatusRequest(action)
{
  if (!statusPtz_request)
    ctlStart();
  var now = new Date();
  statusPtz_request.open("GET", "http://10.101.10.100/axis-cgi/com/ptzqueue.cgi?control=" + action + "&tagresponse=yes&camera=1&timestamp=" + now.getTime(), true);
  delete now;
  statusPtz_request.onreadystatechange = statusPtz_request_stateChange;
  statusPtz_request.send("");

  statusPtz_request_timeout = window.setTimeout(statusPtz_request_timedout, 10000);
}

function statusPtz_request_stateChange()
{
  window.clearTimeout(statusPtz_request_timeout);
  if (statusPtz_request.readyState == 4) {
    if (statusPtz_request.status == 200) {
      setStatusParams(statusPtz_request.responseText);
    } else if (statusPtz_request.status != 204 && statusPtz_request.status != 1223) {
      setStatusParams_error(statusPtz_request.status + " - " + statusPtz_request.statusText)
    }
    if (statusPtz_request.status != 401) {
      statusPtz_periodicRequest_start();
    }
  } else if (statusPtz_request.readyState == 0) {
    setStatusParams_error("Aborted");
    statusPtz_periodicRequest_start();
  }
}

function statusPtz_request_timedout()
{
  statusPtz_request.abort();
}

function sendPeriodicRequest()
{
  if (statusPtz_periodicRequest.readyState != 0 && statusPtz_periodicRequest.readyState != 4)
    return;
  var now = new Date();
  statusPtz_periodicRequest.open("GET", "http://10.101.10.100/axis-cgi/com/ptzqueue.cgi?control=query&tagresponse=yes&camera=1&timestamp=" + now.getTime(), true);
  delete now;
  statusPtz_periodicRequest.onreadystatechange = statusPtz_periodicRequest_stateChange;
  statusPtz_periodicRequest.send("");

  statusPtz_periodicRequest_timeout = window.setTimeout(statusPtz_periodicRequest_timedOut, 10000);
}

function statusPtz_periodicRequest_stateChange()
{
  window.clearTimeout(statusPtz_periodicRequest_timeout);
  if (statusPtz_periodicRequest.readyState == 4) {
    if (statusPtz_periodicRequest.status == 200) {
      setStatusParams(statusPtz_periodicRequest.responseText);
    } else if (statusPtz_periodicRequest.status != 204 && statusPtz_periodicRequest.status != 1223) {
      setStatusParams_error(statusPtz_periodicRequest.status + " - " + statusPtz_periodicRequest.statusText)
    }
    updateStatus();
  } else if (statusPtz_periodicRequest.readyState == 0) {
    setStatusParams_error("Aborted");
    updateStatus();
  }
}

function statusPtz_periodicRequest_timedOut()
{
  statusPtz_periodicRequest.abort();
}

function statusPtz_periodicRequest_start()
{
  if (statusPtz_periodicRequest_interval)
    window.clearInterval(statusPtz_periodicRequest_interval);
  if (statusPtz_periodicRequest_timeout)
    window.clearTimeout(statusPtz_periodicRequest_timeout);

  sendPeriodicRequest();
  statusPtz_periodicRequest_interval = window.setInterval(sendPeriodicRequest, statusPtz_update_min_period * 1000);
}

function handleCtlReq()
{
  window.clearTimeout(statusPtz_update_id);
  sendStatusRequest("request");
  // restart timeout to be sure update will be done in time.
  statusPtz_update_id = window.setTimeout(updateStatus, 2000);
}

function handleCtlDrop(form)
{
  window.clearInterval(statusPtz_count_id);
  window.clearTimeout(statusPtz_update_id);
  sendStatusRequest("drop");
  // restart - but wait a while to be sure the above form is sent.
  statusPtz_update_id = window.setTimeout(ctlStart, 500);
}

function ctlStart()
{
  if (typeof(zXmlHttp) == "undefined") {
    window.setTimeout(ctlStart, 500);
    return;
  }
  statusPtz_periodicRequest = zXmlHttp.createRequest();
  if( statusPtz_periodicRequest.overrideMimeType )
    statusPtz_periodicRequest.overrideMimeType( 'text/plain' );
  statusPtz_request = zXmlHttp.createRequest();
  if( statusPtz_request.overrideMimeType )
    statusPtz_request.overrideMimeType( 'text/plain' );

  statusPtz_periodicRequest_start();

  startCountDown();
}

function ctlRepeat()
{
  statusPtz_periodicRequest_start();
}

function ctlStop()
{
  // reset label + action
  var lbl = document.getElementsByName("label")[0];
  if(lbl)
    lbl.value = "Request control";
  statusPtz_request_control = "request";
  // stop timers
  window.clearInterval(statusPtz_count_id);
  window.clearTimeout(statusPtz_update_id);
}

function startCountDown()
{
  statusPtz_count_id = window.setInterval(countDown, 1000);
}

function countDown()
{
  var form = document.ctlstatusform;
  if (form && form.tleft.value != "")
  {
    var t = parseInt(form.tleft.value, 10);
    if (t > 0)
    {
      form.tleft.value = t - 1;
    }
  }
} 

function applyCurrenPos()
{
  var presetName = document.preset.setserverpresetname;

  var presetNameStr = presetName.value.trim();

  var re = /["<>~:]/;

  if (presetNameStr != presetName.value) {
    alert("Leading and trailing spaces are not allowed.");
    presetName.focus();
    presetName.select();
    return;
  }

  if (presetNameStr == "") {
    alert("Specify a name for the current position.");
    presetName.focus();
    return;
  }

  if (re.test(presetNameStr)) {
    alert("Invalid character. ~, :, <, > and " + '"' + " are not allowed in the preset name.");
    presetName.focus();
    presetName.select();
    return;
  }

  var reHome = /\(H\)$/;

  if(reHome.test(presetNameStr)) {
    alert("Invalid name. (H) is not allowed at the end of the preset name.");
    presetName.focus();
    presetName.select();
    return false;
  }

  var sameAsOld = "no";
  var isHome = false;

  for (var i=0; i<document.test.gotoserverpresetname.length; i++) {
    var oldPresetName = document.test.gotoserverpresetname[i].value;
    isHome = false;

    if (document.test.gotoserverpresetname[i].text.indexOf(" (H)") != -1) {
      isHome = true;
    }

    if (oldPresetName.trim() == presetNameStr) {
      sameAsOld = "yes";
      if (confirm("A preset with the name " + presetNameStr + " already exists.\nDo you want to replace the old preset?")) {
        break;
      } else {
        presetName.focus();
        presetName.select();
        return;
      }
    }
  }

    if (sameAsOld == "no") {
      if ( checkPresetCount()) {
        var max_nbr_of_presets = 100 * 1;
        alert("The maximum number of preset positions is " + max_nbr_of_presets + ". To add more positions you need to remove one or more of the existing positions first.");
        return;
      }
    }
  stopStartStream(stillImagePath);
  wait_start();

  var url = "/axis-cgi/com/ptzconfig.cgi";
  var data = "setserverpresetname=" + escape(presetNameStr);
    isHome = document.preset.home.checked;
    data+= "&home=" + (isHome ? "yes" : "no")
  data+= "&camera=1";
  sendPTZRequest(url, data, true);
}


var request = zXmlHttp.createRequest();
if( request.overrideMimeType )
  request.overrideMimeType( 'text/plain' );
var request_timeout;
var request_reload;

function sendPTZRequest(url, data, isReload)
{
  wait_disableInput();
  request_reload = isReload;
  var now = new Date();
  request.open("get", url +"?"+ data + "&timestamp=" + now.getTime(), true);
  request.onreadystatechange = request_stateChange;
  request.send("");
  delete now;

  request_timeout = window.setTimeout(request_timedout, 10000);
}

function request_stateChange()
{
  if (request.readyState == 4) {
    window.clearTimeout(request_timeout);
    if (!(request.status == 200 || request.status == 204 || request.status == 1223)) {
      alert("The current action caused an error.");
    }
    else if(request.status == 200 && request.responseText != "") {
      var theErrorText = request.responseText;
      if (theErrorText.indexOf("too many preset positions") != -1) {
        theErrorText = "Error:\nCould not add preset.\nMaximum number of presets have been reached.";
      }
      alert(theErrorText);
    }
    wait_enableInput();
    if (request_reload)
      resetForm();
  } else if (request.readyState == 0) {
    alert("The current action was aborted.");
    wait_enableInput();
  }
}

function request_timedout()
{
  request.abort();
}

function checkPresetCount()
{
    return( document.presetForm.elements.length >= (100 * 1 * 2) );
}

function enableQueue(form)
{
  form.submit();
  window.setTimeout("resetForm()", 1000);
}

function extractVideoNbr(theParamPos)
{
  var i = 0;
  var start, stop;
  var len;
  var colonCount = 0;

  while (theParamPos.charAt(i++) != '~' && i < theParamPos.length);
  if (i >= theParamPos.length) {
    return -1;
  }
  while (colonCount < 6 && i < theParamPos.length) {
    if (theParamPos.charAt(i++) == ':') {
      colonCount++;
      if (colonCount == 4)
        start = i;
      if (colonCount == 5)
        len = i-2-start+1;
    }
  }
  if (i < theParamPos.length && len > 0)
    return parseInt(theParamPos.substr(start,len), 10);
  else
    return -1;
}

function disableGotoAndRemove()
{
  if (document.presetForm.elements.length < 1)
  {
    document.test.GotoButton.disabled = true;
    document.test.RemoveButton.disabled = true;
  }
}

function showPresetList()
{
    document.write('<SELECT NAME="gotoserverpresetname">');
  var addedOptions = false;
  if (document.presetForm.elements.length < 1) {
    document.write('<OPTION class="gray">&nbsp;----------------</OPTION>');
    addedOptions = true;
  } else {
    for (var j=0; j<document.presetForm.elements.length; j++) {
      var tmpArray = document.presetForm.elements[j].name.split("_");
          if (tmpArray[tmpArray.length - 1] == "Name") {
            var value = document.presetForm.elements[j].value;
            var group = tmpArray[tmpArray.length - 2];

              var homeGrp = "P1";

            document.write('<option value="' + value + '">' + value + '');
            if (group == homeGrp)
            {
              document.write(' (H)');
            }
            document.write('</option><br />');
            addedOptions = true;
          }
    }//for
    if( !addedOptions )
    {
      document.write('<OPTION class="gray">&nbsp;----------------</OPTION>');
    }

  }
  document.write('</SELECT>');
}

function resetForm()
{
    document.location = 'ptz.shtml?nbr=0&id=156';
}


  var SaveBtnStatTxt = "Save the settings";
  var ResBtnStatTxt = "Revert to last saved settings";
  var addBtnStatTxt = "Add preset at current position";
  var gotoBtnStatTxt = "Go to selected preset";
  var removeBtnStatTxt = "Remove selected preset";
  var applyBtnStatTxt = "Apply PTZ Control Que settings";
  var nextBtnStatTxt = "Go to next step i wizard";

</script><script language="javascript">
<!--
if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform.substr(0,3) != "Mac")) {
	var isIE = true;
} else {
	var isIE = false;
}

var waitDiv1 = null;
var waitDiv2 = null;
var waitDiv3 = null;
var waitDiv4 = null;

//Wait_top and wait_width are OPTIONAL
function wait_init(wait_text, wait_top, wait_width)
{
  var top = 200;
  if(wait_top && wait_top >= 0)
    top = wait_top;
  var width = 400;
  if(wait_width && wait_width > 0)
    width = wait_width;
  var padding = 40;
  var left = parseInt((document.body.clientWidth - width - 2 * padding)/2, 10);
  var default_message = "Processing...";

  waitDiv1 = document.createElement("DIV");
  waitDiv1.style.display = "none";
  waitDiv1.align = "center";
  waitDiv1.style.backgroundColor = "transparent";
  waitDiv1.style.position = "absolute";
  waitDiv1.style.left = 0;
  waitDiv1.style.top = 0;
  waitDiv1.style.zIndex = "500";
  waitDiv1.style.width = "100%";
  waitDiv1.style.height = "100%";
  waitDiv1.innerHTML = "<br>";
  document.body.appendChild(waitDiv1);

  waitDiv2 = document.createElement("DIV");
  waitDiv2.style.top = top+"px";
  waitDiv2.style.left = left+"px";
  waitDiv2.style.width = width+"px";
  waitDiv2.style.position = "absolute";
  waitDiv2.style.backgroundColor = "#3366cc";
  waitDiv2.style.border = "black solid 1px";
  waitDiv2.style.margin = "0";
  waitDiv2.style.padding = padding+"px";
  waitDiv2.style.zIndex = "501";
  waitDiv2.style.opacity = 0.6;
  waitDiv2.style.filter = "alpha(opacity=60)";
  waitDiv2.innerHTML = (typeof(wait_text) != "undefined" ? wait_text : default_message);
  waitDiv1.appendChild(waitDiv2);

  waitDiv3 = document.createElement("DIV");
  waitDiv3.style.top = top+"px";
  waitDiv3.style.left = left+"px";
  waitDiv3.style.width = width+"px";
  waitDiv3.style.position = "absolute";
  waitDiv3.style.backgroundColor = "transparent";
  waitDiv3.style.border = "black solid 1px";
  waitDiv3.style.margin = "0";
  waitDiv3.style.padding = padding+"px";
  waitDiv3.style.zIndex = "502";
  waitDiv3.innerHTML = (typeof(wait_text) != "undefined" ? wait_text : default_message);
  waitDiv1.appendChild(waitDiv3);

  waitDiv4 = document.createElement("DIV");
  waitDiv4.style.display = "none";
  waitDiv4.align = "center";
  waitDiv4.style.backgroundColor = "white";
  waitDiv4.style.position = "absolute";
  waitDiv4.style.left = 0;
  waitDiv4.style.top = 0;
  waitDiv4.style.zIndex = "499";
  waitDiv4.style.width = "100%";
  waitDiv4.style.height = "100%";
  waitDiv4.style.opacity = 0.1;
  waitDiv4.style.filter = "alpha(opacity=10)";
  waitDiv4.innerHTML = "<br>";
  document.body.appendChild(waitDiv4);
}
//Wait_top and wait_width are OPTIONAL
function wait_start(wait_text, wait_top, wait_width)
{
  if (waitDiv1 == null)
    wait_init(wait_text, wait_top, wait_width);

  if ( document.Player ) {
    document.Player.style.visibility = "hidden";
  }
  waitDiv1.style.display = "block";
  waitDiv4.style.display = "block";
}
function wait_stop()
{
  if (waitDiv1 != null) {
    waitDiv1.style.display = "none";
    waitDiv4.style.display = "none";
  }

  if ( document.Player ) {
    document.Player.style.visibility = "visible";
  }
}
function wait_disableInput(typeToDisable)
{
  var inputs = document.getElementsByTagName("INPUT");
  if (typeToDisable == null)
    typeToDisable = "";
  typeToDisable = typeToDisable.toLowerCase();
  for (var i = 0; i < inputs.length; i++) {
    if (typeToDisable == inputs[i].type.toLowerCase() || typeToDisable == "") {
      inputs[i].oldDisabled = inputs[i].disabled;
      inputs[i].disabled = true;
    }
  }
}
function wait_enableInput(typeToEnable)
{
  var inputs = document.getElementsByTagName("INPUT");
  if (typeToEnable == null)
    typeToEnable = "";
  typeToEnable = typeToEnable.toLowerCase();
  for (var i = 0; i < inputs.length; i++) {
    if (typeToEnable == inputs[i].type.toLowerCase() || typeToEnable == "") {
      inputs[i].disabled = inputs[i].oldDisabled;
    }
  }
}
-->
</script>
</head>

<body class="bodyBg" topmargin="0" leftmargin="15" marginwidth="0" marginheight="0" bgcolor="white" onload="bodyOnLoad()" onResize="bodyOnLoad()">

  <form name="UploadedFilesForm">
  </form>

<a name="top"></a>
<table width="100%" cellspacing=0 cellpadding=0 border=0><tr><td align="center">
<br>
<table width=700 cellspacing=0 cellpadding=0 border=0>
  <tr>
    <td colspan=2><img src="http://10.101.10.100/pics/line_corner_lt_5x5px.gif" width=5 height=5 border=0 alt=""></td>
    <td colspan=5 background="http://10.101.10.100/pics/line_t_100x5px.gif"><img src="http://10.101.10.100/pics/line_t_100x5px.gif" width=1 height=5 border=0 alt=""></td>
    <td colspan=2><img src="http://10.101.10.100/pics/line_corner_rt_5x5px.gif" width=5 height=5 border=0 alt=""></td>
  </tr>
  <tr>
    <td class="lineBg"><img src="/pics/blank.gif" width="1" border=0 alt=""></td>
    <td><img src="http://10.101.10.100/pics/blank.gif" width="4" height=1 border=0 alt=""></td>
    <td colspan=5 valign="middle" align="left">
      <table border=0 cellspacing=5 cellpadding=0 width="100%">
        <tr>
          <td width="10%" align="left" nowrap>
  <script language="JavaScript" type="text/javascript">
  <!--
    if( typeof(document.UploadedFilesForm) != "undefined" )
    for (i=0; i<document.UploadedFilesForm.length; i++) {
      if (document.UploadedFilesForm.elements[i].value.indexOf("viewer/extraLogo_left.") != -1) {
        document.write('<img src="/local/'+document.UploadedFilesForm.elements[i].value+'">&nbsp;');
        break;
      }
    }
  -->
  </script>
          <a href="http://www.axis.com/" target=_blank><img src="http://10.101.10.100/pics/logo_70x29px.gif" width=70 height=29 border=0 alt="AXIS"></a>
  <script language="JavaScript" type="text/javascript">
  <!--
    if( typeof(document.UploadedFilesForm) != "undefined" )
    for (i=0; i<document.UploadedFilesForm.length; i++) {
      if (document.UploadedFilesForm.elements[i].value.indexOf("viewer/extraLogo_right.") != -1) {
        document.write('&nbsp;<img src="/local/'+document.UploadedFilesForm.elements[i].value+'">');
        break;
      }
    }
  -->
  </script>
        </td>

          <td class="topTitle" nowrap width="70%" align="center" id="tincl_prodName">AXIS P5532 Network Camera</td>

          <td nowrap align="right">
            <table border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td nowrap><a href="/" class="linkInActive" target="_top" id="tincl_LViewTxt">Live View</A></td>
                <td>|</td>
                <td nowrap><a href="/operator/basic.shtml?id=156" class="linkActive" id="tincl_SetTxt">Setup</a></td>
                <td>|</td>
                <td nowrap><a href="javascript:launch('/help/toc.shtml')" class="linkInActive" id="tincl_HelpTxt">Help</a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td><img src="http://10.101.10.100/pics/blank.gif" width="4" border=0 alt=""></td>	
    <td class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td>
  </tr>
  <tr>
    <td colspan=9 class="lineBg"><img src="/pics/blank.gif" width=1 height=1 border=0 alt=""></td>
  </tr>
  <tr>
    <td class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td>
    <td colspan=2 valign="top" align="left" class="topTitle">
      <table cellpadding=0 cellspacing=0 border=0 width="100%">
        <tr>
          <td width=4 class="menuActive"></td>
          <td valign="middle" align="left" width=169 class="menuActive" id="mainMenu" nowrap>






<script language="javascript" type="text/javascript">
<!--
  var user_realm = 1;

var grView = "http";
var grOper = "http";
var grAdmin = "http";
var hostV = getHost(grView);
var hostO = getHost(grOper);
var hostA = getHost(grAdmin);

function getMenu(arr, level)
{
  if (arr.length < 0)
    return null;

  var ulEl = document.createElement("UL");
  var liEl = document.createElement("LI");

  if (arr[6].length > 0)
    liEl.className = 'subMenuMarker'+(arr[4] ? 'A' : 'Ina' )+'ctive';

  var aEl = document.createElement("A");
  aEl.href = getUrl( arr );
  aEl.innerHTML = arr[0];
  aEl.className = (level == 0 ? 'menu' : 'subMenu') +  (arr[4] && arr[6].length == 0 ? 'In' : '') + 'Active';

  if (arr[5] != null)
    aEl.onclick= function(){ eval( arr[5]) };
  aEl.target="_top";

  liEl.appendChild( aEl );

  var childEl;

  if (arr[6].length > 0 && arr[4]) {
    for (var i = 0; i < arr[6].length; i++) {
      if (arr[6][i] && arr[6][i].length > 0) {
        childEl = getMenu(arr[6][i], level+1);
        if( childEl )
        {
          liEl.appendChild( childEl );
        }
      }
    }
  }

  ulEl.appendChild( liEl );
  return ulEl;
}

function getUrl( arr )
{
  var host = hostV;
  if (user_realm == 1 || arr[3] == 1)
    host = hostA;
  else if (user_realm == 2 || arr[3] == 2)
    host = hostO;

  if( arr[1] == "" && arr[6].length > 0 )
  {
    return getUrl( arr[6][ 0 ] );
  }

  return host + arr[1] + '?' + arr[2] + "id=156";
}

function writeMenu()
{
  var elMenu = document.getElementById("mainMenu");
  if( elMenu )
  {
    var el;
    for (var i = 0; i < oMenu.length; i++) {
      if ( oMenu[i].length <= 0)
        continue;
      el = getMenu(oMenu[i], 0);
      if( el )
      {
        elMenu.appendChild( el );
      }
    }
  }

}


function getHost(group) {
  var httpPort = 80;
  if( location.protocol == "http:" )
  {
    httpPort = (location.port > 0 ?':' + location.port : "");
  }
  else
  {
    httpPort = (httpPort == 80 ? "" : ":" + httpPort);
  }

  var httpsPort = 443;
  if (location.protocol == "https:")
  {
    httpsPort = (location.port > 0 ? ':' + location.port : "");
  }
  else
  {
    httpsPort = (httpsPort == 443 ? "" : ":" + httpsPort);
  }

  var preUrl;
  if (group == "http")
    preUrl = "http://" + getIPv6HostName(location.hostname) + httpPort;
  else if (group == "https")
    preUrl = "https://" + getIPv6HostName(location.hostname) + httpsPort;
  else
    preUrl = location.protocol + "//" + getIPv6HostName(location.hostname) + (location.protocol == "http:" ? httpPort : httpsPort);
  return preUrl;
}

function getIPv6HostName(hostname)
{
  if (hostname.split(":").length > 1 && hostname.indexOf("[") < 0)
    hostname = "[" + hostname + "]";
  return hostname;
}


var bol = 0; //basic menu list numbering

var oMenu =
[


  [ "Basic Setup", "/operator/basic.shtml", "", 2, false, null,
    [
      ["Instructions", "/operator/basic.shtml", "", 2, false, null, []],
      [(++bol) + "  " + "Users", "/admin/users.shtml", "basic=yes&", 1, false, null, []],
      [(++bol) + "  " + "TCP/IP", "/admin/tcpip.shtml", "basic=yes&", 1, false, null, []],
      [(++bol) + "  " + "Date & Time", "/admin/date.shtml", "basic=yes&", 1, false, null, []],
      [(++bol) + "  " + "Video Stream", "/operator/videostream.shtml", "nbr=0&basic=yes&", 2, false, null,
        [
        ]
      ],


    [(++bol) + "  " + "Audio Settings", "/operator/audio_settings.shtml", "basic=yes&nbr=0&", 2, false, null,
      [
      ]
    ],
      []
    ]
  ],




  [ "Video & Audio", "", "", 2, false, null,
    [
      [ "Video Stream", "/operator/videostream.shtml", "nbr=0&", 2, false, null,
        [
        ]
      ],
      [ "Stream Profiles", "/operator/streamprofilelist.shtml", "", 2, false, null, []],
        [ "Camera Settings", "/operator/advanced.shtml", "nbr=0&", 2, false, null, []],

        ["Overlay Image", "/operator/overlay.shtml", "", 2, false, null, []],
        ["Privacy Mask", "/operator/privacy_mask.shtml", "", 2, false, null, []],



      [ "Audio Settings", "/operator/audio_settings.shtml", "nbr=0&", 2, false, null,
        [
        ]
      ],
      [ "Audio Clips", "/operator/audioclip.shtml", "", 2, false, null, []],


      []
    ]
  ],








  [ "Live View Config", "", "", 2, false, null,
    [
      [ "Layout", "/operator/layout.shtml", "", 2, false, null, []],
      []
    ]
  ],


[ "PTZ", "", "", 2, true, null,
  [



        ["Preset Positions", "/operator/ctl.shtml", "nbr=0&", 2, true, null, []],

          [ "Gatekeeper", "/operator/ctl.shtml", "nbr=0&gatekeeper=yes&", 2, false, null, []],
        [ "Guard Tour", "/operator/guardTour.shtml", "nbr=0&", 2, false, null, []],
        [ "OSDI Zones", "/operator/osdi.shtml", "", 2, false, null, []],
        [ "Advanced", "", "", 1, false,  null,
          [
            [ "Limits", "/admin/mechLimits.shtml", "", 1, false, null, []],
            [ "Controls", "/admin/panel_view.shtml", "nbr=0&", 1, false, null, []],
            []
          ]
        ], //menu_ptzcam0 = yes //menu_ptz_show_all_1 = yes

        [ "Control Queue", "/operator/ptzQueue.shtml", "", 2, false, null, []],
    []
  ]
], // $ptz = yes




["Detectors", "", "", null, false, null,
  [
      [ "Motion Detection", "/operator/motionDetection.shtml", "nbr=0&", 2, false, null, []],

      [ "Audio Detection", "/operator/audioDetection.shtml", "", 2, false, null, []],

    []
  ]
],


["Applications", "", "", 1, false, null,
  [
    [ "Overview", "/admin/devtools.shtml", "", 1, false, null, [] ],
  ]
],

["Events", "", "", 2, false, null,
  [
    [ "Action Rules", "/operator/action_rules.shtml", "", 2, false, null, []],
    [ "Recipients", "/operator/recipients.shtml", "", 2, false, null, []],
    [ "Schedules", "/operator/schedules.shtml", "", 2, false, null, []],
    [ "Recurrences", "/operator/recurrences.shtml", "", 2, false, null, []],
    []
  ]
],


[ "Recordings", "", "", 2, false, null,
  [
    [ "List", "/operator/recList.shtml", "", 2, false, null, []]
    ,[ "Continuous", "/operator/continuously.shtml", "", 2, false, null, []]
  ]
],


[ "System Options", "", "", 1, false, null,
  [
    [ "Security", "", "", 1, false, null,
      [
        ["Users", "/admin/users.shtml", "", 1, false, null, []],
        [ "ONVIF", "/admin/onvif.shtml", "", 1, false, null, []],
        [ "IP Address Filter", "/admin/restrictIP.shtml", "", 1, false, null, []],
        [ "HTTPS", "/admin/https.shtml", "", 1, false, null, []],
        [ "IEEE 802.1X", "/admin/8021x.shtml", "", 1, false, null, []],
        [ "Audio Support", "/admin/audio_support.shtml", "", 1, false, null, []],
        []
      ]
    ],

    [ "Date & Time", "/admin/date.shtml", "", 1, false, null, []],

    [ "Network", "", "", 1, false, null,
      [
        [ "TCP/IP", "", "", 1, false, null,
          [
            [ "Basic", "/admin/tcpip.shtml", "", 1, false, null, []],
            [ "Advanced", "/admin/advanced_tcpip.shtml", "", 1, false, null, []]
          ]
        ],

        [ "SOCKS", "/admin/socks.shtml", "", 1, false, null, []],
        [ "QoS", "/admin/qos.shtml", "", 1, false, null, []],
        [ "SMTP (email)", "/admin/smtp.shtml", "", 1, false, null, []],
        [ "SNMP", "/admin/snmp.shtml", "", 1, false, null, []],
        [ "UPnP&#8482;", "/admin/UPnP.shtml", "", 1, false, null, []],
        [ "RTP", "/admin/rtp.shtml", "", 1, false, null, []],
        [ "Bonjour", "/admin/bonjour.shtml", "", 1, false, null, []],
        []
      ]
    ],

      [ "Storage", "", "", 1, false, null,
        [
          [ "Overview", "/admin/storageList.shtml", "", 1, false, null, []],
          []
        ]
      ],


    [ "Ports & Devices", "", "", 1, false, null,
      [
        [ "I/O Ports", "/admin/ioPorts.shtml", "", 1, false, null, []],
        [ "Port Status", "/operator/portStatus.shtml", "", 2, false, null, []],
        []
      ]
    ],
    [ "Maintenance", "/admin/maintenance.shtml", "", 1, false, null, []],
    [ "Support", "", "", 1, false, null,
      [
        [ "Support Overview", "/admin/supportOverview.shtml", "", 1, false, null, []],
        [ "System Overview", "/admin/overview.shtml", "", 1, false, "openPopUp('/admin/collectingData.shtml', 'Data', 300, 130)", []],
        [ "Logs & Reports", "", "", 1, false, null,
          [
            [ "Information", "/admin/logs.shtml", "", 1, false, null, []],
            [ "Configuration", "/admin/logconfig.shtml", "", 1, false, null, []]
          ]
        ]
      ]
    ],
    [ "Advanced", "", "", 1, false, null,
      [
        [ "Scripting", "/admin/scripting.shtml", "", 1, false, null, []],
        [ "File Upload", "/admin/fileUpload.shtml", "", 1, false, null, []],
        [ "Plain Config", "/admin/config.shtml", "", 1, false, null, []]
      ]
    ]
  ]
],


[ "About", "/admin/about.shtml", "", 1, false, null, []]
];
writeMenu();
//-->
</script>
          </td>
        </tr>
      </table>
    </td>
    <td class="lineBg"><img src="/pics/blank.gif" width=1 height=5 alt=""></td>
    <td valign="top"><img src="/pics/blank.gif" width=4 height=1 alt=""></td>
    <td valign="top" colspan=2>
<form name="guardTourForm">
</form>
<form name="presetForm"><input type="hidden" name="root_PTZ_Preset_P0_Position_P1_Name" value="Home" ><input type="hidden" name="root_PTZ_Preset_P0_Position_P1_Data" value="autoiris=on:autofocus=on:dzoom=10000:pan=0:tilt=-45:defaulthomepreset=yes" >
</form>
<form name="listFormInt"><input type="hidden" name="root_ImageSource_NbrOfSources" value="1" ><input type="hidden" name="root_ImageSource_I0_Name" value="Camera" ><input type="hidden" name="root_ImageSource_I0_Sensor_AutoSlowShutter" value="on" ><input type="hidden" name="root_ImageSource_I0_Sensor_Brightness" value="50" ><input type="hidden" name="root_ImageSource_I0_Sensor_ColorLevel" value="50" ><input type="hidden" name="root_ImageSource_I0_Sensor_Exposure" value="auto" ><input type="hidden" name="root_ImageSource_I0_Sensor_ExposureWindow" value="auto" ><input type="hidden" name="root_ImageSource_I0_Sensor_MaxGain" value="75" ><input type="hidden" name="root_ImageSource_I0_Sensor_Sharpness" value="50" ><input type="hidden" name="root_ImageSource_I0_Sensor_Stabilizer" value="off" ><input type="hidden" name="root_ImageSource_I0_Sensor_WhiteBalance" value="auto" ><input type="hidden" name="root_ImageSource_I0_Sensor_WDR" value="wdr1" ><input type="hidden" name="root_ImageSource_I0_Sensor_HighResolutionFilter" value="off" ><input type="hidden" name="root_ImageSource_I0_Sensor_FocusTraceCurve" value="normal" ><input type="hidden" name="root_ImageSource_I0_Sensor_Shutter" value="60" ><input type="hidden" name="root_ImageSource_I0_Sensor_MaxExposureTime" value="-16" ><input type="hidden" name="root_ImageSource_I0_Sensor_NoiseReduction" value="on" ><input type="hidden" name="root_ImageSource_I0_Sensor_NoiseReductionTuning" value="0" ><input type="hidden" name="root_ImageSource_I0_Sensor_AutoIrCutFilterHysteresis" value="50" ><input type="hidden" name="root_ImageSource_I0_Video_DetectedType" value="NTSC" ><input type="hidden" name="root_ImageSource_I0_Video_CaptureMode" value="NTSC" >
</form>
<form name="sequenceForm">
</form>

<table border="0" cellpadding="3" cellspacing="0" width="100%" valign="top">
  <tr>
    <td>
      <table border="0" cellpadding="3" cellspacing="0" width="100%" class="color1">
        <tr>
          <td colspan="4" valign="top" class="topTitle">
            <div align="left">Preset Positions
            </div>
          </td>
          <td class="topTitle" align="right"><a href="javascript:launch%28%27/help/ptz_h.shtml%27%29"><img height="27" width="27" src="/pics/help.gif" border="0" alt="Click here for help"></a></td>
        </tr>
          <tr>
            <td class="subTitle" colspan="5" align="left">Preset Position Setup</td>
          </tr>
      </table>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="20%" valign="top" class="oddItem">
              <table border="0" cellpadding="3" cellspacing="0" class="evenItem">
                <tr>
                  <td nowrap class="evenItem">Current position:</td>
                </tr>
                <tr>
                  <td class="evenItem" nowrap>
                    <form name="preset" action="" method="post" onsubmit="return false;">
                      <input type="text" name="setserverpresetname" value="" maxlength="31" /><br><br>
                        <input type="checkbox" name="home" value="yes" />&nbsp;Use current position as Home<br><br>
                      <input type="button" class="btnNormal" value="Add" onclick="applyCurrenPos();" onmouseover="return showStatus(addBtnStatTxt)" onmouseout="return showStatus('')" /><br><br>
                      <input type="hidden" name="camera" value="1" />
                    </form>
                  </td>
                </tr>
                <tr>
                  <td class="oddItem"><br></td>
                </tr>
                <tr>
                  <td colspan="1" nowrap class="evenItem">Available positions:</td>
                </tr>
                <tr>
                  <td>
                    <form name="test" action="" method="post" onsubmit="return false;">
                      <script>showPresetList()</script><br>
                      <input type="button" value="Go to" name="GotoButton" onclick="JavaScript: gotoPreset();" onmouseover="return showStatus(gotoBtnStatTxt)" onmouseout="return showStatus('')" />
                      <input type="button" class="btnNormal" value="Remove" name="RemoveButton" onclick="javascript:removePreset();" onmouseover="return showStatus(removeBtnStatTxt)" onmouseout="return showStatus('')" />
                    </form>
                    <br><br>
                  </td>
                </tr>

                  <form name="returntooverviewtime" action="" method="post" onsubmit="return false;">
                    <tr>
                      <td class="oddItem"><br></td>
                    </tr>
                    <tr>
                        <td class="evenItem">Return to home when inactive:<br></td>
                    </tr>
                    <tr>
                      <td class="evenItem" nowrap>
                        <input type="text" name="setTime" maxlength="3" value="0" size="5" style="text-align:right" /> [0..300] seconds, <br>0 = disabled
                      </td>
                    </tr>
                    <tr>
                      <td class="evenItem" nowrap>
                        <input type="button" class="btnNormal" value="Save" onclick="Javascript:commitRetTime(this.form)" onmouseover="return showStatus(SaveBtnStatTxt)" onmouseout="return showStatus('')" /><br><br>
                      </td>
                    </tr>
                  </form>

              </table>
          </td>
          <td width="80%" valign="top">
            <table border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="300">
                      <img id="crosshair" src="http://10.101.10.100/pics/crosshair.png" width="16" height="16" style="position:absolute;visibility:hidden;left:0;top:0" border="0">
                    <div id="filterinstallocation"></div>
                    <SCRIPT LANGUAGE="JavaScript">
                    <!--
                        var tmp_w = parseInt("352", 10);
                        var tmp_h = parseInt("240", 10);
                        var img_width = (tmp_w > 0 ? tmp_w : 480);
                        var img_height = (tmp_h > 0 ? tmp_h : 360);

                        var target_w = img_width;
                        var target_h = img_height;
                        var max_parhand_resolution = '720x480';
                        var max_w = parseInt(max_parhand_resolution.split("x")[0], 10);
                        var max_h = parseInt(max_parhand_resolution.split("x")[1], 10);

                          var max_zoom_resolutions_str = "720x480,704x480,704x240,352x240,176x120";
                          var max_zoom_resolutions = max_zoom_resolutions_str.split(",");
                        if (target_w > max_w || target_h > max_h) {
                          img_width = max_w;
                          img_height = max_h;
                        } else {
                          img_width = parseInt(max_zoom_resolutions[0].split("x")[0], 10);
                          img_height = parseInt(max_zoom_resolutions[0].split("x")[1], 10);
                          for (var i = 1; i < max_zoom_resolutions.length; i++) {
                            var tmp_w = parseInt(max_zoom_resolutions[i].split("x")[0], 10);
                            var tmp_h = parseInt(max_zoom_resolutions[i].split("x")[1], 10);
                            if ( tmp_w <= max_w ) {
                              img_width = tmp_w;
                              img_height = tmp_h;
                              if ( tmp_w <= target_w )
                                break;
                            }
                          }
                        }

                      var File = "http://10.101.10.100/axis-cgi/mjpg/video.cgi?camera=1&resolution=" + img_width + "x" + img_height; 	 



var stillImagePath;
var fullImagePath = "";
var use_activex = 0;
var use_java = 0;
var use_spush = 0;
var use_flash = 0;
var use_still = 0;
var use_quicktime = 0;
var rotation_in_url = "";
var rotation_in_parhand = "180";
var resolution_in_url = "";
var resolution_in_parhand = "D1";
var streamprofile_in_url = "";
var recording = "";
var zoom_fact = "";
var ShowAMCToolbar = "yes";

function IPAddress(path)
{
  var str = path.slice(7);
  var anArray = str.split('/');

  if (anArray[0].split(":").length > 1)
  {
    anArray[0] = "[" + anArray[0] + "]";
  }
  return anArray[0];
}

function video(imagepath)
{
  var resolution = 0;
  var width = 0;
  var height = 0;
  var isTilted = false;

  if (imagepath.indexOf("rotation=") != -1) {
    if (rotation_in_url == "90" || rotation_in_url == "270") {
      isTilted = true;
    } else if (rotation_in_url == "" && (rotation_in_parhand == "90" || rotation_in_parhand == "270")) {
      isTilted = true;
    }
  } else {
    if (rotation_in_parhand == "90" || rotation_in_parhand == "270") {
      isTilted = true;
    }
  }

  if (imagepath.indexOf("resolution=") != -1)
  {
    var resStart = imagepath.indexOf("resolution=")
    var resStop = imagepath.indexOf("&", resStart)
    if (resStop == -1)
      resStop = imagepath.length
    resolution = imagepath.substring(resStart + 11, resStop);
    if (resolution.indexOf('x') != -1)
    {
      width = parseInt(resolution.substring(0, resolution.indexOf('x')), 10);
      height = parseInt(resolution.slice((resolution.indexOf('x') + 1)), 10);
    }
  }

  if (!(width > 0 && height > 0))
  {
    if (typeof(img_width) == "number" && typeof(img_height) == "number" && img_width > 0 && img_height > 0)
    {
      width = img_width;
      height = img_height;
      resolution = width + 'x' + height;
    }
    else if ((imagepath.indexOf("mpeg4") != -1) || (imagepath.indexOf("h264") != -1))
    {
      width = parseInt("640", 10);
      height = parseInt("480", 10);
      resolution = width + 'x' + height;
    }
    else
    {
      width = parseInt("640", 10);
      height = parseInt("480", 10);
      resolution = width + 'x' + height;
    }
  }

  if ('1' != '1')
  {
    var strSize = '1';
    var sizeNum = 0;
    //floating number try to parse it
    if( strSize.indexOf('.') != -1  )
    {
      sizeNum = parseFloat( strSize );
      //might be the wrong decimal separation
      if( sizeNum == 0 || isNaN( sizeNum ) )
      {
        strSize = strSize.replace( ".", "," );
        sizeNum = parseFloat( strSize );
      }
    }
    else if( strSize.indexOf(',') != -1  )
    {
      sizeNum = parseFloat( strSize );
      //might be the wrong decimal separation
      if( sizeNum == 0 || isNaN( sizeNum ) )
      {
        strSize = strSize.replace( ",", "." );
        sizeNum = parseFloat( strSize );
      }
    }
    else
    {
      sizeNum = parseInt( strSize, 10 );
    }
    width = width * sizeNum;
    height = height * sizeNum;
  }

  var doubleLines = false;
  var imagepath_has_resolution = (imagepath.indexOf("resolution=") >= 0);
  var imagepath_uses_2cif = (imagepath.indexOf("resolution=2CIFEXP") == -1 && imagepath.indexOf("resolution=2CIF") != -1);

  var streamprofile_has_resolution = false;
  var streamprofile_uses_2cif = false;
  if ((imagepath.indexOf("streamprofile=") != -1))
  {
    var videoFormat = document.getElementsByName("videoFormat")[0];
    if (videoFormat)
    {
      var streamprofile_nr = videoFormat.options[videoFormat.selectedIndex].value;
      var streamprofile_param = document.getElementsByName("root_StreamProfile_S" + streamprofile_nr + "_Parameters")[0];
      if (streamprofile_param)
      {
        streamprofile_has_resolution = (streamprofile_param.value.indexOf("resolution=") >= 0);
        streamprofile_uses_2cif = (streamprofile_param.value.indexOf("resolution=2CIFEXP") == -1 && streamprofile_param.value.indexOf("resolution=2CIF") != -1);
      }
    }
  }

  if (recording != "yes" && resolution_in_url == "" && streamprofile_in_url == "" && !imagepath_has_resolution && !streamprofile_has_resolution && resolution_in_parhand.toLowerCase() == "2cif"
      || imagepath_uses_2cif || streamprofile_uses_2cif)
  {
    doubleLines = true;
  }

  if (width > height)
  {
    height *= (doubleLines ? 2 : 1);
    if (isTilted)
    {
      var tmp = width;
      width = height;
      height = tmp;
    }
  }
  else
  {
    width *= (doubleLines ? 2 : 1);
  }
  resolution = width + 'x' + height;

  var width_height = 'width="' + width + '" height="' + height + '"';
  var viewer = "";

  if (viewer == "")
  {
    if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform != "MacPPC") && (navigator.platform != "Mac68k"))
    {
      viewer = "activex";
    }
    else
    {
      viewer = "spush";
    }
  }

  if (viewer.indexOf("activex") != -1)
  {
    use_activex = 1;
  }
  if (viewer.indexOf("spush") != -1)
  {
    use_spush = 1;
  }
  if (viewer.indexOf("flash") != -1)
  {
    use_flash = 1;
  }
  if (viewer.indexOf("quicktime") != -1)
  {
    use_quicktime = 1;
  }
  if ((imagepath.indexOf("videocodec=mpeg4") != -1) || (imagepath.indexOf("videocodec=h264") != -1))
  {
    if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform != "MacPPC") && (navigator.platform != "Mac68k"))
    {
        use_quicktime = 0;
        use_activex = 1;
    }
    else
    {
      use_quicktime = 1;
      use_spush = 0;
      use_still = 0;
    }
  }
  else
  {
    if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform != "MacPPC") && (navigator.platform != "Mac68k"))
    {
        use_quicktime = 0;
        use_activex = 1;
    }
    else
    {
      use_quicktime = 0;
      use_spush = 1;
      use_still = 0;
    }
  }
  if (viewer.indexOf("java") != -1)
  {
    if ((imagepath.indexOf("mpeg4") == -1) && (imagepath.indexOf("h264") == -1))
    {
      use_java = 1;
      use_activex = 0;
      use_spush = 0;
      use_flash = 0;
      use_still = 0;
      use_quicktime = 0;
    }
  }

  var obey_still = true;
  var ExcludeList = new Array("ptz.shtml", "vmd.shtml", "playWindow.shtml", "streampreview.shtml");
  var ppath = window.location.pathname;
  var pcurrent = ppath.substring(ppath.lastIndexOf('/') + 1);

  for (var i=0; i<ExcludeList.length; i++)
  {
    if (ExcludeList[i] == pcurrent)
    {
      obey_still = false;
      break;
    }
  }

  if ((obey_still && (viewer.indexOf("still") != -1) ) || !(use_activex || use_spush || use_flash || use_java || use_quicktime))
  {
    if ((imagepath.indexOf("mpeg4") == -1) && (imagepath.indexOf("h264") == -1))
    {
      use_still = 1;
      use_quicktime = 0;
      use_spush = 0;
      use_activex = 0;
    }
    else
    {
      if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform != "MacPPC") && (navigator.platform != "Mac68k"))
      {
        use_activex = 1;
      }
      else
      {
        use_quicktime = 1;
      }
    }
  }
  var agent = navigator.userAgent.toLowerCase();
  if (agent.indexOf("applewebkit/") != -1)
  {
    var pos = agent.indexOf("applewebkit/") + 12
    var webKitVersion = parseInt(agent.substring(pos, agent.indexOf(" ", pos)), 10)
    if ((use_spush) && (webKitVersion < 416))
    {
      use_java = 1;
      use_spush = 0;
    }
  }
  if (use_activex)
  {
    if (ShowAMCToolbar == "yes")
      height = height + 54;
    var notAuthorizedText = "The installation of the MPEG-4 Decoder has been disabled. Contact the Administrator of this AXIS P5532 Network Camera.";
    var notAuthorizedH264Text = "The installation of the H.264 Decoder has been disabled. Contact the Administrator of this AXIS P5532 Network Camera.";
    var authorizedText = "Click here to install or upgrade the MPEG-4 Decoder.";
    var authorizedH264Text = "Click here to install or upgrade the H.264 Decoder.";
    var installDecoderText1 = "<b>MPEG-4 Decoder</b>, which enables streaming video in Microsoft Internet Explorer, has not been installed or could not be registered on this computer.";
    var installDecoderH264Text1 = "<b>The H.264 Decoder</b>, which enables streaming video in Microsoft Internet Explorer, has not been installed or could not be registered on this computer.";
    var installDecoderText2 = "To install or upgrade the MPEG-4 Decoder, you must have Administration rights on this computer and you must answer Yes <br>when asked if you wish to allow the installation. AXIS P5532 Network Camera can also be configured to show still images.";
    var installDecoderH264Text2 = "To install or upgrade the H.264 Decoder, you must have Administration rights on this computer and you must answer Yes <br>when asked if you wish to allow the installation. AXIS P5532 Network Camera can also be configured to show still images.";
    var notAuthorizedAacText = "The installation of the AAC Decoder has been disabled. Contact the Administrator of this AXIS P5532 Network Camera.";
    var authorizedAacText = "Click here to install or upgrade the AAC Decoder.";
    var installAacDecoderText1 = "<b>AAC Decoder</b>, which enables streaming AAC audio in Microsoft Internet Explorer, has not been installed or could not be registered on this computer.";
    var installAacDecoderText2 = "To install or upgrade the AAC Decoder, you must have Administration rights on this computer and you must answer Yes <br>when asked if you wish to allow the installation.";

    var installText1 = "which enables streaming";
    var videoText = "video";
    var audioText = "audio";
    var installText2 = "in Microsoft Internet Explorer, has not been installed<br>or could not be registered on this computer.";
    var installText3 = "To install or upgrade the";
    var installText4 = ", you must have Administration rights on this computer and you must answer Yes <br>when asked if you wish to allow the installation.<br>Click on the yellow banner to begin the installation. If the banner is not visible, turn off pop-up blockers<br>from the Tools menu in Microsoft Internet Explorer.<br>AXIS P5532 Network Camera can also be configured to show still images.";
    document.write("<center>");
    DrawAMC("AXIS P5532", "AXIS Media Control", height, width, imagepath, "DE625294-70E6-45ED-B895-CFFA13AEB044", "AMC.cab", "6&#44;2&#44;10&#44;2", ShowAMCToolbar, "yes", "yes", "1", "yes", "yes", "", "", "no", "554", "no", installText1, videoText, installText2, installText3, installText4, "", (recording == "yes" ? "recording" : zoom_fact), "yes", "yes");

      if (imagepath.indexOf("h264") != -1)
      {
        InstallDecoder("AXIS P5532", "H.264 Decoder", "7340F0E4-AEDA-47C6-8971-9DB314030BD7", "NotFound.cab", "3&#44;0&#44;2&#44;0", "", notAuthorizedH264Text, authorizedH264Text, installDecoderH264Text1, installDecoderH264Text2);
      }
        InstallFilter("AXIS P5532", "File Writer", "24E31783-87EF-4765-A430-4C8A983ACE16", "2&#44;0&#44;24&#44;0", "AMC.cab", installText1, videoText, installText2, installText3, installText4);
      if ( String( getHost(imagepath) ).indexOf("rtsp") != -1 )
      {
          InstallFilter("AXIS P5532", "Overlay Mixer Filter", "03825DEB-4BC8-4344-ACF7-EC390A8A5A21", "2&#44;0&#44;4&#44;0", "AMC.cab", installText1, videoText, installText2, installText3, installText4);
        InstallFilter("AXIS P5532", "MPEG RTP Reader", "67B1A88A-B5D2-48B1-BF93-EB74D6FCB077", "3&#44;2&#44;5&#44;0", "AMC.cab", installText1, videoText, installText2, installText3, installText4);
        InstallFilter("AXIS P5532", "Image Notify Component", "0173EEF5-1FDE-479C-9F24-34C3CB0B3243", "1&#44;2&#44;3&#44;0", "AMC.cab", installText1, videoText, installText2, installText3, installText4);
      }

    document.write("</center>");
    document.write("<br>");
  }

  if (use_spush)
  {
   if (recording != "yes" && ShowAMCToolbar == "yes")
   {
    document.write('<table cellspacing=0 cellpadding=0 border=0 style="min-width:260"><tr><td colspan="3" align="center">');
   }
    var output = '';
    output += '<img id="stream" SRC="' + imagepath + '" '+ width_height ;
    var view_PressReloadTxt = "Press Reload if no image is displayed"
    output += ' ALT="' + view_PressReloadTxt + '" BORDER="0">';
    output += '<br>';
    document.write(output);
    if (recording != "yes" && ShowAMCToolbar == "yes")
    {
      if (document.getElementById("stream"))
        fullImagePath = document.getElementById("stream").src
      else
        fullImagePath = "";
      stillImagePath = "http://10.101.10.100/jpg/1/image.jpg"
      if (imagepath.indexOf("http://10.101.10.100/axis-cgi/mjpg/video.cgi") != -1)
      {
        var searchStr = "http://10.101.10.100/axis-cgi/mjpg/video.cgi"
        var replaceStr = "http://10.101.10.100/jpg/1/image.jpg"
        var re = new RegExp(searchStr , "g")
        stillImagePath = imagepath.replace(re, replaceStr)
      }

      document.write('</td></tr>');


        document.write('<tr><td colspan="3" align="center" style="white-space:nowrap">' );

              document.write('<div class="cornerVideoPTZ"><div class="cornerTabs"><ul><li id="videoselection" class="selectedTab"><a href="javascript:selectVideoOrPtz(\'video\')">');
              document.write("<b>Video</b></a></li>");
              document.write('<li id="ptzselection" class="unselectedTab"><a href="javascript:selectVideoOrPtz(\'ptz\')">');
              document.write("<b>PTZ</b></a></li></ul></div>");
            document.write('<div id="zoombox" class="dragbox"></div>');

        document.write('<div class="cornerVideoBox"><div class="content">');
        document.write('<table cellspacing=0 border=0 width="100%" id="videoItems" class="shownItems">');
        document.write('<tr height="32">');
        document.write("<td align=\"left\" width=\"40\"><a id=\"stopBtn\" href=\"javascript:void(0)\" onclick=\"stopStartStream('" + stillImagePath + "')\"><img src=\"/pics/stop_blue_button_27x27px.gif\" width=\"27\" height=\"27\" alt=\"Stop stream\" title=\"Stop stream\" border=\"0\" onmouseover=\"javascript:btnShiftCls( this, true )\" onmouseout=\"javascript:btnShiftCls( this, false )\" /></a>");
        document.write("<a id=\"playBtn\" style=\"display:none;\" href=\"javascript:void(0)\" onclick=\"stopStartStream('" + fullImagePath + "')\"><img src=\"/pics/play_blue_button_27x27px.gif\" width=\"27\" height=\"27\" alt=\"Start stream\" title=\"Start stream\" border=\"0\" onmouseover=\"javascript:btnShiftCls( this, true )\" onmouseout=\"javascript:btnShiftCls( this, false )\" /></a></td></tr></table>");
            document.write('<table cellspacing=0 border=0 width="100%" id="ptzItems" class="collapsed" >');
            document.write('<tr height="32">');
            document.write('<td style="padding-left:15px;"><select name="ptzMode" id="ptzModeSelector" onChange="setPtzMode()">');
            document.write("<option selected> Center </option>");
            document.write("<option> Joystick </option>");
            document.write('</select></td><td>&nbsp;</td>');
            document.write("<td><input type=\"checkbox\" id=\"crossHairCheckbox\" onClick=\"showHideCrosshair()\" checked> Crosshair</td></tr></table>");

        document.write('</div><div class="footerLeft"><div class="footerRight"></div></div></div>');

            document.write('</div>');


        document.write('</td></tr></table>');
    }
  }

  if (use_quicktime)
  {
    var DisplayWidth = width;
    var DisplayHeight = height + (ShowAMCToolbar == "yes" ? 16 : 0 );
    var rtspPort = "554";
    if (imagepath.indexOf("://") == -1)
    {
      if (location.hostname.split(":").length > 1)
      {
        //IPv6
        var MediaURL = "rtsp://[" + location.hostname + "]:" + rtspPort + imagepath 
      }
      else
      {
        //IPv4
        var MediaURL = "rtsp://" + location.hostname + ":" + rtspPort + imagepath 
      }
    }
    else
    {
      var MediaURL = imagepath
    }

    var output = "";
    output  = '<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width=' + DisplayWidth + ' height=' + DisplayHeight + ' CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">';
    output += '<param name="src" value="http://10.101.10.100/view/AxisMoviePoster.mov">';
    output += '<param name="autoplay" value="true">';
    output += '<param name="controller" value="' + (ShowAMCToolbar == "yes" ? true : false) + '">';
    output += '<param name="qtsrc" value="' + MediaURL + '">';
    output += '<embed src="/view/AxisMoviePoster.mov" width=' + DisplayWidth + ' height=' + DisplayHeight + ' qtsrc="' + MediaURL + '" autoplay="true" controller="' + (ShowAMCToolbar == "yes" ? true : false) + '" target="myself" PLUGINSPAGE="http://www.apple.com/quicktime/download/"></embed>';
    output += '</OBJECT>';
    document.write(output);
  }

  if (use_flash)
  {
    var view_NeedFlashPluginTxt = "You need a Shockwave Flash plugin, get it from:"
    document.write('<EMBED src="/axis-cgi/mjpg/video.swf?resolution=' + resolution +'&camera=1" ' +
    'quality=high bgcolor=#000000 ' + width_height +
    ' TYPE="application/x-shockwave-flash" swLiveConnect=TRUE' +
    ' PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">' +
    '</EMBED>' +
    '<NOEMBED>' + view_NeedFlashPluginTxt +
    '<a href="http://www.macromedia.com/shockwave/download/">Macromedia</a>.' +
    '</NOEMBED><br>');
  }

  if (use_java)
  {
    var playerWidth = width;
    var playerHeight = height;
    if (ShowAMCToolbar == "yes")
    {
      if (playerWidth < 300)
        playerWidth = 300;
      playerHeight += 105;
    }

    var addr = "";
    if (imagepath.indexOf("http") != -1)
    {
      var addrEnd = imagepath.indexOf("/", 8);
      addr = imagepath;
    }
    //init AMA applet
    document.write('<OBJECT name="AMA" codeBase="/java/ama" archive="ama.jar" code="ama.MediaApplet" codetype="application/x-java-applet;version=1.4" type="application/x-java-applet;version=1.4" width="' + playerWidth + '" height="' + playerHeight + '">');
    document.write('<PARAM NAME="name" VALUE="AMA">');
    document.write('<PARAM NAME="codebase" VALUE="/java/ama">');
    document.write('<PARAM NAME="archive" VALUE="ama.jar">');
    document.write('<PARAM NAME="code" VALUE="ama.MediaApplet">');
    document.write('<PARAM NAME="codetype" VALUE="application/x-java-applet;version=1.4">');
    document.write('<PARAM NAME="type" VALUE="application/x-java-applet;version=1.4">');
    document.write('<PARAM NAME="mayscript" VALUE="false">');
    document.write('<PARAM NAME="ama_cgi-path" VALUE="axis-cgi">');
    document.write('<PARAM NAME="cache_archive" VALUE="ama.jar, ptz.jar">');
    document.write('<PARAM NAME="cache_version" VALUE="1.1.9.0, 1.3.5.0">');
    document.write('<PARAM NAME="ama_plugins" VALUE="ptz.PTZ,">');
  var img_opts = "";
  if (imagepath.indexOf("?") > 0)
  {
    img_opts = imagepath.substring(imagepath.indexOf("?"));
    imagepath = imagepath.substring(0, imagepath.indexOf("?"));
  }
  if (img_opts.indexOf("camera=") == -1)
    img_opts += (img_opts.length > 0 ? "&" : "?") + "camera=1";



  if (rotation_in_parhand != "" && img_opts.indexOf("rotation=") == -1)
    img_opts += (img_opts.length > 0 ? "&" : "?") + "rotation=" + rotation_in_parhand;

  document.write('<PARAM NAME="ama_url" VALUE="' + imagepath + img_opts + '">');
    if ("yes" == "no")
      document.write('<PARAM NAME="ama_ptz-mode" VALUE="absolute">');
    else
      document.write('<PARAM NAME="ama_ptz-mode" VALUE="relative">');
    document.write('<PARAM NAME="ama_ptz-cross" VALUE="yes">');
    document.write("Your browser does not support Java")
    document.write('</OBJECT><br>');
  }

  if (use_still)
  {
    var picturepath;
    var tmpAddress = imagepath.match(/\/\/(.+?)\//g);

    if (tmpAddress == null)
      tmpAddress = imagepath.match(/(.+?)\//g);

    if (imagepath.charAt(0) == '/' || tmpAddress == null)
      picturepath = "http://10.101.10.100/jpg/1/image.jpg";
    else
      picturepath = document.location.protocol + "//" + tmpAddress + "/jpg/1/image.jpg";

    document.write('<img SRC="' + picturepath + '" border=0 ' + width_height +'><br>');
  }
}

function stopStartStream(path)
{
  try {
    var orgPath = path;
    theDate = new Date();
    if (path.indexOf("?") != -1)
      path += "&"
    else
      path += "?"
    path += "timestamp=" + theDate.getTime()
    if (use_spush)
    {
      if (recording != "yes")
        stopStartBtnShift( orgPath );
      document.getElementById("stream").src = path;
    }
    else if (use_activex)
    {
      document.Player.MediaURL = path;
    }
  }
  catch(e) {}
}


function stopStartBtnShift( orgPath )
{
  if( orgPath == stillImagePath )
  {
    document.getElementById("stopBtn").style.display = 'none';
    document.getElementById("playBtn").style.display = 'inline';
  }
  else
  {
    document.getElementById("stopBtn").style.display = 'inline';
    document.getElementById("playBtn").style.display = 'none';
  }
}

function btnShiftCls( btnEl, over )
{
  if( btnEl ){
    btnEl.className = ((over)?'hover':'');
  }
}

                      video(File);
                    //-->
                    </script>
                </td>
                <td><!-- tiltbar.shtml -->
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
  <table align="center" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td valign="bottom" class="normalText">Up</td>
    </tr>
    <tr>
      <td>
        <script language="JavaScript">
        <!--
          if (typeof(ptzDefContSpeedTilt) != "number" || isNaN(ptzDefContSpeedTilt))
            var ptzDefContSpeedTilt = 70;
        -->
        </script>
        <img src="http://10.101.10.100/pics/up_14x13px.gif" width="14" height="13" onmousedown="continousMove('tilt', '0,'+ptzDefContSpeedTilt);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('tilt', '0,0');this.onmouseout=noAction; return false;">
        <span id="tilt-up"></span>
      </td>
    </tr>
    <tr>
      <td>
        <table id="tiltbar1" border="0" cellpadding="0" cellspacing="0">
          <tr><td><img src="http://10.101.10.100/pics/tiltbar_abs_14x200px.gif" border="0" width="14" height="200" id="tilt-bg" onmousemove="handleBarMove(this.parentNode.parentNode.parentNode.parentNode, event);" onclick="getPtzPositions();" /></td></tr>
         </table>
        <input type="hidden" name="tiltvalue" id="tilt" value="">
      </td>
      <td class="normalText"> <b>TILT</b></td>
    </tr>
    <tr>
      <td>
        <span id="tilt-down"></span>
        <img src="http://10.101.10.100/pics/down_14x13px.gif" width="14" height="13" onmousedown="continousMove('tilt', '0,-'+ptzDefContSpeedTilt);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('tilt', '0,0');this.onmouseout=noAction; return false;">
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" class="normalText">Down</td>
    </tr>
  </table>
<!-- end of tiltbar.shtml -->
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td><br /></td>
          <td align="left" valign="top" colspan="2" nowrap>
            <table name="ptzcontrol_table" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><!-- bars.shtml -->
  <div id="toolTip" style="visibility: hidden"></div>
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

        if (typeof(ptzDefContSpeedFocus) != "number" || isNaN(ptzDefContSpeedFocus))
          var ptzDefContSpeedFocus = 70;
  -->
  </script>

<table name="bars_table" align="center" border="0" cellspacing="1" cellpadding="0"><!-- panbar.shtml -->
<tr>
<script language="JavaScript">
<!--
var StLeBtnStatTxt = "Step left";
var StRiBtnStatTxt = "Step right";var ptzDefMaxOpticalZoomMag=29;
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

//-->
</script>
  <td class="normalText"><b>PAN</b></td>
  <td class="normalText">&nbsp;Left&nbsp;</td>
  <td align="right">
      <script language="JavaScript">
      <!--
        if (typeof(ptzDefContSpeedPan) != "number" || isNaN(ptzDefContSpeedPan))
          var ptzDefContSpeedPan = 70;
      -->
      </script>
    <table cellpadding="0" cellspacing="0" border="0" height="17" width="60%">
      <tr>
        <td valign="middle">
          <span id="pan-left"></span><img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('pan', -ptzDefContSpeedPan+',0');this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('pan', '0,0');this.onmouseout=noAction; return false;"><span id="panbar1"><img src="http://10.101.10.100/pics/panbar_abs_268x14px.gif" width="268" height="14" id="pan-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();"></span><img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('pan', ptzDefContSpeedPan+',0');this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('pan', '0,0');this.onmouseout=noAction; return false;"><span id="pan-right"></span>
          <input type="hidden" name="panvalue" id="pan" value="">
        </td>
      </tr>
    </table>
  </td>
  <td class="normalText"> &nbsp;Right</td>
</tr>
<!-- end of panbar.shtml --><!-- zoombar.shtml -->
  <tr>
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
      <table cellpadding="0" cellspacing="0" border="0" height="17" width="60%">
        <tr>
          <td valign="middle">
            <span id="zoom-left"></span><img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('zoom', -ptzDefContSpeedZoom);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('zoom', 0);this.onmouseout=noAction; return false;"><span id="zoombar1"><img src="http://10.101.10.100/pics/zoombar_268x14px.gif" width="268" height="14" id="zoom-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();"></span><img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('zoom', ptzDefContSpeedZoom);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('zoom', 0);this.onmouseout=noAction; return false;"><span id="zoom-right"></span>
            <input type="hidden" name="zoomvalue" id="zoom" value="">
          </td>
         </tr>
       </table>
     </td>
     <td class="normalText">&nbsp;Tele</td>
   </tr>
<!-- end of zoombar.shtml -->
  <tr>
    <td class="normalText"><b>FOCUS</b></td>
    <td class="normalText">&nbsp;Near&nbsp;</td>
    <td align="center">
      <table cellpadding="0" cellspacing="0" border="0" height="17" width="60%">
        <tr>
          <td valign="middle">
            <span id="focus-left"></span><img src="http://10.101.10.100/pics/left_15x14px.gif" width="15" height="14" onmousedown="continousMove('focus', -ptzDefContSpeedFocus);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('focus', 0);this.onmouseout=noAction; return false;"><span id="focusbar1"><img src="http://10.101.10.100/pics/panbar_rel_nonlin_268x14px.gif" width="268" height="14" id="focus-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();"></span><img src="http://10.101.10.100/pics/right_15x14px.gif" width="15" height="14" onmousedown="continousMove('focus', ptzDefContSpeedFocus);this.onmouseout=this.onmouseup; return false;" onmouseup="continousMove('focus', 0);this.onmouseout=noAction; return false;">
            <span id="focus-right"></span>
            <input type="hidden" name="focusvalue" id="focus" value="">
          </td>
         </tr>
       </table>
     </td>
    <td class="normalText">&nbsp;Far</td>
      <td class="normalText"><span id="idAutoFocus" style="font-style: italic; font-size: 8px; color: gray; visibility: hidden;">&nbsp;Auto</span></td>
  </tr>
  <tr>
    <td class="normalText"><b>IRIS</b></td>
    <td class="normalText">&nbsp;Close&nbsp;</td>
    <td align="center">
      <table cellpadding="0" cellspacing="0" border="0" height="17" width="60%">
        <tr>
          <td valign="middle">
            <span id="iris-left"></span><span id="irisbar1"><img src="http://10.101.10.100/pics/zoombar_268x14px.gif" width="268" height="14" id="iris-bg" onmousemove="handleBarMove(this.parentNode, event);" onclick="getPtzPositions();"></span>
            <span id="iris-right"></span>
            <input type="hidden" name="irisvalue" id="iris" value="">
          </td>
        </tr>
      </table>
    </td>
    <td class="normalText">&nbsp;Open</td>
      <td class="normalText"><span id="idAutoIris" style="font-style: italic; font-size: 8px; color: gray; visibility: hidden;">&nbsp;Auto</span></td>
  </tr>
</table>

<!-- end of bars.shtml -->
                </td>
                <td width="5">
                  <img src="/pics/blank.gif" width="5" height="100%">
                </td>
                <td><style type="text/css">
table.ptzctrlbtn { cursor:pointer; table-layout:fixed }
td.ptzctrlbtn_label { height:22px; vertical-align:middle; text-align:center; overflow:hidden; }
</style>
<script language="JavaScript" type="text/javascript"><!--
function ptzctrlpanel(obj, url)
{
  if (url.indexOf("auxiliary:") == 0) {
    url = url.replace(/auxiliary:/,'/axis-cgi/com/ptz.cgi?camera&#61;1&#38;auxiliary&#61;');
    auto(url);  // see view.shtml
  } else if (url.indexOf("link:") == 0) {
    url = url.replace(/link:/,'');
    window.open(url);
  }
  auto(url);  // see view.shtml
}

// -->
</script>

<!-- If "$pcb_showall = yes" then all 16 buttons are displayed, else only Home and Ctrl panel are displayed --> 
<!-- The 2 left cols contain static functions, the 2 right cols are reserved for driver specific use. -->
<!-- Driver specific functions should be defined by driver parameters. (not yet supported by PTZ driver framework). -->

<!-- Set default param values for buttons -->

<style type="text/css">
table.ptzctrlbtn                { cursor:pointer; table-layout:fixed }
td.ptzctrlbtn_label             { height:22px; vertical-align:middle; text-align:center; overflow:hidden; }
td.ptzctrlbtn_label_dimmed      { color:#666666; height:22px; vertical-align:middle; text-align:center; overflow:hidden; }
td.ptzctrlbtn_bg                { height:16px; vertical-align:middle; text-align:center; overflow:hidden; background-image:url('/pics/ptzctrlbtn_100x14px.gif'); padding-top: 1; padding-bottom: 1; background-position: center; background-repeat: no-repeat; }
td.ptzctrlbtn_bg_short          { height:16px; vertical-align:middle; text-align:center; overflow:hidden; background-image:url('/pics/ptzctrlbtn_70x14px.gif'); padding-top: 1; padding-bottom: 1; background-position: center; background-repeat: no-repeat; }
td.ptzctrlbtn_bg_shorter        { height:16px; vertical-align:middle; text-align:center; overflow:hidden; background-image:url('/pics/ptzctrlbtn_46x14px.gif'); padding-top: 1; padding-bottom: 1; background-position: center; background-repeat: no-repeat; }
td.ptzctrlbtn_bg_dimmed         { color:#666666; height:16px; vertical-align:middle; text-align:center; overflow:hidden; background-image:url('/pics/ptzctrlbtn_dis_100x14px.gif'); padding-top: 1; padding-bottom: 1; background-position: center; background-repeat: no-repeat; }
td.ptzctrlbtn_bg_short_dimmed   { color:#666666; height:16px; vertical-align:middle; text-align:center; overflow:hidden; background-image:url('/pics/ptzctrlbtn_dis_70x14px.gif'); padding-top: 1; padding-bottom: 1; background-position: center; background-repeat: no-repeat; }
td.ptzctrlbtn_bg_shorter_dimmed { color:#666666; height:16px; vertical-align:middle; text-align:center; overflow:hidden; background-image:url('/pics/ptzctrlbtn_dis_46x14px.gif'); padding-top: 1; padding-bottom: 1; background-position: center; background-repeat: no-repeat; }
td.disabledText                 { color:#aaaaaa; }
table.noclick                   { cursor:default;}
td.panelclick                   { cursor:pointer; }
td.panelmove                    { cursor:move; }
td.panelframe                   { background-color:#cccccc; }
td.paneltitle                   { background-color:#cccccc; }
</style>

<script language="JavaScript">
<!--
var dragging = false;
var posX = 0;
var posY = 0;
var diffX = 0;
var diffY = 0;
  var panelopen = "no";

var imgNavSup = true;

//--------------------------------------
// Help functions
//--------------------------------------

function changeCursor(id,style)
{
  var elem = document.getElementById(id);
  elem.style.cursor = style;
}

function getMousePos(e)
{
  if (!e)
    var e = window.event;
  if (e.pageX || e.pageY) {
    posX = e.pageX;
    posY = e.pageY;
  }
  else if (e.clientX || e.clientY) {
    posX = e.clientX + document.body.scrollLeft;
    posY = e.clientY + document.body.scrollTop;
  }
}

function getPanelLeft()
{
  pos = 0;
  if (document.getElementById) {
    pos = document.getElementById('ptzPanelLayer').style.left;
  } else if (document.layers) {
    pos = document.layers['ptzPanelLayer'].left;
  }
  n = pos.indexOf("px");
  if (n != -1)
    pos = pos.substring(0,n);
  return pos;
}

function getPanelTop()
{
  pos = 0;
  if (document.getElementById) {
    pos = document.getElementById('ptzPanelLayer').style.top;
  } else if (document.layers) {
    pos = document.layers['ptzPanelLayer'].top;
  }
  n = pos.indexOf("px");
  if (n != -1)
    pos = pos.substring(0,n);
  return pos;
}

function getPanelDiff()
{
  diffX = posX - getPanelLeft();
  diffY = posY - getPanelTop();
}

//--------------------------------------
// Function to handle the PTZ panel
//--------------------------------------

function showPTZpanel(show)
{

  if ((navigator.appName == "Microsoft Internet Explorer") && (navigator.platform != "MacPPC") && (navigator.platform != "Mac68k")) {
    viewer = "activex";
  } else {
    viewer = "spush";
  }

  if (show) {
    panel_val = "visible";
    panelopen = "yes";
  } else {
    panel_val = "hidden";
    panelopen = "no";
  }

  document.getElementById('ptzPanelLayer').style.visibility = panel_val;

  if (show && (navigator.appName != "Microsoft Internet Explorer") && (viewer == "spush"))
  {
    document.getElementById('imgNavButtons').style.display="";
  }
  else if( show && (navigator.appName == "Microsoft Internet Explorer") && (viewer == "activex"))
  {
    document.getElementById('imgNavButtons').style.display="none";
  }
  else
  {
    document.getElementById('imgNavButtons').style.display="none";
  }

    if (show && (navigator.appName != "Microsoft Internet Explorer"))
    {
      document.getElementById('crosshairButtons').style.display="";
    }
    else
    {
      document.getElementById('crosshairButtons').style.display="none";
    }

}

function togglePTZpanel()
{
  var show = document.getElementById('ptzPanelLayer').style.visibility;
  if (show == "visible") {
    showPTZpanel(false);
    panelopen = "no";
  } else {
    showPTZpanel(true);
    panelopen = "yes";
  }
}

function clickPTZpanel(clicked)
{
  if (dragging) {
    dragging = false;
  } else {
    dragging = true;
    getPanelDiff();
  }

  var name = clicked.className;
  var click = "panelclick";
  var move = "panelmove";
  if (name.indexOf(move) != -1) {
    var re = new RegExp(move, "g");
    name = name.replace(re, click);
  } else {
    var re = new RegExp(click, "g");
    name = name.replace(re, move);
  }
  clicked.className = name;
}

function dragPTZpanel(e)
{
  if (dragging) {
    panX = posX - diffX; 
    panY = posY - diffY;  
    if (document.getElementById) {
      document.getElementById('ptzPanelLayer').style.left = panX;
      document.getElementById('ptzPanelLayer').style.top = panY;
    } else if (document.layers) {
      document.layers['ptzPanelLayer'].left = panX;
      document.layers['ptzPanelLayer'].top = panY;
    }
  }
}

function atMouseMove(e)
{
  if (!e)
    var e = window.event;
  getMousePos(e);
  dragPTZpanel(e);
}

if (document.layers)
  document.captureEvents(Event.MOUSEMOVE);
document.onmousemove = atMouseMove;

//--------------------------------------
// Change between joystick and center,
// e.g. relative or absolute
//--------------------------------------
function imgNavigation(absolute)
{
  if (!imgNavSup)
    return;

  var form = document.panelForm;
  var relative = "yes";
  if (absolute)
    relative = "no";

  // Reload the page with the requested options
  var url = document.URL;
  if (url.indexOf("?") == -1)
    url += "?relative=" + relative;
  else if (url.indexOf("relative=") == -1)
    url += "&relative=" + relative;
  else {
    var searchStr = "relative=";
    var replaceStr = "relative=" + relative;
    var re = new RegExp(searchStr , "g");
    url = url.replace(re, replaceStr);
  }

  if (document.getElementById("crossHairCheckbox")) {
    var crosshairChecked = "no";
    if (document.getElementById("crossHairCheckbox").checked)
      crosshairChecked = "yes";
    if (url.indexOf("crosshair=") == -1) {
      url += "&crosshair=" + crosshairChecked;
    } else {
      var searchStr = "crosshair=";
      var replaceStr = "crosshair=" + crosshairChecked;
      var re = new RegExp(searchStr , "g");
      url = url.replace(re, replaceStr);
    }
  }


  if (url.indexOf("&&") != -1) {
    var searchStr = "&&";
    var replaceStr = "&";
    var re = new RegExp(searchStr , "g");
    url = url.replace(re, replaceStr);
  }
  panelPosition(url);
}


function showCrosshair(crosshair)
{
  if (!imgNavSup)
    return;

  var form = document.panelForm;

  // Reload the page with the requested options
  var url = document.URL;
  if (url.indexOf("?") == -1)
    url += "?crosshair=" + crosshair;
  else if (url.indexOf("crosshair=") == -1)
    url += "&crosshair=" + crosshair;
  else {
    var searchStr = "crosshair=";
    var replaceStr = "crosshair=" + crosshair;
    var re = new RegExp(searchStr , "g");
    url = url.replace(re, replaceStr);
  }

  panelPosition(url);
}

function panelPosition(url)  // Keep the panel position at the reload of the page
{
  var form = document.panelForm;

  if (url.indexOf("?") == -1)
    url += "?panelopen=" + panelopen;
  else if (url.indexOf("panelpos=") == -1)
    url += "&panelopen=" + panelopen;
  else {
    var searchStr = "panelopen=";
    var replaceStr = "panelopen=" + panelopen;
    var re = new RegExp(searchStr , "g");
    url = url.replace(re, replaceStr);
  }

  panelpos =  "left:" + getPanelLeft() + ";top:" + getPanelTop() + ";";
  if (url.indexOf("?") == -1)
    url += "?panelpos=" + panelpos;
  else if (url.indexOf("panelpos=") == -1)
    url += "&panelpos=" + panelpos;
  else {
    var searchStr = "panelpos=left:10&#59; top:10&#59;";
    var replaceStr = "panelpos=" + panelpos;
    var re = new RegExp(searchStr , "g");
    url = url.replace(re, replaceStr);
  }

  document.location = url;
}

//-->
</script>

<div id="ptzPanelLayer" style="position:absolute; width:100; height:180; visibility:hidden; left&#58;10&#59; top&#58;10&#59; z-index:10">
<p>

<table bgcolor="white" cellspacing=0 cellpadding=0 border=0>
  <!-- Title bar -->
  <tr>
    <td colspan=2 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this);" class="panelclick" background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif"><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this);" class="funcText panelclick" background="/pics/gray_t_5x50px.gif" valign=top align=center nowrap>Control panel</td>
    <td colspan=2 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this);" class="panelclick" background="http://10.101.10.100/pics/gray_corner_rt_5x50px.gif"><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
  </tr>
  <!-- Panel -->
  <tr>
    <td colspan=5 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this);" class="panelclick panelframe"><img src="http://10.101.10.100/pics/blank.gif" height="1" border=0 alt=""></td>
  </tr>
  <tr>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="http://10.101.10.100/pics/blank.gif" width="1" border=0 alt=""></td>
    <td colspan=3 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick"><img src="http://10.101.10.100/pics/blank.gif" height="6" border=0 alt=""></td>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="http://10.101.10.100/pics/blank.gif" width="1" border=0 alt=""></td>
  </tr>
  <tr>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="http://10.101.10.100/pics/blank.gif" width="1" border=0 alt=""></td>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick"><img src="http://10.101.10.100/pics/blank.gif" width="4" border=0 alt=""></td>
    <td colspan=1 valign="middle" align="left">

<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0>
  <tr valign="top">
    <td colspan="2" rowspan="1">
      <table bgcolor="white" cellSpacing=0 cellPadding=0 width="114" border=0>
        <tr>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
          <td class=funcText vAlign=top align=center width="100%" background="http://10.101.10.100/pics/gray_t_5x50px.gif" nowrap>Auto focus</td>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_rt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
        </tr>
        <tr>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td vAlign=center align=middle width="100%">
            <table cellSpacing=2 cellPadding=0 border=0>
              <tr>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Adjust focus automatically' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;autofocus&#61;on&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >On
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Adjust focus manually' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;autofocus&#61;off&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Off
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
              </tr>
            </table>
          </td>
          <td width=4><img height=5 alt="" src="/pics/blank.gif" width=4></td>
          <td class="lineBg" width=1><img height=5 alt="" src="/pics/blank.gif" width=1></td>
        </tr>
        <tr>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5 border=0></td>
          <td width="100%" background="http://10.101.10.100/pics/line_b_100x5px.gif" height=5><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif"  width=1></td>
          <td width=5 colSpan=2 height=5><img height=5 alt=""  src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5  border=0></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0>
  <tr valign="top">
    <td colspan="2" rowspan="1">
      <table bgcolor="white" cellSpacing=0 cellPadding=0 width="114" border=0>
        <tr>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
          <td class=funcText vAlign=top align=center width="100%" background="http://10.101.10.100/pics/gray_t_5x50px.gif" nowrap>Auto iris</td>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_rt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
        </tr>
        <tr>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td vAlign=center align=middle width="100%">
            <table cellSpacing=2 cellPadding=0 border=0>
              <tr>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Adjust iris automatically' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;autoiris&#61;on&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >On
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Adjust iris manually' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;autoiris&#61;off&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Off
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
              </tr>
            </table>
          </td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
        </tr>
        <tr>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5  border=0></td>
          <td width="100%" background="http://10.101.10.100/pics/line_b_100x5px.gif" height=5><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif"  width=1></td>
          <td width=5 colSpan=2 height=5><img height=5 alt=""  src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5  border=0></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0>
  <tr valign="top">
    <td colspan="2" rowspan="1">
      <table bgcolor="white" cellSpacing=0 cellPadding=0 width="114" border=0>
        <tr>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif"  colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
          <td class=funcText vAlign=top align=center width="100%" background="http://10.101.10.100/pics/gray_t_5x50px.gif" nowrap>Backlight comp</td>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_rt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
        </tr>
        <tr>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td vAlign=center align=middle width="100%">
            <table cellSpacing=2 cellPadding=0 border=0>
              <tr>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Back Light Compensation on (bright)' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;backlight&#61;on&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >On
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Back Light Compensation off (normal)' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;backlight&#61;off&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Off
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
              </tr>
            </table>
          </td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
        </tr>
        <tr>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5 border=0></td>
          <td width="100%" background="http://10.101.10.100/pics/line_b_100x5px.gif" height=5><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5 border=0></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div id="imgNavButtons" style="display:none;">
<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0>
  <tr valign="top">
    <td colspan="2" rowspan="1">
      <table bgcolor="white" cellSpacing=0 cellPadding=0 width="114" border=0>
        <tr>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
          <td class=funcText vAlign=top align=center width="100%" background="http://10.101.10.100/pics/gray_t_5x50px.gif" nowrap>Navigation mode</td>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_rt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
        </tr>
        <tr>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td vAlign=center align=middle width="100%">
            <table cellspacing=2 cellpadding=0 border=0>
              <tr>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Center camera (absolute)' onclick="Javascript:imgNavigation(true)&#59;">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Center
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Joystick control (relative)' onclick="Javascript:imgNavigation(false)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Joystick
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
              </tr>
            </table>
          </td>
          <td width=4><img height=5 alt=""  src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
        </tr>
        <tr>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5 border=0></td>
          <td width="100%" background="http://10.101.10.100/pics/line_b_100x5px.gif" height=5><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5 border=0></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>


<div id="crosshairButtons" style="display:none;">
<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0>
  <tr valign="top">
    <td colspan="2" rowspan="1">
      <table bgcolor="white" cellSpacing=0 cellPadding=0 width="114" border=0>
        <tr>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
          <td class=funcText vAlign=top align=center width="100%" background="http://10.101.10.100/pics/gray_t_5x50px.gif" nowrap>Crosshair</td>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_rt_5x50px.gif" colSpan=2><img height=5 alt="" src="/pics/blank.gif" width=5 border=0></td>
        </tr>
        <tr>
          <td class="lineBg" width=1><img height=5 alt="" src="/pics/blank.gif" width=1></td>
          <td width=4><img height=5 alt="" src="/pics/blank.gif" width=4></td>
          <td vAlign=center align=middle width="100%">
            <table cellSpacing=2 cellPadding=0 border=0>
              <tr>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Show crosshair' onclick="Javascript:showCrosshair(&#39;yes&#39;)&#59;">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Show
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                <td>
<table class="ptzctrlbtn" width="70" height="14px" cellpadding=0 cellspacing=0 border=0 title='Hide crosshair' onclick="Javascript:showCrosshair(&#39;no&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_short" bgcolor="#ffffff" nowrap >Hide
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
              </tr>
            </table>
          </td>
          <td width=4><img height=5 alt=""  src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
        </tr>
        <tr>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5 border=0></td>
          <td width="100%" background="/pics/line_b_100x5px.gif" height=5><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5 border=0></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>

<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0>
  <tr valign="top">
    <td colspan="2" rowspan="1">
      <table bgcolor="white" cellSpacing=0 cellPadding=0 width="114" border=0>
        <tr>
          <td width=5 background="http://10.101.10.100/pics/gray_corner_lt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
          <td class=funcText vAlign=top align=center width="100%" background="http://10.101.10.100/pics/gray_t_5x50px.gif" nowrap>IR cut filter</td>
          <td width=5 background="/pics/gray_corner_rt_5x50px.gif" colSpan=2><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=5 border=0></td>
        </tr>
        <tr>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td vAlign=center align=middle width="100%">
            <table cellSpacing=2 cellPadding=0 border=0>
              <tr>
                <td>
<table class="ptzctrlbtn" width="46" height="14px" cellpadding=0 cellspacing=0 border=0 title='Filter on (day)' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;ircutfilter&#61;on&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_shorter" bgcolor="#ffffff" nowrap >On
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                <td>
<table class="ptzctrlbtn" width="46" height="14px" cellpadding=0 cellspacing=0 border=0 title='Filter off (night)' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;ircutfilter&#61;off&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_shorter" bgcolor="#ffffff" nowrap >Off
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                </td>
                  <td>
<table class="ptzctrlbtn" width="46" height="14px" cellpadding=0 cellspacing=0 border=0 title='Adjust filter automatically' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;ircutfilter&#61;auto&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg_shorter" bgcolor="#ffffff" nowrap >Auto
    </td>
  </tr>
</table>
<!-- reset params for next button -->
                  </td>
              </tr>
            </table>
          </td>
          <td width=4><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=4></td>
          <td class="lineBg" width=1><img height=5 alt="" src="http://10.101.10.100/pics/blank.gif" width=1></td>
        </tr>
        <tr>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5 border=0></td>
          <td width="100%" background="/pics/line_b_100x5px.gif" height=5><img height=5 alt="" src="/pics/blank.gif" width=1></td>
          <td width=5 colSpan=2 height=5><img height=5 alt="" src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5 border=0></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table bgcolor="white" cellSpacing=0 cellPadding=2 border=0 width="100%">
  <tr>
    <td colspan="2" align="center">
<table class="ptzctrlbtn" width="100" height="14px" cellpadding=0 cellspacing=0 border=0 title='Close PTZ control panel' onclick="Javascript:showPTZpanel(false)">
  <tr>
    <td class="normalText ptzctrlbtn_bg" bgcolor="#ffffff" nowrap >Close panel
    </td>
  </tr>
</table>
<!-- reset params for next button -->
    </td>
  </tr>
</table>

    </td>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick"><img src="/pics/blank.gif" width="4" border=0 alt=""></td>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="/pics/blank.gif" width="1" border=0 alt=""></td>
  </tr>
  <tr>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="/pics/blank.gif" width="1" border=0 alt=""></td>
    <td colspan=3 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick"><img src="/pics/blank.gif" height="2" border=0 alt=""></td>
    <td colspan=1 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="/pics/blank.gif" width="1" border=0 alt=""></td>
  </tr>
  <tr>
    <td colspan=5 title="Click to drag/drop" onmousedown="javascript:clickPTZpanel(this)" class="panelclick panelframe"><img src="/pics/blank.gif" height="1" border=0 alt=""></td>
  </tr>
</table>

</p>
</div>

<script language="JavaScript">
<!--
showPTZpanel(false);
//-->
</script>

<table cellpadding=0 cellspacing=2 border=0>
<tr><!-- "_$pcb_showall = _yes" --><!-- "_$pcb_showall = _yes" -->
<td>
<table class="ptzctrlbtn" width="100" height="14px" cellpadding=0 cellspacing=0 border=0 title='Go to Home position' onclick="Javascript:ptzctrlpanel(this&#44; &#39;&#47;axis-cgi&#47;com&#47;ptz.cgi&#63;camera&#61;1&#38;move&#61;home&#39;)">
  <tr>
    <td class="normalText ptzctrlbtn_bg" bgcolor="#ffffff" nowrap >Home
    </td>
  </tr>
</table>
<!-- reset params for next button --></td><!-- "_$pcb_showall = _yes" -->
</tr>

<tr><!-- "_$pcb_showall = _yes" -->
<td>
<table class="ptzctrlbtn" width="100" height="14px" cellpadding=0 cellspacing=0 border=0 title='Open&#47;close PTZ control panel' onclick="Javascript:togglePTZpanel()">
  <tr>
    <td class="normalText ptzctrlbtn_bg" bgcolor="#ffffff" nowrap >Ctrl panel
    </td>
  </tr>
</table>
<!-- reset params for next button --></td><!-- "_$pcb_showall = _yes" --><!-- "_$pcb_showall = _yes" -->
</tr>

<tr>
<td>
<table class="ptzctrlbtn noclick" width="100" height="14px" cellpadding=0 cellspacing=0 border=0 title=''>
  <tr>
    <td class="normalText ptzctrlbtn_bg_dimmed" bgcolor="#ffffff" nowrap >&nbsp;
    </td>
  </tr>
</table>
<!-- reset params for next button --></td><!-- "_$pcb_showall = _yes" -->
</tr>
<tr>
<td>
<table class="ptzctrlbtn noclick" width="100" height="14px" cellpadding=0 cellspacing=0 border=0 title=''>
  <tr>
    <td class="normalText ptzctrlbtn_bg_dimmed" bgcolor="#ffffff" nowrap >&nbsp;
    </td>
  </tr>
</table>
<!-- reset params for next button --></td><!-- "_$pcb_showall = _yes" -->
</tr>
</table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>

    <form id="settimeform" method="post" action="http://10.101.10.100/sm/sm.srv">
      <input type="hidden" name="root_PTZ_Various_V1_ReturnToOverview" value="">
        <input type="hidden" name="return_page" value="http://10.101.10.100/operator/ptz.shtml?nbr=0&id=156" />
      <input type="hidden" name="action" value="modify">
    </form>
</table>  



<style type="text/css">
.dragbox { position: absolute; border: red 2px ridge; background-color:transparent; z-index: 500; }
</style>

<script type="text/javascript" src="http://10.101.10.100/incl/zxml.js"></script>
<script type="text/javascript" src="http://10.101.10.100/incl/slider.js"></script>
<script type="text/javascript" src="http://10.101.10.100/incl/tooltip.js"></script>

<script language="JavaScript">
<!--

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

function switchMode()
{
  var ptzmode;
  if (!img)
    return;
  img.onmousedown = undefinedVar;
  img.onmouseup   = undefinedVar;
  img.onmousemove = undefinedVar;
  img.style.cursor = "crosshair";
    cross.onmousedown = undefinedVar;
    cross.onmouseup   = undefinedVar;
    cross.onmousemove = undefinedVar;
    cross.style.cursor = "crosshair";
        cross.style.visibility = '';

  if (mode == "center") {
    ptzmode = "center";
  } else if (mode == "joystick") {
    ptzmode = "joystick";
    img.onmousedown = ptzJoystick_start;
      cross.onmousedown = ptzJoystick_start;
  } else {
    ptzmode = "off";
  }
}

function ptzJoystick_start(event)
{
  img.onmousemove = ptzJoystick;
  img.onmouseup = ptzStop;
  img.onmouseout  = ptzStop;
  window.onblur   = ptzStop;
    cross.onmousemove = ptzJoystick;
    cross.onmouseup = ptzStop;
  document.onmouseup = ptzStop;

  ptzJoystick(event);

  return false;
}

function ptzJoystick(event)
{
  var mousePos = getMousePosition(event);
  var imgPos = getPos(img);
  mousePos.x -= imgPos.x;
  mousePos.y -= imgPos.y;
  var pspeed = 100 * (mousePos.x*2 - imgPos.w) / imgPos.w;
  var tspeed = -100 * (mousePos.y*2 - imgPos.h) / imgPos.h;
  var cmd = "continuouspantiltmove="+Math.floor(pspeed)+","+Math.floor(tspeed);
  ptzCommand(cmd);
  return false; // Returning false prevents image drag'n'drop behaviour in mozilla.
}

function ptzStop(event)
{
  img.onmouseup   = undefinedVar;
  img.onmousemove = undefinedVar;
  img.onmouseout  = undefinedVar;

    cross.onmouseup   = undefinedVar;
    cross.onmousemove = undefinedVar;
  document.onmouseup = undefinedVar;

  var cmd = "continuouspantiltmove=0,0";
  ptzCommand(cmd, true);
  return false;
}

var ptzRequest = zXmlHttp.createRequest();
if( ptzRequest.overrideMimeType )
  ptzRequest.overrideMimeType( 'text/plain' );

var ptzCommand_queue = false;
function ptzCommand(cmdstring, que)
{
  if (ptzRequest.readyState > 0 && ptzRequest.readyState < 4) {
    if (que) {
      ptzCommand_queue = cmdstring;
    }
    return false;
  }


  var now = new Date();
  var ptzUrl = "/axis-cgi/com/ptz.cgi?camera=1&";
  ptzUrl += cmdstring;
  if (imagerotation != "")
    ptzUrl += "&imagerotation=" + imagerotation;
  ptzUrl += "&timestamp=" + now.getTime();
  ptzRequest.open("GET", ptzUrl, true);
  delete now;
  ptzRequest.onreadystatechange = ptzCommand_onreadystatechange;
  update_sliders = false;
  try{ ptzRequest.send(null); } catch(e) { delete e; }
  return true;
}

function ptzCommand_onreadystatechange()
{
  try
  {
    if(ptzRequest.status == 401)
    {
      return;
    }
  }
  catch( e )
  {
  }

  if (typeof(ptzRequest) == 'object' && ptzRequest.readyState == 4) {
    update_sliders = true;

    if (ptzCommand_queue) {
      var cmdstring = ptzCommand_queue;
      ptzCommand_queue = false;
      ptzCommand(cmdstring);
    }
  }
}

function selectVideoOrPtz(selection)
{
  if (selection == "video") {
    document.getElementById("videoselection").className = "selectedTab";
    document.getElementById("ptzselection").className = "unselectedTab";
    document.getElementById("videoItems").className = "shownItems";
    document.getElementById("ptzItems").className = "collapsed";
  } else {
    document.getElementById("videoselection").className = "unselectedTab";
    document.getElementById("ptzselection").className = "selectedTab";
    document.getElementById("videoItems").className = "collapsed";
    document.getElementById("ptzItems").className = "shownItems";
  }
}

function showHideCrosshair() // For server push browsers
{
    if (document.getElementById("crossHairCheckbox").checked) {
      cross.style.visibility = '';
    } else {
      cross.style.visibility = 'hidden';
    }
}

function setPtzMode()
{
  if (document.getElementById("ptzModeSelector").selectedIndex == 1) {
    imgNavigation(false);
  } else if (document.getElementById("ptzModeSelector").selectedIndex == 2) {
    centermodeNavigation(true);
  } else {
    imgNavigation(true);
  }
}

function placeHandler(event)
{
  if (!event) event = window.event;
  var mpos = getMousePosition(event);

  thedragbox.onmousemove = dragHandler;
  thedragbox.onmouseup = stopDragging;
  thedragarea.onmousemove = dragHandler;
  thedragarea.onmouseup = stopDragging;
    cross.onmouseup = stopDragging;

  thedragbox.style.width = boxdef.w;
  thedragbox.style.height = boxdef.h;
  thedragbox.style.left = mpos.x;
  thedragbox.style.top = mpos.y;

  boxdef.x = mpos.x;
  boxdef.y = mpos.y;
  event.cancelBubble = true;
  if (event.stopPropagation) event.stopPropagation();
  return false; // Returning false prevents image drag'n'drop behaviour in mozilla.
}

function stopDragging(event)
{
  if (!event) event = window.event;
  thedragbox.onmousemove = noAction;
  thedragbox.onmouseup = noAction;
  thedragarea.onmouseup = noAction;
  thedragarea.onmousemove = noAction;
  thedragbox.style.visibility = 'hidden';
  thedragbox.style.cursor = 'crosshair';
  thedragarea.style.cursor = 'crosshair';
  event.cancelBubble = true;
  if (event.stopPropagation) event.stopPropagation();

  var si = document.getElementById("stream");
  var siPos = getPos(si);
  var boxCenterX = parseInt(thedragbox.style.left.slice(0, -2) - siPos.x + thedragbox.style.width.slice(0, -2)/2, 10);
  var boxCenterY = parseInt(thedragbox.style.top.slice(0, -2) - siPos.y + thedragbox.style.height.slice(0, -2)/2, 10);
  var imgPos = getPos(img);
  if (thedragbox.style.width.slice(0, -2) < 11) {
    var mousePos = getMousePosition(event);
    var speed = parseInt("100", 10);
    mousePos.x -= imgPos.x;
    mousePos.y -= imgPos.y;
    var cmd = "speed="+speed+"&center="+mousePos.x+","+mousePos.y+"&imagewidth="+imgPos.w+"&imageheight="+imgPos.h;
  } else {
    var zoomfactor = parseInt(50*(Math.sqrt(imgPos.w*imgPos.w + imgPos.h*imgPos.h)/radius), 10);
    var cmd = "areazoom=" + boxCenterX + "," + boxCenterY + "," + zoomfactor + "&imagewidth=" + imgPos.w + "&imageheight=" + imgPos.h;
  }
  ptzCommand(cmd); 
  return false;
}

function dragHandler(event)
{
  if (!event) event = window.event;
  var mpos = getMousePosition(event);
  resizeBox(mpos.x, mpos.y);
  event.cancelBubble = true;
  if (event.stopPropagation) event.stopPropagation();
  return false; // Returning false prevents event bubbling
}

function resizeBox(mouseX, mouseY)
{
  var nX;
  var nY;
  var nW;
  var nH;

// Calculate radius
  var katX = Math.abs(boxdef.x - mouseX)
  var katY = Math.abs(boxdef.y - mouseY)
  radius = Math.sqrt(katX*katX + katY*katY)
    nX = boxdef.x - radius*Math.sin(Math.atan(640/480));
    nY = boxdef.y - radius*Math.cos(Math.atan(640/480));

  nW = 2*(boxdef.x - nX)
  nH = 2*(boxdef.y - nY)

  thedragbox.style.left = nX;
  thedragbox.style.top = nY;
  thedragbox.style.width = nW;
  thedragbox.style.height = nH;
  thedragbox.style.visibility = '';
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

var thePtzValuesArray;
function showPtzValues()
{
  if (ptzPosInterval)
    window.clearTimeout(ptzPosInterval);

  try {
    if (ptzValues.status == 401) {
      return;
    }
  }
  catch( e ) {}

  if (typeof(ptzValues) == 'object' && ptzValues.readyState == 4) {

    if (ptzValues.status == 200) {
      var thePtzValuesString = escape(ptzValues.responseText);
      thePtzValuesString = thePtzValuesString.replace(/%3D/g,'=');
      thePtzValuesString = thePtzValuesString.replace(/%0D/g,'');
      thePtzValuesString = thePtzValuesString.replace(/%0A/g,',');
      thePtzValuesArray  = thePtzValuesString.split(",");

      var panValExists   = false;
      var tiltValExists  = false;
      var zoomValExists  = false;
      var focusValExists = false;
      var irisValExists  = false;

      var p, j, v;
      var arrElType;
      var len = (typeof( thePtzValuesArray ) != "undefined") ? thePtzValuesArray.length : 0;

      for (i = 0; i < len; i++)
      {
        arrElType = typeof( thePtzValuesArray[i] );
        if(arrElType.toLowerCase() != "string" )
          continue;
        j = thePtzValuesArray[i].indexOf("=");
        if (j < 0) continue;
        v = thePtzValuesArray[i].substr(j+1);
        p = parseInt(v, 10);
        switch (thePtzValuesArray[i].substr(0, j)) {
          case "pan":
            panPos = p;
            if (!isNaN(panPos))
              panValExists = true;
            break;
          case "tilt":
            tiltPos = p;
            if (!isNaN(tiltPos))
              tiltValExists = true;
            break;
          case "zoom":
            zoomPos = p;
            if (!isNaN(zoomPos))
              zoomValExists = true;
            break;
          case "iris":
            irisPos = p;
            if (!isNaN(irisPos))
              irisValExists = true;
            break;
          case "MinPan":
              minPan = p;
            break;
          case "MaxPan":
              maxPan = p;
            break;
          case "MinTilt":
              minTilt = p;
            break;
          case "MaxTilt":
              maxTilt = p;
            break;
          case "MinZoom":
            minZoom = p; break;
          case "MaxZoom":
            maxZoom = p; break;
          case "MaxFocus":
            maxFocus = p;
            minFocus = -p; break;
          case "MinIris":
            minIris = p; break;
          case "MaxIris":
            maxIris = p; break;
          case "autofocus":
            var oAF = document.getElementById("idAutoFocus");
            if (oAF)
              oAF.style.visibility = (v == "on" ? "visible" : "hidden")
            break;
          case "autoiris":
            var oAI = document.getElementById("idAutoIris");
            if (oAI)
              oAI.style.visibility = (v == "on" ? "visible" : "hidden")
            break;
        }
      }
    }

      if (panSlider)
        panSlider.update(minPan, maxPan, panSlider.value);
      else
        panSlider = new Slider('pan', minPan, maxPan, panPos, true, "horizontal");
        if (panValExists) {
          panSlider.setActual(panPos);
        } else {
          panSlider.removeActual();
        }

      if (tiltSlider)
        tiltSlider.update(minTilt, maxTilt, tiltSlider.value);
      else
        tiltSlider = new Slider('tilt', minTilt, maxTilt, tiltPos, true, "vertical");
        if (tiltValExists) {
          tiltSlider.setActual(tiltPos);
        } else {
          tiltSlider.removeActual();
        }

      if (zoomSlider)
        zoomSlider.update(minZoom, maxZoom, zoomSlider.value);
      else
        zoomSlider = new Slider('zoom', minZoom, maxZoom, zoomPos, true, "horizontal");
        if (zoomValExists) {
          zoomSlider.setActual(zoomPos);
        } else {
          zoomSlider.removeActual();
        }

      if (focusSlider)
        focusSlider.update(minFocus, maxFocus, focusSlider.value);
      else
        focusSlider = new Slider('focus', minFocus, maxFocus, focusPos, true, "horizontal");

      if (irisSlider)
        irisSlider.update(minIris, maxIris, irisSlider.value);
      else
        irisSlider = new Slider('iris', minIris, maxIris, irisPos, true, "horizontal");
        if (irisValExists) {
          irisSlider.setActual(irisPos);
        } else {
          irisSlider.removeActual();
        }

    window.clearTimeout(ptzPosInterval);
    if (panValExists || tiltValExists || zoomValExists || focusValExists || irisValExists)
      ptzPosInterval = window.setTimeout(getPtzPositions, position_interval);

    if (initiateToolTip) {
        bars.push(new Bar("panbar1", "pan", 1, 1, Bar.ORIENT_H, Bar.MODE_A, panToolTip, 3, 264, minPan, maxPan));
        bars.push(new Bar("zoombar1", "zoom", 0, 1, Bar.ORIENT_H, Bar.MODE_A, zoomToolTip, 3, 264, minZoom, maxZoom));
        bars.push(new Bar("focusbar1", "rfocus", 0, 3, Bar.ORIENT_H, Bar.MODE_R, focusToolTip, 3, 264, minFocus, maxFocus));
        bars.push(new Bar("irisbar1", "iris", 0, 1, Bar.ORIENT_H, Bar.MODE_A, irisToolTip, 3, 264, minIris, maxIris));
        bars.push(new Bar("tiltbar1", "tilt", 1, 1, Bar.ORIENT_V, Bar.MODE_A, tiltToolTip, 3, 196, minTilt, maxTilt));

      createToolTip("toolTip", 0, 300, TOOLTIP_STYLE2, 15, 15, TOOLTIP_FOLLOWMOUSE);

      initiateToolTip = false;
    }
  }
}


var newPtzVal = zXmlHttp.createRequest();
if( newPtzVal.overrideMimeType )
  newPtzVal.overrideMimeType( 'text/plain' );
function slider_onChange(group)
{
  if ((group == "pan" && "abs" == "rel") ||
      (group == "tilt" && "abs" == "rel") ||
      (group == "zoom" && "abs" == "rel") ||
      (group == "focus" && "rel" == "rel") ||
      (group == "iris" && "abs" == "rel")) {
    group = "r" + group;
  }

  var url = "/axis-cgi/com/ptz.cgi?camera=1&"+group+"="+parseInt(theNewSliderValue, 10);
  if (imagerotation != "")
    url += "&imagerotation=" + imagerotation;

  if (newPtzVal.readyState > 0 || newPtzVal.readyState < 4)
    newPtzVal.abort();

  newPtzVal.open("GET", url, true);
  newPtzVal.onreadystatechange = newPtzVal_onchange;
  update_sliders = false;
  newPtzVal.send("");
}

function newPtzVal_onchange()
{
  if (ptzPosInterval)
    window.clearTimeout(ptzPosInterval);

  try {
    if(newPtzVal.status == 401) {
      return;
    }
  }
  catch(e) {}

  if (typeof(newPtzVal) == 'object' && newPtzVal.readyState == 4) {
    update_sliders = true;
    if (newPtzVal.responseText.length > 0)
      alert(newPtzVal.responseText.replace(/<.*>/ig, "").trim() );
	 
    ptzPosInterval = window.setTimeout(getPtzPositions, position_interval);
  }
}

/* =================================== Continuous move (arrows) =================================== */

var newContMove = zXmlHttp.createRequest();
if( newContMove.overrideMimeType )
  newContMove.overrideMimeType( 'text/plain' );

var mouseUp;

function continousMove(action, val)
{
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

/* =================================== Generic object and event functions =================================== */

function getObjX(obj)
{
  var pos = 0;
  if (obj.offsetParent) {
    while(obj.offsetParent) {
      pos += obj.offsetLeft;
      obj = obj.offsetParent;
    }
  } else if (obj.x) {
    pos = obj.x;
  }
  return pos;
}

function getObjY(obj)
{
  var pos = 0;
  if (obj.offsetParent) {
    while(obj.offsetParent) {
      pos += obj.offsetTop;
      obj = obj.offsetParent;
    }
  } else if (obj.y) {
    pos = obj.y;
  }
  return pos;
}

function getEventX(e)
{
  if (e.pageX) {
    return e.pageX;
  } else if (e.clientX) {
    return (e.clientX + document.body.scrollLeft);
  }
}

function getEventY(e)
{
  if (e.pageY) {
    return e.pageY;
  } else if (e.clientY) {
    return (e.clientY + document.body.scrollTop);
  }
}


/* =================================== PTZ bar and tooltip handling =================================== */

// Array to hold all bars
var bars = new Array();

// Bar data object:
// element_id   : ID of bar container element. Offsets and values are calculated from this element's geometry.
// api_cmd      : PTZ API command to send as action when bar is clicked.
// value_prec   : precision of value to send (number of decimals).
// linear:      : if != 1, the scale of the bar is not linear. Try 3 for non-linear behaviour.
// orientation  : Bar.ORIENT_H for horizontal bar,  Bar.ORIENT_V for vertical bar.
// mode         : Bar.MODE_A for absolute bar, Bar.MODE_R for relative bar.
// tooltip_func : Function taking a bar object as argument and returns a string to set as tooltip,
//                or set undefined to disable tooltip.
// range_start  : Pixel offset at which the bar scale starts.
// range_end    : Pixel offset at which the bar scale ends.
// min_val      : value of scale at range_start.
// max_val      : value of scale at range_end.

Bar.ORIENT_H = 1;
Bar.ORIENT_V = 2;
Bar.MODE_A = 3;
Bar.MODE_R = 4;

function Bar(element_id, api_cmd, value_prec, linear, orientation, mode, tooltip_func, range_start, range_end, min_val, max_val)
{
  this.element_id = element_id;
  this.api_cmd = api_cmd;
  this.value_prec = value_prec;
  this.linear=linear;
  this.orientation = (orientation == Bar.ORIENT_V) ? Bar.ORIENT_V : Bar.ORIENT_H;
  this.mode = (mode == Bar.MODE_A) ? Bar.MODE_A : Bar.MODE_R;
  this.tooltip_func = tooltip_func;
  this.range_start = range_start;
  this.range_end = range_end;
  this.min_val = min_val;
  this.max_val = max_val;
  this.value = undefined;
  this.timer = undefined;
  this.lastvalue = undefined;
}

// Get bar value at event mouse position
function getBarValue(event, target, bar)
{
  var bar_pos = (bar.orientation == Bar.ORIENT_H) ? getObjX(target) : getObjY(target);
  var click_pos = (bar.orientation == Bar.ORIENT_H) ? getEventX(event) : getEventY(event);
  var offset = click_pos-bar_pos - bar.range_start;
  var span = bar.range_end - bar.range_start;
  var pos; // 0 ... 1
  var val; // bar.min_val ... bar.max_val
  if (bar.orientation == Bar.ORIENT_H) {
    if (offset < 0) {
      val = bar.min_val;
    } else if (offset > span) {
      val = bar.max_val;
    } else {
      pos = offset/span;
    }
  } else {
    if (offset < 0) {
      val = bar.max_val;
    } else if (offset > span) {
      val = bar.min_val;
    }
    pos = (span - offset)/span;
  }
  if (val == undefined) {
    if (bar.linear != 1) {
      if (bar.mode == Bar.MODE_A) {
        // Non-linear absolute
        pos = Math.pow(pos,bar.linear)/Math.pow(1,bar.linear);
        val = bar.min_val + pos * (bar.max_val - bar.min_val);
      } else {
        // Non-linear relative
        val = 2*(pos-0.5); // +/- 1.0
        val = Math.abs(Math.pow(val,bar.linear)/Math.pow(1,bar.linear));
        if (pos < 0.5)
          val = bar.min_val * (val);
        else
          val = bar.max_val * (val);
      }
    } else {
      if (bar.mode == Bar.MODE_A) {
       // Linear absolute
        val = bar.min_val + pos * (bar.max_val - bar.min_val);
      } else {
        // Linear relative
        if (pos < 0.5)
          val = bar.min_val * ((0.5-pos) * 2);
        else
          val = bar.max_val * ((pos-0.5) * 2);
      }
    }
  }
  theNewSliderValue = val;
  return val;
}

// Update a tooltip, if bar value have changed (mouse have moved)
function updateBarTooltip(bar)
{
  if (bar.value == bar.lastvalue) {
    // Mouse have stopped, disable tooltip updates.
    window.clearInterval(bar.timer);
    bar.timer = undefined;
    bar.lastvalue = undefined;
  } else {
    var status = bar.tooltip_func(bar);
    if (bar.lastvalue == undefined)
      setToolTip("toolTip", bar.element_id, status);
    else
      updateToolTip("toolTip", bar.element_id, status);
    bar.lastvalue = bar.value;
  }
}

// Disable tooltip updates
function handleBarExit(target, event)
{
  if (!event) event = window.event;
  for (var b = 0 ; b < bars.length ; b++) {
    if (bars[b].element_id == target.id) {
      if (bars[b].timer != undefined) {
        window.clearInterval(bars[b].timer);
        bars[b].timer = undefined;
      }
    }
  }
}

// Get bar value at mouse position and update tooltip
function handleBarMove(target, event)
{
  if (!event) event = window.event;
  for (var b = 0 ; b < bars.length ; b++) {
    if (bars[b].element_id == target.id && bars[b].tooltip_func) {
      bars[b].value = getBarValue(event, target, bars[b]);
      if (bars[b].timer == undefined) {
        // Don't update tooltip at each mousemove event, it will cause ugly delays and use too much cpu.
        // Instead, start a timer to update at 10Hz until mouse stoppes moving.
        updateBarTooltip(bars[b]);
        var code = "updateBarTooltip(bars[" + b +"]);";
        bars[b].timer = window.setInterval(code, 100)
      }
      return;
    }
  }
}


/* =================================== PTZ tooltip formatting =================================== */
// These functions can be replaced to suit different products and driver types

function panToolTip(bar)
{
  var str = "Pan to [#]&deg;";
  return str.replace(/\[#\]/, Number(bar.value).toFixed(1));
}
function zoomToolTip(bar)
{
  if (typeof(ptzDefMaxZoomList) == "number" && isNaN(ptzDefMaxZoomList))
  {
    var str = "[#]x zoom";
    var maxmag = Math.round(558/17);
    var mag = 1 + (maxmag-1) * (bar.value/(bar.max_val-bar.min_val));
  }
  else
  {
    var hasOptical = (typeof(ptzDefMaxOpticalZoomMag) == "number" && !isNaN(ptzDefMaxOpticalZoomMag));
    var hasDigital = (typeof(ptzDefMaxDigitalZoomMag) == "number" && !isNaN(ptzDefMaxDigitalZoomMag));
    var mag = 0;
    var preMag = 1;
    var preValue = 0;
    for (var i = 0; i < ptzDefMaxZoomList.length; i++)
    {
      if (bar.value <= ptzDefMaxZoomList[i][0])
      {
        mag = (bar.value - preValue) / (ptzDefMaxZoomList[i][0] - preValue) * (ptzDefMaxZoomList[i][1] - preMag) + preMag;
        break;
      }
      preValue = ptzDefMaxZoomList[i][0];
      preMag = ptzDefMaxZoomList[i][1];
    }
  }
  var str_mag = "";
  var str_optical = "[#]x zoom";
  var str_digital = "[#]x D zoom";
  var str_optical_digital = "[#]x ([#D]x D) zoom";
  if (hasOptical && hasDigital)
  {
    if (mag > ptzDefMaxOpticalZoomMag)
      str = str_optical_digital.replace(/\[#D\]/, Number(mag/ptzDefMaxOpticalZoomMag).toFixed(1));
    else
      str = str_optical;
  }
  else if (hasDigital)
  {
    str = str_digital;
  }
  else
  {
    str = str_optical;
  }
  return str.replace(/\[#\]/, Number(mag).toFixed(1));
}

function focusToolTip(bar)
{
    var str_n = "Focus near [#]%";
    var str_f = "Focus far [#]%";
    if (bar.value < 0) {
      var focus = 100 * (bar.value/bar.min_val);
      return str_n.replace(/\[#\]/, Number(focus).toFixed(1));
    } else {
      var focus = 100 * (bar.value/bar.max_val);
      return str_f.replace(/\[#\]/, Number(focus).toFixed(1));
    }
}

function irisToolTip(bar)
{
    var str_s = "Set iris to [#]%";
    var iris = 100 * (bar.value/bar.max_val);
    return str_s.replace(/\[#\]/, Number(iris).toFixed(1));
}

function tiltToolTip(bar)
{
    var str_d = "Tilt down to [#]&deg;";
    var str_u = "Tilt up to [#]&deg;";
  if (bar.value < tiltPos) {
    return str_d.replace(/\[#\]/, Number(bar.value).toFixed(1));
  } else {
    return str_u.replace(/\[#\]/, Number(bar.value).toFixed(1));
  }
}

//-->
</script>
    </td>
    <td width=4><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 border=0 alt=""></td>
    <td width=1 class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 border=0 alt=""></td>
  </tr>

  <!-- ################################################################ -->
  <!-- Defines the table width -->
  <tr>
    <td colspan=1 width=1 class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td>
    <td colspan=1 width=4><img src="http://10.101.10.100/pics/blank.gif" width=4 height=1 alt=""></td>
    <td colspan=1 width=180><img src="http://10.101.10.100/pics/blank.gif" width=180 height=1 alt=""></td>
    <td colspan=1 width=1 class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td> 
    <td colspan=1 width=4><img src="http://10.101.10.100/pics/blank.gif" width=4 height=1 alt=""></td>
    <td colspan=1 width=164><img src="http://10.101.10.100/pics/blank.gif" width=164 height=1 alt=""></td>
    <td colspan=1 width=195><img src="http://10.101.10.100/pics/blank.gif" width=295 height=1 alt=""></td>
    <td colspan=1 width=4><img src="http://10.101.10.100/pics/blank.gif" width=4 height=1 alt=""></td>
    <td colspan=1 width=1 class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td>
  </tr>
  <!-- ################################################################ -->
	
  <tr>
    <td colspan=2><img src="http://10.101.10.100/pics/line_corner_lb_5x5px.gif" width=5 height=5 alt=""></td>
    <td colspan=1 background="http://10.101.10.100/pics/line_b_100x5px.gif"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td>
    <td colspan=1 class="lineBg"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td>
    <td colspan=3 background="http://10.101.10.100/pics/line_b_100x5px.gif"><img src="http://10.101.10.100/pics/blank.gif" width=1 height=1 alt=""></td> 
    <td colspan=2><img src="http://10.101.10.100/pics/line_corner_rb_5x5px.gif" width=5 height=5 alt=""></td>
  </tr>
  <tr>
    <td colspan=9><img src="http://10.101.10.100/pics/blank.gif" width=1 height=5 border=0 alt=""></td>
  </tr>
  <tr>
    <td width=1><img src="http://10.101.10.100/pics/blank.gif" width="1" height="1" border=0 alt=""></td>
    <td colspan=7 valign="middle" align="left"></td>
    <td width=1><img src="http://10.101.10.100/pics/blank.gif" width="1" height="1" border=0 alt=""></td>
  </tr>
</table>

</td></tr></table>
<script language="JavaScript" type="text/javascript">
<!--
/*
	Standards Compliant Script
	Alternates Table Columns
	Author : Kevin Cannon
	http://www.multiblah.com
	Last Edited: 12.12.2004
	Version 1.0

	Search through the document for tables with the "alternateRows" class,
	and set the class of even rows to "even" to appropriate rows <tr>

	Licence:
	Use as you wish, though it'd be nice if you can leave in the credit in
	the code.

	Changes:
	4/10/2004 - Added in AddLoadEvent function which piggybacks code onto
	window.onLoad

	2005-04-21 - Modified to work with Axis web pages. [pkj]
*/

// Main function, called when the page loads
function alternateRows()
{
	var i;

	if (!document.getElementById)
		return

	var tables = document.getElementsByTagName("table");

	// Search through tables in document
	for (i = 0; i < tables.length; i++) {
		// If table has the right classname
		if (tables[i].className == "alternateRows") {
			applyClassToRows(tables[i]);
		}
	}
}

// Function, which is passed a table reference, applies the class 'evenItem'
// to each even row and 'oddItem' to each odd row
function applyClassToRows(table)
{
	var rows = table.rows;
	var row_is_odd = 0;
	var i;

	// Search through rows
	for (i = 0; i < rows.length; i++) {
		if (rows[i].className != "reuseLast")  {
			row_is_odd = !row_is_odd;
		}

		if (rows[i].className == "topTitle" ||
		    rows[i].className == "subTitle")  {
			row_is_odd = 0;
		} else if (row_is_odd) {
			rows[i].setAttribute("className", "oddItem");
			rows[i].setAttribute("class", "oddItem");
		} else {
			rows[i].setAttribute("className", "evenItem");
			rows[i].setAttribute("class", "evenItem");
		}
	}
}

// Piggy-back function onto onLoad event ......................................
var oldonload;

function addLoadEvent(func)
{
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		oldonload = window.onload;
		window.onload = function() {
			oldonload();
			func();
		}
	}
}

addLoadEvent(alternateRows);
// -->
</script>
</body>
</html>
