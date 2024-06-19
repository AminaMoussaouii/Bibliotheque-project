document.getElementById('togglePassword').addEventListener('click', function () {
  var passwordInput = document.getElementById('password');
  var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordInput.setAttribute('type', type);
});

  