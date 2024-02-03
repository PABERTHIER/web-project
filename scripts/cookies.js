function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function addUserCookie(username, password, admin, exdays) {
  setCookie("username", username, exdays);
  setCookie("password", password, exdays);
  setCookie("admin", admin, exdays);
}

function checkUserCookie() {
  var user = getCookie("username");
  if (user == "") {
    document.location.href = "../templates/authenticate.html";
  }
}

function checkAdmin() {
  var admin = getCookie("admin");
  if (admin == "false") {
    alert("You need to be Admin");
  } else {
    openTab(id = 'form');
  }
}

function showLogin() {
  var user = getCookie("username");
  var myHTML = '';
  var wrapper = document.getElementById("login");
  myHTML += '<span>' + user + '</span>';
  wrapper.innerHTML = myHTML;
}
