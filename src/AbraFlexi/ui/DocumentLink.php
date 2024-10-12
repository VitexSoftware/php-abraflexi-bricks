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
 * Description of DocumentLink.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class DocumentLink extends \Ease\Html\ATag
{
    /**
     * A Href to document in AbraFlexi web interface.
     */
    public function __construct(string $idCode, \AbraFlexi\Document $engine, string $format = '')
    {
        $engine->setMyKey($idCode);
        parent::__construct($engine->getApiUrl($format), \AbraFlexi\Functions::uncode((string)$engine->getRecordIdent()));
    }
}
