const notRegistedLink = document.getElementById('open-register-form');
const toLogInLink = document.getElementById('open-log-in');

const logInForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');

notRegistedLink.addEventListener('click', (e) => {
  e.preventDefault();
  logInForm.style.display = 'none';
  registerForm.style.display = 'flex';
});

toLogInLink.addEventListener('click', (e) => {
  e.preventDefault();
  logInForm.style.display = 'flex';
  registerForm.style.display = 'none';
});
