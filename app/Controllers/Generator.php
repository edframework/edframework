<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 05/12/2017
 * Time: 16:21
 */

namespace Edogawa\App\Controllers;

use Edogawa\Core\Controllers\EdogawaController;
use Edogawa\Core\Database\Database;
use Edogawa\Core\Directory\ReadDirectory;
use Edogawa\Core\Requete\RequestDataInterface;
use Edogawa\Helpers\DataGenerator;
use Edogawa\Core\Directory\File;
use Edogawa\Core\Requete\Requete;
use Edogawa\Helpers\Encode;
use Edogawa\Helpers\Str;

/**
 * Class Generator
 * @package Edogawa\App\Controllers
 */
class Generator extends EdogawaController
{
    /**
     * Menu à afficher sur la page
     *
     * @var array
     */
    private $menu = array(
        array(
            'nom' => 'Controller',
            'lien' => WROOT.'#',
            'icon' => 'fa fa-th',
            'sous-menu' => [
                array(
                    'nom' => 'Générer',
                    'lien' => WROOT . 'Generator/GController/gen'
                ),
                array(
                    'nom' => 'Lister',
                    'lien' => WROOT . 'Generator/GController/lister'
                )
            ]
        ),
        array(
            'nom' => 'Modele',
            'lien' => WROOT.'#',
            'icon' => 'fa fa-th',
            'sous-menu' => [
                array(
                    'nom' => 'Générer',
                    'lien' => WROOT . 'Generator/GModele/gen'
                ),
                array(
                    'nom' => 'Lister',
                    'lien' => WROOT . 'Generator/GModele/lister'
                )
            ]
        ),
        array(
            'nom' => 'Vue',
            'lien' => WROOT.'#',
            'icon' => 'fa fa-th',
            'sous-menu' => [
                array(
                    'nom' => 'Générer',
                    'lien' => WROOT . 'Generator/GVue/gen'
                ),
                array(
                    'nom' => 'Lister',
                    'lien' => WROOT . 'Generator/GVue/lister'
                )
            ]
        ),
        array(
            'nom' => 'Table Modele',
            'lien' => WROOT.'#',
            'icon' => 'fa fa-th',
            'sous-menu' => [
                array(
                    'nom' => 'Générer',
                    'lien' => WROOT . 'Generator/GTable/gen'
                ),
                array(
                    'nom' => 'Lister',
                    'lien' => WROOT . 'Generator/GTable/lister'
                )
            ]
        ),
        array(
            'nom' => 'CRUD',
            'lien' => WROOT.'#',
            'icon' => 'fa fa-th',
            'sous-menu' => [
                array(
                    'nom' => 'Générer',
                    'lien' => WROOT . 'Generator/GCrud/gen'
                )
            ]
        )
    );

    /**
     * Contient les données d'URL
     *
     * @var RequestDataInterface
     */
    private $request;


    /**
     * Generator constructor.
     * @param RequestDataInterface $request
     */
    public function __CONSTRUCT(RequestDataInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Toutes les opérations concernant la génération de Controller
     *
     * @param string $action
     * @return string
     */
    public function GController(string $action)
    {
        $data = [
            'menu' => $this->menu
        ];
        $this->setLayout('Generator/layout');
        switch ($action) {
            /**
             * Action à faire sur la page de génération de controller
             */
            case 'gen' : {
                return $this->render('Generator/Controller/generer', $data);
                break;
            }
            /**
             * Actions à faire sur la page de liste des controllers
             */
            case 'lister' : {
                $liste = [];
                foreach (scandir('app/Controllers') as $file) {
                    if ($file != '.' and $file != '..') {
                        $contenu = File::get_contents("app/Controllers/$file");
                        $liste[] = [
                            'filename' => $file,
                            'contenu' => $contenu
                        ];
                    }
                }
                $data['liste'] = $liste;
                return $this->render('Generator/Controller/lister', $data);
                break;
            }
            /**
             * Requête ajax d'enregistrement de controller
             */
            case 'genAjax' : {
                if (isset($_POST['libelle'])) {
                    $libelle = ucfirst($this->security()->prevent(Requete::post('libelle')));
                    $filename = "app/Controllers/$libelle.php";
                    if (!File::exists($filename)) {
                        $f = File::create($filename);
                        if (File::write($f, DataGenerator::Controller($libelle))) {
                            return 1;
                        }

                    } else {
                        return 0;
                    }
                }else{
                    return "-2";
                }
                break;
            }
            /**
             * Erreur pour toutes autres actions
             */
            default : {
                return $this->erreur()->Erreur404();
            }
        }
    }

    /**
     * Toutes les opérations concernant la génération de Modèle
     *
     * @param string $action
     * @return string
     */
    public function GModele(string $action)
    {
        $data = [
            'menu' => $this->menu
        ];
        $this->setLayout('Generator/layout');
        switch ($action) {
            /**
             * Action à faire sur la page de génération de Modèle
             */
            case 'gen' : {
                return $this->render('Generator/Modele/generer', $data);
                break;
            }
            /**
             * Actions à faire sur la page de liste des Modèles
             */
            case 'lister' : {
                $liste = [];
                foreach (scandir('app/Modeles') as $file) {
                    if ($file != '.' and $file != '..') {
                        $contenu = File::get_contents("app/Modeles/$file");
                        $liste[] = [
                            'filename' => $file,
                            'contenu' => $contenu
                        ];
                    }
                }
                $data['liste'] = $liste;
                return $this->render('Generator/Modele/lister', $data);
                break;
            }
            /**
             * Requête ajax de génération de Modèles
             */
            case 'genAjax' : {
                if (isset($_POST['libelle'])) {
                    $libelle = ucfirst($this->security()->prevent(Requete::post('libelle')));
                    $filename = "app/Modeles/$libelle.php";
                    if (!File::exists($filename)) {
                        $f = File::create($filename);
                        if (File::write($f, DataGenerator::Modele($libelle))) {
                            return 1;
                        }

                    } else {
                        return 0;
                    }
                }else{
                    return "-2";
                }
                break;
            }
            /**
             * Erreur pour toutes autres actions
             */
            default : {
                return $this->erreur()->Erreur404();
            }
        }
    }

    /**
     * Toutes les opérations concernant la génération de Table
     *
     * @param string $action
     * @return string
     */
    public function GTable(string $action)
    {
        $data = [
            'menu' => $this->menu
        ];
        $this->setLayout('Generator/layout');
        switch ($action) {
            /**
             * Action à faire sur la page de génération de table
             */
            case 'gen' : {
                $database = [];
                $dbUser = [];
                /**
                 * Défintion des fichiers d'inclusion sur la page rendue
                 */
                $includes = array(
                    'css' => array(
                        'select2.min.css'
                    ),
                    'js' => array(
                        'select2.full.js'
                    )
                );
                foreach (DATABASE as $key => $item) {
                    $dbUser[] = Str::toLower($item['DATABASE_NAME']);
                }
                foreach (Database::show() as $item) {
                    if (in_array(Str::toLower($item['Database']), $dbUser)) {
                        $database[] = $item['Database'];
                    }
                }
                $data['database'] = $database;
                $data['includes'] = $includes;
                return $this->render('Generator/Table/generer', $data);
                break;
            }
            /**
             * Actions à faire sur la page de liste des tables
             */
            case 'lister' : {
                $liste = [];
                foreach (scandir('app/Table') as $file) {
                    if ($file != '.' and $file != '..') {
                        $contenu = File::get_contents("app/Table/$file");
                        $liste[] = [
                            'filename' => $file,
                            'contenu' => $contenu
                        ];
                    }
                }
                $data['liste'] = $liste;
                return $this->render('Generator/Modele/lister', $data);
                break;
            }
            /**
             * Requête ajax de génération de Tables
             */
            case 'genAjax' : {
                if (!empty(Requete::post('database')) and !empty(Requete::post('table'))) {
                    $database = $this->security()->prevent(Requete::post('database'));
                    $table = $this->security()->prevent(Requete::post('table'));

                    /**
                     * Récupération des information sur la base de données
                     */
                    $properties = Database::showTableProperties($database, $table);
                    $nomClasse = ucfirst(strtolower($table));
                    $filename = "app/Table/$nomClasse.php";
                    if (is_array($properties)) {
                        /**
                         * Génération et création du fichier Modèle
                         */
                        $f = File::create($filename);
                        if (File::write($f, DataGenerator::Table($table, $properties))) {
                            return 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return $properties;
                    }

                } else {
                    return -2;
                }
                break;
            }
            /**
             * Requête ajax de chargement des tables en fonction de la base de données
             */
            case 'searchTable' : {
                $database = $this->security()->prevent(Requete::post('database'));
                if ($database){
                    return Encode::json(Database::tables($database));
                }else{
                    return "-2";
                }
                break;
            }
            /**
             * Erreur pour toutes autres actions
             */
            default : {
                $this->erreur()->Erreur404();
            }
        }
    }

    /**
     * Toutes les opérations concernant la génération de CRUD
     *
     * @param string $action
     * @return string
     */
    public function GCRUD(string $action)
    {
        $data = [
            'menu' => $this->menu
        ];
        $this->setLayout('Generator/layout');
        switch ($action) {
            /**
             * Action à faire sur la page de génération de CRUD
             */
            case 'gen' : {
                $database = [];
                $dbUser = [];
                /**
                 * Définition des fichiers d'inclusion sur la page rendue
                 */
                $includes = array(
                    'css' => array(
                        'select2.min.css'
                    ),
                    'js' => array(
                        'select2.full.js'
                    )
                );
                foreach (DATABASE as $key => $item) {
                    $dbUser[] = Str::toLower($item['DATABASE_NAME']);
                }
                foreach (Database::show() as $item) {
                    if (in_array(Str::toLower($item['Database']), $dbUser)) {
                        $database[] = $item['Database'];
                    }
                }
                $data['database'] = $database;
                $data['includes'] = $includes;
                return $this->render('Generator/CRUD/generer', $data);
                break;
            }
            /**
             * Requête ajax de génération de CRUD
             */
            case 'genAjax' : {
                $database = $this->security()->prevent(Requete::post('database'));
                $table = $this->security()->prevent(Requete::post('table'));
                if ($database and $table){
                    $attributes = Requete::post('attributes');
                    if (File::exists("app/Table/".ucfirst(strtolower($table)).".php")){
                        return DataGenerator::CRUD($database , $table , $attributes);
                    }else{
                        return "0";
                    }
                }else{
                    return "-2";
                }

                break;
            }
            /**
             * Requête ajax de recupération des attributs de la table
             */
            case 'getAttributes' : {
                $database = $this->security()->prevent(Requete::post('database'));
                $table = $this->security()->prevent(Requete::post('table'));
                if ($database and $table) {
                    $properties = Database::showTableProperties($database, $table);
                    $prop = [];
                    if (is_array($properties)){
                        foreach ($properties as $key => $property) {
                            $prop[$key]['Field'] = $property['Field'];
                            $prop[$key]['Key'] = $property['Key'];
                            if (preg_match('#int#', $property['Type'])) {
                                $prop[$key]['Type'] = 'number';
                            } elseif (preg_match('#(datetime|timestamp)#', $property['Type'])) {
                                $prop[$key]['Type'] = 'datetime';
                            } elseif (preg_match('#date#', $property['Type'])) {
                                $prop[$key]['Type'] = 'date';
                            } elseif (preg_match('#time#', $property['Type'])) {
                                $prop[$key]['Type'] = 'time';
                            } else {
                                $prop[$key]['Type'] = 'text';
                            }
                        }
                    }else{
                        return $properties;
                    }
                    return Encode::json($prop);
                }else{
                    return "-2";
                }
                break;
            }
            /**
             * Erreur pour toutes autres actions
             */
            default : {
                $this->erreur()->Erreur404();
            }
        }
    }

    /**
     * Toutes les opérations concernant la génération de Vue
     *
     * @param $action
     * @return string
     */
    public function GVue(string $action)
    {
        $data = [
            'menu' => $this->menu
        ];
        $this->setLayout('Generator/layout');
        switch ($action) {
            /**
             * Action à faire sur la page de génération de Vue
             */
            case 'gen' : {
                return $this->render('Generator/Vue/generer', $data);
                break;
            }
            /**
             * Actions à faire sur la page de générations des Vues
             */
            case 'lister' : {
                $liste = ReadDirectory::convertToHtml(ReadDirectory::read('app/Vues'));

                $data['liste'] = $liste;
                return $this->render('Generator/Vue/lister', $data);
                break;
            }
            /**
             * Requête ajax de génération de Vue
             */
            case 'genAjax' : {
                $path = "app/Vues/pages";

                $libelle = ucfirst($this->security()->prevent(Requete::post('libelle')));
                if ($libelle){
                    $chemin = $this->security()->prevent(Requete::post('chemin'));
                    $dir = $this->security()->prevent(Requete::post('nomDirectory'));
                    if (Requete::post('check3') == "true") {
                        if ($chemin != "") {
                            $path = "app/Vues/" . $chemin;
                        }
                    }

                    rtrim('/', $path);
                    if (Requete::post('check1') == "true") {
                        if ($dir != "") {
                            $path .= '/' . $dir;
                        } else {
                            $path .= '/' . $libelle;
                        }
                    }

                    if (!is_dir($path)) {
                        mkdir($path, 0, true);
                    }

                    if (Requete::post('check2') == "true") {
                        $f = File::create($path . '/' . "layout.php");
                        File::write($f, DataGenerator::Vue($libelle));
                    }

                    $f = File::create($path . '/' . $libelle . '.php');
                    return (File::write($f, "<h1>Hello world</h1>") ? 1 : 0);

                }else{
                    return "-2";
                }

                break;
            }
            default : {
                $this->erreur()->Erreur404();
            }
        }

    }

    public function sendMail()
    {
        $this->setLayout("Generator/layout");
        $this->render("Generator/sendMail");
    }

    public function help()
    {

    }

    public function removeGen()
    {
        $dir = "app/Vues/pages/Generator";
        if (is_dir($dir)){
            $doc = new \RecursiveDirectoryIterator($dir , \RecursiveDirectoryIterator::SKIP_DOTS);
            $fichiers = new \RecursiveIteratorIterator($doc , \RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($fichiers as $fichier) {
                if ($fichier->isDir()){
                    rmdir($fichier->getRealPath());
                }else{
                    unlink($fichier->getRealPath());
                }
            }
            if (rmdir($dir)){
                $f = File::open("app/route.php");
                $route = "";
                while ($fget = fgets($f , 4096)){
                    if (!preg_match('#Generator#' , $this->security()->preventXSS($fget))){
                        $route .= $fget;
                    }
                }
                File::close($f);
                $f = File::create("app/route.php");
                if (File::write($f , $route)){
                    $this->request->redirectTo('Site');
                }
            }
        }
    }

}
