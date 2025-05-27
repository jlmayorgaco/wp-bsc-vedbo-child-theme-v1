<?php
/* Template Name: Ingreso personalizado */
get_header();

$login_error = isset($_GET['login']) && $_GET['login'] === 'failed';
?>
<style>
.login {
  display: block;
  height: 100%;
}

.login__container {
  display: flex;
  width: 100%;
  min-height: 600px;
  background-color: #fff;
  border-radius: 12px;
  overflow: hidden;
}

.login__image {
  width: 50%;
}

.login__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.login__form {
  width: 50%;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.form__image {
  text-align: center;
  margin-bottom: 5px;
}

.form__image img {
  width: 100%;
  max-width: 250px;
  margin: 0 auto;
  height: auto;
  position: relative;
  left: -10px;
}

.form__title {
  text-align: center;
  margin-bottom: 30px;
}
.form__title img {
  width: 60px;
}

.form__heading {
  margin-bottom: 10px;
  font-size: 22px;
  font-weight: 600;
  letter-spacing: 2px;
}

.form__fields {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form__field {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.form__label {
  font-weight: regular;
  font-size: 16px;
  margin-bottom: 5px;
  letter-spacing: 2px;
  text-align: center;
}

.form__label strong {
  font-weight: 600;
}

.form__input {
  font-size: 14px;
  width: 350px;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-radius: 22px;
  height: 32px;
  margin: 0 auto;
}

.form__input--invalid {
  border-color: #d32f2f;
}

.form__checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form__checkbox {
  margin: 0px;
}

.form__submit {
  width: 100%;
  padding: 12px;
  background-color: #3f51b5;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1rem;
}

.form__submit:hover {
  background-color: #303f9f;
}

.form__error {
  background-color: #f8d7da;
  color: #842029;
  padding: 1rem;
  border-left: 4px solid #f5c2c7;
  margin-bottom: 1rem;
  border-radius: 4px;
}

.form__error-msg {
  color: #d32f2f;
  font-size: 17px;
  margin-top: 5px;
  display: none;
  text-align: center;
}

.form__links {
  text-align: center;
  margin-top: 10px;
}

.form__link {
  color:rgb(97, 97, 97);
  text-decoration: underline;
  font-style: italic;
  font-size: 14px;
    letter-spacing: 2px;
}

.form__link:hover {
  font-weight: bold;
    color:rgb(97, 97, 97);
}
.form__field--remember-me {
  display: flex;
  width: 100%;
  justify-content: center;
  align-items: center;
  letter-spacing: 2px;
}

.form__field--submit {
  display: flex;
  width: fit-content;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
  padding: 10px 30px !important;
  font-size: 17px !important;
}
.form__field--submit input:hover {
  color: var(--color--black) !important;
  background-color:var(--color--pink)
}
</style>

<main class="login">
  <div class="login__container">
    <div class="login__image">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/SIGNIN_COVER_BG.png" alt="Imagen de fondo de ingreso" />
    </div>

    <div class="login__form">
      <div class="form__image">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/BSC_LOGIN_RAINBOW.png" alt="Decoración arcoíris login" />
      </div>

      <div class="form__title">
        <h1 class="form__heading">¡Iniciar sesión!</h1>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bsc__waving-line.png" alt="Línea decorativa" />
      </div>

      <div class="form__fields">
        <?php if ($login_error): ?>
          <div class="form__error">⚠️ Credenciales inválidas. Intenta de nuevo.</div>
        <?php endif; ?>

        <form name="loginform" id="loginform" action="<?php echo esc_url(wp_login_url()); ?>" method="post" class="form">
          <div class="form__field form__field--username">
            <label for="user_login" class="form__label"><strong>Correo</strong> registrado</label>
            <input type="text" name="log" id="user_login" class="form__input" required />
            <div class="form__error-msg" id="error_user_login"></div>
          </div>

          <div class="form__field form__field--password">
            <label for="user_pass" class="form__label"><strong>Contraseña</strong> registrada</label>
            <input type="password" name="pwd" id="user_pass" class="form__input" required />
            <div class="form__error-msg" id="error_user_pass"></div>
          </div>

          <div class="form__field form__field--remember-me">
            <label class="form__checkbox-label">
              <input name="rememberme" type="checkbox" id="rememberme" class="form__checkbox" value="forever" />
              Recordar datos
            </label>
          </div>

          <div class="form__field form__field--submit">
            <input type="submit" name="wp-submit" id="wp-submit" style="padding: 10px 30px; font-size:17px;" class="form__submit btn btn--primary" value="¡ Iniciar sesión !" />
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/mi-cuenta/')); ?>" />
          </div>

          <div class="form__links">
            <a href="<?php echo wp_lostpassword_url(); ?>" class="form__link">¿Olvidaste tu contraseña?</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("loginform");
  const userLogin = document.getElementById("user_login");
  const userPass = document.getElementById("user_pass");

  form.addEventListener("submit", function (e) {
    let hasError = false;

    clearError(userLogin, "error_user_login");
    clearError(userPass, "error_user_pass");

    if (userLogin.value.trim() === "") {
      showError(userLogin, "error_user_login", "Por favor ingresa tu usuario o correo.");
      hasError = true;
    }

    if (userPass.value.trim() === "") {
      showError(userPass, "error_user_pass", "Por favor ingresa tu contraseña.");
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    }
  });

  function showError(input, errorId, message) {
    input.classList.add("form__input--invalid");
    const errorDiv = document.getElementById(errorId);
    errorDiv.textContent = message;
    errorDiv.style.display = "block";
  }

  function clearError(input, errorId) {
    input.classList.remove("form__input--invalid");
    const errorDiv = document.getElementById(errorId);
    errorDiv.textContent = "";
    errorDiv.style.display = "none";
  }
});
</script>

<?php get_footer(); ?>
