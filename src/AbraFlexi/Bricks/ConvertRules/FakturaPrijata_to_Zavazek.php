<?php

declare(strict_types=1);

/**
 * This file is part of the BricksForAbraFlexi package
 *
 * https://github.com/VitexSoftware/php-abraflexi-bricks
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AbraFlexi\Bricks\ConvertRules;

/**
 * Description of FakturaPrijata_to_Zavazek.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class FakturaPrijata_to_Zavazek extends \AbraFlexi\Bricks\ConvertorRule
{
    /**
     * Source object type.
     *
     * @var array<string, array<string, string>|string>
     */
    public array $rules = [
        //        'kod' => 'kod',
        'cisDosle' => 'cisDosle',
        'varSym' => 'varSym',
        'cisSml' => 'cisSml',
        'cisObj' => 'cisObj',
        //        'datObj' => 'datObj',
        //        'cisDodak' => 'cisDodak',
        //        'doprava' => 'doprava',
        'datVyst' => 'datVyst',
        //        'duzpPuv' => 'duzpPuv',
        //        'duzpUcto' => 'duzpUcto',
        'datSplat' => 'datSplat',
        //        'datTermin' => 'datTermin',
        //        'datReal' => 'datReal',
        'popis' => 'popis',
        'poznam' => 'poznam',
        //        'kurz' => 'kurz',
        //        'kurzMnozstvi' => 'kurzMnozstvi',
        //        'stavUzivK' => 'stavUzivK',
        //        'nazFirmy' => 'nazFirmy',
        //        'ulice' => 'ulice',
        //        'mesto' => 'mesto',
        //        'psc' => 'psc',
        'eanKod' => 'eanKod',
        //        'ic' => 'ic',
        //        'dic' => 'dic',
        //        'buc' => 'buc',
        //        'iban' => 'iban',
        //        'bic' => 'bic',
        //        'specSym' => 'specSym',
        //        'bezPolozek' => 'bezPolozek',
        //        'szbDphSniz' => 'szbDphSniz',
        //        'szbDphSniz2' => 'szbDphSniz2',
        //        'szbDphZakl' => 'szbDphZakl',
        //        'uzpTuzemsko' => 'uzpTuzemsko',
        //        'datUcto' => 'datUcto',
        //        'vyloucitSaldo' => 'vyloucitSaldo',
        'stitky' => 'stitky',
        //        'typDokl' => 'typDokl',
        'mena' => 'mena',
        //        'konSym' => 'konSym',
        'firma' => 'firma',
        //        'stat' => 'stat',
        //        'banSpojDod' => 'banSpojDod',
        //        'bankovniUcet' => 'bankovniUcet',
        //        'typUcOp' => 'typUcOp',
        //        'primUcet' => 'primUcet',
        //        'protiUcet' => 'protiUcet',
        //        'dphZaklUcet' => 'dphZaklUcet',
        //        'dphSnizUcet' => 'dphSnizUcet',
        //        'dphSniz2Ucet' => 'dphSniz2Ucet',
        //        'smerKod' => 'smerKod',
        //        'statDph' => 'statDph',
        //        'clenDph' => 'clenDph',
        'stredisko' => 'stredisko',
        'cinnost' => 'cinnost',
        'zakazka' => 'zakazka',
        //        'statOdesl' => 'statOdesl',
        //        'statUrc' => 'statUrc',
        //        'statPuvod' => 'statPuvod',
        //        'dodPodm' => 'dodPodm',
        //        'obchTrans' => 'obchTrans',
        //        'druhDopr' => 'druhDopr',
        //        'zvlPoh' => 'zvlPoh',
        //        'krajUrc' => 'krajUrc',
        'zodpOsoba' => 'zodpOsoba',
        'kontaktOsoba' => 'kontaktOsoba',
        'kontaktJmeno' => 'kontaktJmeno',
        'kontaktEmail' => 'kontaktEmail',
        'kontaktTel' => 'kontaktTel',
        //        'rada' => 'rada',
        'smlouva' => 'smlouva',
        //        'formaDopravy' => 'formaDopravy',
        //        'source' => 'source',
        //        'clenKonVykDph' => 'clenKonVykDph',
        //        'datUp1' => 'datUp1',
        //        'datUp2' => 'datUp2',
        //        'datSmir' => 'datSmir',
        //        'datPenale' => 'datPenale',
        //        'formaUhradyCis' => 'formaUhradyCis',
        //        'stavUhrK' => 'stavUhrK',
        //        'juhSumPp' => 'juhSumPp',
        //        'juhSumPpMen' => 'juhSumPpMen',
        //        'sumPrepl' => 'sumPrepl',
        //        'sumPreplMen' => 'sumPreplMen',
        //        'zakazPlatba' => 'zakazPlatba',
        //        'sumCelkemBezZaloh' => 'sumCelkemBezZaloh',
        //        'sumCelkemBezZalohMen' => 'sumCelkemBezZalohMen',
        'polozkyFaktury' => [
            //            'ucetni' => 'ucetni',
            //            'eanKod' => 'eanKod',
            'nazev' => 'nazev',
            'nazevA' => 'nazevA',
            'nazevB' => 'nazevB',
            'nazevC' => 'nazevC',
            //            'cisRad' => 'cisRad',
            'typPolozkyK' => 'polozkyFakturyTypPolozkyK()',
            //            'baleniId' => 'baleniId',
            //            'mnozBaleni' => 'mnozBaleni',
            'mnozMj' => 'mnozMj',
            'typCenyDphK' => 'typCenyDphK',
            //            'typSzbDphK' => 'typSzbDphK',
            //            'szbDph' => 'szbDph',
            'cenaMj' => 'cenaMj',
            //            'sumZkl' => 'sumZkl',
            //            'sumDph' => 'sumDph',
            //            'sumCelkem' => 'sumCelkem',
            //            'sumZklMen' => 'sumZklMen',
            //            'sumDphMen' => 'sumDphMen',
            //            'sumCelkemMen' => 'sumCelkemMen',
            //            'objem' => 'objem',
            //            'cenJednotka' => 'cenJednotka',
            //            'typVypCenyK' => 'typVypCenyK',
            //            'cenaMjNakup' => 'cenaMjNakup',
            //            'cenaMjProdej' => 'cenaMjProdej',
            //            'cenaMjCenikTuz' => 'cenaMjCenikTuz',
            //            'procZakl' => 'procZakl',
            //            'slevaMnoz' => 'slevaMnoz',
            //            'zaokrJakK' => 'zaokrJakK',
            //            'zaokrNaK' => 'zaokrNaK',
            //            'sarze' => 'sarze',
            //            'expirace' => 'expirace',
            //            'datTrvan' => 'datTrvan',
            //            'datVyroby' => 'datVyroby',
            //            'stavUzivK' => 'stavUzivK',
            'poznam' => 'poznam',
            //            'kopZklMdUcet' => 'kopZklMdUcet',
            //            'kopZklDalUcet' => 'kopZklDalUcet',
            //            'kopDphMdUcet' => 'kopDphMdUcet',
            //            'kopDphDalUcet' => 'kopDphDalUcet',
            //            'kopTypUcOp' => 'kopTypUcOp',
            //            'kopZakazku' => 'kopZakazku',
            //            'kopStred' => 'kopStred',
            //            'kopCinnost' => 'kopCinnost',
            //            'kopKlice' => 'kopKlice',
            //            'kopClenDph' => 'kopClenDph',
            //            'kopDatUcto' => 'kopDatUcto',
            //            'datUcto' => 'datUcto',
            //            'sklad' => 'sklad',
            //            'stredisko' => 'stredisko',
            //            'cinnost' => 'cinnost',
            //            'typUcOp' => 'typUcOp',
            //            'zklMdUcet' => 'zklMdUcet',
            //            'zklDalUcet' => 'zklDalUcet',
            //            'dphMdUcet' => 'dphMdUcet',
            //            'dphDalUcet' => 'dphDalUcet',
            //            'zakazka' => 'zakazka',
            //            'dodavatel' => 'dodavatel',
            //            'clenDph' => 'clenDph',
            //            'dphPren' => 'dphPren',
            'mj' => 'mj',
            //            'mjObjem' => 'mjObjem',
            'stitky' => 'stitky',
            //            'source' => 'source',
            //            'clenKonVykDph' => 'clenKonVykDph',
            //            'kopClenKonVykDph' => 'kopClenKonVykDph',
            //            'ciselnyKodZbozi' => 'ciselnyKodZbozi',
            //            'druhZbozi' => 'druhZbozi',
            //            'sumVedlNaklIntrMen' => 'sumVedlNaklIntrMen',
        ],
    ];

    /**
     * zavazek-polozka do not support typPolozky.katalog and "cenik" column.
     *
     * @param string $inputValue typPolozky.obecny|typPolozky.ucetni|typPolozky.text|typPolozky.katalog
     *
     * @return string typPolozky.obecny|typPolozky.ucetni|typPolozky.text
     */
    public function polozkyFakturyTypPolozkyK($inputValue)
    {
        return ($inputValue === 'typPolozky.katalog') ? 'typPolozky.obecny' : $inputValue;
    }
}
