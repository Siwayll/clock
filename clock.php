<?php
/**
 * Pointeuse simple
 *
 * @package    Clock
 * @subpackage Main
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @author     Jonathan Sahm <contact@johnstyle.fr>
 * @license    beerware http://wikipedia.org/wiki/Beerware
 */

$archivesPath = 'archives';

/** Dossier d'archives */
if (!is_dir($archivesPath)) {
    mkdir($archivesPath);
}

/** Fichier du jour */
$fileName = $archivesPath . '/' . date('Y-m-d') . '.csv';

/** Taches */
do {
    $start = new DateTime ();
    $taskStart = $start->format('H:i');
    $line = $taskStart . "\t";
    echo "Start: " . $taskStart . "\n";

    $taskName = trim(fgets(STDIN));

    $end = new DateTime ();
    $taskEnd = $start->format('H:i');
    $line .= $taskEnd . "\t";

    $diff = $start->diff($end);
    $taskTime = $diff->format('%hh %im');
    $line .= $taskTime . "\t";
    echo "Time: " . $taskTime . "\n\n";

    $line .= $taskName . "\n";

    file_put_contents($fileName, $line, FILE_APPEND);

} while ($taskName != 'q');
