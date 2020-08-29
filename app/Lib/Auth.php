<?php

/**
 * Auth Class
 * @author Juan Bautista main developer
 * @package Lib
 */

use Firebase\JWT\JWT;

class Auth
{
    private static $secret_key = __SECRET_KEY__;
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public function __construct()
    {
    }

    /**
     * SignIn
     * (IN) This method is responsible for starting and generating the session token
     * (ES) Este método se encarga de iniciar y generar el token de sesión
     * @access public
     * @param array $data
     * Array que contiene toda la información de sesión del usuario
     * @return string
     */
    public static function SignIn($data): string
    {
        $time = time();

        $token = array(
            'exp' => $time + (60 * 60),
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }

    /**
     * Check
     * (IN) This method is responsible for validating the session token
     * (ES) Este método se encarga de validar el token de sesion
     * @access public
     * @param string $token
     * Contiene el token codificado
     * @return bool
     */
    public static function Check(string $token): bool
    {
        try {
            if (empty($token)) {
                throw new Exception("Invalid token supplied.");
                //return false;
            } else {
                $decode = JWT::decode(
                    $token,
                    self::$secret_key,
                    self::$encrypt
                );

                if ($decode->aud !== self::Aud()) {
                    throw new Exception("Invalid user logged in.");
                    //return false;
                } else {
                    return true;
                }
            }
        } catch (Exception $e) {
            return false;
            die($e->getMessage());
        }
    }

    /**
     * GetData
     * (IN) This method is responsible for obtaining the token information
     * decodes the data element
     * (ES) Este método se encarga de obtener la información del token
     * decofica el elemento data
     * @access public
     * @param string $token
     * Contiene el token codificado
     * @return object
     */
    public static function GetData(string $token): object
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }

    /**
     * Aud
     * (IN)This method is responsible for obtaining the host information
     * client that communicates to the application and returns the information
     * encrypted.
     * (ES) Este método se encarga de obtener la información del host
     * cliente que se comunica a la aplicación y retorma la información
     * encriptada.
     * @access private
     * @return string
     */
    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}
