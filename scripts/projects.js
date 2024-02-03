function openTab(id) {
    var path = '../templates/';
    window.location = path + id + '.html';
}

function showProjects() {

    $.ajax({
        url: "../includes/projects.php",
        type: "POST",
        success: function (response, status) {

            var x = response;

            var options = x.split(",");
        
            var select = document.getElementById('project');
            for (var i = 0; i < options.length; i++) {
                select.options[i] = new Option(options[i], options[i]);
            }

        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });
}

function handleKeyPress(e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        send();
    }
}

function create() {

    $admin = getCookie("admin");
    $project = prompt("Enter name project to create:");

    $string_send = {"project_sel":$project, "admin":$admin};

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/create_project.php",
        dataType: "json",
        contentType: 'application/json',
        type: "POST",
        data: $text_string,
        processData: false,
        success: function (response, status) {
            alert(response.result);
        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });
}

function createTable() {
    var myHTML = '';
    var wrapper = document.getElementById("username");

    $.ajax({
        url: "../includes/load_names.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        processData: false,
        success: function (response, status) {
            if (response != "") {
                $.each(response, function (i, obj) {
                    var nom = obj.Nom;
                    var prenom = obj.Prenom;
                    myHTML += '<div style="width:20%"><p><label><input type="checkbox" id="Check" name='+nom+' style="outline: 1px solid black; width: 18px; height: 18px;">'+nom + ' ' + prenom +'</label></p></div>';
                    wrapper.innerHTML = myHTML;
                });
            } else {
                myHTML += '<h1>No Users !!!</h1>';
                wrapper.innerHTML = myHTML;
            }
        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });
}

function check() {

    var elms = document.querySelectorAll("[id='Check']");

    for(var i = 0; i < elms.length; i++) 
        elms[i].checked = false;

    $project = document.getElementById("project");
    $value = $project.value;

    $string_send = { "project_sel": $value };

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/load_manage.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            if (response != "") {
                $.each(response, function (i, obj) {
                    var nom = obj.Nom;
                    document.getElementsByName(nom)[0].checked = true;
                });
            } else {
                alert("Warning : No users assign");
            }
        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });
}


function send() {

    $project = document.getElementById("project");
    $value = $project.value;

    $string_send = { "project_sel": $value };

    var elms = document.querySelectorAll("[id='Check']");

    var true_tab = [];
    var false_tab = [];

    for(var i = 0; i < elms.length; i++) 
        if(elms[i].checked == true){
             true_tab.push(elms[i].name);
        }else{
             false_tab.push(elms[i].name);
        }

    $string_send['state_true'] = true_tab;
    $string_send['state_false'] = false_tab;

    console.log($string_send);
    
    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/upload_manage.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            console.log(response);
        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });

}