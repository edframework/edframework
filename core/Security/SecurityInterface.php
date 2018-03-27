<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 14:59
 */

namespace Edogawa\Core\Security;

/**
 * Interface SecurityInterface
 * @package Edogawa\Core\Security
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface SecurityInterface
{
    /**
     * Prévient contre la faille CSRF
     *
     * @return bool
     */
    public function preventCSRF() : bool;

    /**
     * Champ donnant le token
     *
     * @return string
     */
    public function CSRF();

    /**
     * Prévient la faille CRLF pour empêcher les retours chariots
     * @param string $string
     * @return string
     */
    public function preventCRLF(string $string) : string;

    /**
     * Prévient contre la faille SQLInjection
     *
     * @param string $string
     * @return string
     */
    public function preventSQLInjection(string $string) : string;

    /**
     * Prévient contre la faille XSS
     *
     * @param string $string
     * @return string
     */
    public function preventXSS(string $string) : string;

    /**
     * Prévient contre les failles XSS et InjectionSQL
     *
     * @param string $string
     * @return string
     */
    public function prevent(string $string) : string;
}