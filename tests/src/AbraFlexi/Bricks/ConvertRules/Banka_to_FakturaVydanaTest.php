<?php

namespace Test\AbraFlexi\Bricks\ConvertRules;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2020-03-25 at 11:18:50.
 */
class Banka_to_FakturaVydanaTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Banka_to_FakturaVydana
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Banka_to_FakturaVydana();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        
    }

    /**
     * @covers AbraFlexi\Bricks\ConvertRules\Banka_to_FakturaVydana::sumCelkZakl
     * @todo   Implement testSumCelkZakl().
     */
    public function testSumCelkZakl()
    {
        $this->assertEquals('', $this->object->SumCelkZakl());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}