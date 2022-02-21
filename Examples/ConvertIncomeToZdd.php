<?php
/**
 * AbraFlexi - Example how to convert Bank Income into ZDD
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2020-2022 Vitex Software
 */

namespace AbraFlexi\Bricks;

include_once './config.php';
include_once '../vendor/autoload.php';
include_once './common.php';


$payment = \Test\AbraFlexi\Banka::makeTestPayment();

$copyer = new \AbraFlexi\Bricks\Convertor($payment,
    new \AbraFlexi\FakturaVydana(
        ['typDokl' => 'code:ZDD',
        'nazev' => 'XXXX',
        'stavMailK' => 'stavMail.neodesilat'
    ]));

/**
 * @var FakturaVydana ZDD
 */
$zdd = $copyer->conversion();

$zdd->defaultUrlParams['relations'] = 'vazby';

if ($zdd->sync()) {
    $zdd->addStatusMessage(sprintf(_('New advance tax document was created: %s '), \AbraFlexi\RO::uncode($zdd)), 'success');

    if ($zdd->getDataValue('sumCelkem') == $payment->getDataValue('sumCelkem')) {

        if ($zdd->vytvorVazbuZDD($payment)) {
            $zdd->addStatusMessage(sprintf(_('ZDD %s bond to payment %s '),
                    \AbraFlexi\RO::uncode($zdd), \AbraFlexi\RO::uncode($payment)), 'success');

            $zdd->sync(['id' => $zdd, 'stavMailK' => 'stavMail.odeslat']);

            $bonds = $zdd->getDataValue('vazby');
            if (empty($bonds)) {
                $zdd->addStatusMessage(sprintf(_('Error creating ZDD %s bond to payment %s '),
                        fb::uncode($zdd), fb::uncode($payment)), 'error');
            }
        }
    } else {
        $zdd->addStatusMessage(sprintf(_('ZDD %s value %d does not match payment %s value %s'),
                \AbraFlexi\RO::uncode($zdd), $zdd->getDataValue('sumCelkem'), $payment,
                $payment->getDataValue('sumCelkem')), 'error');
    }
} else {
    $zdd->addStatusMessage(sprintf(_('Error creating ZZD for %s'), \AbraFlexi\RO::uncode($payment)), 'error');
}
