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

use AbraFlexi\Bricks\Convertor;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2019-02-21 at 12:27:19.
 */
class ConvertorTest extends \Test\Ease\SandTest
{
    protected Convertor $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Convertor(new \AbraFlexi\FakturaPrijata(), new \AbraFlexi\FakturaVydana());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::__construct
     */
    public function testConstruct(): void
    {
        $classname = \get_class($this->object);

        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->__construct(new \AbraFlexi\FakturaPrijata(), new \AbraFlexi\FakturaVydana(), new \AbraFlexi\Bricks\ConvertRules\Banka_to_FakturaVydana());

        $this->assertIsObject($mock->getInput());
        $this->assertIsObject($mock->getOutput());
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::setSource
     */
    public function testSetSource(): void
    {
        $sourcer = new \AbraFlexi\FakturaVydana();
        $this->object->setSource($sourcer);
        $this->assertEquals($sourcer, $this->object->getInput());
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::setDestination
     */
    public function testSetDestination(): void
    {
        $dester = new \AbraFlexi\FakturaPrijata();
        $this->object->setDestination($dester);
        $this->assertEquals($dester, $this->object->getOutput());
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::conversion
     * #expectedException \Ease\Exception
     */
    public function testConversion(): void
    {
        $varSym = \Ease\Functions::randomNumber(1111, 9999);
        $price = \Ease\Functions::randomNumber(11, 99);
        $payment = \Test\AbraFlexi\BankaTest::makeTestPayment(['varSym' => $varSym,
            'sumZklZakl' => $price]);
        $this->object->setSource($payment);

        $converted = $this->object->conversion();
        $this->assertEquals($payment->getDataValue('varSym'), $converted->getDataValue('varSym'));
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::prepareRules
     */
    public function testPrepareRules(): void
    {
        $this->object->debug = false;
        $this->object->setSource(new \AbraFlexi\Banka());
        $this->object->prepareRules(
            true /* $keepId */,
            true /* $addExtId */,
            true /* $keepCode */,
            true, /* $handleAccounting */
        );

        $this->object->debug = true;

        $this->object->setSource(new \AbraFlexi\Cenik());
        $this->expectException('\Ease\Exception'); // Cannot Load Class: \AbraFlexi\Bricks\ConvertRules\Cenik_to_FakturaVydana

        $this->object->prepareRules(
            true /* $keepId */,
            true /* $addExtId */,
            true /* $keepCode */,
            true, /* $handleAccounting */
        );
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::getConvertorClassName
     */
    public function testgetConvertorClassName(): void
    {
        $this->assertEquals('FakturaPrijata_to_FakturaVydana', $this->object->getConvertorClassName());
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::convertSubitems
     */
    public function testConvertSubitems(): void
    {
        $this->object->prepareRules(false, false, false, false);
        $source = new \AbraFlexi\FakturaVydana();
        $source->addArrayToBranch(['nazev' => 'test', 'cenaMj' => 33], 'polozkyDokladu');
        $this->object->setSource($source);
        $this->object->convertSubitems('polozkyDokladu');
        $this->assertEquals([['nazev' => 'test', 'cenaMj' => 33]], $this->object->getOutput()->getDataValue('polozkyFaktury'));
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::convertItems
     */
    public function testConvertItems(): void
    {
        $this->object->prepareRules(false, false, false, false);
        $source = new \AbraFlexi\FakturaVydana(['popis' => 'test', 'sumZklCelkem' => 2345]);
        $this->object->setSource($source);
        $this->object->convertItems();
        $this->assertEquals('test', $this->object->getOutput()->getDataValue('popis'));
    }

    //    /**
    //     * @covers AbraFlexi\Bricks\Convertor::removeRoColumns
    //     */
    //    public function testRemoveRoColumns()
    //    {
    //        $this->assertEquals('', $this->removeRoColumns());
    //    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::commonItems
     */
    public function testCommonItems(): void
    {
        $this->assertIsArray($this->object->commonItems());
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::baseClassName
     */
    public function testbaseClassName(): void
    {
        $this->assertEquals('FakturaPrijata', Convertor::baseClassName($this->object->getInput()));
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::getInput
     */
    public function testGetInput(): void
    {
        $test = new \AbraFlexi\Adresar();
        $this->object->setSource($test);
        $this->assertEquals($test, $this->object->getInput());
    }

    /**
     * @covers \AbraFlexi\Bricks\Convertor::getOutput
     */
    public function testGetOutput(): void
    {
        $test = new \AbraFlexi\Adresar();
        $this->object->setDestination($test);
        $this->assertEquals($test, $this->object->getOutput());
    }
}
