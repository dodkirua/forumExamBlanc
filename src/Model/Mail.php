<?php

namespace Dodkirua\Forum\Model;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail{
    private static ?PHPMailer $mailInstance= null;
    private static array $arrayError =  [];


    public function __construct()    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/conf.local.php")){
            require_once $_SERVER['DOCUMENT_ROOT'] . "/conf.local.php";
        }
       else {
            require_once $_SERVER['DOCUMENT_ROOT'] . "/conf.php";
        }
        /**
         * @var String $hostMail
         * @var int $portMail
         * @var String $userMail
         * @var String $passMail
         */
        if (is_null($hostMail) || is_null($passMail) || is_null($userMail) || is_null($portMail) ){
            self::$arrayError[] = "Il manque au moins une variable de connection.";
        }
        else {
            self::$mailInstance = new PHPMailer();
            self::$mailInstance->CharSet = 'UTF-8';
            self::$mailInstance->IsSMTP();
            self::$mailInstance->Host = $hostMail;
            self::$mailInstance->Port = $portMail;
            self::$mailInstance->SMTPAuth = 1;                        //use identification
            self::$mailInstance->SMTPSecure = 'ssl';                //SMTP transfert protocole security
            self::$mailInstance->Username = $userMail;
            self::$mailInstance->Password = $passMail;

            try {
                self::$mailInstance->smtpConnect();
                }

            catch (Exception $ex) {
                self::$arrayError[] = $ex->getMessage();
            }
        }

    }

    /**
     * Avoid instance to be cloned.
     */
    public function __clone() { }
    
    /**
     * Return array of error
     * @return array
     */
    
    public static function getError() : array{
        return self::$arrayError;
    }

    public static function mail(array $array) :  bool    {
        if (is_null(self::$mailInstance)) {
            new self();
        }
        self::$mailInstance->WordWrap = 50;
        if (is_null($array['from'])){
            self::$arrayError[] = 'Manque le from';
            return false;
        }
        else {
            self::$mailInstance->From = $array['from'];
        }
        if (is_null($array['subject'])){
            self::$arrayError[] = 'Manque le subject';
            return false;
        }
        else {
            self::$mailInstance->Subject = $array['subject'];
        }

        if (is_null($array['body'])){
            self::$arrayError[] = 'Manque le message à envoyer';
            return false;
        }
        else {
            if (is_null($array['HTML']) || $array['HTML'] === false){
                self::$mailInstance->IsHTML(false);
                self::$mailInstance->AltBody = $array['body'];
            }
            else{
                self::$mailInstance->IsHTML(true);
                try {
                    self::$mailInstance->msgHTML($array['body']);
                }
                catch (Exception $ex){
                    self::$arrayError[] = $ex->getMessage();
                    return false;
                }
            }
        }
        if (is_null($array['to'])){
            self::$arrayError[] = 'Pas de destinataire au message';
            return false;
        }
        else {
            try {
                foreach ($array['to'] as $to) {
                    if (is_null($to['alias'])){
                        self::$mailInstance->addAddress($to);
                    }
                    else {
                        self::$mailInstance->addAddress($to['mail'],$to['alias']);
                    }
                }
            }
            catch (Exception $ex){
                self::$arrayError[] = $ex->getMessage();
                return false;
            }
        }
        if (!is_null($array['cci'])){
            try {
                foreach ($array['cci'] as $cci) {
                    if (is_null($cci['alias'])){
                        self::$mailInstance->addBCC($cci);
                    }
                    else {
                        self::$mailInstance->addBCC($cci['mail'],$cci['alias']);
                    }
                }
            }
            catch (Exception $ex){
                self::$arrayError[] = $ex->getMessage();
                return false;
            }
        }
        if (!is_null($array['pj'])){
            self::$mailInstance->addAttachment($array['pj']);
        }
    }
}
