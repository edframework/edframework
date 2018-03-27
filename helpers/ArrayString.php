<?php
namespace Edogawa\Helpers;

/**
 * Class ArrayString
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class ArrayString
{
    /**
     * Change un tableau en chaine de caractères
     *
     * @param string $divider
     * @param string|array $array
     * @return string
     */
    public static function ArrayToString(string $divider, $array)
    {
        return (is_array($array)) ? implode($divider, $array) : $array;
    }
}

?>
