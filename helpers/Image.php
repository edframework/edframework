<?php
namespace Edogawa\Helpers;

/**
 * Class Image
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Image
{
    /**
     * Variable qui contient la variable d'image
     *
     * @var array
     */
    private $image;

    /**
     * Image constructor.
     * @param $image
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Recupère l'extension de l'image
     *
     * @return string
     */
    private function getExtension() : string
    {
        $file = explode('.', $this->image['name']);
        return $file[count($file) - 1];
    }

    /**
     * Récupère le nom du répertoire tampon
     *
     * @return string
     */
    private function getTmpName()
    {
        return $this->image['tmp_name'];
    }

    /**
     * Récupère la largeur de l'image
     *
     * @return string|int
     */
    private function getOldWidth()
    {
        list($width, $height) = getimagesize($this->image['tmp_name']);
        return $width;
    }

    /**
     * Récupère la hauteur de l'image
     *
     * @return string|int
     */
    private function getOldHeight()
    {
        list($width, $height) = getimagesize($this->image['tmp_name']);
        return $height;
    }

    /**
     * Redimensionne une image
     *
     * @param string $newPath
     * @param string $width
     * @param string $height
     * @param string $ratio
     */
    public function resize(string $newPath, string $width, string $height, string $ratio = 'anormal')
    {

        if (strtolower($this->getExtension()) == 'png') {

            $img = imagecreatefrompng($this->getTmpName());

        } elseif (strtolower($this->getExtension()) == 'jpg' || strtolower($this->getExtension()) == 'jpeg') {

            $img = imagecreatefromjpeg($this->getTmpName());

        }

        $newWidth = $width;
        if ($ratio == 'anormal') {
            $newHeight = ($this->getOldHeight() / $this->getOldWidth()) * $height;
        } elseif ($ratio == 'normal') {
            $newHeight = $height;
        }

        $tmp_image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp_image, $img, 0, 0, 0, 0, $newWidth, $newHeight, $this->getOldWidth(), $this->getOldHeight());
        imagejpeg($tmp_image, $newPath, 100);
        imagedestroy($tmp_image);
        imagedestroy($img);
    }
}

?>
