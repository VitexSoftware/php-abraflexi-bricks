<?php
/**
 * AbraFlexi-Bricks - Unit Test bootstrap
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright (c) 2018-2020, Vítězslav Dvořák
 */
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php'; //Test Run
} else {
    require_once 'vendor/autoload.php'; //Create Test
}
\Ease\Shared::instanced()->loadConfig('tests/client.json',true);
define('EASE_LOGGER', 'syslog');

/* Run me to prepare AbraFlexi database to be used for Tests

$labeler = new AbraFlexi\Stitek();
$labeler->createNew('PREPLATEK', ['banka']);
$labeler->createNew('CHYBIFAKTURA', ['banka']);
$labeler->createNew('NEIDENTIFIKOVANO', ['banka']);

$banker = new AbraFlexi\Banka(null, ['evidence' => 'bankovni-ucet']);
if (!$banker->recordExists(['kod' => 'HLAVNI'])) {
    $banker->insertToAbraFlexi(['kod' => 'HLAVNI', 'nazev' => 'Main Account']);
}
*/
