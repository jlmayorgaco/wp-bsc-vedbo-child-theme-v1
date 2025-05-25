<?php
/* Template Name: Registro personalizado */
get_header();

$registration_error = '';

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
  // Seguridad básica
  $nombres   = sanitize_text_field($_POST['nombres']);
  $email     = sanitize_email($_POST['email']);
  $password  = $_POST['password'];

  // Verifica si ya existe
  if (email_exists($email)) {
    $registration_error = 'Este correo ya está registrado. Intenta iniciar sesión.';
  } elseif (empty($nombres) || empty($email) || empty($password)) {
    $registration_error = 'Por favor completa todos los campos.';
  } else {
    // Separar nombres
    $name_parts = explode(' ', $nombres, 2);
    $first_name = $name_parts[0];
    $last_name  = isset($name_parts[1]) ? $name_parts[1] : '';

    // Crear usuario
    $user_id = wp_insert_user([
      'user_login' => $email,
      'user_pass'  => $password,
      'user_email' => $email,
      'first_name' => $first_name,
      'last_name'  => $last_name,
      'role'       => 'customer',
    ]);

    if (!is_wp_error($user_id)) {
      // Auto-login
      wp_set_current_user($user_id);
      wp_set_auth_cookie($user_id, true);
      do_action('wp_login', $email, get_user_by('ID', $user_id));
      wp_redirect(home_url('/mi-cuenta/'));
      exit;
    } else {
      $registration_error = 'Hubo un error al crear la cuenta. Intenta con otro correo.';
    }
  }
}
?>

<style>
/* Reutilizamos los mismos estilos que la página de ingreso */
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

.form__submit {
  width: 100%;
  padding: 12px;
  background-color: #009688;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1rem;
}

.form__submit:hover {
  background-color: #00796b;
}

.form__error-msg {
  color: #d32f2f;
  font-size: 13px;
  margin-top: 5px;
  display: none;
  text-align: center;
}
</style>

<main class="login">
  <div class="login__container">
    <div class="login__image">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/SIGNIN_COVER_BG.png" alt="Imagen de fondo de registro" />
    </div>

    <div class="login__form">
      <div class="form__image">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/BSC_LOGIN_RAINBOW.png" alt="Decoración arcoíris registro" />
      </div>

      <div class="form__title">
        <h1 class="form__heading">¡Quiero ser parte de BSC!</h1>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bsc__waving-line.png" alt="Línea decorativa" />
      </div>

      <div class="form__fields">
        <?php if (!empty($registration_error)) : ?>
          <div class="form__error"><?php echo esc_html($registration_error); ?></div>
        <?php endif; ?>

        <form name="registerform" id="registerform" method="post" class="form" novalidate>
          <div class="form__field">
            <label for="nombres" class="form__label"><strong>Nombres</strong> y Apellidos</label>
            <input type="text" name="nombres" id="nombres" class="form__input" required />
            <div class="form__error-msg" id="error_nombres"></div>
          </div>

          <div class="form__field">
            <label for="email" class="form__label"><strong>Correo</strong> electrónico</label>
            <input type="email" name="email" id="email" class="form__input" required />
            <div class="form__error-msg" id="error_email"></div>
          </div>

          <div class="form__field">
            <label for="password" class="form__label"><strong>Contraseña</strong></label>
            <input type="password" name="password" id="password" class="form__input" required />
            <div class="form__error-msg" id="error_password"></div>
          </div>

          <div class="form__field form__field--submit">
            <input type="submit" id="register-submit" class="form__submit" value="¡Unirme a Bubbles!" />
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registerform");

  form.addEventListener("submit", function (e) {
    let hasError = false;

    const fields = [
      { id: "nombres", msg: "Por favor ingresa tu nombre completo." },
      { id: "email", msg: "Por favor ingresa un correo válido." },
      { id: "password", msg: "Por favor ingresa una contraseña." }
    ];

    fields.forEach(field => {
      const input = document.getElementById(field.id);
      clearError(input, `error_${field.id}`);

      if (input.value.trim() === "") {
        showError(input, `error_${field.id}`, field.msg);
        hasError = true;
      }

      if (field.id === "email" && input.value.trim() !== "") {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(input.value.trim())) {
          showError(input, `error_${field.id}`, "El correo no tiene un formato válido.");
          hasError = true;
        }
      }
    });

    if (hasError) e.preventDefault();
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