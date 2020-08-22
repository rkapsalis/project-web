$(document).ready(function() {
    $(".form-wrapper .button").click(function() {
        var button = $(this);
        var currentSection = button.parents(".section");
        var currentSectionIndex = currentSection.index();
        var headerSection = $('.steps li').eq(currentSectionIndex);
        currentSection.removeClass("is-active").next().addClass("is-active");
        headerSection.removeClass("is-active").next().addClass("is-active");

        $(".form-wrapper").submit(function(e) {
            e.preventDefault();
        });

        if (currentSectionIndex === 3) {
            $(document).find(".form-wrapper .section").first().addClass("is-active");
            $(document).find(".steps li").first().addClass("is-active");
        }
    });
});
//---------------------------------------------------------create map-------------------------------------------------------
let mymap = L.map("mapid");
let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
let osmAttrib =
    'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
let osm = new L.TileLayer(osmUrl, {
    attribution: osmAttrib
});
mymap.addLayer(osm);
mymap.setView([38.246242, 21.7350847], 16);
var center = [38.230462, 21.753150];
var circle = L.circle(center, {
    color: 'red',
    fillOpacity: 0,
    radius: 10000
}).addTo(mymap);

var editableLayers = new L.FeatureGroup();
mymap.addLayer(editableLayers);

var drawPluginOptions = {
    position: 'topright',
    draw: {
        polygon: false,
        polyline: false,
        circle: false,
        rectangle: true,
        marker: false
    },
    edit: {
        featureGroup: editableLayers,
        remove: true
    }
};
var drawControl = new L.Control.Draw(drawPluginOptions);
mymap.addControl(drawControl);
//---------------------------------------------get excluded areas-------------------------------------------
mymap.on('draw:created', function(e) {
    var type = e.layerType,
        layer = e.layer;
    editableLayers.addLayer(layer);
    // Iterate all drawn things and JSON them into the areas input
    var shape = editableLayers.toGeoJSON().features;
    var shape_for_db = JSON.stringify(shape);
    var rectanglesLength = shape.length;
    var coords = [];
    for (var i = 0; i < rectanglesLength; i++) {
        var rectangle = new Object();
        rectangle.p1 = shape[i].geometry.coordinates[0][0];
        rectangle.p2 = shape[i].geometry.coordinates[0][1];
        rectangle.p3 = shape[i].geometry.coordinates[0][2];
        rectangle.p4 = shape[i].geometry.coordinates[0][3];
        coords.push(rectangle);
    }
    document.getElementById('cens').value = JSON.stringify(coords);
    console.log(shape);
    console.log(coords);
});

let marker = L.marker([38.246242, 21.7350847]);
marker.addTo(mymap);
marker.bindPopup("<b>Πλατεία Γεωργίου</b>");

//----------------------------------------------------------file upload-----------------------------------------------------------
(function() {

    // getElementById
    function $id(id) {
        return document.getElementById(id);
    }
    // output information
    function Output(msg) {
        var m = $id("messages");
        m.innerHTML = msg + m.innerHTML;
    }
    // file drag hover
    function FileDragHover(e) {
        e.stopPropagation();
        e.preventDefault();
        e.target.className = (e.type == "dragover" ? "hover" : "");
        // look at removal of class on icon
    }
    // file selection-it is called when one or more files is chosen or dropped
    function FileSelectHandler(e) {
        // cancel event and hover styling
        FileDragHover(e);
        // fetch FileList object
        var files = e.target.files || e.dataTransfer.files;
        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            ParseFile(f);
            UploadFile(f);
        }
    }

    // output file information
    function ParseFile(file) {
        Output(
            "File name: " + file.name
        );

        // display text
        if (file.type.indexOf("text") == 0) {
            var reader = new FileReader();
            reader.onload = function(e) {
                Output(
                    "<p>" + file.name + ":</p><pre>" +
                    e.target.result.replace(/</g, "&lt;").replace(/>/g, "&gt;") +
                    "</pre>"
                );
            }
            reader.readAsText(file);
        }
    }

    function UploadFile(file) {
        var xhr = new XMLHttpRequest();
        var validExtensions = ['json']; //array of valid extensions
        var fileName = file.name;
        var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        var flag = true;
        console.log(file.name);
        if ($.inArray(fileNameExt, validExtensions) == -1) {
            alert("Invalid file type");
            $("#yourElem").uploadifyCancel(q);
            flag = false;
        }

        if (xhr.upload && flag == true) {
            // create progress bar

            var o = $id("progress");
            var progress = o.appendChild(document.createElement("p"));
            progress.appendChild(document.createTextNode("Uploading..."));
            // progress bar
            xhr.upload.addEventListener("progress", function(e) {
                var pc = parseInt(100 - (e.loaded / e.total * 100));
                var percent = e.loaded / e.total;
                var perc = parseInt(percent * 100)
                $id("status").innerHTML = perc + "% uploaded... please wait";
                progress.style.backgroundPosition = pc + "% 0";
            }, false);
            // file received/failed
            xhr.onreadystatechange = function(e) {
                if (xhr.readyState == 4) { //The operation is complete
                    progress.className = (xhr.status == 200 ? "success" : "failure");                   
                }
            };

            // start upload
            document.getElementById("submitbutton").addEventListener("click", function() {
                console.log($id('submitbutton'));
                console.log($id('cens'));
                var cens = $id('cens').value;
                //var params = "file="+file"&cens="+cens ;
                var data = new FormData();
                data.append("file", file);
                data.append("cens", cens);
                xhr.open("POST", $id("upload2").action, true);
                console.log(file);
                console.log(cens);
                //xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.setRequestHeader("Cache-Control", "no-cache, no-store, must-revalidate");
                xhr.setRequestHeader("X-FILENAME", file.name);
                //xhr.send("file=" + file + "&cens="+ cens);
                xhr.send(data);
                console.log(xhr.responseText);
            });
        } else {
            alert("Error! Wrong file type, please try again.");
        }
    }

    // initialize
    function Init() {
        var fileselect = $id("fileselect"),
            filedrag = $id("filedrag"),
            submitbutton = $id("submitbutton");
        console.log("Upload Initialised");
        // file select
        fileselect.addEventListener("change", FileSelectHandler, false);
        // is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {
            // file drop
            filedrag.addEventListener("dragover", FileDragHover, false);
            filedrag.addEventListener("dragleave", FileDragHover, false);
            filedrag.addEventListener("drop", FileSelectHandler, false);
            //filedrag.style.display = "block";
        }
    }

    // call initialization file
    if (window.File && window.FileList && window.FileReader) {
        Init();
    }
})();