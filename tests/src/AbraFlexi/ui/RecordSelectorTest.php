<?php

namespace Test\AbraFlexi\ui;

use AbraFlexi\ui\RecordSelector;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2022-10-04 at 20:24:22.
 */
class RecordSelectorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var RecordSelector
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new RecordSelector();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        
    }

    /**
     * @covers AbraFlexi\ui\RecordSelector::selectize
     * @todo   Implement testselectize().
     */
    public function testselectize()
    {
        $this->assertEquals('', $this->object->selectize());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}