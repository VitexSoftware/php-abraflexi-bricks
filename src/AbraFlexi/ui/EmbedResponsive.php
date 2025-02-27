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
class EmbedResponsive extends \Ease\Html\DivTag
{
    public function finalize(): void
    {
        $this->addCSS(<<<'EOD'

.embed-responsive {
    position: relative;
    display: block;
    height: 0;
    padding: 0;
    overflow: hidden;
}

EOD);
        parent::finalize();
    }
}
