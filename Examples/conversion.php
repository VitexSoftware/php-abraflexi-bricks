<?php
/**
 * Convert Documents
 * 
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */

require_once '../vendor/autoload.php';

function unc($code)
{
    return \AbraFlexi\RO::uncode($code);
}

/**
 * Prepare testing payment
 * 
 * @param array $initialData
 * 
 * @return \AbraFlexi\Banka
 */
function makePayment($initialData = [], $dayBack = 1)
{
    $yesterday = new \DateTime();
    $yesterday->modify('-'.$dayBack.' day');

    $testCode = 'PAY_'.\Ease\Functions::randomString();

    $payment = new \AbraFlexi\Banka($initialData);

    $payment->takeData(array_merge([
        'kod' => $testCode,
        'banka' => 'code:HLAVNI',
        'typPohybuK' => 'typPohybu.prijem',
        'popis' => 'AbraFlexi bricks Test bank record',
        'varSym' => \Ease\Functions::randomNumber(1111, 9999),
        'specSym' => \Ease\Functions::randomNumber(111, 999),
        'bezPolozek' => true,
        'datVyst' => \AbraFlexi\RO::dateToFlexiDate($yesterday),
        'typDokl' => \AbraFlexi\RO::code('STANDARD')
            ], $initialData));
    if ($payment->sync()) {
        $payment->addStatusMessage($payment->getApiURL().' '.unc($payment->getDataValue('typPohybuK')).' '.unc($payment->getRecordIdent()).' '.unc($payment->getDataValue('sumCelkem')).' '.unc($payment->getDataValue('mena')),
            'success');
    } else {
        $payment->addStatusMessage(json_encode($payment->getData()), 'debug');
    }
    return $payment;
}


\Ease\Shared::instanced()->loadConfig(dirname(__DIR__).'/tests/client.json');

$prijem = makePayment();
$zdd = new AbraFlexi\FakturaVydana(['typDokl' => \AbraFlexi\RO::code('ZDD')]);

$engine = new AbraFlexi\Bricks\Convertor($prijem,$zdd);
$zdd = $engine->conversion();

print_r($zdd->getData());
    