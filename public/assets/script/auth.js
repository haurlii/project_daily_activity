const API_URL = "http://localhost/Daily_Activity_DAC_Group/backend/api/";
const BASE_URL = "http://localhost/Daily_Activity_DAC_Group/pages/";

async function register() {
  const namadepan = document.getElementById("exampleFirstName").value.trim();
  const namabelakang = document.getElementById("exampleLastName").value.trim();
  const email = document.getElementById("exampleInputEmail").value.trim();
  const password = document.getElementById("exampleInputPassword").value;
  const confirmpassword = document.getElementById("exampleRepeatPassword").value;

  if (password !== confirmpassword) {
    Swal.fire({
      icon: "error",
      title: "Kata sandi tidak cocok!",
      showConfirmButton: false,
      timer: 1500
    });
    return;
  }

  try {
    const response = await fetch(API_URL + "register.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ namadepan, namabelakang, email, password }),
    });
    const result = await response.json();
    Swal.fire({
      icon: result.status === "success" ? "success" : "error",
      title: result.message,
      showConfirmButton: false,
      timer: 1500
    });

    if (result.status === "success") {
      window.location.href = BASE_URL + result.redirect;
    }
  } catch (error) {
    console.error("Error during registration:", error);
    Swal.fire({
      icon: result.status === "success" ? "success" : "error",
      title: result.message,
      showConfirmButton: false,
      timer: 1500
    });
  }
}

async function login() {
  const email = document.getElementById("inputEmail").value;
  const password = document.getElementById("inputPassword").value;

  const response = await fetch(API_URL + "login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email, password }),
  });

  const result = await response.json();

  Swal.fire({
      icon: result.status === "success" ? "success" : "error",
      title: result.message,
      showConfirmButton: false,
      timer: 1500
    });

  if (result.status === "success") {
    localStorage.setItem("email", email);

    window.location.href = BASE_URL + result.redirect;
  }
}

window.register = register;
window.login = login;