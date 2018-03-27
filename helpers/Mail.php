<?php
namespace Edogawa\Helpers;

/**
 * Class Mail
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Mail
{

    /**
     * Envoi un mail
     *
     * @param string $email
     * @param string $recepteur
     * @param string $sujet
     * @param string $message
     * @param string $type
     * @return bool
     */
    public function send(string $email, string $recepteur, string $sujet, string $message, string $type = 'html') : bool
    {
        $mail = $recepteur; // Déclaration de l'adresse de destination.
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
        {
            $passage_ligne = "\r\n";
        } else {
            $passage_ligne = "\n";
        }

        if ($type == 'html') {
            $msg = "<html><head></head><body>" . $message . "</body></html>";
        } else {
            $msg = $message;
        }
        //==========

        //=====Création de la boundary
        $boundary = "";
        //==========

        //=====Création du header de l'e-mail.
        $header = "MIME-Version: 1.0" . $passage_ligne;
        $header .= "From: aptvtogo.org<$email>" . $passage_ligne;
        $header .= "Reply-to: aptvtogo.org<$email>" . $passage_ligne;
        $header .= "X-Priority: 1 " . $passage_ligne;
        $header .= "Content-Type: text/html;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
        //==========

        //=====Création du message.
        $message = $passage_ligne . "" . $boundary . $passage_ligne;
        //=====Ajout du message au format texte.
        if ($type == 'text') {
            $header .= "Content-Type: text/plain; charset=\"utf-8\"" . $passage_ligne;
            $header .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
            $message .= $passage_ligne . $msg . $passage_ligne;
        } elseif ($type == 'html') {
            $header .= "Content-Type: text/html; charset=\"utf-8\"" . $passage_ligne;
            $header .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
            $message .= $passage_ligne . $msg . $passage_ligne;
        }
        //==========
        //$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //==========

        //=====Envoi de l'e-mail.
        if (mail($mail, $sujet, $message, $header)) {
            return true;
        } else {
            return false;
        }

        //==========
    }
}
