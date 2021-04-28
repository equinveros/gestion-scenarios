var page = Array();

var onCanvas = false;

var mode = "normal";
var oldMode = "normal";
var scene = false;
var calque_top = false;
var calque_bottom = false;

var newElement = false;
var elementIdentic = false;

var lines = 0;
var rectangles = 0;
var textes = 0;
var pens = 0;
var images = 0;

var selecteurs = Array();
var start_point = Array();
var elementFinish = false;
var element = false;
var group = false;
var inhibe_selection = false;
var box = false;
var offset = false;
var onCurrent = false;
var onOverlay = false;
var onElement = false;
var urlImg = false;

var scenario_id = false;
var step_number = false;

var updatePage = false;
var nbPage;

var maxStageWidth;
var maxStageHeight;
var maxPageWidth;
var current_lang;

window.onload = function () {
    // initDropZone();

    document.getElementById(mode).classList.add("mode--active");

    $(document).keydown(function (e) {
        // Annulation
        if (e.keyCode == 90 && e.ctrlKey) {
            restore_object();
        }
        if (e.keyCode == 27) {
            if (!document.getElementById("options_text").classList.contains("tg-hidden")) {
                document.getElementById("options_text").classList.add("tg-hidden");
            }
            calque_top.removeChildren();
            calque_top.draw();
            loadFormElement(true);
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

    scenario_id = document.getElementById('scenario_id').value;
    step_number = document.getElementById('step_number').value;
    current_lang = document.getElementById('current_lang').value;
    getScenarioStep();
    getNbSteps();

    // iFrameResize({log: true, autoResize: true, resizeFrom: 'parent', sizeWidth: true, sizeHeight: true}, "#iframe");
    document.getElementById("iframe").src = page.url;
    document.getElementById("iframe").onload = function () {

        initialize();

    };

    document.getElementById("line").onclick = function () {
        mode = "line";
        changeMode();
        oldMode = mode;
    };
    document.getElementById("rect").onclick = function () {
        mode = "rect";
        changeMode();
        oldMode = mode;
    };
    document.getElementById("normal").onclick = function () {
        mode = "normal";
        changeMode();
        oldMode = mode;
    };
    document.getElementById("pen").onclick = function () {
        mode = "pen";
        changeMode();
        oldMode = mode;
    };
    document.getElementById("text").onclick = function () {
        mode = "text";
        changeMode();
        oldMode = mode;
    };
    document.getElementById("img").onclick = function () {
        mode = "img";
        changeMode();
        oldMode = mode;
    };

    document.getElementById("look_Console").onclick = function () {
        if (document.getElementById("console").classList.contains("tg-hidden")) {
            document.getElementById("console").classList.remove("tg-hidden")
        } else {
            document.getElementById("console").classList.add("tg-hidden");
        }
    };
    // document.getElementById("look_Iframe").onclick = function () {
    //     if (document.getElementById("overlay").classList.contains("tg-hidden")) {
    //         document.getElementById("overlay").classList.remove("tg-hidden")
    //     } else {
    //         document.getElementById("overlay").classList.add("tg-hidden");
    //     }
    // };

    document.getElementById("validate").onclick = function () {
        updateStep();
    };

    document.getElementById("libelle").oninput = function () {
        addElementField();

        if (element && element.className == "Text") {
            element.setText(document.getElementById("libelle").value);
            calque_bottom.draw();
            select_object();

        }
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
                    element.attrs.stroke = "#bfe5bf";
                    break;
                case "ko" :
                    element.attrs.stroke = "#ff9a8e";
                    break;
                case "inProgress" :
                    element.attrs.stroke = "#d4c5f9";
                    break;
            }
            addElementField();
        }
        calque_bottom.draw();
    };

    document.getElementById("stroke").onchange = function () {
        if (element) {
            if (element.className == "Text") {
                element.attrs.fontSize = document.getElementById("stroke").value;
                element.setText(element.attrs.text);

            } else {
                element.attrs.strokeWidth = document.getElementById("stroke").value;
            }
            addElementField();
            elementToUpdate();
            calque_bottom.draw();
            select_object();
        }
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
    else if (inhibe_selection) {

    } else if (mode == "normal" && !onElement) {
        element = false;
        if (!document.getElementById("options_text").classList.contains("tg-hidden")) {
            document.getElementById("options_text").classList.add("tg-hidden");
        }
        onCurrent = false;
        calque_top.removeChildren();
        calque_top.draw();
        loadFormElement(true);
    } else {
        select_object();
    }
}

function processMouseUp() {
    onCanvas = false;
    if (onOverlay) {
        if (element && !elementIdentic && !newElement) {
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
        var stroke;
        switch (element.className) {
            case "Rect":
                if (newElement) {
                    rectangles++;
                }
                newProprities = {
                    "width": element.attrs.width,
                    "height": element.attrs.height
                };
                stroke = element.attrs.strokeWidth;
                elementableType = "Rectangle";
                break;
            case "Line" :
                var points = element.getPoints();
                stroke = element.attrs.strokeWidth;
                if (points.length > 4) {

                    if (newElement) {
                        pens++;
                    }
                    newProprities = {
                        "points": JSON.stringify(element.attrs.points)
                    };
                    elementableType = "Pen";

                } else {
                    if (newElement) {
                        lines++;
                    }
                    var pos = element.getPosition();
                    newProprities = {
                        "x1": element.attrs.points[0] + pos.x,
                        "x2": element.attrs.points[2] + pos.x,
                        "y1": element.attrs.points[1] + pos.y,
                        "y2": element.attrs.points[3] + pos.y
                    };
                    elementableType = "Line";
                }
                break;
            case "Text" :
                if (newElement) {
                    textes++;
                }
                newProprities = {
                    "fontFamily": element.attrs.fontFamily,
                };
                stroke = element.attrs.fontSize;
                elementableType = "Text";
                break;
        }
        var newElementDef = {
            'name': "",
            'description': "",
            'context': "",
            'priority': "P4",
            'state': "ko",
            'strokeWidth': stroke,
            'pos_x': element.attrs.x,
            'pos_y': element.attrs.y
        };

        var newE = {
            "elementableType": elementableType,
            "elementSonDef": newProprities,
            "elementDef": newElementDef,
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
                        'strokeWidth': stroke,
                        'pos_x': element.attrs.x,
                        'pos_y': element.attrs.y,
                        'priority': document.getElementById('priority').value,
                        'state': document.getElementById('state').value,
                    };
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
        elementToUpdate();

        onCurrent = true;
        calque_top.draw();
    }
}

//////////////

function initialize() {

    lines = 0;
    rectangles = 0;
    pens = 0;
    textes = 0;

    document.getElementById("allPages").innerText = nbPage;
    document.getElementById("nowPage").innerText = step_number;
      if (document.getElementById("allPages").innerText != document.getElementById("nowPage").innerText){
    document.getElementById("next").onclick = function () {
        otherPage("next");
    };
  }
    document.getElementById("previous").onclick = function () {
        otherPage("previous");
    };
    document.getElementById("page").onchange = function () {
        var options = Array();
        options["lang"] = current_lang;
        options["page"] = document.getElementById("page").value;
        otherPage("other", $options);
    };

    var langs = document.getElementsByClassName("change_lang");
    for (var i = 0; i < langs.length; i++) {

        document.getElementById(langs[i].id).onclick = function (e) {
            var l = e.currentTarget.id.split("_");
            var options = Array();
            options["lang"] = l[2];
            otherPage("lang", options);
        }
    }

    var canvasDiv = document.getElementById('overlay');
    maxPageWidth = canvasDiv.clientWidth;
    canvasDiv.appendChild(createCanvas(false));
    canvasDiv.appendChild(createCanvas(true));
    canvasDiv.appendChild(createCanvas(true));

    var elementSonDef = Array();

    scene = new Kinetic.Stage({
        container: "overlay",
        width: canvasDiv.clientWidth,
        height: canvasDiv.clientHeight
    });
    maxStageWidth = scene.attrs.width;
    maxStageHeight = scene.attrs.height;

    calque_top = new Kinetic.Layer();
    calque_bottom = new Kinetic.Layer();

    for (var j = 0; j < page.elements.length; j++) {
        var elementInit = page.elements[j];

        switch (elementInit.elementableType) {
            case "Rectangle" :
                mode = "rect";
                changeMode();
                oldMode = mode;
                create(
                    elementInit.elementDef.pos_x,
                    elementInit.elementDef.pos_y,
                    elementSonDef = {
                        "width": elementInit.elementSonDef.width,
                        "height": elementInit.elementSonDef.height,
                        "strokeWidth": elementInit.elementDef.strokeWidth
                    }
                );
                rectangles++;
                break;
            case "Line":
                mode = "line";
                changeMode();
                oldMode = mode;
                create(
                    elementInit.elementDef.pos_x,
                    elementInit.elementDef.pos_y,
                    elementSonDef = {
                        "x1": elementInit.elementSonDef.x1,
                        "x2": elementInit.elementSonDef.x2,
                        "y1": elementInit.elementSonDef.y1,
                        "y2": elementInit.elementSonDef.y2,
                        "strokeWidth": elementInit.elementDef.strokeWidth

                    }
                );
                lines++;
                break;
            case "Text":
                mode = "text";
                changeMode();
                oldMode = mode;
                create(
                    elementInit.elementDef.pos_x,
                    elementInit.elementDef.pos_y,
                    elementSonDef = {
                        "text": elementInit.elementDef.name,
                        "strokeWidth": elementInit.elementDef.strokeWidth,
                        "fontFamily": elementInit.elementSonDef.fontFamily,
                    }
                );
                textes++;
                break;
            case "Pen":
                mode = "pen";
                changeMode();
                oldMode = mode;
                create(
                    elementInit.elementDef.pos_x,
                    elementInit.elementDef.pos_y,
                    elementSonDef = {
                        "points": JSON.parse(elementInit.elementSonDef.points),
                        "strokeWidth": elementInit.elementDef.strokeWidth,
                    }
                );
                pens++;
        }
        element.moveTo(calque_bottom);
        switch (elementInit.elementDef.state) {
            case "ok" :
                element.attrs.stroke = "#bfe5bf";
                break;
            case "ko" :
                element.attrs.stroke = "#ff9a8e";
                break;
            case "inProgress" :
                element.attrs.stroke = "#d4c5f9";
                break;
        }

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

    elementFinish = true;
    element = false;
    mode = "normal";
    changeMode();
    loadFormElement(true);

    oldMode = mode;
}

// Gestion des scénarios

function loadFormElement(step) {
    // if (page.elements[element.attrs.id] != undefined) {
    document.getElementById('form_title').innerText = "";
    document.getElementById('libelle').value = "";
    document.getElementById('description').value = "";
    document.getElementById('context').value = "";
    document.getElementById('priority').value = "";
    document.getElementById('state').value = "ko";
    if (step) {
        document.getElementById('form_title').innerText = page.step.name;
        document.getElementById('libelle').value = page.step.name;
        document.getElementById('description').value = page.step.description;
        document.getElementById('context').value = page.step.context;
        document.getElementById('priority').value = page.step.priority;
        document.getElementById('state').value = page.step.state;
    } else {
        //// PROCESS A REVOIR d'URGENCE ///
        for (var i = 0; i < page.elements.length; i++) {
            if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
                document.getElementById('form_title').innerText = page.elements[i].elementDef.name;
                document.getElementById('libelle').value = page.elements[i].elementDef.name;
                document.getElementById('description').value = page.elements[i].elementDef.description;
                document.getElementById('context').value = page.elements[i].elementDef.context;
                document.getElementById('priority').value = page.elements[i].elementDef.priority;
                // document.getElementById('stroke').value = page.elements[i].elementDef.strokeWidth;
                document.getElementById('state').value = page.elements[i].elementDef.state;
                break;
            }
        }
    }
}

function addElementField() {
    //// PROCESS A REVOIR d'URGENCE ///
    elementToUpdate();
    if (element) {
        for (var i = 0; i < page.elements.length; i++) {
            if (page.elements[i].kinetic.attrs.id == element.attrs.id) {
                var elementDef = page.elements[i].elementDef;
                elementDef.name = document.getElementById('libelle').value;
                elementDef.description = document.getElementById('description').value;
                elementDef.context = document.getElementById('context').value;
                elementDef.priority = document.getElementById('priority').value;
                elementDef.state = document.getElementById('state').value;
                elementDef.strokeWidth = document.getElementById('stroke').value;
                break;
            }
        }
    } else {
        page.step.name = document.getElementById('libelle').value;
        page.step.description = document.getElementById('description').value;
        page.step.context = document.getElementById('context').value;
        page.step.priority = document.getElementById('priority').value;
        page.step.state = document.getElementById('state').value;
    }
}

function otherPage(otherPage, options) {
    element = false;
    var nextPage = step_number;
    if (otherPage == "next") {
        nextPage++;
    } else if (otherPage == "previous") {
        nextPage--;
    }
    confirmSave(nextPage, options);

}

function changeMode() {
    var modes = ["rect", "line", "normal", "text", "pen"];

    for (var i = 0; i < modes.length; i++) {
        document.getElementById(modes[i]).classList.remove("mode--active");
    }
    document.getElementById(mode).classList.add("mode--active");
}

////////////////////
///// KINETIC //////
////////////////////


//////Objets////////
function newImage(x, y, elementSonDef) {
    var h = 1;
    var w = 1;
    var strokeWidth = 8;
    if (elementSonDef != undefined) {
        h = elementSonDef['height'];
        w = elementSonDef['width'];
        strokeWidth = elementSonDef['strokeWidth'];
    }
    var img = new Image(100, 200);
    getImage("no_image_found.png");
    img.src = urlImg;
    return new Kinetic.Image({
        x: x,
        y: y,
        width: 100,
        height: 100,
        image: img,
        stroke: "#ff9a8e",
        strokeWidth: strokeWidth,
        draggable: true,
        id: "img_" + images
    });
}

function newRectangle(x, y, elementSonDef) {
    var h = 1;
    var w = 1;
    var strokeWidth = 8;
    if (elementSonDef != undefined) {
        h = elementSonDef['height'];
        w = elementSonDef['width'];
        strokeWidth = elementSonDef['strokeWidth'];
    }
    return new Kinetic.Rect({
        x: x,
        y: y,
        width: w,
        height: h,
        stroke: "#ff9a8e",
        strokeWidth: strokeWidth,
        draggable: true,
        id: "rect_" + rectangles
    });
}

function newLine(x, y, elementSonDef) {
    var points = [x, y];
    var strokeWidth = 8;
    if (elementSonDef != undefined) {
        points = [
            elementSonDef['x1'],
            elementSonDef['y1'],
            elementSonDef['x2'],
            elementSonDef['y2']
        ];
        strokeWidth = elementSonDef['strokeWidth'];

    }
    ;

    return new Kinetic.Line({
        points: points,
        stroke: "#ff9a8e",
        strokeWidth: strokeWidth,
        id: "line_" + lines,
        selected: false,
        lineCap: "round",
        lineJoin: "round",
        x: 0,
        y: 0,
        draggable: true
    });
}

function newPen(x, y, elementSonDef) {
    var points = [x, y];
    var strokeWidth = 8;
    if (elementSonDef != undefined) {
        points = elementSonDef['points'];
        strokeWidth = elementSonDef['strokeWidth'];
    } else {
        x = 0;
        y = 0;
    }
    ;

    return new Kinetic.Line({
        points: points,
        stroke: "#ff9a8e",
        strokeWidth: strokeWidth,
        id: "pen_" + pens,
        selected: false,
        lineCap: "round",
        lineJoin: "round",
        x: x,
        y: y,
        draggable: true
    });
}

function newText(x, y, elementSonDef) {
    var fontSize = 18;
    var fontFamily = "Raleway";
    var text = "";
    if (elementSonDef != undefined) {
        fontSize = elementSonDef['strokeWidth'];
        text = elementSonDef.text;
        fontFamily = elementSonDef.fontFamily;
    }
    return new Kinetic.Text({
        x: x,
        y: y,
        text: text,
        fontSize: fontSize,
        // textFill: "#ff9a8e",
        stroke: "#ff9a8e",
        strokeWidth: 1,
        fontFamily: fontFamily,
        id: "text_" + textes,
        selected: false,
        draggable: true
    });
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
        case "text":
            element = newText(x, y, elementSonDef);
            nb = textes;
            break;
        case "pen":
            element = newPen(x, y, elementSonDef);
            nb = pens;
            break;
        case "img":
            element = newImage(x, y, elementSonDef);
            nb = images;
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
            changeMode();
        }
    });
    element.on("mouseleave", function () {
        $('.overlay').css('cursor', 'default');
        onElement = false;
        if (elementFinish) {
            mode = oldMode;
            changeMode();
        }
    });
    element.on("dragstart", function () {
        onCurrent = true;
        elementToUpdate();

        calque_top.removeChildren();
        calque_top.draw();
    });


    element.on("dragend", function (e) {


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
    });


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
        case "img":
            element.attrs.width = x - element.attrs.x;
            element.attrs.height = y - element.attrs.y;
            break;
        case "text":
            break;
        case "pen":
            element.setPoints(element.attrs.points.concat([x, y]));
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
    if (document.getElementById("options_text").classList.contains("tg-hidden")) {
        document.getElementById("options_text").classList.remove("tg-hidden");
    }

    selecteurs = [];
    var pos = null;
    if (element.className == "Line") {
        document.getElementById("stroke").value = element.attrs.strokeWidth;

        var points = element.getPoints();
        pos = element.getPosition();
        ///// PEN /////////
        if (points.length > 4) {
            selecteurs.push(build_selector(points[0] + pos.x, points[1] + pos.y, 'start', true));
            selecteurs.push(build_selector(points[points.length - 2] + pos.x, points[points.length - 1] + pos.y, 'end', true));
        }
        //// LINE /////////
        else {
            selecteurs.push(build_selector(points[0] + pos.x, points[1] + pos.y, 'start', true));
            selecteurs.push(build_selector(points[2] + pos.x, points[3] + pos.y, 'end', true));
        }
    }
    else if (element.className == "Rect" || element.className == "Image") {
        document.getElementById("stroke").value = element.attrs.strokeWidth;
        //pos = element.getPosition();
        selecteurs.push(build_selector(element.attrs.x, element.attrs.y, 'topLeft', true));
        selecteurs.push(build_selector(element.attrs.x + element.attrs.width, element.attrs.y, 'topRight', true));
        selecteurs.push(build_selector(element.attrs.x + element.attrs.width, element.attrs.y + element.attrs.height, 'bottomRight', true));
        selecteurs.push(build_selector(element.attrs.x, element.attrs.y + element.attrs.height, 'bottomLeft', true));
    }
    else if (element.className == "Ellipse") {

    }
    else if (element.className == "Text") {
        document.getElementById("stroke").value = element.attrs.fontSize;
        document.getElementById("libelle").focus();
        selecteurs.push(build_selector(element.attrs.x - 15, element.attrs.y - 5, 'topLeft'));
        selecteurs.push(build_selector(element.attrs.x + element.textWidth + 15, element.attrs.y - 5, 'topRight'));
        selecteurs.push(build_selector(element.attrs.x + element.textWidth + 15, element.attrs.y + element.textHeight + 10, 'bottomRight'));
        selecteurs.push(build_selector(element.attrs.x - 15, element.attrs.y + element.textHeight + 10, 'bottomLeft'));

    }
    loadFormElement();
    onCurrent = true;
    $('.overlay').css('cursor', 'default');
}

function build_selector(x, y, name, draggable) {
    var selector = new Kinetic.Circle({
        x: x,
        y: y,
        radius: 6,
        stroke: "#666",
        fill: "#ddd",
        strokeWidth: 6,
        draggable: draggable,
        name: name,
    });

    selector.on("dragmove", function (e) {
        mode = "normal";
        changeMode();
        update(this);
        elementToUpdate();
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
        changeMode();
    });

    selector.on("mouseout", function () {
        $('.overlay').css('cursor', 'default');
        inhibe_selection = false;
        mode = oldMode;
        changeMode();
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
            var points = element.getPoints();
            var position = element.getPosition();
            if (points.length > 4) {
                if (activeAnchor.attrs.name == "end") {
                    element.attrs.points.push(topRight.getX() - position.x, topRight.getY() - position.y);
                } else {
                    element.attrs.points.unshift(topLeft.getX() - position.x, topLeft.getY() - position.y);
                }
                elementToUpdate();
                onCurrent = true;
                calque_top.draw();
                // Aggrandir la ligne ?
            } else {
                if (activeAnchor.attrs.name == "start") {
                    points[0] = topLeft.getX() - position.x;
                    points[1] = topLeft.getY() - position.y;
                    start_point = [topLeft.getX() - position.x, topLeft.getY() - position.y];
                } else {
                    points[2] = topRight.getX() - position.x;
                    points[3] = topRight.getY() - position.y;
                }
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
        case 'Image':
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
    elementToUpdate();

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
    loadFormElement(true);

}

function restore_object() {
    elementToUpdate();

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
    loadFormElement();

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

function confirmSave(otherPage, options) {
    var lang;
    if (options != undefined) {
        lang = "/" + options["lang"];
    } else {
        lang = "/" + current_lang
    }
    if (updatePage) {
        document.getElementById('myModal').classList.remove("tg-hidden");
        document.getElementById('modal-body').innerHTML = "Sauvegarder les modifications ?";
        if (!otherPage) {
            document.getElementById('modalNoSave').classList.add("tg-hidden");
        } else {
            document.getElementById('modalNoSave').classList.remove("tg-hidden");
        }
        document.getElementById('modalSave').onclick = function () {
            if (!otherPage) {
                updateStep();
                document.location = "/scenario/" + scenario_id + "/" + step_number + lang;
            } else {
                if (otherPage > 0 && otherPage <= nbPage) {
                    updateStep();
                    document.location = "/scenario/" + scenario_id + "/" + otherPage + lang;
                }
            }
        };
        document.getElementById('modalNoSave').onclick = function () {
            if (otherPage > 0 && otherPage <= nbPage) {
                document.location = "/scenario/" + scenario_id + "/" + otherPage + lang;
            }
        };
        document.getElementById('modalCancel').onclick = function () {
            modal.style.display = "none";
        };
        var modal = document.getElementById('myModal');
        var span = document.getElementsByClassName("close")[0];
        modal.style.display = "block";
        span.onclick = function () {
            modal.style.display = "none";
        };


        /*var result = confirm("Des changements ont été effectués sur la page, voulez-vous sauvegarder ?");
         if (result) {
         updateStep();
         }*/
    } else {
        if (otherPage) {
            ;
            document.location = "/scenario/" + scenario_id + "/" + otherPage + lang;
        }
    }

}

function elementToUpdate() {
    updatePage = true;
    document.getElementById('validate').disabled = false;
}

///////////////////
/////// AJAX //////
///////////////////

function getScenarioStep() {
    var url = '/getScenarioStep/' + scenario_id + "/" + step_number + "/" + current_lang;
    $.ajax({
        method: 'GET',
        url: url,
        // data: {id: scenario_id},
        async: false,
        dataType: "json",
        success: function (data) {
            page = {
                "url": data[0].url,
                "step": data[0].step,
                "scene": null,
                "calque_bottom": null,
                "calque_top": null,
                "area": null,
                "elementsDeleted": Array(),
                //"priority": data[0].priority,
                "elements": data[0].elements
            };
        },
        error: function () {
            console.log('error getScenarioStep');

        }
    });
}

function getImage(file) {
    var url = '/image/' + file;
    $.ajax({
        method: 'GET',
        url: url,
        async: false,
        // dataType: 'json',
        success: function (data) {
            urlImg = data;
        },
        error: function () {
            console.log('error getImage : ' + file);
        }
    })
}

function getNbSteps() {
    $.ajax({
        method: 'GET',
        url: '/getSteps/' + scenario_id,
        async: false,
        success: function (data) {
            nbPage = data
        },
        error: function () {
            console.log('error getSteps');
        }
    });
}

function updateStep() {
    var datas = Array();
    for (var j = 0; j < page.elements.length; j++) {
        if (page.elements[j].elementDef.id == undefined && page.elements[j].delete) {
            continue;
        }

        datas.push({
            "elementSonDef": page.elements[j].elementSonDef,
            "elementDef": page.elements[j].elementDef,
            "elementableType": page.elements[j].elementableType,
            "delete": page.elements[j].delete
        });
    }
    var secure_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        method: 'POST',
        url: '/scenario/step/update',
        data: {
            _token: secure_token,
            step: page.step,
            elements: datas
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

function initDropZone() {

    // myAwesomeDropzone = new Dropzone("#droparea", { url:"image/upload"});
    // var div = document.createElement("div");
    // div.id = "dropzone";
    // div.classList.add("dropzone");

    var div = document.createElement('form');
    div.classList.add('dropzone');
    div.method = 'post';
    div.action = '/image/upload';
    document.getElementById('droparea').appendChild(div);
    myAwesomeDropzone = new Dropzone(div);

    Dropzone.options.myAwesomeDropzone =
        {
            maxFilesize: 12,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            url: "image/upload",

            success: function (file, response) {
            },
            error: function (file, response) {

                return false;
            }
        };


    // document.getElementById("droparea").appendChild(div);

}


////// RESIZER ///////
function resizeStage() {
    var canvasDiv = document.getElementById('overlay');

    var scalePercentage = canvasDiv.clientWidth / maxPageWidth;

    scene.setAttr('scaleX', scalePercentage);
    scene.setAttr('scaleY', scalePercentage);
    scene.setAttr('width', canvasDiv.clientWidth);
    scene.setAttr('height', canvasDiv.clientHeight);
    // document.getElementById("iframe").style.transform = "scale("+scalePercentage+")";
    // document.getElementById("iframe").style.width = canvasDiv.clientWidth+"px";
    scene.draw();
};

//Sets scale and dimensions of stage to max settings
function maxStageSize() {
    scene.setAttr('scaleX', 1);
    scene.setAttr('scaleY', 1);
    scene.setAttr('width', maxStageWidth);
    scene.setAttr('height', maxStageHeight);
    // document.getElementById("iframe").style.transform = 1;
    // document.getElementById("iframe").style.width = maxStageWidth;
    scene.draw();
};

window.addEventListener('resize', setStageWidth);

function setStageWidth() {
    var canvasDiv = document.getElementById('overlay');
    if (canvasDiv.clientWidth < maxPageWidth) {
        resizeStage();
    } else {
        maxStageSize();
    }
    ;
};
