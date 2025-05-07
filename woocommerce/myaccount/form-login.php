<?php defined( 'ABSPATH' ) || exit; ?>

<div class="bsc bsc__login custom-login-bg">
	<div class="custom-login-container">
	<div class="login-card">
		<img class="rainbow-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/arcoirisProductosPDRN.png" alt="Rainbow">

		<div class="login__title">
			<h2>Iniciar sesión</h2>
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bsc__waving-line.png" alt="bsc__waving-line.png>
		</div>
		

		<form class="woocommerce-form woocommerce-form-login custom-form" method="post">
		<?php do_action( 'woocommerce_login_form_start' ); ?>

		<p class="woocommerce-form-row">
			<label for="username">Correo registrado</label>
			<input type="text" name="username" id="username" required>
		</p>

		<p class="woocommerce-form-row">
			<label for="password">Clave registrada</label>
			<input type="password" name="password" id="password" required>
		</p>

		<p class="woocommerce-form-row">
			<input type="checkbox" name="rememberme" id="rememberme" value="forever">
			<label for="rememberme">Recordar datos</label>
		</p>

		<p class="woocommerce-form-row">
			<button type="submit" class="button login-button">¡Iniciar sesión!</button>
		</p>

		<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>

		<p class="lost-password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Olvidé mi contraseña</a>
		</p>
	</div>
	</div>
</div>

<style>

body.page-id-11512 .elementor-widget-container {
  padding: 0 !important;
  margin: 0 !important;
}

.custom-login-bg {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  background: url('<?php echo get_stylesheet_directory_uri(); ?>/images/BSC_LOGIN_BG.jpg') center/cover no-repeat;

}
.custom-login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  backdrop-filter: blur(50px);
}

.login-card {
  background: rgba(255, 255, 255, 0.0);
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.0);
  text-align: center;
  max-width: 400px;

}

.rainbow-logo {
  width:200px;
  margin-bottom: 10px;
}

.login__title h2 {
	color: var(--site-heading-color);
  	font-family: "Helvetica", sans-serif;
    font-size: 23px;
    font-weight: 400;
    letter-spacing: 2.5px;
	font-weight: 700;

	margin-bottom: 5px;
}

.login__title img {
  width: 75px;
  margin-bottom: 20px;
}

.custom-form input[type="text"], 
.custom-form input[type="password"] {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.login-button {
  background: #333;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.login-button:hover {
  background: #555;
}

.lost-password a {
  font-size: 14px;
  color: #555;
  text-decoration: none;
}

</style>