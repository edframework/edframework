<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 13/12/2017
 * Time: 20:13
 */

namespace Edogawa\Helpers;


use Edogawa\Core\App\App;
use Edogawa\Core\Database\Database;
use Edogawa\Core\Directory\File;
use Edogawa\Core\Security\Security;

/**
 * Class DataGenerator
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class DataGenerator
{
    /**
     * Middleware pour le générateur de controller
     *
     * @param string $name
     * @return string
     */
    public static function Controller(string $name)
    {
        return self::controller_data($name);
    }

    /**
     * Middleware pour le générateur de modèle
     * @param string $name
     * @return string
     */
    public static function Modele(string $name)
    {
        return self::modele_data($name);
    }

    /**
     * Middleware pour le générateur de vue
     *
     * @param string $name
     * @return string
     */
    public static function Vue(string $name)
    {
        return self::vue_data($name);
    }

    /**
     * Middleware pour le générateur de table
     *
     * @param string $table
     * @param array $properties
     * @return string
     */
    public static function Table(string $table, array $properties)
    {
        return self::table_data($table, $properties);
    }

    /**
     * Middleware pour le générateur de CRUD
     *
     * @param string $database
     * @param string $table
     * @param array $attributes
     * @return bool
     */
    public static function CRUD(string $database, string $table, array $attributes)
    {
        return self::CRUD_data($database, $table, $attributes);
    }

    /**
     * Générateur de controller
     *
     * @param string $name
     * @return string
     */
    private static function controller_data(string $name) : string
    {
        return
            '<?php
namespace Edogawa\App\Controllers;

use Edogawa\Core\Controllers\EdogawaController;

class ' . $name . ' extends EdogawaController
{
    // Code
    public function index()
    {
        return "Hello from '.$name.'";
    }
}
';
    }

    /**
     * Générateur de modèle
     *
     * @param string $name
     * @return string
     */
    private static function modele_data(string $name) : string
    {
        return
            '<?php
namespace Edogawa\App\Modeles;

use Edogawa\Core\Modeles\EdogawaModele;

class ' . $name . ' extends EdogawaModele
{
    // Code
}
';
    }

    /**
     * Générateur de vue
     *
     * @param $name
     * @return string
     */
    private static function vue_data(string $name) : string
    {
        return
            '<!doctype html>
<html>
    <head>
        <title>' . $name . '</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="' . RES . '/assets/css/bootstrap.min.css">

        <!-- Bootstrap 4.0-->
        <link rel="stylesheet" href="' . RES . '/assets/css/bootstrap-extend.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="' . RES . '/assets/css/font-awesome.min.css">

        <script src="' . RES . '/assets/js/jquery.min.js"></script>

        <!-- Bootstrap 4.0-->
        <script src="' . RES . '/assets/js/bootstrap.min.js"></script>
        <script src="' . RES . '/assets/js/controls.js"></script>
    </head>
    <body>
      <?=$content?>
    </body>
</html>
';
    }

    /**
     * Générateur de table
     *
     * @param string $table
     * @param array $properties
     * @return string
     */
    private static function table_data(string $table, array $properties) : string
    {
        $nomClasse = ucfirst(strtolower($table));
        $html = '';
        $prop = "";
        $idsVals = "";
        $class = '<?php

namespace Edogawa\App\Table;

use Edogawa\Core\Database\Table;

/**
*@table="' . $table . '"
*/
class ' . $nomClasse . ' extends Table
{
';
        foreach ($properties as $property) {
            $field = Str::toLower($property['Field']);

            $prop .= '
    /**
    *@column(field="' . $property['Field'] . '",type="' . $property['Type'] . '",key="' . $property['Key'] . '",extra="' . $property['Extra'] . '")
    */
    private $' . $field . ';
    ';

            $html .= '

    /**
     * @param $value
     * @return bool
     */
    public function set' . ucfirst($field) . '($value)
    {';
            $html .= '
        if (!empty($value)){
            $this->' . $field . ' = $value;
            return true;
        }
        return false;
    }



    /**
     * @return mixed
     */
    public function get' . ucfirst($field) . '()
    {
        return $this->' . $field . ';
    }';

            if ($property['Key'] == "PRI") {
                $idsVals .= '$this->get' . ucfirst($field) . '().\'/\'.';
            }

        }
        $idsVals = rtrim($idsVals , '.\'/\'.');

        $html .= '

    public function getId()
    {
        return '.$idsVals.';
    }';
        $class .= $prop . '
    /**
     * ' . $nomClasse . ' constructor
     */
    public function __construct()
    {
        $this->tableName = "' . $table . '";
    }' . $html . '

}
 ?>';
        return $class;
    }

    /**
     * Générateur de CRUD
     *
     * @param string $database
     * @param string $table
     * @param array $attributes
     * @return string
     */
    private static function CRUD_data(string $database, string $table, array $attributes) : string
    {
        /**
         * Défintion des données utiles dans l'application
         */
        $uc_table = Str::ucFirst(Str::toLower($table));
        $uc_controller = Str::ucFirst(Str::toLower($table)) . 'Controller';
        $path = "CRUD/" . Str::toLower($table);
        $path_update = "CRUD/" . Str::toLower($table) . "_update";
        $layout = "CRUD/layout";

        /**
         * Selection de la clé de la  base de données à utiliser
         */
        $db = "";
        foreach (DATABASE as $key => $item) {
            if ($item['DATABASE_NAME'] == $database) {
                $db = $key;
            }
        }

        /**
         * Arrêt de l'application s'il y a pas de concordance de base de données
         */
        if (empty($db)) {
            return false;
        }

        /**
         * Code du layout
         */
        $layout_data = '
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRUD ' . $table . '">
    <meta name="author" content="Edogawa Cédric">
    <link rel="icon" href="images/favicon.ico">

    <title> CRUD </title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?=RES?>/assets/css/bootstrap.min.css">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?=RES?>/assets/css/bootstrap-extend.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=RES?>/assets/css/font-awesome.min.css">

    <?php
    /**
     * Inclusion des fichiers CSS définis dans le controller par dans la variable $includes avec la clé css
     */
    if (isset($includes["css"])){
        foreach ($includes["css"] as $include) {
            echo "<link rel=\"stylesheet\" href=\"".RES."/assets/css/{$include}\">";
        }
    }
    ?>

<!-- jQuery 3 -->
<script src="<?=RES?>/assets/js/jquery.min.js"></script>


<!-- popper -->
<script src="<?=RES?>/assets/js/popper.min.js"></script>

<!-- Bootstrap 4.0-->
<script src="<?=RES?>/assets/js/bootstrap.min.js"></script>

<?php
/**
 * Inclusion des fichiers JS définis dans le controller par dans la variable $includes avec la clé js
 */
if (isset($includes["js"])){
    foreach ($includes["js"] as $include) : ?>
        <script src=\'<?=RES?>/assets/js/{$include}\'></script>
    <?php endforeach;
}
?>

</head>
<body>
<div class="container">

    <?=$content;?>

</div>
<footer class="main-footer">
    <b>Version</b> 1.0
    Copyright &copy; 2017 - <?=date("Y")?>. All Rights Reserved.
</footer>
</body>
</html>
';

        $route = 'Route::CRUD(\'/' . $uc_table . '\' , \'' . $uc_controller . '\',"",\'C-U-D\');';

        $insert_controller = '<?php
namespace Edogawa\App\Controllers;

use Edogawa\Core\App\App;
use Edogawa\Core\Controllers\EdogawaController;
use Edogawa\Core\Requete\RequestDataInterface;
use Edogawa\Helpers\FlashMessage;
use Edogawa\Helpers\Pagination;
use Edogawa\Helpers\Str;
use \Edogawa\App\Table\\' . $uc_table . ';

class ' . $uc_controller . ' extends EdogawaController
{
    /**
     * Contient les informations sur la requête
     *
     * @var RequestDataInterface
     */
    private $request;

    public function __construct(RequestDataInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Page d\'affichage du formulaire d\'inscription et de liste
     *
     * @return string
     */
    public function index()
    {
        $select_data = [];
        ';
        foreach ($attributes as $attribute) {
            if (($attribute['Afficher'] === "true") and (!empty($attribute['ForeignKey']))) {
                $insert_controller .= '
        $select_data[] = App::query()->select("' . $attribute['ForeignKey'] . '")->champ("*")->exec("' . $db . '");
                ';
            }
        }
        $insert_controller .= '
        $data[\'pagination\'] = Pagination::setPagination($this->request , "' . $db . '" , "' . $table . '");
        $this->setLayout("' . $layout . '");
        $data["select_data"] = $select_data;
        return $this->render("' . $path . '" , $data);
    }

    /**
     * Exécution de l\'instruction à l\'insertion
     */
    public function insert()
    {
        if ($this->security()->preventCSRF()){
            if (isset($_POST["submit"])){
                $validateArray = [];
                $table = new ' . $uc_table . '();
                foreach( $this->request->getRequests() as $key => $request){
                    $key = $this->security()->prevent($key);
                    $attribute = "set".Str::ucFirst(Str::toLower($key));
                    $request = $this->security()->prevent($request);
                    if ($key != "submit" and method_exists($table , $attribute)){
                        $validateArray[$key] = array("value" => $request , "pattern" => "required");
                        $table->{$attribute}($request);
                    }
                }
                if ($this->validator()->validate($validateArray)){
                    if ($table->save()){
                        FlashMessage::success(\'' . $uc_table . ' inséré\');
                        $this->request->redirectTo("' . $uc_table . '");
                    }
                }else{
                    $this->request->redirectTo("' . $uc_table . '");
                }
            }
        }else{
            return $this->index();
        }
    }

    /**
     * Exécution de l\'instruction de mise à jour
     */
    public function update_data()
    {
        if ($this->security()->preventCSRF()){
            if (isset($_POST["submit"])){
                $validateArray = [];
                $table = new ' . $uc_table . '();
                foreach( $this->request->getRequests() as $key => $request){
                    $key = $this->security()->prevent($key);
                    $attribute = "set".Str::ucFirst(Str::toLower($key));
                    $request = $this->security()->prevent($request);
                    if ($key != "submit" and method_exists($table , $attribute)){
                        $validateArray[$key] = array("value" => $request , "pattern" => "required");
                        $table->{$attribute}($request);
                    }
                }
                if ($this->validator()->validate($validateArray)){
                    if ($table->update()){
                        FlashMessage::success(\'' . $uc_table . ' mis à jour\');
                        $this->request->redirectTo("' . $uc_table . '");
                    }
                }else{
                    $this->request->redirectTo("' . $uc_table . '/update/".$table->getId());
                }
            }
        }else{
            return $this->index();
        }
    }

    /**
     * Page d\'affichage du formulaire de mise à jour
     *
     * @return string
     */
    public function update()
    {
        $table = new ' . $uc_table . '();
        $table_data = App::query()->select("' . $table . '")->champ("*")->exec("' . $db . '", "array");
        $select_data = [];
        $id = [];
        ';
        foreach ($attributes as $attribute) {
            if (($attribute['Afficher'] === "true") and (!empty($attribute['ForeignKey']))) {
                $insert_controller .= '
        $select_data[] = App::query()->select("' . $attribute['ForeignKey'] . '")->champ("*")->exec("' . $db . '");
                ';
            }
        }
        $insert_controller .= '
        $data["table_data"] = $table_data;

        foreach( $this->request->getParams() as $key => $param){
            $key = $this->security()->prevent($key);
            $attribute = "set".Str::ucFirst(Str::toLower($key));
            $param = $this->security()->prevent($param);
            if (method_exists($table , $attribute)){
                $table->{$attribute}($param);
                $id[$key] = $param;
            }
        }
        $data["table"] = $table->findOne();
        if (empty($data["table"])){
            $this->request->redirectTo("' . $uc_table . '");
        }else{
            $data["id"] = $id;

            $this->setLayout("' . $layout . '");
            $data["select_data"] = $select_data;
            return $this->render("' . $path_update . '" , $data);
        }
    }

    /**
     * Exécution de l\'instruction de suppression de données
     */
    public function remove()
    {
        if ($this->security()->preventCSRF()){
            $table = new ' . $uc_table . '();
            foreach( $this->request->getParams() as $key => $param){
                $key = $this->security()->prevent($key);
                $attribute = "set".Str::ucFirst(Str::toLower($key));
                $param = $this->security()->prevent($param);
                if (method_exists($table , $attribute)){
                    $table->{$attribute}($param);
                }
            }
            if ($table->remove()){
                FlashMessage::success("' . $uc_table . ' supprimé");
                $this->request->redirectTo("' . $uc_table . '");
            }
        }else{
            return $this->index();
        }
    }
}
';
        $insert_html = "";
        $update_html = "";

        $insert_html .= "
        <form action='<?=WROOT?>$table' method='post' id='form'>
            " . '<?=$CSRF()?>' . "
            <h1>Ajouter un {$table} </h1>
            " . '<?php
                if (isset($messages) and is_array($messages)){
                    foreach($messages as $key => $value){
                        if (isset($messages[$key])){
                            foreach($messages[$key] as $val){
                                echo "
                                    <div class=\'alert alert-".MESSAGES[$key]."\'>$val</div>
                                ";
                            }
                        }
                    }
                }
             ?>' . "
            <div class='row'>
        ";

        $update_html .= "
        <form action='<?=WROOT?>$table/update' method='post' id='form'>
            " . '<?=$CSRF()?>' . "
            <h1>Modifier un {$table} </h1>
            " . '<?php
                if (isset($messages) and is_array($messages)){
                    foreach($messages as $key => $value){
                        if (isset($messages[$key])){
                            foreach($messages[$key] as $val){
                                echo "
                                    <div class=\'alert alert-".MESSAGES[$key]."\'>$val</div>
                                ";
                            }
                        }
                    }
                }
             ?>' . "
            <div class='row'>" . '
            <?php foreach($id as $key => $value) : ?>
                 <input class=\'form-control\' name="<?=strtolower($key)?>" id="<?=strtolower($key)?>" type="hidden" value="<?=$value?>">
            <?php endforeach; ?>
        ';

        /**
         * Définition des inputs en fonction de la table
         */
        $i = 0;
        foreach ($attributes as $attribute) {
            $lowField = Str::toLower($attribute['Field']);
            if ($attribute['Afficher'] === "true") {
                if (!empty($attribute['ForeignKey'])) {

                    $insert_html .= "
                <div class='form-group col-6'>
                    <label for='{$lowField}'>{$attribute['Field']}</label>
                    <select class='form-control' name='$lowField' id='$lowField'>" . '
                    <?php foreach ($select_data[' . $i . '] as $attr) : ?>
                            <option value="<?=$attr->' . $attribute['Field'] . '?>"><?=$attr->' . $attribute['Field'] . '?></option>
                    <?php endforeach; ?>
                    ' . "</select>
                </div>
                ";
                    $update_html .= "
                <div class='form-group col-6'>
                    <label for='{$lowField}'>{$attribute['Field']}</label>
                    <select class='form-control' name='$lowField' id='$lowField'>" . '
                    <?php foreach ($select_data[' . $i . '] as $attr) : ?>
                            <option value="<?=$attr->' . $attribute['Field'] . '?>" <?php echo (($attr->' . $attribute['Field'] . ' == $table->' . $attribute['Field'] . ') ? "selected" : "") ?>><?=$attr->' . $attribute['Field'] . '?></option>
                    <?php endforeach; ?>
                    ' . "</select>
                </div>
                ";
                    $i++;
                } else {
                    $insert_html .= "
                <div class='form-group col-6'>
                    <label for='{$lowField}'>{$attribute['Field']}</label>
                    <input class='form-control' name='$lowField' id='$lowField' type='{$attribute['Type']}' placeholder='{$attribute['Field']}'>
                </div>
            ";
                    $update_html .= "
                <div class='form-group col-6'>
                    <label for='{$lowField}'>{$attribute['Field']}</label>
                    <input class='form-control' name='$lowField' id='$lowField' type='{$attribute['Type']}' value='" . '<?=$table->' . $attribute['Field'] . '?>' . "' placeholder='{$attribute['Field']}'>
                </div>
            ";
                }

            }
        }
        $update_html .= "
            </div>
            <div class='form-group'>
                <input type='submit' name='submit' class='btn btn-primary' value='Update'>
                <input type='reset' class='btn btn-danger' value='Cancel'>
            </div>
        </form>";

        $insert_html .= "
            </div>
            <div class='form-group'>
                <input type='submit' name='submit' class='btn btn-primary' value='Add'>
                <input type='reset' class='btn btn-danger' value='Cancel'>
            </div>
        </form>

        <table class='table table-bordered'>
            <thead>
                <tr>
                ";
        $primary = "";
        $ids = "";
        $idsVals = "";
        /**
         * Définition des colonnes de la table
         */
        foreach ($attributes as $attribute) {
            if (isset($attribute['PrimaryKey']) and $attribute['PrimaryKey'] === 'PRI') {
              $ids .= $attribute['Field'].'|';
              $idsVals .= '<?=$data["'.$attribute['Field'].'"] ?? $data["' . Str::toUpper($attribute['Field']) . '"]?>/';
              $primary = $attribute['Field'];
            }
            $insert_html .= '
        <th>
            <a href="<?=WROOT?>' . $uc_table . '?page=<?=$pagination["page"]?>&nbp=<?=$pagination["number_per_page"]?>&sort=' . $attribute['Field'] . '&dir=up"">
                <i class="fa fa-sort-up"></i>
            </a>
            <span>' . $attribute['Field'] . '</span>
            <a href="<?=WROOT?>' . $uc_table . '?page=<?=$pagination["page"]?>&nbp=<?=$pagination["number_per_page"]?>&sort=' . $attribute['Field'] . '&dir=down">
                <i class="fa fa-sort-down"></i>
            </a>
        </th>';
        }
        $ids = rtrim($ids , '|');
        $idsVals = rtrim($idsVals , '/');
        $route = 'Route::CRUD(\'/' . $uc_table . '\' , \'' . $uc_controller . '\' , \'' . $ids . '\',\'C-U-D\');';
        /**
         * Définition des données du tableau, de la pagination, des tris du tableau
         */
        $insert_html .= "
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                " . '
                <?php foreach ($pagination["table_data"] as $data) : ?>
                <tr>
                    <?php foreach($data as $field) : ?>
                        <td><?=$field?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="<?=WROOT?>' . $uc_table . '/update/<?=$data["' . $primary . '"]?>"><i class="fa fa-edit fa-2x"></i></a>
                        <a href="<?=WROOT?>' . $uc_table . '/remove/<?=$data["' . $primary . '"]?>?token=<?=$token?>"><i class="fa fa-remove fa-2x"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                ' . "
            </tbody>
        </table>
        " . '
        <div class="text-center">
            Affichage de <?=count($pagination["table_data"]) + $pagination["number_per_page"]*($pagination["page"]-1)?> / <?=$pagination["total_number"]?><br>
            <nav aria-label="Page navigation" style="display: inline-block">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="<?=WROOT?>' . $uc_table . '?page=1&nbp=<?=$pagination["number_per_page"]?>&sort=<?=$pagination["sort"]?>&dir=<?=$pagination["dir"]?>"><?=1?></a>
                    </li>
                    <?php if ($pagination["page"] - 10 > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="#">...</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i=2 ; $i<$pagination["number_page"] ; $i++) : ?>
                        <?php if ($i > $pagination["page"] - 10 and $i < $pagination["page"] + 10) : ?>
                            <li class="page-item">
                                <a class="page-link" href="<?=WROOT?>' . $uc_table . '?page=<?=$i?>&nbp=<?=$pagination["number_per_page"]?>&sort=<?=$pagination["sort"]?>&dir=<?=$pagination["dir"]?>"><?=$i?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($pagination["page"] + 10 < $pagination["number_page"] - 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="#">...</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($pagination["number_page"] > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="<?=WROOT?>' . $uc_table . '?page=<?=$pagination["number_page"]?>&nbp=<?=$pagination["number_per_page"]?>&sort=<?=$pagination["sort"]?>&dir=<?=$pagination["dir"]?>"><?=$pagination["number_page"]?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        ';

        /**
         * Création de répertoires, des fichiers pour les éléments du CRUD
         */

        /**
         * Création du dossier contenant les fichiers vues
         */
        $crud_path = "App/Vues/pages/CRUD";
        if (!is_dir($crud_path)) {
            mkdir($crud_path, 0, true);
        }

        /**
         * Ajout des routes au fichier de routage
         */
        $filename = "App/route.php";
        if (File::exists($filename)) {
            $trouve = false;
            $f = File::open($filename);
            while ($fget = fgets($f, 4096)) {
                $s = new Security();
                $route = $s->preventXSS($route);
                if ($route == $s->preventXSS($fget)) {
                    $trouve = true;
                }
            }
            if (!$trouve) {
                $f1 = File::openAppend($filename);
                File::append($f1, "\n\n" . $route);
                File::close($f1);
            }
            File::close($f);
        }
        /**
         * Création et remplissage du controller
         */
        $filename = "App/Controllers/" . Str::toLower($uc_controller) . ".php";
        $f = File::create($filename);
        if (File::write($f, $insert_controller)) {
            /**
             * Création et remplissage du fichier de layout
             */
            $filename = 'App/Vues/pages/' . $layout . '.php';
            if (!File::exists($filename)) {
                $f = File::create($filename);
                File::write($f, $layout_data);

            }
            /**
             * Création et remplissage du fichier d'insertion et de mise à jour
             */
            $filename = 'App/Vues/pages/' . $path . '.php';
            $f = File::create($filename);
            if (File::write($f, $insert_html)) {
                $filename = 'App/Vues/pages/' . $path_update . '.php';
                $f = File::create($filename);
                if (File::write($f, $update_html)) {
                    return true;
                }
            }

        }

        return false;
    }

}
