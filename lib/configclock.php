<?php
/**
* Enregistrement du temps
 *
 * @package    Clock
 * @subpackage Modules
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Lib;

/**
 * Enregistrement du temps
 *
 * @package    Clock
 * @subpackage Modules
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
trait ConfigClock
{
    /**
     * Configuration
     *
     * @var \Deuton\Config
     */
    protected static $config = false;

    /**
     * Renvois la valeur d'un parametre de configuration
     *
     * @param string $section Code de la section
     * @param string $key     Nom de la clé de configuration
     *
     * @return mixed null si aucune configuration ne répond aux critères
     * @use \Deuton\Config->get()
     */
    public static function conf($section, $key = null)
    {
        if (self::$config === false) {
            self::getConf();
        }
        return self::$config->get($section, $key);
    }

    /**
     * Chargement de la configuration
     *
     * @return void
     */
    private static function getConf()
    {
        self::$config = new \Deuton\Config('clock.ini');
    }
}

