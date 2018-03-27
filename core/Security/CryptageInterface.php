<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 15:01
 */

namespace Edogawa\Core\Security;

/**
 * Interface CryptageInterface
 * @package Edogawa\Core\Security
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface CryptageInterface
{
    /**
     * Triple cryptage d'un mot de passe successivement avec le sha1 suivi du md5 suivi de nouveau sha1
     *
     * @param string $value
     * @return string
     */
    public function crypt(string $value) : string;

    /**
     * Crypte avec le bcrypt
     *
     * @param string $value
     * @return string
     */
    public function bcrypt(string $value) : string;

    /**
     * Crypte un mot de passe avec le sha512
     *
     * @param string $salt
     * @return string
     */
    public function sha512(string $salt) : string;

    /**
     * Crypte un mot de passe avec le sha256
     *
     * @param string $string
     * @return string
     */
    public function sha256(string $string) : string;
}