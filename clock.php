<?php
/**
 * Pointeuse simple
 *
 * @package    Clock
 * @subpackage Main
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @license    beerware http://wikipedia.org/wiki/Beerware
 */

$date = date('Y.m.d');
$fileName = $date . '.csv';

file_put_contents($fileName, '', FILE_APPEND);

do {
    $start = new DateTime();
    file_put_contents($fileName, "\r\n" . $start->format('H:i') . ';', FILE_APPEND);
    $choice = trim(fgets(STDIN));
    $end = new DateTime();
    $line = $end->format('H:i') . ';';
    $diff = $start->diff($end);

    $line .= $diff->format('%hh %im') . ';' . $choice;

    file_put_contents($fileName, $line, FILE_APPEND);

    echo $diff->format('%hh %im') . "\r\n";

} while ($choice != 'q');


