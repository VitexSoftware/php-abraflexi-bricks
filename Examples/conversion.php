<?php
/**
 * Convert Documents
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */

require_once '../vendor/autoload.php';

function unc($code)
{
    return \AbraFlexi\Code::strip((string)$code);
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
        'datVyst' => $yesterday->format('Y-m-d'),
        'typDokl' => \AbraFlexi\Code::ensure((string)'STANDARD')
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

// Test conversion without network calls
$yesterday = new \DateTime();
$yesterday->modify('-1 day');

// Create test payment data without sync
$payment = new AbraFlexi\Banka(array_merge([
    'banka' => \AbraFlexi\Code::ensure((string)'KB'),
    'typPohybuK' => \AbraFlexi\Code::ensure((string)'typPohybu.prijem'),
    'popis' => 'AbraFlexi bricks Test bank record',
    'varSym' => \Ease\Functions::randomNumber(1111, 9999),
    'specSym' => \Ease\Functions::randomNumber(111, 999),
    'bezPolozek' => true,
    'datVyst' => $yesterday->format('Y-m-d'),
    'typDokl' => \AbraFlexi\Code::ensure('STANDARD')
], []));

echo "=== Testing AbraFlexi Bricks Conversion ===\n";
echo "Source Payment Data:\n";
print_r($payment->getData());

$zdd = new AbraFlexi\FakturaVydana(['typDokl' => \AbraFlexi\Code::ensure('ZDD')]);

echo "\n=== Creating Convertor ===\n";
$engine = new AbraFlexi\Bricks\Convertor($payment, $zdd);

echo "=== Running Conversion ===\n";  
$result = $engine->conversion();

echo "=== Converted ZDD Data ===\n";
print_r($result->getData());

echo "\n=== Conversion Test Complete! ===\n";
    