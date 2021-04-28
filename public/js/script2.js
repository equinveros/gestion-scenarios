var page = Array();

var onCanvas = false;
var mode = "line";
var scene = false;
var calque_top = false;
var calque_bottom = false;

var newElement = false;
var elementIdentic = false;

var lines = 0;
var rectangles = 0;

var selecteurs = Array();
var start_point = Array();
var elementFinish = false;
var element = false;
var group = false;
var inhibe_selection = false;
var box = false;
var offset = false;
var oldMode = false;
var onCurrent = false;
var onOverlay = false;
var onElement = false;

var scenario_id = false;
var layer_number = false;

var updatePage = false;
var nbPage;

window.onload = function () {

  $(document).keydown(function (e) {
    // Annulation
    if (e.keyCode == 90 && e.ctrlKey) {
      restore_object();
    }
    if (e.keyCode == 27) {
      calque_top.removeChildren();
      calque_top.draw();
    }
    // Delete
    else if (e.keyCode == 46) del_object();
  });
  offset = $('.kineticjs-content').offset();
  overlay.onmousedown = function (e) {
    processMouseDown(e);
  };
  overlay.onmouseup = function (e) {
    processMouseUp();
  };
  overlay.onmousemove = function (e) {
    processMouseMove(e);
  };

  overlay.onmouseover = function () {
    onOverlay = true;
  };
  overlay.onmouseout = function () {
    onOverlay = false;
  };
  // overlay.onmouseleave = function (e) {
  //     processMouseLeave(e);
  // };
  // overlay.onmouseout = function () {
  //     onCanvas = false;
  // };


  scenario_id = document.getElementById('scenario_id').value;
  layer_number = document.getElementById('layer_number').value;

  getScenarioLayer();
  getNbLayers();
  document.getElementById("iframe").src = page.url;
  document.getElementById("iframe").onload = function () {
    initialize();
  };

  document.getElementById("line").onclick = function () {
    mode = "line";
    oldMode = mode;
  };
  document.getElementById("rect").onclick = function () {
    mode = "rect";
    oldMode = mode;
  };
  document.getElementById("look_Console").onclick = function () {
    document.getElementById("console").classList;
    if (document.getElementById("console").classList.contains("tg-hidden")) {
      document.getElementById("console").classList.remove("tg-hidden")
    } else {
      document.getElementById("console").classList.add("tg-hidden");
    }
  };
  document.getElementById("normal").onclick = function () {
    mode = "normal";
    oldMode = mode;
  };
  document.getElementById("clear").onclick = function () {
    clearCanvas();
  };

  document.getElementById("ok").onclick = function () {
    addElementField();
  };
  document.getElementById("validate").onclick = function () {
    updateLayer();
  };

  document.getElementById("libelle").oninput = function () {
    addElementField();
  };
  document.getElementById("description").oninput = function () {
    addElementField();
  };
  document.getElementById("context").oninput = function () {
    addElementField();
  };
  document.getElementById("priority").onchange = function () {
    addElementField();
  };
  document.getElementById("state").onchange = function () {
    if (element != null) {
      switch (document.getElementById("state").value) {
        case "ok" :
        element.attrs.stroke = "#114dd8";
        break;
        case "ko" :
        element.attrs.stroke = "#ed1212";
        break;
        case "inProgress" :
        element.attrs.stroke = "#32bc12";
        break;
      }
      addElementField();
    }
    calque_bottom.draw();
  };

};
///////////////
////PROCESS ///
///////////////
function processMouseDown(e) {

  elementFinish = false;
  onCanvas = true;

  if (mode != "normal" && !onElement) {
    $('.overlay').css('cursor', 'pointer');
    create(e.pageX - offset.left, e.pageY - offset.top);
  }
}

function processMouseUp() {
  onCanvas = false;
  if (onOverlay) {
    if (!elementIdentic && !newElement) {
      log(" - Element selectionné : " + element.attrs.id + ".<br/>");
    }
  }
  if (onCurrent == true) {
    elementFinish = true;
    onCurrent = false;
    start_point = [];

    element.moveTo(calque_bottom);

    select_object();

    var newProprities = Array();
    var elementableType = false;

    switch (element.className) {
      case "Rect":
      if (newElement) {
        rectangles++;
      }
      newProprities = {
        "width": element.attrs.width,
        "height": element.attrs.height
      };
      elementableType = "Rectangle";
      break;
      case "Line" :
      if (newElement) {
        lines++
      }
      newProprities = {
        "x1": element.attrs.points[0],
        "x2": element.attrs.points[2],
        "y1": element.attrs.points[1],
        "y2": element.attrs.points[3]
      };
      elementableType = "Line";
      break;
    }
    var newElementDef = {
      'name': "",
      'description': "",
      'context': "",
      'pos_x': element.attrs.x,
      'pos_y': element.attrs.y
      // 'layer_id' : pages[pageCourrante(page).layer]
    };

    var newE = {
      "elementableType": elementableType,
      "elementSonDef": newProprities,
      "elementDef": newElementDef,
      'priority': {"code": "P4"},
      'state': {"code": "ko"},
      "kinetic": element,
      "delete": false
    };
    if (newElement) {
      log(" - Element crée : " + element.attrs.id, element);
      page.elements.push(newE);
      newElement = false;
    } else {
      for (var i = 0; i < page.elements.length; i++) {
        if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
          newE['elementableType'] = page.elements[i].elementableType;
          newE['elementDef'] = {
            'id': page.elements[i].elementDef.id,
            'elementable_id': page.elements[i].elementDef.elementable_id,
            'elementable_type': page.elements[i].elementDef.elementable_type,
            'name': document.getElementById('libelle').value,
            'description': document.getElementById('description').value,
            'context': document.getElementById('context').value,
            'pos_x': element.attrs.x,
            'pos_y': element.attrs.y
          };
          newE['state'] = {"code": document.getElementById('state').value};
          newE['priority'] = {"code": document.getElementById('priority').value};
          // 'layer_id' : pages[pageCourrante(page).layer]
          page.elements[i] = newE;
          break;
        }
      }
    }

    calque_bottom.draw();
  }
}

function processMouseMove(e) {
  if (onCanvas == true && mode != "normal") {
    addAtElement(e.pageX - offset.left, e.pageY - offset.top);
    updatePage = true;

    onCurrent = true;
    calque_top.draw();
  }
}

//////////////

function initialize() {

  lines = 0;
  rectangles = 0;

  // document.getElementById("iframe").src = page.url;
  // page = document.getElementById("iframe").src;

  document.getElementById("allPages").innerText = nbPage;
  document.getElementById("nowPage").innerText = layer_number;
  // iFrameResize({autoresize: true}, '#iframe');

  if (document.getElementById("allPages").innerText != document.getElementById("nowPage").innerText){
    document.getElementById("next").onclick = function () {
      otherPage("next");
    };
  }
  document.getElementById("previous").onclick = function () {
    otherPage("previous");
  };

  var canvasDiv = document.getElementById('overlay');
  canvasDiv.appendChild(createCanvas(false));
  canvasDiv.appendChild(createCanvas(true));
  canvasDiv.appendChild(createCanvas(true));

  var elementSonDef = Array();

  scene = new Kinetic.Stage({
    container: "overlay",
    width: canvasDiv.clientWidth,
    height: canvasDiv.clientHeight
  });
  calque_top = new Kinetic.Layer();
  calque_bottom = new Kinetic.Layer();

  for (var j = 0; j < page.elements.length; j++) {
    var elementInit = page.elements[j];

    switch (elementInit.elementableType) {
      case "Rectangle" :
      mode = "rect";
      oldMode = mode;
      create(
        elementInit.elementDef.pos_x,
        elementInit.elementDef.pos_y,
        elementSonDef = {
          "width": elementInit.elementSonDef.width,
          "height": elementInit.elementSonDef.height
        }
      );
      rectangles++;
      break;
      case "Line":
      mode = "line";
      oldMode = mode;
      create(
        elementInit.elementDef.pos_x,
        elementInit.elementDef.pos_y,
        elementSonDef = {
          "x1": elementInit.elementSonDef.x1,
          "x2": elementInit.elementSonDef.x2,
          "y1": elementInit.elementSonDef.y1,
          "y2": elementInit.elementSonDef.y2
        }
      );
      lines++;
      break;
    }
    element.moveTo(calque_bottom);
    element.attrs.stroke = elementInit.state.color;


    newElement = false;
    page.elements[j]['kinetic'] = element;
    page.elements[j]['delete'] = false;
  }

  scene.add(calque_bottom);
  scene.add(calque_top);

  page.calque_bottom = calque_bottom;
  page.calque_top = calque_top;

  page.scene = scene;
  page.area = "";


  element = false;
  mode = "normal";
}

// Gestion des scénarios

function loadFormElement() {
  // if (page.elements[element.attrs.id] != undefined) {
  document.getElementById('libelle').value = "";
  document.getElementById('description').value = "";
  document.getElementById('context').value = "";
  document.getElementById('priority').value = "";
  document.getElementById('state').value = "ko";
  //// PROCESS A REVOIR d'URGENCE ///
  for (var i = 0; i < page.elements.length; i++) {
    if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
      document.getElementById('libelle').value = page.elements[i].elementDef.name;
      document.getElementById('description').value = page.elements[i].elementDef.description;
      document.getElementById('context').value = page.elements[i].elementDef.context;
      document.getElementById('priority').value = page.elements[i].priority.code;
      document.getElementById('state').value = page.elements[i].state.code;
      break;
    }
  }
}

function addElementField() {
  //// PROCESS A REVOIR d'URGENCE ///
  if (element) {
    updatePage = true;
    for (var i = 0; i < page.elements.length; i++) {
      if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
        var elementDef = page.elements[i].elementDef;
        elementDef.name = document.getElementById('libelle').value;
        elementDef.description = document.getElementById('description').value;
        elementDef.context = document.getElementById('context').value;
        page.elements[i].priority.code = document.getElementById('priority').value;
        page.elements[i].state.code = document.getElementById('state').value;

        break;
      }
    }
  }
}

function otherPage(otherPage) {
  element = false;
  if (updatePage) {
    var result = confirm("Des changements ont été effectués sur la page, voulez-vous sauvegarder ?");
    if (result) {
      updateLayer();
    }
  }


  var nextPage = layer_number;
  if (otherPage == "next") {
    nextPage++;
  } else {
    nextPage--;
  }


  if (nextPage > 0 && nextPage <= nbPage) {
    document.location = "/scenario/" + scenario_id + "/" + nextPage;
  }
}

////////////////////
///// KINETIC //////
////////////////////


//////Objets////////
function newRectangle(x, y, elementSonDef) {
  var h = 1;
  var w = 1;
  if (elementSonDef != undefined) {
    h = elementSonDef['height'];
    w = elementSonDef['width'];
  }
  var rectangle = new Kinetic.Rect({
    x: x,
    y: y,
    width: w,
    height: h,
    stroke: "#ed1212",
    strokeWidth: 5,
    draggable: true,
    id: "rect_" + rectangles
  });
  return rectangle;
}

function newLine(x, y, elementSonDef) {
  var points = Array();

  if (elementSonDef != undefined) {
    points = [
      elementSonDef['x1'],
      elementSonDef['y1'],
      elementSonDef['x2'],
      elementSonDef['y2']
    ];

  } else {
    points = [x, y];
  }

  var ligne = new Kinetic.Line({
    points: points,
    stroke: "#ed1212",
    strokeWidth: 8,
    id: "line_" + lines,
    selected: false,
    lineCap: "round",
    lineJoin: "round",
    x: 0,
    y: 0,
    draggable: true
  });
  return ligne;
}

/////Contrôles//////
function create(x, y, elementSonDef) {
  var nb = false;
  newElement = true;

  switch (mode) {
    case "line":
    start_point = [x, y];
    element = newLine(x, y, elementSonDef);
    nb = lines;
    break;
    case "rect":
    element = newRectangle(x, y, elementSonDef);
    nb = rectangles;
    break;
  }

  group = new Kinetic.Group({
    x: x,
    y: y,
    name: "group_" + mode + "_" + nb,
    draggable: true
  });

  onCurrent = false;
  element.on("mouseenter", function () {
    $('.overlay').css('cursor', 'pointer');
    onElement = true;
    if (elementFinish) {
      mode = "normal";
    }
  });
  element.on("mouseleave", function () {
    $('.overlay').css('cursor', 'default');
    onElement = false;
    if (elementFinish) {
      mode = oldMode;
    }
  });
  element.on("dragstart", function () {
    onCurrent = true;
    updatePage = true;

    calque_top.removeChildren();
    calque_top.draw();
  });


  element.on("dragend", function () {
    calque_top.removeChildren();
    select_object();
    calque_top.draw();
  });

  element.on("drag", function () {
    calque_top.removeChildren();
    select_object();
    calque_top.draw();
  });

  element.on("mousedown", function (e) {
    if (element == e.target) {
      elementIdentic = true;
    } else {
      element = e.target;
      elementIdentic = false;
    }
    select_object();
    calque_top.draw();
    // calque_bottom.draw();
  });


  // document.getElementById("form").hidden = false;
  group.add(element);
  calque_top.add(element);
}

function addAtElement(x, y) {
  switch (mode) {
    case "line":
    element.setPoints(start_point.concat([x, y]));
    break;
    case "rect":
    element.attrs.width = x - element.attrs.x;
    element.attrs.height = y - element.attrs.y;
    break;
  }
}

function select_object(e) {
  calque_top.removeChildren();
  if (e) {
    for (i = 0; i < Object.keys(calque_bottom.children).length; i++) {
      if (calque_bottom.children[i].attrs.id == e) {
        element = calque_bottom.children[i];
        break;
      }
    }
  }
  //element.moveTo(calque_top);
  selecteurs = [];
  var pos = null;
  if (element.className == "Line") {
    var points = element.getPoints();
    pos = element.getPosition();
    selecteurs.push(build_selector(points[0] + pos.x, points[1] + pos.y, 'start'));
    selecteurs.push(build_selector(points[2] + pos.x, points[3] + pos.y, 'end'));

  }
  else if (element.className == "Rect") {
    //pos = element.getPosition();
    selecteurs.push(build_selector(element.attrs.x, element.attrs.y, 'topLeft'));
    selecteurs.push(build_selector(element.attrs.x + element.attrs.width, element.attrs.y, 'topRight'));
    selecteurs.push(build_selector(element.attrs.x + element.attrs.width, element.attrs.y + element.attrs.height, 'bottomRight'));
    selecteurs.push(build_selector(element.attrs.x, element.attrs.y + element.attrs.height, 'bottomLeft'));
  }
  else if (element.className == "Ellipse") {

  }
  loadFormElement();
  onCurrent = true;
  $('.overlay').css('cursor', 'default');
}

function build_selector(x, y, name) {
  var selector = new Kinetic.Circle({
    x: x,
    y: y,
    radius: 10,
    stroke: "#666",
    fill: "#ddd",
    strokeWidth: 15,
    draggable: true,
    name: name,
  });

  selector.on("dragmove", function (e) {
    update(this);
    calque_top.draw();
    calque_bottom.draw();
  });

  selector.on("mousedown touchstart", function () {
    group.setDraggable(false);
    this.moveToTop();
  });

  selector.on("dragend", function () {
    group.setDraggable(true);
    calque_top.draw();
  });

  selector.on("mouseover", function () {
    $('.overlay').css('cursor', 'pointer');
    inhibe_selection = true;
    mode = "normal";
  });

  selector.on("mouseout", function () {
    $('.overlay').css('cursor', 'default');
    inhibe_selection = false;
    mode = oldMode;
  });

  calque_top.add(selector);
  calque_top.draw();
  return selector;
}

function update(activeAnchor) {
  var topLeft = selecteurs[0];
  var topRight = selecteurs[1];
  var bottomRight = selecteurs[2];
  var bottomLeft = selecteurs[3];
  var anchorX = activeAnchor.getX();
  var anchorY = activeAnchor.getY();
  // update anchor positions

  switch (activeAnchor.getName()) {
    case 'topLeft':
    topRight.setY(anchorY);
    bottomLeft.setX(anchorX);
    break;
    case 'topRight':
    topLeft.setY(anchorY);
    bottomRight.setX(anchorX);
    break;
    case 'bottomRight':
    bottomLeft.setY(anchorY);
    topRight.setX(anchorX);
    break;
    case 'bottomLeft':
    bottomRight.setY(anchorY);
    topLeft.setX(anchorX);
    break;
    case 'start':
    topLeft.setX(anchorX);
    topLeft.setY(anchorY);
    break;
    case 'end':
    topRight.setX(anchorX);
    topRight.setY(anchorY);
    break;
  }

  switch (element.className) {
    case 'Line':
    if (activeAnchor.attrs.name == "start") {
      element.attrs.points[0] = topLeft.getX();
      element.attrs.points[1] = topLeft.getY();
      start_point = [topLeft.getX(), topLeft.getY()];
    } else {
      element.attrs.points[2] = topRight.getX();
      element.attrs.points[3] = topRight.getY();
    }
    break;
    case 'Rect':
    element.setPosition(topLeft.getPosition());
    var width = topRight.getX() - topLeft.getX();
    var height = bottomLeft.getY() - topLeft.getY();
    if (width && height) {
      element.attrs.width = width;
      element.attrs.height = height;
    }
    break;
  }
}

/////////////////////
////// Control //////
/////////////////////

function del_object() {
  //params.objets_effaces.push(params.objet_modif);
  group.remove();
  log(" - Element : " + element.attrs.id + " à été effacer.<br/>");
  page.elementsDeleted.push(element);
  for (var i = 0; i < page.elements.length; i++) {
    if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
      page.elements[i].delete = true;
    }
  }
  element.remove();
  calque_bottom.draw();
  calque_top.removeChildren();
  calque_top.draw();
  element = false;
}

function restore_object() {
  element = page.elementsDeleted[page.elementsDeleted.length - 1];
  page.elementsDeleted.splice(page.elementsDeleted.length - 1, 1);
  for (var i = 0; i < page.elements.length; i++) {
    if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
      page.elements[i].delete = false;
    }
  }
  calque_bottom.add(element);
  log(" - Element : " + element.attrs.id + " à été restauré. <br/>");
  calque_bottom.draw();
  calque_top.draw();
  select_object(element.attrs.id);
}

function log(message, element) {
  var console = document.getElementById("console");
  var text = console.innerHTML;
  text = text + message + "\n";
  if (element) {
    text = text + ", <u style='cursor:pointer;' id='log_" + element.attrs.id + "' onclick='select_object(\"" + element.attrs.id + "\")'> Cliquez ici pour le selectionner</u> <br/>";
  }
  page.area = text;
  console.innerHTML = text;
}

function createCanvas(display) {
  var canvasDiv = document.getElementById('overlay');
  var canvas = document.createElement('canvas');
  canvas.setAttribute('width', canvasDiv.clientWidth);
  canvas.setAttribute('height', canvasDiv.clientHeight);
  if (display) {
    canvas.setAttribute('style', 'display:none;');
  } else {
    canvas.setAttribute('id', 'canvas');
  }

  return canvas;
}

///////////////////
/////// AJAX //////
///////////////////

function getScenarioLayer() {
  var url = false;
  if (layer_number != undefined) {
    url = '/getScenarioLayer/' + scenario_id + "/" + layer_number;
  } else {
    url = '/getScenarioLayer/' + scenario_id;
  }
  $.ajax({
    method: 'GET',
    url: url,
    // data: {id: scenario_id},
    async: false,
    dataType: "json",
    success: function (data) {
      page = {
        "url": data[0].url,
        "layer": data[0].layer,
        "scene": null,
        "calque_bottom": null,
        "calque_top": null,
        "area": null,
        "elementsDeleted": Array(),
        "priority": data[0].priority,
        "elements": data[0].elements
      };
      console.log(page);
    },
    error: function () {
      console.log('error getScenarioLayer');

    }
  });
}

function getNbLayers() {
  $.ajax({
    method: 'GET',
    url: '/getLayers/' + scenario_id,
    async: false,
    success: function (data) {
      nbPage = data
    },
    error: function () {
      console.log('error getLayers');
    }
  });
}

function updateLayer() {
  var scenario_id = document.getElementById('scenario_id').value;
  var datas = Array();
  var layer_number = page.layer;
  for (var j = 0; j < page.elements.length; j++) {
    if (page.elements[j].elementDef.id == undefined && page.elements[j].delete) {
      continue;
    }
    datas.push({
      "elementSonDef": page.elements[j].elementSonDef,
      "elementDef": page.elements[j].elementDef,
      "elementableType": page.elements[j].elementableType,
      "delete": page.elements[j].delete,
      "priority": page.elements[j].priority,
      "state": page.elements[j].state,
      "layer": layer_number
    })
  }

  var secure_token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    method: 'POST',
    // async: false,
    url: '/updateLayer/' + scenario_id,
    data: {
      _token: secure_token,
      id: scenario_id,
      datas: datas
    },
    dataType: "json",
    success: function (response) {
      if (updatePage) {
        log("Modification effectué.");
        updatePage = false;
      }
    },
    error: function () {
      console.log('error');
    }
  });
}


// function resizeIframe(obj) {
//     obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
// }
