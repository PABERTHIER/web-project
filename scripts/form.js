function handleKeyPress(e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
    }
}

function openTab(id) {
    var path = '../templates/';
    window.location = path + id + '.html';
}

function send() {
    var error = '';
    if (confirm('Do you want to confirm the registration ?')) {
        register();
        alert('Registration has been validated');
    } else {
        error = 'Error during registration, missing fields to fill !';
        alert(error);
    }
}

function register(){
    $last_name = document.getElementsByName("lastName")[0].value;
    $first_name = document.getElementsByName("firstName")[0].value;
    $birth_date = document.getElementsByName("birthDate")[0].value;
    $mail = document.getElementsByName("mail")[0].value;
    $login = document.getElementsByName("login")[0].value;
    $password = document.getElementsByName("password")[0].value;
    
    $selValue = $('input[name=admin]:checked').val();
    if($selValue == "oui"){$administrateur = "1";}
    else{$administrateur = "0";}

    $string_send = "last_name=" + $last_name + "&first_name=" + $first_name + "&birth_date=" + $birth_date + "&mail=" + $mail + "&login=" + $login + "&password=" + $password + "&admin=" + $administrateur;

    $.ajax({
        url: "../includes/form.php",
        type: "POST",
        data: $string_send,
        success: function (response, status) {

            alert(response);
            window.location = '../templates/homePage.html';

        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });
}
