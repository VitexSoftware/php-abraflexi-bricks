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

namespace AbraFlexi\ui;

/**
 * Description of SearchBox.
 *
 * @deprecated this class is deprecated and will be removed in a future release
 *
 * @author vitex
 */
class SearchBox extends \Ease\Html\InputSearchTag
{
    public function afterAdd(): void
    {
        $this->parent()->addItem(new \Ease\Html\DatalistTag(
            new \Ease\Html\OptionTag('zatim nic'),
            ['id' => 'datalist-'.$this->getTagID()],
        ));
        $this->addJavaScript(<<<'EOD'

var dataList = $('#datalist-
EOD.$this->getTagID().<<<'EOD'
');
var input = $('#
EOD.$this->getTagID().<<<'EOD'
');

input.change(function() {
    $.getJSON( "pricelistsearcher.php?column=nazev&q=" + input.val() , function( data ) {
//      dataList.empty();
      $.each( data, function( key, val ) {
        alert(val['nazev']);
        var option = document.createElement('option');
        option.value = val['nazev'];
        dataList.appendChild(option);
      });

    });

});



EOD);
    }

    public function finalize(): void
    {
        $this->setTagProperties(['list' => 'datalist-'.$this->getTagID()]);
        parent::finalize();
    }
}
