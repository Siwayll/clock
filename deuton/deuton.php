<?php
/**
 * FrameWork en lignes de commande
 *
 * @package    Deuton
 * @subpackage Core
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Deuton;

require __DIR__ . DS . 'path.php';

/**
 * FrameWork en lignes de commande
 *
 * @package    Deuton
 * @subpackage Core
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class Deuton
{
    /**
     * Numéro de version de Deuton
     */
    const VERSION = '3.2';

    /**
     * Nom de l'interface des modules Deuton
     */
    const INTERFACE_NAME = 'Deuton\iModule';

    /**
     * Configuration de Deuton
     *
     * @var Config
     */
    protected static $config;

    /**
     * Arguments de la commande
     *
     * @var \Deuton\Opt
     */
    protected static $arg;

    /**
     * Fonctionnement par modules
     *
     * @return void
     */
    public static function runByModule()
    {

        $arg = new Opt();

        $className = self::$arg->getCmd();
        if (empty($className)) {
            return;
        }
        try {
            if (isset(self::$arg->h)) {
                $className::help();
            } else {
                $className::run(self::$arg);
            }
        } catch (\Exception $exc) {
            \cli\err('%1' . $exc->getMessage() . '%n');
        }
    }

    /**
     *
     */
    public static function runByInteract($default)
    {
        self::prepare();
        /** initialisation **/
        $defaultName = '\\Modules\\' . $default;
        self::validateModule($defaultName);
        $defaultName::init();

        $stopCmd = self::$config->get('core', 'stopCmd');

        do {
            echo "\033[34m::\033[00m";
            $taskName = trim(fgets(STDIN));
            if ($taskName == $stopCmd) {
                break;
            }
            if (strpos($taskName, ':') === 0) {
                $className = '\\Modules\\' . str_replace(':', '', $taskName);
                try {
                    self::validateModule($className);
                    $className::interact(array());
                } catch (Exception $exc) {
                    echo 'ERREUR;';
                }

                continue;
            }
            $param = array($taskName);
            $defaultName::interact($param);
        } while ($taskName != $stopCmd);
    }

    /**
     * Initialisation de Deuton
     *
     * @return void
     */
    public static function prepare()
    {
        /** Configuration de l'autload **/
        spl_autoload_register('\Deuton\Deuton::autoload');

        self::$config = new Config(__DIR__ . DS . 'deuton.ini');

        self::$arg = new Opt();

        $stopCmd = self::$config->get('core', 'stopCmd');
        if (empty($stopCmd)) {
            throw new Exception('information stopCmd vide');
        }
    }

    /**
     * Contrôle la validité d'un module
     *
     * @param type $className
     *
     * @return boolean
     * @throws Deuton\Exception
     */
    protected static function validateModule($className)
    {
        if (class_exists($className)) {
            $interfaces = class_implements($className, true);
            if (in_array(self::INTERFACE_NAME, $interfaces)) {
                return true;
            }
        }
        throw new Exception('Module ' . $className . ' incorrecte');
    }

    /**
     * Execute un module
     *
     * @param string     $className Nom du module à charger
     * @param Deuton\Opt $arg       Options
     *
     * @return void
     */
    public static function launch($className, $arg)
    {
        self::validateModule($className);
        $className::run($arg);
    }

    /**
     * Arrêt complet du script
     *
     * @return void
     */
    public static function stop()
    {
        die("\r\n");
    }


    /**
     * Chargement dynamique des classes
     *
     * @param string $name Nom du fichier à inclure
     *
     * @return boolean
     * @uses Deuton\Path
     */
    public static function autoload($name)
    {
        $fileName = strtolower($name) . '.php';
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);

        $path = new Path($fileName, Path::SILENT);
        if ($path->get()) {
            include_once $path->get();
            return true;
        }

        if (self::$config->get('error', 'exception') == true) {
            throw new Exception('Module ' . $name . ' inexistant');
        }

        return false;
    }
}

