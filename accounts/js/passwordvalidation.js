// This file checks to make sure that the passwords from the user is correct

document.getElementById("accountform").addEventListener("submit", function (event) {
    let password1 = document.getElementById("password").value;
    let password2 = document.getElementById("password2").value;
    if (password1 !== password2) {
        event.preventDefault();
        document.getElementById("errorMessage").style.display = "block";
    }
});