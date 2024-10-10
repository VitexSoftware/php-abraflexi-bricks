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

use AbraFlexi\Bricks\ConvertorRule;

/**
 * Description of FakturaVydana_to_PokladniPohyb.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class FakturaVydana_to_PokladniPohyb extends ConvertorRule
{
    public $rules = [
        //        'kod' => 'kod',
        //        'typPohybuK' => NULL,
        //        'cisDosle' => 'cisDosle',
        //        'varSym' => 'varSym',
        //        'datVyst' => 'datVyst',
        //        'duzpPuv' => 'duzpPuv',
        //        'duzpUcto' => 'duzpUcto',
        'popis' => 'popis',
        //        'poznam' => 'poznam',
        //        'sumOsv' => 'sumOsv',
        //        'sumZklSniz' => 'sumZklSniz',
        //        'sumZklSniz2' => 'sumZklSniz2',
        //        'sumZklZakl' => 'sumZklZakl',
        //        'sumDphSniz' => 'sumDphSniz',
        //        'sumDphSniz2' => 'sumDphSniz2',
        //        'sumDphZakl' => 'sumDphZakl',
        //        'sumCelkSniz' => 'sumCelkSniz',
        //        'sumCelkSniz2' => 'sumCelkSniz2',
        //        'sumCelkZakl' => 'sumCelkZakl',
        'sumCelkem' => 'sumCelkem',
        //        'sumOsvMen' => 'sumOsvMen',
        //        'sumZklSnizMen' => 'sumZklSnizMen',
        //        'sumZklSniz2Men' => 'sumZklSniz2Men',
        //        'sumZklZaklMen' => 'sumZklZaklMen',
        //        'sumDphZaklMen' => 'sumDphZaklMen',
        //        'sumDphSnizMen' => 'sumDphSnizMen',
        //        'sumDphSniz2Men' => 'sumDphSniz2Men',
        //        'sumCelkSnizMen' => 'sumCelkSnizMen',
        //        'sumCelkSniz2Men' => 'sumCelkSniz2Men',
        //        'sumCelkZaklMen' => 'sumCelkZaklMen',
        //        'sumCelkemMen' => 'sumCelkemMen',
        //        'slevaDokl' => 'slevaDokl',
        //        'kurz' => 'kurz',
        //        'kurzMnozstvi' => 'kurzMnozstvi',
        //        'stavUzivK' => 'stavUzivK',
        //        'nazFirmy' => 'nazFirmy',
        //        'ulice' => 'ulice',
        //        'mesto' => 'mesto',
        //        'psc' => 'psc',
        //        'eanKod' => 'eanKod',
        //        'ic' => 'ic',
        //        'dic' => 'dic',
        'bezPolozek' => true,
        //        'szbDphSniz' => 'szbDphSniz',
        //        'szbDphSniz2' => 'szbDphSniz2',
        //        'szbDphZakl' => 'szbDphZakl',
        //        'uzpTuzemsko' => 'uzpTuzemsko',
        //        'datUcto' => 'datUcto',
        //        'vyloucitSaldo' => 'vyloucitSaldo',
        //        'zaokrJakSumK' => 'zaokrJakSumK',
        //        'zaokrNaSumK' => 'zaokrNaSumK',
        //        'zaokrJakDphK' => 'zaokrJakDphK',
        //        'zaokrNaDphK' => 'zaokrNaDphK',
        //        'stitky' => 'stitky',
        //        'typDokl' => 'typDokl',
        //        'pokladna' => NULL,
        'mena' => 'mena',
        'firma' => 'firma',
        //        'stat' => 'stat',
        //        'typUcOp' => 'typUcOp',
        //        'primUcet' => 'primUcet',
        //        'protiUcet' => 'protiUcet',
        //        'dphZaklUcet' => 'dphZaklUcet',
        //        'dphSnizUcet' => 'dphSnizUcet',
        //        'dphSniz2Ucet' => 'dphSniz2Ucet',
        //        'statDph' => 'statDph',
        //        'clenDph' => 'clenDph',
        //        'stredisko' => 'stredisko',
        //        'cinnost' => 'cinnost',
        //        'zakazka' => 'zakazka',
        //        'statOdesl' => 'statOdesl',
        //        'statUrc' => 'statUrc',
        //        'statPuvod' => 'statPuvod',
        //        'dodPodm' => 'dodPodm',
        //        'obchTrans' => 'obchTrans',
        //        'druhDopr' => 'druhDopr',
        //        'zvlPoh' => 'zvlPoh',
        //        'krajUrc' => 'krajUrc',
        //        'zodpOsoba' => 'zodpOsoba',
        //        'kontaktOsoba' => 'kontaktOsoba',
        //        'kontaktJmeno' => 'kontaktJmeno',
        //        'kontaktEmail' => 'kontaktEmail',
        //        'kontaktTel' => 'kontaktTel',
        //        'rada' => 'rada',
        //        'source' => 'source',
        //        'clenKonVykDph' => 'clenKonVykDph',
        //        'danEvidK' => NULL,
        //        'jakUhrK' => NULL,
        //        'zdrojProSkl' => 'zdrojProSkl',
        //        'formaUhradyCis' => 'formaUhradyCis',
        //        'cisSouhrnne' => NULL,
        //        'eetDicPoverujiciho' => 'eetDicPoverujiciho',
        //        'eetFik' => 'eetFik',
        //        'eetPkp' => 'eetPkp',
        //        'eetPokladniZarizeni' => 'eetPokladniZarizeni',
        //        'eetProvozovna' => 'eetProvozovna',
        //        'eetTypK' => 'eetTypK',
        //        'eetDatCasTrzby' => 'eetDatCasTrzby',
        //        'eetTisknoutPkp' => 'eetTisknoutPkp',
        //        'typDoklSkl' => 'typDoklSkl',
        //        'polozkyDokladu' =>
        //        array(
        //            'ucetni' => 'ucetni',
        //            'kod' => 'kod',
        //            'eanKod' => 'eanKod',
        //            'nazev' => 'nazev',
        //            'nazevA' => 'nazevA',
        //            'nazevB' => 'nazevB',
        //            'nazevC' => 'nazevC',
        //            'cisRad' => 'cisRad',
        //            'typPolozkyK' => 'typPolozkyK',
        //            'baleniId' => 'baleniId',
        //            'mnozBaleni' => 'mnozBaleni',
        //            'mnozMj' => 'mnozMj',
        //            'typCenyDphK' => 'typCenyDphK',
        //            'typSzbDphK' => 'typSzbDphK',
        //            'szbDph' => 'szbDph',
        //            'cenaMj' => 'cenaMj',
        //            'slevaPol' => 'slevaPol',
        //            'uplSlevaDokl' => 'uplSlevaDokl',
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
        //            'poznam' => 'poznam',
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
        //            'cenik' => 'cenik',
        //            'cenHlad' => 'cenHlad',
        //            'mj' => 'mj',
        //            'mjObjem' => 'mjObjem',
        //            'sazbaDphPuv' => 'sazbaDphPuv',
        //            'stitky' => 'stitky',
        //            'source' => 'source',
        //            'clenKonVykDph' => 'clenKonVykDph',
        //            'kopClenKonVykDph' => 'kopClenKonVykDph',
        //            'ciselnyKodZbozi' => 'ciselnyKodZbozi',
        //            'druhZbozi' => 'druhZbozi',
        //            'poplatekParentPolInt' => NULL,
        //            'zdrojProSkl' => 'zdrojProSkl',
        //            'eetTypPlatbyK' => 'eetTypPlatbyK',
        //        ),
    ];
}
