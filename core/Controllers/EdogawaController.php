<?php
namespace Edogawa\Core\Controllers;
/**
*  Pour encadrer un contenu avec le contenu d'autres pages on peut soit utiliser
* un layout dans lequel on affichera le contenu d'une autre page ou soit utiliser
* les méthodes beforeView(), afterView() et pour définir le layout
*/

use Edogawa\App\Controllers\Erreur;
use Edogawa\Core\Html\FormInterface;
use Edogawa\Core\Html\HtmlInterface;
use Edogawa\Core\Html\Vue;
use Edogawa\Core\Html\Form;
use Edogawa\Core\Html\Html;
use Edogawa\Core\Html\VueInterface;
use Edogawa\Core\Security\CryptageInterface;
use Edogawa\Core\Security\Security;
use Edogawa\Core\Security\Cryptage;
use Edogawa\Core\Security\SecurityInterface;
use Edogawa\Core\Session\Session;
use Edogawa\Core\Validator\Validation;
use Edogawa\Core\App\App;
use Edogawa\Core\Validator\ValidationInterface;
use Edogawa\Helpers\FlashMessage;

/**
 * Classe EdogawaController
 *
 * Le coeur du traitement du framework
 *
 * @package Edogawa\Core\Controller
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class EdogawaController
{
    /**
     * Le layout du contenu à afficher
     *
     * @var string
     */
    protected $layout;


    /**
     * La nom de la classe dans laquelle cette classe est appélée
     * Ex : La classe Generator fait appele à celle ci par un extends donc
     * className aura comme valeur Generator
     *
     * @var string
     */
    protected $className;


    /**
     * Le nom de la classe avec le namespace
     *
     * @var string
     */
    protected $classPath;

    /**
     * La dernière classe Modèle chargée
     *
     * @var \Edogawa\App\Modeles\:class
     */
    protected $currentModel;

    /**
     * L'instance du dernier helper chargé
     *
     * @var \Edogawa\Helpers\:class
     */
    protected $currentHelper;


    /**
     * L'instance du dernier controller chargé
     *
     * @var \Edogawa\App\Controllers\:class
     */
    protected $currentController;

    /**
     * L'instance du dernier core chargé
     *
     * @var \Edogawa\Core\:class
     */
    protected $currentCore;

    /**
     * L'instace de la dernière librairie chargée
     *
     * @var :class
     */
    protected $currentLibrairies;

    /**
     * Le template Html a chargé avant le chargement de la vue à rendre
     *
     * @var array
     */
    protected $beforeView = [];

    /**
     * Le template php a chargé après le chargement de la vue à rendre
     *
     * @var array
     */
    protected $afterView = [];

    /**
     * EdogawaController constructor.
     * Définition du nom de la classe sans et avec namespace
     */
    public function __CONSTRUCT()
    {
        $this->classPath = get_class($this);
        $explodeClassPath = explode('\\', get_class($this));
        $this->className = $explodeClassPath[count($explodeClassPath) - 1];
    }


    /**
     * La classe de pour les éléments utiles
     *
     * @return \Edogawa\Core\Html\VueInterface
     */
    public function vue() : VueInterface
    {
        return new Vue();
    }


    /**
     * La classe de génération de formulaire
     *
     * @return \Edogawa\Core\Html\FormInterface
     */
    public function form() : FormInterface
    {
        return new Form();
    }

    public function erreur(){
        return new Erreur();
    }


    /**
     * La classe de génération Html
     *
     * @return \Edogawa\Core\Html\HtmlInterface
     */
    public function html() : HtmlInterface
    {
        return new Html();
    }


    /**
     * La classe qui sécurise les entrées cliente
     *
     * @return \Edogawa\Core\Security\SecurityInterface
     */
    public function security() : SecurityInterface
    {
        return new Security();
    }


    /**
     * Fournit quelques méthodes de cryptage
     *
     * @return \Edogawa\Core\Security\CryptageInterface
     */
    public function cryptage() : CryptageInterface
    {
        return new Cryptage();
    }


    /**
     * Fournit les méthodes de validation
     *
     * @return \Edogawa\Core\Validator\ValidationInterface
     */
    public function validator() : ValidationInterface
    {
        return new Validation();
    }


    /**
     * Charger le modèle passé en paramètre
     *
     * @param string|null $modele
     * @return \Edogawa\App\Modeles\:class
     */
    public function loadModel(string $modele = null)
    {
        $modeles = $modele ?? $this->className;
        $modeles = "Edogawa\\App\\Modeles\\" . $modeles;
        $this->currentModel = new $modeles();
        return new $modeles();
    }

    /**
     * Retourne le modèle courant
     *
     * @return \Edogawa\App\Modeles\:class
     */
    public function model()
    {
        return $this->currentModel;
    }


    /**
     * Charge le Core indiqué dans le paramètre
     *
     * @param string $core
     * @return \Edogawa\Core\:class
     */
    public function loadCore(string $core)
    {
        $cores = "Edogawa\\Core\\" . $core;
        $this->currentCore = new $cores();
        return new $cores();
    }


    /**
     * Retourne le core courant
     *
     * @return \Edogawa\Core\:class
     */
    public function core()
    {
        return $this->currentCore;
    }


    /**
     * Retourne la librairie passée en paramètre
     *
     * @param string $library
     * @return mixed
     */
    public function loadLibrary(string $library)
    {
        $libraries = $library;
        $this->currentLibrairies = new $libraries();
        return new $libraries();
    }

    /**
     * Retourne la librairie courante
     *
     * @return mixed
     */
    public function library()
    {
        return $this->currentLibrairies;
    }

    /**
     * Retourne le helper passé en paramètre
     *
     * @param string $helper
     * @return \Edogawa\Helpers\:class
     */
    public function loadHelper(string $helper)
    {
        $helpers = "Edogawa\\Helpers\\" . $helper;
        $this->currentHelper = new $helpers();
        return new $helpers();
    }

    /**
     * Retourne le helper courant
     *
     * @return \Edogawa\Helpers\:class
     */
    public function helper()
    {
        return $this->currentHelper;
    }

    /**
     * Retourne le controller passé en paramètre
     *
     * @param string $controller
     * @return \Edogawa\App\Controllers\:class
     */
    public function loadController(string $controller)
    {
        $this->currentController = new $controller();
        return new $controller();
    }


    /**
     * Retourne le controller courant
     *
     * @return \Edogawa\App\Controllers\:class
     */
    public function controller()
    {
        return $this->currentController;
    }


    /**
     * Retourne le contenu de la page à afficher
     *
     * @param string $vue
     * @param array $data
     * @return string
     */
    public function render(string $vue, array $data = [])
    {
        /**
         * Définit les variables qui seront disponibles sur la vue
         */
        $data['that'] = (object)array(
            'vue' => $this->vue(),
            'html' => $this->html(),
            'form' => $this->form()
        );

        /**
         * Fonction de callback pour obtenir le champ du token
         *
         * @return string
         */
        $CSRF = function (){
                return $this->security()->CSRF();
        };


        /**
         * Retourne l'URL
         *
         * @param string $url
         * @return string
         */
        $asset = function (string $url) : string
        {
          return RES.'/assets/'.$url;
        };


        /**
         * Retourne le path
         *
         * @param string $path
         * @return string
         */
        $path = function (string $path) : string
        {
          return WROOT.$path;
        };

        $data['token'] = Session::get('token');
        $data['asset'] = $asset;
        $data['path'] = $path;

        /**
         * Variable contenant le fichier json de langue chargé
         */
        $data['json'] = App::getJson();

        /**
         * Variable contenant l'ensemble des messages flash
         */
        $data['messages'] = FlashMessage::get();

        /**
         * Convertis le tableau $data en plusieurs variables en fonction de leur clé
         */
        extract($data);

        /**
         * Début de la mise en cache
         */
        ob_start();

        /**
         * Inclusion des fichiers avant le chargement de la vue
         */
        foreach ($this->beforeView as $value) {
            require "App/Vues/includes/" . $value . ".php";
        }

        /**
         * Chargement de la page
         */
        require "App/Vues/pages/" . $vue . ".php";

        /**
         * Inclusion des fichiers après le chargement de la vue
         */
        foreach ($this->afterView as $value) {
            require "App/Vues/includes/" . $value . ".php";
        }

        /**
         * Met dans la variable $content tout ce qui a été affiché depuis le debut
         * de la temporisation
         */
        $content = ob_get_clean();

        /**
         * Récupération du contenu à afficher
         */
        ob_start();
        if (! $this->layout) {
            echo $content;
        } else {
            require "App/Vues/pages/{$this->layout}.php";
        }
        $page = ob_get_clean();
        return $page;
    }

    /**
     * Retourne le layout applicable dans le render
     *
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * Définit un layout à la vue
     *
     * @param string $layout
     * @return EdogawaController
     */
    public function setLayout(string $layout): EdogawaController
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Retourne le tableau d'inclusion avant la vue
     *
     * @return array
     */
    public function getBeforeView(): array
    {
        return $this->beforeView;
    }

    /**
     * Définit l'ensemble des inclusions avant la vue
     *
     * @param string $beforeView
     * @return EdogawaController
     */
    public function setBeforeView(string $beforeView): EdogawaController
    {
        $this->beforeView[] = $beforeView;
        return $this;
    }

    /**
     * Retourne l'ensemble des inclusions après la vue
     *
     * @return array
     */
    public function getAfterView(): array
    {
        return $this->afterView;
    }

    /**
     * Définit l'ensemble des inclusions après la vue
     *
     * @param string $afterView
     * @return EdogawaController
     */
    public function setAfterView(string $afterView): EdogawaController
    {
        $this->afterView[] = $afterView;
        return $this;
    }

}

?>
