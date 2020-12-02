<?php
/**
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
require_once '../vendor/autoload.php';
\Ease\Shared::instanced()->loadConfig(dirname(__DIR__).'/tests/client.json',
    true);

$oPage = new \Ease\TWB\WebPage();

$id       = $oPage->getRequestValue('id');
$evidence = $oPage->getRequestValue('evidence');


$document = new \AbraFlexi\RO(is_numeric($id) ? intval($id) : $id,
    ['evidence' => $evidence, 'detail' => 'summary']);

$oPage->setPageTitle($document->getEvidence().' '.$document);


$feeder = 'getpdf.php?lang=en'; //Override choosen language here

$embed = new \AbraFlexi\ui\EmbedResponsivePDF($document, $feeder, 'default');

$oPage->addItem(new \Ease\TWB\Container($embed));
$oPage->draw();
