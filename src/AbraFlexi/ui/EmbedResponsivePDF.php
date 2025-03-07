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
 * @deprecated this class is deprecated and will be removed in a future release
 *
 * @author vitex
 */
class EmbedResponsivePDF extends EmbedResponsive
{
    /**
     * Ebed Document's PDF to Page.
     *
     * @see https://www.abraflexi.eu/api/dokumentace/ref/pdf/ PDF Export
     *
     * @param \AbraFlexi\RO $source object with document
     * @param string        $feeder script can send us the pdf
     * @param string        $report printSet name
     */
    public function __construct($source, $feeder = 'getpdf.php', $report = null)
    {
        $addParams = ['evidence' => $source->getEvidence(), 'embed' => 'true'];

        if (!empty($source->getMyKey())) {
            $addParams['id'] = $source->getMyKey();
        }

        if (!empty($report)) {
            $addParams['report-name'] = urlencode($report);
        }

        $url = \Ease\Functions::addUrlParams($feeder, $addParams);

        parent::__construct(
            '<object data=\''.$url.'\' type=\'application/pdf\' height=\'600\' width=\'100%\'></object>',
            ['class' => 'embed-responsive', 'style' => 'min-height:100vh;width:100%'],
        );
    }
}
