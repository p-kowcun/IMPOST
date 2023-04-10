const passwordInput = document.querySelector("#password");
const passwordInput2 = document.querySelector("#password2");
const strengthBar = document.querySelector(".bar");
const warnText = document.querySelector(".warn");

passwordInput.addEventListener("input", () => {
const password = passwordInput.value;
const strength = calculatePasswordStrength(password);


switch (strength) {
    case 1:
      strengthBar.className = "bar one";
      break;
    case 2:
      strengthBar.className = "bar two";
      break;
    case 3:
      strengthBar.className = "bar three";
      break;
    case 4:
      strengthBar.className = "bar four";
      break;
    case 5:
      strengthBar.className = "bar five";
      break;
    default:
      strengthBar.className = "bar";
      break;
  }

strengthBar.style.width = `${strength * 20}%`;

if (strength < 5) {
    passwordInput.setCustomValidity(`Hasło musi zawierać 8 znaków, w tym: 1 wielka litera, 1 mała litera, 1 cyfra i 1 znak specjalny`);
  } else {
    passwordInput.setCustomValidity('');
  }

  checkPasswordsMatch();
});

function calculatePasswordStrength(password) {
let strength = 0;
if (password.length >= 8) strength++;
if (/[a-z]/.test(password)) strength++;
if (/[A-Z]/.test(password)) strength++;
if (/\d+/.test(password)) strength++;
if (/[\W_]/.test(password)) strength++;

return strength;
}

function toggleWarnText(event) {
warnText.style.display = event.getModifierState("CapsLock") ? "block" : "none";
}

passwordInput.addEventListener("keyup", toggleWarnText);
passwordInput2.addEventListener("keyup", toggleWarnText);

function checkPasswordsMatch() {
  if (passwordInput.value !== passwordInput2.value) {
    passwordInput2.setCustomValidity('Hasła nie są takie same');
  } else {
    passwordInput2.setCustomValidity('');
  }
}

passwordInput2.addEventListener("input", () => {
  checkPasswordsMatch();
});
