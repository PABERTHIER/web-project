function openTab(id) {
    var path = '../templates/';
    window.location = path + id + '.html';
}

function handleKeyPress(e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        addTasks();
        setTimeout(() => {

        }, 1000); reset();
    }
}

function showProjects() {

    $string_send = "user=" + getCookie("username");

    $.ajax({
        url: "../includes/homePage.php",
        type: "POST",
        data: $string_send,
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

function reset() {
    document.getElementById('task-name').value = '';
    document.getElementById('textarea-tasks').value = '';
}

function loadTasks() {

    var wrapper = document.getElementById("conteneur");
    var myHTML = '';

    $project = document.getElementById("project");
    $value = $project.value;

    $string_send = { "project_sel": $value };

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/tasks.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            if (response != "") {
                $.each(response, function (i, obj) {
                    var nom = obj.Nom;
                    var content = obj.Contenue;
                    var vote = obj.Vote;
                    var string_vote = "'" + String(nom) + "', '" + String(vote) + "'";
                    var importance = obj.Importance;
                    var identity = "'" + String(nom) + "'";
                    myHTML += '<div class="element"><h1 class="task-title-show">' + nom + '</h1><br/><br/><div class="element-child"><div class="element-text">' + content + '</div><div class="button-content" ><button class="button-task-show" onclick="vote(' + string_vote + ')">' + vote + '</button><button class="button-task-show" onclick="importance(' + identity + ')">' + importance + '</button><button class="button-task-show-delete" onclick="deleteTask(' + identity + ')">X</button></div></div></div>';
                    wrapper.innerHTML = myHTML;
                });
            } else {
                myHTML += '<h1>No Task Here !!!</h1>';
                wrapper.innerHTML = myHTML;
            }
        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });

}


function addTask() {
    $project = document.getElementById("project").value;
    $task_name = document.getElementsByName("name-task")[0].value;
    $task_content = document.getElementsByName("textarea-tasks")[0].value;

    $string_send = { "project_sel": $project, "task_name": $task_name, "task_content": $task_content };

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/add_task.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            console.log(response);
        },
        error: function (result, status, error) {
            console.log("No response : " + status);
        }
    });
}

setInterval(loadTasks, 500);


function deleteTask(parameter) {
    $string_send = { "task_sel": parameter };

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/del_task.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            console.log(response);
        },
        error: function (result, status, error) {
            console.log("No response : " + status);
        }
    });
}


function vote(nom_task, val_param) {
    val_param = String(parseInt(val_param) + 1);
    $string_send = { "task_sel": nom_task, "type": "Vote", "value": val_param };

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/update_task.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            console.log(response);
        },
        error: function (result, status, error) {
            console.log("No response : " + status);
        }
    });
}

function importance(nom_task) {
    var importanceTask = prompt("Entrer l\'importance de la tâche sur 10:");

    $string_send = { "task_sel": nom_task, "type": "Importance", "value": importanceTask };

    // Transforme l'objet JavaScript en chaîne de caractères JSON
    $text_string = JSON.stringify($string_send);

    $.ajax({
        url: "../includes/update_task.php",
        type: "POST",
        dataType: "json",
        contentType: 'application/json',
        data: $text_string,
        processData: false,
        success: function (response, status) {
            console.log(response);
        },
        error: function (result, status, error) {
            console.log("No response : " + status);
        }
    });
}
