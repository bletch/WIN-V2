var request = false;
var mapXPos = 4;
var mapYPos = 4;

function requestMap(xPos, yPos) {
  if (window.XMLHttpRequest) {
    request = new XMLHttpRequest(); // Mozilla, Safari, Opera
  }
  else if (window.ActiveXObject) {
    try {
      request = new ActiveXObject('Msxml2.XMLHTTP'); // IE 5
    } catch (e) {
      try {
        request = new ActiveXObject('Microsoft.XMLHTTP'); // IE 6
      } catch (e) {}
    }
  }

  if (!request) {
    alert("Kann keine XMLHTTP-Instanz erzeugen");
    return false;
  }
  else {
    var url = "test.php";
    request.open('post', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send('xPos='+xPos+'&yPos='+yPos);
    request.onreadystatechange = receiveMap;
  }
}

function receiveMap() {
  switch (request.readyState) {
    case 4:
      if (200 != request.status) {
        alert("Request completed, but not ok\nError:" + request.status);
      }
      else {
        var content = request.responseText;
        document.getElementById('map').innerHTML = content;
      }
      break;
    default:
      break;
  }
  return;
}

function moveMap(direction){
  switch (direction){
    case 'left':
      if(4 < mapXPos){
        mapXPos -= 1;
      }
      break;
    case 'up':
      if(4 < mapYPos){
        mapYPos -= 1;
      }
      break;
    case 'right':
      if(35 > mapXPos){
        mapXPos += 1;
      }
      break;
    case 'down':
      if(35 > mapYPos){
        mapYPos += 1;
      }
      break;
    default:
      break;
  }

  requestMap(mapXPos, mapYPos);
  return;
}