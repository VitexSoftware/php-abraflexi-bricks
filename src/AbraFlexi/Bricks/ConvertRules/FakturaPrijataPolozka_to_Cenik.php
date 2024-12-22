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
 * Description of FakturaPrijataPolozka_to_Cenik.
 *
 * @author EaseAbraFlexiConvertorRule <info@vitexsoftware.cz>
 */
class FakturaPrijataPolozka_to_Cenik extends \AbraFlexi\Bricks\ConvertorRule
{
    /**
     * Source object type.
     *
     * @var array<string, array<string, string>|string>
     */
    public array $rules = [
        'kod' => 'kod',
        'nazev' => 'nazev',
        'nazevA' => 'nazevA',
        'nazevB' => 'nazevB',
        'nazevC' => 'nazevC',
        'poznam' => 'poznam',
        //        'popis' => NULL,
        //        'platiOd' => NULL,
        //        'platiDo' => NULL,
        'eanKod' => 'eanKod',
        //        'kodPlu' => NULL,
        'typCenyDphK' => 'typCenyDphK',
        //        'procZakl' => 'procZakl',
        //        'individCena' => NULL,
        //        'limMnoz2' => NULL,
        //        'limMnoz3' => NULL,
        //        'limMnoz4' => NULL,
        //        'limMnoz5' => NULL,
        //        'procento2' => NULL,
        //        'procento3' => NULL,
        //        'procento4' => NULL,
        //        'procento5' => NULL,
        //        'cena2' => NULL,
        //        'cena3' => NULL,
        //        'cena4' => NULL,
        //        'cena5' => NULL,
        //        'zaokrJakK' => 'zaokrJakK',
        //        'zaokrNaK' => 'zaokrNaK',
        //        'typSzbDphK' => 'typSzbDphK',
        //        'desetinMj' => NULL,
        'nakupCena' => 'cenaMj',
        //        'cenJednotka' => 'cenJednotka',
        //        'typCenyVychoziK' => NULL,
        //        'typVypCenyK' => 'typVypCenyK',
        //        'typCenyVychozi25K' => NULL,
        //        'typVypCeny25K' => NULL,
        //        'evidVyrCis' => NULL,
        //        'unikVyrCis' => NULL,
        //        'zaruka' => NULL,
        //        'mjZarukyK' => NULL,
        //        'mjKoef2' => NULL,
        //        'mjKoef3' => NULL,
        //        'prodejMj' => NULL,
        //        'hmotMj' => NULL,
        //        'hmotObal' => NULL,
        //        'objem' => 'objem',
        //        'zatrid' => NULL,
        //        'skladove' => NULL,
        //        'typZasobyK' => NULL,
        //        'baleniNazev1' => NULL,
        //        'baleniNazev2' => NULL,
        //        'baleniNazev3' => NULL,
        //        'baleniNazev4' => NULL,
        //        'baleniNazev5' => NULL,
        //        'baleniMj1' => NULL,
        //        'baleniMj2' => NULL,
        //        'baleniMj3' => NULL,
        //        'baleniMj4' => NULL,
        //        'baleniMj5' => NULL,
        //        'baleniEan1' => NULL,
        //        'baleniEan2' => NULL,
        //        'baleniEan3' => NULL,
        //        'baleniEan4' => NULL,
        //        'baleniEan5' => NULL,
        //        'inEvid' => NULL,
        //        'inKoefMj' => NULL,
        //        'inKoefStat' => NULL,
        //        'inKodSled' => NULL,
        //        'popisA' => NULL,
        //        'popisB' => NULL,
        //        'popisC' => NULL,
        //        'cenaBezna' => NULL,
        //        'stitky' => 'stitky',
        //        'exportNaEshop' => NULL,
        //        'minMarzeCenik' => NULL,
        //        'minMarze' => 'minMarze',
        //        'evidSarze' => NULL,
        //        'evidExpir' => NULL,
        //        'dnyTrvanPoExpir' => NULL,
        //        'neseskupovatObj' => NULL,
        'kratkyPopis' => 'kod',
        'klicSlova' => 'kod',
        //        'techParam' => NULL,
        //        'dodaciLhuta' => NULL,
        //        'prodejKasa' => NULL,
        //        'skupZboz' => NULL,
        //        'mj1' => NULL,
        //        'mj2' => NULL,
        //        'mj3' => NULL,
        //        'mjHmot' => NULL,
        //        'mjObj' => NULL,
        //        'stat' => NULL,
        //        'nomen' => NULL,
        'dodavatel' => 'dodavatel',
        //        'vyrobce' => NULL,
        //        'dphPren' => 'dphPren',
        //        'mjDodaciLhuta' => NULL,
        //        'cenaZakl' => NULL,
    ];
}
