<?php
namespace Edogawa\Core\Security;
use Edogawa\Core\Requete\Requete;
use Edogawa\Core\Session\Session;

/**
 * Class Security
 * @package Edogawa\Core\Security
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Security implements SecurityInterface
{

    /**
     * Prévient contre la faille CSRF
     *
     * @return bool
     */
    public function preventCSRF() : bool
    {
        if (Session::get('token') === Requete::request('token')){
            return true;
        }
        return false;
    }

    /**
     * Champ donnant le token
     */
    public function CSRF()
    {
        echo "<input type='hidden' name='token' value='".Session::get("token")."' />";
    }

    /**
     * Prévient la faille CRLF pour empêcher les retours chariots
     * @param string $string
     * @return string
     */
    public function preventCRLF(string $string) : string
    {
        return str_replace(array("\n","\r" , PHP_EOL) , "" , $string);
    }

    /**
     * Prévient contre la faille SQLInjection
     *
     * @param string $string
     * @return string
     */
    public function preventSQLInjection(string $string) : string
    {
        return addslashes(trim($string));
    }

    /**
     * Prévient contre la faille XSS
     *
     * @param string $string
     * @return string
     */
    public function preventXSS(string $string) : string
    {
        return htmlspecialchars(trim($string));
    }

    /**
     * Prévient contre les failles XSS et InjectionSQL
     *
     * @param string $string
     * @return string
     */
    public function prevent(string $string) : string
    {
        return $this->preventSQLInjection($this->preventXSS($string));
    }
}

?>
