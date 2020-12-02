<?php
/**
 * Try to connecte to AbraFlexi by form 
 * Show Connection Status
 * 
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
require_once '../vendor/autoload.php';

$oPage = new \Ease\TWB\WebPage(_('AbraFlexi connection probe'));

$connForm = new AbraFlexi\ui\ConnectionForm();
$connForm->fillUp($_REQUEST);


$container = $oPage->addItem(new \Ease\TWB\Container($connForm));

$container->addItem( new \Ease\TWB\Well( new \AbraFlexi\ui\StatusInfoBox(null, $_REQUEST)));

$container->addItem( $oPage->getStatusMessagesAsHtml() );

$oPage->draw();
