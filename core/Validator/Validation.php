<?php
namespace Edogawa\Core\Validator;

use Edogawa\Core\App\App;
use Edogawa\Helpers\FlashMessage;

/**
 * Class Validation
 * @package Edogawa\Core\Validator
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Validation implements ValidationInterface
{
    /**
     * Définit si la validation est acceptée ou non
     *
     * @var bool
     */
    private $isValidate = false;

    /**
     * Regex pour une adresse email
     *
     * @var string
     */
    private $regexEmail = '#^[a-z0-9._\-\+]+@[a-z0-9\._-]{2,}\.[a-z0-9]{2,6}$#';

    /**
     * Regex pour un nombre
     *
     * @var string
     */
    private $regexNumber = '#^[0-9]*$#';

    /**
     * Regex pour un numéro de telephone
     *
     * @var string
     */
    private $regexTel = '#^((\()?(\+)?[0-9]{1,5})(\))?( )?([0-9]{1,4}( |-)?){2,6}$#';

    /**
     * Regex pour une URL de site web
     *
     * @var string
     */
    private $regexSiteWeb = '#^(http\:\/\/|ftp\:\/\/|https\:\/\/){1}([a-zA-Z0-9]{3,4}\.)?([a-zA-Z0-9\.\-\_\:@]){2,}\.(([a-z]{2,4})?)([\/\:]([a-zA-Z0-9\/\?=\-_\:&\(\)]){0,})?$#';

    /**
     * Regex pour la validation de mot de passe
     *
     * @var string
     */
    private $regexPassword = '#.{8,}#';

    /**
     * Valide une adresse mail
     *
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email) : bool
    {
        return preg_match($this->regexEmail, $email);
    }

    /**
     * Valide un nombre
     *
     * @param string $number
     * @return bool
     */
    public function validateNumber(string $number) : bool
    {
        return preg_match($this->regexNumber, $number);
    }

    /**
     * Validate un numéro de telephone
     *
     * @param string $tel
     * @return bool
     */
    public function validateTel(string $tel) : bool
    {
        return preg_match($this->regexTel, $tel);
    }

    /**
     * Valide une URL de site web
     *
     * @param string $site
     * @return bool
     */
    public function validateSiteWeb(string $site) : bool
    {
        return preg_match($this->regexSiteWeb, $site);
    }

    /**
     * Valide un mot de passe
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password) : bool
    {
        return preg_match($this->regexPassword, $password);
    }

    /**
     * Vérifie la contenance en nombre d'un string
     *
     * @param string $text
     * @return bool
     */
    public function verifyIfContainsNumber(string $text) : bool
    {
        return preg_match('#[0-9]+#', $text);
    }

    /**
     * Vérifie la contenance en lettres d'un string
     *
     * @param string $text
     * @return bool
     */
    public function verifyIfContainsLetter(string $text) : bool
    {
        return preg_match('#[a-zA-Z]+#', $text);
    }

    /**
     * Vérifie la contenance en caractères spéciaux d'un string
     *
     * @param string $text
     * @return bool
     */
    public function verifyIfContainsSpecialChars(string $text) : bool
    {
        return preg_match('#[^0-9a-zA-Z_]+#', $text);
    }

    /**
     * Valide avec les paramètres données
     *
     * @param array $fields
     * @return bool
     */
    public function validate(array $fields) : bool
    {
        $error = false;
        $min = 3;
        $max = 255;
        foreach ($fields as $key => $field) {
            $value = $field['value'] ?? "";
            $message = $field['message'] ?? "";
            if (is_string($value) or is_float($value) or is_int($value) or is_bool($value) or is_double($value)){
                $filters = explode('|' , $field['pattern'] ?? "");
                foreach ($filters as $filter) {
                    $under_filter = explode(':' , $filter);
                    switch ($under_filter[0]) {
                        case 'required' : {
                            if (empty($value)){
                                if ($message == ""){
                                    FlashMessage::error($key.' ne doit pas être vide');
                                }else{
                                    FlashMessage::error($message);
                                }
                                $error = true;
                            }
                            break;
                        }
                        case 'min' : {
                            if (isset($under_filter[1])){
                                $min = $under_filter[1];
                            }

                            if (strlen($value) < $min){
                                $error = true;
                                if ($message == ""){
                                    FlashMessage::error($key.' doit contenir au minimum '.$min.' caractères');
                                }else{
                                    FlashMessage::error($message);

                                }
                            }
                            break;
                        }
                        case 'max' : {
                            if (isset($under_filter[1])){
                                $max = $under_filter[1];
                            }

                            if (strlen($value) > $max){
                                $error = true;
                                if ($message == ""){
                                    FlashMessage::error($key.' doit contenir au maximum '.$max.' caractères');
                                }else{
                                    FlashMessage::error($message);

                                }
                            }
                            break;
                        }
                        case 'email' : {
                            if (!empty($value)){
                                if (!$this->validateEmail($value)){
                                    if ($message == ""){
                                        FlashMessage::error($key.' doit être un email');
                                    }else{
                                        FlashMessage::error($message);
                                    }
                                    $error = true;
                                }
                            }
                            break;
                        }
                        case 'equal' : {
                            if (isset($under_filter[1]) and isset($under_filter[2])) {
                                if ($value != $under_filter[2]) {
                                    $error = true;
                                    if ($message == ""){
                                        FlashMessage::error($key . ' doit être équivalent à '.$under_filter[1]);
                                    }else{
                                        FlashMessage::error($message);

                                    }
                                }
                            }else{
                                FlashMessage::warning('Paramètre(s) manquant pour equal');
                            }
                            break;
                        }
                        case 'regex' : {
                            if (isset($under_filter[1])){
                                if (!preg_match($under_filter[1] , $value)){
                                    $error = true;
                                    if ($message == ""){
                                        FlashMessage::error($key . ' incorrect');
                                    }else{
                                        FlashMessage::error($message);

                                    }
                                }
                            }else{
                                FlashMessage::warning('Paramètre(s) manquant pour regex');
                            }
                            break;
                        }
                        case 'function' : {
                            if (isset($under_filter[1])){
                                if (method_exists($this , $under_filter[1])){
                                    if (!$this->{$under_filter[1]}($value)){
                                        $error = true;
                                        if ($message == ""){
                                            FlashMessage::error($key . ' non concordant avec la méthode');
                                        }else{
                                            FlashMessage::error($message);

                                        }
                                    }
                                }
                            }else{
                                FlashMessage::warning('Paramètre(s) manquant pour function');
                            }
                            break;
                        }
                        case 'unique' : {
                            if (isset($under_filter[1]) and isset($under_filter[2]) and isset($under_filter[3])){
                                $nombre = App::query()->select($under_filter[1])
                                    ->champCount('*' , 'nombre')
                                    ->where($under_filter[2] , '=' , $under_filter[3])
                                    ->exec($under_filter[4] ?? DEFAULT_DATABASE)[0]->nombre;
                                if ($nombre > 0){
                                    $error = true;
                                    if ($message == ""){
                                        FlashMessage::error($key.' existe déjà');
                                    }else{
                                        FlashMessage::error($message);
                                    }
                                }
                            }else{
                                FlashMessage::warning('Paramètre(s) manquant pour unique');
                            }
                            break;
                        }
                    }
                }
            }

        }

        $this->isValidate = !$error;
        return !$error;
    }

    /**
     * Vérifie si la méthode validate est validé
     *
     * @return bool
     */
    public function isValidate(): bool
    {
        return $this->isValidate;
    }


}

?>
