<?php
namespace Edogawa\Core\Security;

/**
 * Class Cryptage
 * @package Edogawa\Core\Security
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Cryptage implements CryptageInterface
{

    /**
     * Triple cryptage d'un mot de passe successivement avec le sha1 suivi du md5 suivi de nouveau sha1
     *
     * @param string $value
     * @return string
     */
    public function crypt(string $value) : string
    {
        return sha1(md5(sha1($value)));
    }

    /**
     * Crypte avec le bcrypt
     *
     * @param string $value
     * @return string
     */
    public function bcrypt(string $value) : string
    {
        return bcrypt($value);
    }

    /**
     * Crypte un mot de passe avec le sha512
     *
     * @param string $string
     * @return string
     */
    public function sha512(string $string) : string
    {
        return hash("SHA_512", SHAKEY . $string . SHA_KEY);
    }

    /**
     * Crypte un mot de passe avec le sha256
     *
     * @param string $string
     * @return string
     */
    public function sha256(string $string) : string
    {
        return hash("sha256", SHA_KEY . $string . SHA_KEY);
    }

}
