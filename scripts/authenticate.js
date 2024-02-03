function cancel(id, type) {

    if (type === 'none') {
        document.getElementById(id).style.display = 'none';
    } else if (type === 'block') {
        document.getElementById(id).style.display = 'block';
    }
}

function handleKeyPress(e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        login();
    }
}

function login() {
    $user = document.getElementById("username").value;
    $passwd = document.getElementById("password").value;
    $string_send = "user=" + $user + "&password=" + $passwd;
    $admin = null;

    $.ajax({
        url: "../includes/authenticate.php",
        type: "POST",
        data: $string_send,
        success: function (response, status) {
            if (response == 0) {
                $admin = false;
            }
            else if (response == 1) {
                $admin = true;
            }
            else { alert(response); };

            if ($admin != null) {
                addUserCookie($user, $passwd, $admin, 365);
                window.location = '../templates/homePage.html';
            }

        },
        error: function (result, status, error) {
            alert("Error : impossible to connect database");
        }
    });

}
