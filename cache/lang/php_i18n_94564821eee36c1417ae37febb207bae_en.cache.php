<?php class I {
const login_title = 'Core-o-graphy';
const login_subtitle = 'Sample project';
const login_form_error = 'User or password mismatch';
const login_form_email_ph = 'Your email';
const login_form_password_ph = 'Your password';
const login_form_email = 'Email';
const login_form_password = 'Password';
const login_form_submit = 'Submit';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args) ?? $string;
}
}