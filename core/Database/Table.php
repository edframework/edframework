<?php

namespace Edogawa\Core\Database;

use Edogawa\Core\App\App;

/**
 * Classe Table
 *
 * Fournit des méthodes pour gérer le CRUD des tables
 *
 * @package Edogawa\Core\Database
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Table
{
    /**
     * @var string
     */
    protected $tableName = "typeparrainage";

    /**
     * Sélectionne toutes les lignes de la table
     *
     * @return array of object
     */
    public function all()
    {
        App::query()->select($this->tableName);
        App::query()->champ("*");
        return App::query()->exec();
    }

    /**
     * Compte le nombre d'enregistrement dans la table
     *
     * @return int
     */
    public function countAll()
    {
        App::query()->select($this->tableName);
        App::query()->champCount("*" , 'nombre');
        return App::query()->exec()[0]->nombre;
    }

    /**
     * Enregistre dans la table les données des propriétés de la classe
     *
     * @return bool
     */
    public function save()
    {
        $classname = get_called_class();
        $rc = new \ReflectionClass($classname);
        $rc_properties = $rc->getProperties();

        $attrib = [];
        $values = [];

        foreach ($rc_properties as $rc_property) {
            if ($rc_property->class == get_called_class()) {
                $rm = new \ReflectionProperty($classname, $rc_property->getName());
                $rm->setAccessible(true);

                if (!empty($rm->getValue($this))) {
                    array_push($attrib, $rc_property->getName());
                    array_push($values, $rm->getValue($this));
                }
            }
        }
        if (count($attrib) == count($values)) {
            $valeurs = array_combine($attrib, $values);
            return App::query()->insert($this->tableName, $valeurs);
        } else {
            return false;
        }
    }

    /**
     * Mets à jour une ligne par son identifiant
     *
     * @return bool
     */
    public function update()
    {
        $classname = get_called_class();
        $rc = new \ReflectionClass($classname);
        $rc_properties = $rc->getProperties();

        $id = [];
        $values = [];

        foreach ($rc_properties as $rc_property) {
            if ($rc_property->class == $classname) {

                $rc_doc = $rc_property->getDocComment();
                $rm = new \ReflectionProperty($classname, $rc_property->getName());

                $rm->setAccessible(true);

                if ($this->getKey($rc_doc) == "PRI") {
                    if ($rm->getValue($this) != NULL) {
                        $id = [$this->getField($rc_doc), $rm->getValue($this)];
                    } else {
                        return false;
                    }
                } else {
                    if ($rm->getValue($this) != NULL) {
                        $values[] = [$this->getField($rc_doc), $rm->getValue($this)];
                    }
                }
            }
        }

        if (!empty($id) and !empty($values)) {
            App::query()->update($this->tableName)->where($id[0], '=', $id[1]);
            foreach ($values as $value) {
                App::query()->set($value[0], $value[1]);
            }
            return App::query()->exec();
        } else {
            return false;
        }
    }

    /**
     * Supprime une ligne d'une table par ses attributs
     *
     * @return bool
     */
    public function remove()
    {
        $classname = get_called_class();
        $rc = new \ReflectionClass($classname);
        $rc_properties = $rc->getProperties();

        $params = [];

        foreach ($rc_properties as $rc_property) {
            $rp = new \ReflectionProperty($classname, $rc_property->getName());
            $rp->setAccessible(true);
            if ($rc_property->class == get_called_class()) {
                if (!empty($rp->getValue($this))) {
                    array_push($params, array($rc_property->getName(), $rp->getValue($this)));
                }
            }
        }


        if (!empty($params)) {
            App::query()->delete($this->tableName);
            foreach ($params as $param) {
                App::query()->where($param[0], '=', $param[1]);
            }
            return App::query()->exec();
        } else {
            return false;
        }
    }

    /**
     * Récupère la clé de la ReflexionDoc
     *
     * @param $rc_doc
     * @return bool|string
     */
    private function getKey($rc_doc)
    {
        $start_pos = strpos($rc_doc, 'key="') + 5;
        $end_pos = strpos($rc_doc, '"', $start_pos);
        return substr($rc_doc, $start_pos, $end_pos - $start_pos);
    }

    /**
     * Récupère le field de la ReflexionDoc
     *
     * @param $rc_doc
     * @return bool|string
     */
    private function getField($rc_doc)
    {
        $start_pos = strpos($rc_doc, 'field="') + 7;
        $end_pos = strpos($rc_doc, '"', $start_pos);
        return substr($rc_doc, $start_pos, ($end_pos - $start_pos));
    }

    /**
     * Récupère le Type de la ReflexionDoc
     *
     * @param $rc_doc
     * @return bool|string
     */
    private function getType($rc_doc)
    {
        $start_pos = strpos($rc_doc, 'type="') + 6;
        $end_pos = strpos($rc_doc, '"', $start_pos);
        return substr($rc_doc, $start_pos, ($end_pos - $start_pos));
    }

    /**
     * Récupère l'Extra de la ReflexionDoc
     *
     * @param $rc_doc
     * @return bool|string
     */
    private function getExtra($rc_doc)
    {
        $start_pos = strpos($rc_doc, 'extra="') + 7;
        $end_pos = strpos($rc_doc, '"', $start_pos);
        return substr($rc_doc, $start_pos, ($end_pos - $start_pos));
    }

    /**
     * Hydrate les propriétés de la instance avec les paramètres
     *
     * @return bool
     */
    public function findOne()
    {
        $classname = get_called_class();
        $rc = new \ReflectionClass($classname);
        $rc_properties = $rc->getProperties();

        $params = [];

        foreach ($rc_properties as $rc_property) {
            $rp = new \ReflectionProperty($classname, $rc_property->getName());
            $rp->setAccessible(true);
            if ($rc_property->class == get_called_class()) {
                if (!empty($rp->getValue($this))) {
                    array_push($params, array($rc_property->getName(), $rp->getValue($this)));
                }
            }
        }

        if (!empty($params)) {
            App::query()->select($this->tableName)->champ('*');
            foreach ($params as $param) {
                App::query()->where($param[0], '=', $param[1]);
            }
            $data = App::query()->exec();

            if (!$data) {
                return false;
            } else {
                foreach ($rc_properties as $rc_property) {
                    $rp = new \ReflectionProperty($classname, $rc_property->getName());
                    $rp->setAccessible(true);
                    $rc_doc = $rp->getDocComment();
                    if ($rc_property->class == get_called_class()) {
                        $rp->setValue($this, $data[0]->{$this->getField($rc_doc)});
                    }
                }
                return $data[0];
            }
        } else {
            return false;
        }
    }

    /**
     * Récupère tous les enregistrements par rapport aux paramètres
     *
     * @return bool|array of object
     */
    public function findAll()
    {
        $classname = get_called_class();
        $rc = new \ReflectionClass($classname);
        $rc_properties = $rc->getProperties();

        $params = [];

        foreach ($rc_properties as $rc_property) {
            $rp = new \ReflectionProperty($classname, $rc_property->getName());
            $rp->setAccessible(true);
            if ($rc_property->class == get_called_class()) {
                if (!empty($rp->getValue($this))) {
                    array_push($params, array($rc_property->getName(), $rp->getValue($this)));
                }
            }
        }

        if (!empty($params)) {
            App::query()->select($this->tableName)->champ('*');
            foreach ($params as $param) {
                App::query()->where($param[0], '=', $param[1]);
            }
            return App::query()->exec();
        } else {
            return false;
        }
    }

}
