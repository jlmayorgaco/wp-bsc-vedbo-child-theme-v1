<?php
class EmailService {
    public static function sendWelcomeEmail($email, $name, $password) {
        wp_mail(
            $email,
            'Welcome!',
            "Hello $name,\nYour password is $password.",
            ['Content-Type: text/html; charset=UTF-8']
        );
    }
}
