document.getElementById("loginForm").addEventListener("submit", function (e) {
    const username = document.querySelector("input[name='username']").value;
    const password = document.querySelector("input[name='password']").value;

    if (username.trim() === "" || password.trim() === "") {
        e.preventDefault();
        alert("Username dan Password tidak boleh kosong!");
    }
});
