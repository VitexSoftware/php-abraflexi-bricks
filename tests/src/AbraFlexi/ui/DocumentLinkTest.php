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

namespace Test\AbraFlexi\ui;

use AbraFlexi\ui\DocumentLink;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2022-10-04 at 20:24:48.
 */
class DocumentLinkTest extends \PHPUnit\Framework\TestCase
{
    protected DocumentLink $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new DocumentLink(new \AbraFlexi\Adresar('code:TEST',['ignore404'=>true]));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }
}
