<?php
/**
 * Pointeuse simple
 *
 * @package    Clock
 * @subpackage Core
 * @author     Siwaÿll <sanath.labs@gmail.com>
 * @author     Jonathan Sahm <contact@johnstyle.fr>
 * @license    beerware http://wikipedia.org/wiki/Beerware
 */
define('DS', DIRECTORY_SEPARATOR);

set_include_path(get_include_path()
    . PATH_SEPARATOR . realpath(__DIR__)
);
require_once 'deuton/deuton.php';

Deuton\Deuton::runByInteract('clock');