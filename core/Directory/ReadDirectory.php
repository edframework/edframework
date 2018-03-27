<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 14/12/2017
 * Time: 11:37
 */

namespace Edogawa\Core\Directory;


/**
 * Classe ReadDirectory
 *
 * Fournit des méthodes statiques pour lire un dossier et créer un html correspondant à l'arborescence du dossier
 *
 * @package Edogawa\Core\Directory
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class ReadDirectory
{

    /**
     * Lire un dossier
     *
     * @param string $path
     * @return array
     */
    public static function read(string $path)
    {
        return self::scanDir($path);
    }

    /**
     * Convertis en HTML un dossier
     *
     * @param array $tab
     * @return string
     */
    public static function convertToHtml(array $tab)
    {
        return self::showHtml($tab);
    }

    /**
     * Agence les éléments du dossier
     *
     * @param array $tab
     * @return string
     */
    private static function showHtml(array $tab)
    {
        return self::makeList($tab, "ul");
    }

    /**
     * Générer la liste
     *
     * @param array $tab
     * @param string $encadrer
     * @return string
     */
    private static function makeList(array $tab, string $encadrer = "")
    {
        $res = "";
        if (!empty($encadrer)) {
            $res .= "<$encadrer style='list-style-type : none;'>";
        } else {
            $res .= "<$encadrer style='list-style-type : none;'>";
        }
        foreach ($tab as $item) {
            $res .= "<li><i class=\"{$item['icon']}\"></i> {$item['nom']}</li>";
            if (isset($item['contenu'])) {
                if (!empty($item['contenu'])) {
                    $res .= self::makeList($item['contenu'], "ul");
                }
            }
        }
        if (!empty($encadrer)) {
            $res .= "</$encadrer>";
        }
        return $res;
    }

    /**
     * Scanner un dossier
     *
     * @param string $path
     * @return array
     */
    private static function scanDir(string $path)
    {
        $d = opendir($path);
        $contenu = [];
        while ($value = readdir($d)) {
            if (!in_array($value, ['.', '..'])) {
                if (is_dir($path . '/' . $value)) {
                    $contenu[] = [
                        'nom' => $value,
                        'icon' => 'fa fa-folder',
                        'contenu' => self::scanDir($path . '/' . $value)
                    ];
                } else {
                    if (is_file($path . '/' . $value)) {

                        $extension = explode('.', $value);
                        $extension = $extension[count($extension) - 1];

                        switch ($extension) {
                            case 'php' : {
                                $icon = 'fa fa-file-code-o';
                                break;
                            }
                            case 'js' : {
                                $icon = 'fa fa-file-code-o';
                                break;
                            }
                            case 'css' : {
                                $icon = 'fa fa-file-code-o';
                                break;
                            }
                            case 'html' : {
                                $icon = 'fa fa-file-code-o';
                                break;
                            }
                            case 'jpeg' : {
                                $icon = 'fa fa-file-picture-o';
                                break;
                            }
                            case 'jpg' : {
                                $icon = 'fa fa-file-picture-o';
                                break;
                            }
                            case 'png' : {
                                $icon = 'fa fa-file-picture-o';
                                break;
                            }
                            case 'pdf' : {
                                $icon = 'fa fa-file-pdf-o';
                                break;
                            }
                            default : {
                                $icon = 'fa fa-file';
                            }
                        }

                        $contenu[] = [
                            'nom' => $value,
                            'icon' => $icon
                        ];
                    }
                }
            }
        }
        return $contenu;
    }
}