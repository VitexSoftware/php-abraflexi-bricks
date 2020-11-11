<?php
/**
 * Show company logo on page
 * 
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
require_once '../vendor/autoload.php';

$oPage = new \Ease\WebPage();
\Ease\Shared::instanced()->loadConfig(dirname(__DIR__).'/tests/client.json',
    true);


$oPage->addItem(new \AbraFlexi\ui\CompanyLogo(['width'=>'100']));

$oPage->draw();
