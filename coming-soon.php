<?php
// coming-soon.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Pronto regresaremos! - Bubbles Skin Care</title>

    <style>
        :root {
            --color--pink: #f7c0cd;
            --color--black: #333333;
            --font-family: 'Arial', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--color--pink);
            font-family: var(--font-family);
            color: var(--color--black);
        }

        .coming-soon-container {
            text-align: center;
            max-width: 800px;
            padding: 20px;
        }

        .coming-soon-container img {
            max-width: 300px;
            height: auto;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        p {
            font-size: 1.2rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .notify-button {
            background-color: var(--color--black);
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .notify-button:hover {
            background-color: #000;
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/BSC_Checkout_Logo.png" alt="Bubbles Skin Care">
        <h1>¡Pronto regresaremos!</h1>
        <p>Nuestra tienda está en mantenimiento. Muy pronto volveremos con más K-Beauty para ti.</p>
    </div>
</body>
</html>