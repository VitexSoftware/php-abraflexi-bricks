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

namespace Test\AbraFlexi\Bricks;

use AbraFlexi\Bricks\GdprLog;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2022-11-23 at 23:27:04.
 */
class GdprLogTest extends \PHPUnit\Framework\TestCase
{
    protected GdprLog $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new GdprLog();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @covers \AbraFlexi\Bricks\GdprLog::logAbraFlexiEvent
     *
     * @todo   Implement testlogAbraFlexiEvent().
     */
    public function testlogAbraFlexiEvent(): void
    {
        $this->assertEquals('', $this->object->logAbraFlexiEvent());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\GdprLog::logAbraFlexiChange
     *
     * @todo   Implement testlogAbraFlexiChange().
     */
    public function testlogAbraFlexiChange(): void
    {
        $this->assertEquals('', $this->object->logAbraFlexiChange());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
