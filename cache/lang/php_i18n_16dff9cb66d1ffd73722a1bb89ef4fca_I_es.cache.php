<?php class I {
const page_404_title = 'Página no encontrada';
const login_title = 'Core-o-graphy';
const login_subtitle = 'Projecto de ejemplo';
const login_go_to_register = '¿No tienes cuenta?';
const login_go_to_register_action = '¡Regístrate!';
const login_form_error = 'El usuario o la contraseña no encajan';
const login_form_email_ph = 'Tu dirección de correo';
const login_form_password_ph = 'Tu contraseña';
const login_form_email = 'Email';
const login_form_password = 'Contraseña';
const login_form_submit = 'Enviar';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function I($string, $args=NULL) {
    $return = constant("I::".$string);
    return $args ? vsprintf($return,$args) : $return;
}