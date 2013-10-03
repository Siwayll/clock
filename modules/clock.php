<?php
/**
 * Enregistrement du temps
 *
 * @package    Clock
 * @subpackage Modules
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Modules;

/**
 * Enregistrement du temps
 *
 * @package    Clock
 * @subpackage Modules
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class Clock implements \Deuton\iModule
{
    use \Lib\ConfigClock;

    /**
     * instance interne
     *
     * @var \Modules\Clock
     * @ignore
     */
    static private $singleton = null;

    /**
     * Initialisation
     */
    public static function init()
    {
        $clock = self::load();
        $clock->start();
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
     * Met à l'étude un site
     *
     * @param \Deuton\Opt $opt Paramètres pour l'application
     *
     * @return void
     */
    static public function run(\Deuton\Opt $opt)
    {

    }

    /**
     *
     * @return self
     */
    public static function load()
    {
        if (!empty(self::$singleton)) {
            return self::$singleton;
        }

        self::$singleton = new self();
        return self::$singleton;
    }

    /**
     * Met à l'étude un site
     *
     * @param \Deuton\Opt $opt Paramètres pour l'application
     *
     * @return void
     */
    public static function interact(array $opt)
    {
        $clock = self::load();
        $clock->end($opt[0]);
    }

    /**
     * Création de l'objet Clock
     *
     * @ignore
     */
    public function __construct()
    {
        $this->fileName = self::conf('svg', 'dir') . date('Y.m.d') . '.csv';
    }

    /**
     * Début d'une tranche horaire
     *
     * @return void
     */
    protected function start()
    {
        $this->st = new \DateTime ();
        $taskStart = $this->st->format('H:i');
        $line = "\n" . $taskStart . self::conf('svg', 'separator');
        echo "Start: " . $taskStart . "\n";

        file_put_contents($this->fileName, $line, FILE_APPEND);
    }

    /**
     * Fin d'une tranche horaire
     *
     * @param string $message Nom de la tranche horaire qui vient de finir
     *
     * @return void
     */
    protected function end($message)
    {
        $end = new \DateTime ();
        $taskEnd = $this->st->format('H:i');
        $line = $taskEnd . self::conf('svg', 'separator');

        $diff = $this->st->diff($end);
        $taskTime = $diff->format('%hh %im');
        $line .= $taskTime . self::conf('svg', 'separator');
        echo "Time: " . $taskTime . "\n\n";

        $line .= $message;

        file_put_contents($this->fileName, $line, FILE_APPEND);

        $this->start();
    }
}

