<?php
/**
 *
 *
 * @package    Clock
 * @subpackage Modules
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Modules;

/**
 *
 *
 * @package    Clock
 * @subpackage Modules
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class Report implements \Deuton\iModule
{
    use \Lib\ConfigClock;

    /**
     * Initialisation
     */
    public static function init()
    {
    }

    /**
     * Affichage de l'aide
     *
     * @return void
     */
    static public function help()
    {
        \cli\line('%_NAME%n');
        \cli\line("\t");
        \cli\line('%_SYNOPSIS%n');
        \cli\line('php clock.php');
        \cli\line('%_OPTIONS%n');
    }

    /**
     * Affiche les informations de temps compilées
     *
     * @param \Deuton\Opt $opt Paramètres pour l'application
     *
     * @return void
     * @ignore
     */
    static public function run(\Deuton\Opt $opt)
    {

    }

    /**
     * Affiche les informations de temps compilées
     *
     * @param \Deuton\Opt $opt Paramètres pour l'application
     *
     * @return void
     */
    public static function interact(array $opt)
    {
        $fileName = self::conf('svg', 'dir') . date('Y.m.d') . '.csv';
        $file = fopen($fileName, 'r');
        $time = array();
        while (($data = fgetcsv($file, 1000, self::conf('svg', 'separator'))) !== false) {
            if (!isset($data[3]) || !isset($data[2])) {
                continue;
            }
            if (isset($time[$data[3]])) {
                $time[$data[3]] = self::addTo($time[$data[3]], $data[2]);
                continue;
            }
            $time[$data[3]] = $data[2];
        }

        print_r($time);
    }

    /**
     *
     * @param string $old
     * @param string $new
     *
     * @return string
     */
    public static function addTo($old, $new)
    {
        preg_match('#([0-9]+)h ([0-9]+)m#', $old, $matchOld);
        preg_match('#([0-9]+)h ([0-9]+)m#', $new, $matchNew);

        $min = ($matchOld[2] + $matchNew[2]) % 60;
        $h = ($matchOld[2] + $matchNew[2] - $min) / 60 + $matchNew[1] + $matchOld[1];

        return $h . 'h ' . $min . 'm';
    }
}

