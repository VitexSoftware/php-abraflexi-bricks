<?php
/**
 * AbraFlexi - Example how to show connection check InfoBox
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017 Vitex Software
 */

namespace AbraFlexi\Bricks;

include_once './config.php';
include_once '../vendor/autoload.php';
include_once './common.php';

$oPage->addItem(new AddressRegisterForm());
$oPage->draw();
