function validateLoginForm() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    if (email === "" || password === "") {
        alert("Por favor, preencha todos os campos.");
        return false;
    }
    return true;
}

function validateRegisterForm() {
    var nome = document.getElementById('nome').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    if (nome === "" || email === "" || password === "") {
        alert("Por favor, preencha todos os campos.");
        return false;
    }
    return true;
}
