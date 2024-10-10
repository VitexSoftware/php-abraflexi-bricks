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
 * Description of EmbedResponsive.
 *
 * @author vitex
 */
class EmbedResponsiveHTML extends EmbedResponsive
{
    /**
     * Ebed Document's HTML to Page.
     *
     * @param \AbraFlexi\RO $source object with document
     * @param string        $feeder script can send us the pdf
     */
    public function __construct($source, $feeder = 'gethtml.php')
    {
        $url = $feeder.'?evidence='.$source->getEvidence().'&id='.$source->getMyKey().'&embed=true';

        parent::__construct(
            '<iframe src=\''.$url.'\' type=\'text/html\' width=\'100%\' height=\'100%\'></iframe>',
            ['class' => 'embed-responsive', 'style' => 'padding-bottom:150%'],
        );
    }
}
