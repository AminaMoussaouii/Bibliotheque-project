
document.addEventListener('DOMContentLoaded', function() {
    const element = document.getElementById('password');
    if (element) {
        element.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const showPasswordCheckbox = document.getElementById('showPassword');

            showPasswordCheckbox.addEventListener('change', function() {
           if (showPasswordCheckbox.checked) {
             passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
});
        });
    } else {
        console.error("L'élément avec l'ID 'elementId' n'a pas été trouvé.");
    }
});
//gestion de mot de pass oublié
// Fonction pour vérifier si un utilisateur existe
 /* function findUserByEmail(email) {
    return users.find(user => user.email === email);
  }
  
  // Fonction pour envoyer un email de réinitialisation de mot de passe
  function sendPasswordResetEmail(email) {
    // Ici, vous enverriez un email de réinitialisation de mot de passe à l'utilisateur
    console.log(`Email de réinitialisation envoyé à ${email}`);
  }
  
  // Fonction pour gérer le processus de mot de passe oublié
  function handleForgotPassword() {
    const email = prompt('Veuillez entrer votre adresse e-mail :');
    const user = findUserByEmail(email);
    if (user) {
      sendPasswordResetEmail(email);
      alert('Un email de réinitialisation a été envoyé à votre adresse e-mail.');
    } else {
      alert("Aucun utilisateur trouvé avec cette adresse e-mail.");
    }
  }
  
  // Appel de la fonction pour gérer le mot de passe oublié
  handleForgotPassword();*/
  