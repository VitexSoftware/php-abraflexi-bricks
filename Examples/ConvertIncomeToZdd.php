<?php
/**
 * FlexiPeeHP - Example how to convert Bank Income into ZDD
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2020 Vitex Software
 */

namespace FlexiPeeHP\Bricks;

include_once './config.php';
include_once '../vendor/autoload.php';
include_once './common.php';


$payment = \Test\FlexiPeeHP\Banka::makeTestPayment();

$copyer = new \FlexiPeeHP\Bricks\Convertor($payment,
    new \FlexiPeeHP\FakturaVydana(
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
    $zdd->addStatusMessage(sprintf(_('New advance tax document was created: %s '), \FlexiPeeHP\FlexiBeeRO::uncode($zdd)), 'success');

    if ($zdd->getDataValue('sumCelkem') == $payment->getDataValue('sumCelkem')) {

        if ($zdd->vytvorVazbuZDD($payment)) {
            $zdd->addStatusMessage(sprintf(_('ZDD %s bond to payment %s '),
                    \FlexiPeeHP\FlexiBeeRO::uncode($zdd), \FlexiPeeHP\FlexiBeeRO::uncode($payment)), 'success');

            $zdd->sync(['id' => $zdd, 'stavMailK' => 'stavMail.odeslat']);

            $bonds = $zdd->getDataValue('vazby');
            if (empty($bonds)) {
                $zdd->addStatusMessage(sprintf(_('Error creating ZDD %s bond to payment %s '),
                        fb::uncode($zdd), fb::uncode($payment)), 'error');
            }
        }
    } else {
        $zdd->addStatusMessage(sprintf(_('ZDD %s value %d does not match payment %s value %s'),
                \FlexiPeeHP\FlexiBeeRO::uncode($zdd), $zdd->getDataValue('sumCelkem'), $payment,
                $payment->getDataValue('sumCelkem')), 'error');
    }
} else {
    $zdd->addStatusMessage(sprintf(_('Error creating ZZD for %s'), \FlexiPeeHP\FlexiBeeRO::uncode($payment)), 'error');
}
