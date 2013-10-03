<?php
/**
 * Interface pour les modules
 *
 * @package    Deuton
 * @subpackage Core
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Deuton;

/**
 * Interface pour les modules
 *
 * @package    Deuton
 * @subpackage Core
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
interface iModule
{
    /**
     * initialisation du module
     *
     * @return void
     */
    public static function init();

    /**
     * Execution du module en mode direct
     *
     * @param \Deuton\Opt $opt Paramètres de l'utilisateur
     *
     * @return void
     */
    public static function run(\Deuton\Opt $opt);

    /**
     * Execution du module en mode interactif
     *
     * @param \Deuton\Opt $opt Paramètres de l'utilisateur
     *
     * @return void
     */
    public static function interact(array $param);

    /**
     * Affichage de l'aide
     *
     * @return void
     */
    public static function help();
}

