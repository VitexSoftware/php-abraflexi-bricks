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

use AbraFlexi\Bricks\Customer;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2022-11-23 at 23:27:06.
 */
class CustomerTest extends \PHPUnit\Framework\TestCase
{
    protected Customer $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Customer();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getCustomerList
     *
     * @todo   Implement testgetCustomerList().
     */
    public function testgetCustomerList(): void
    {
        $this->assertEquals('', $this->object->getCustomerList());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::loadFromAbraFlexi
     *
     * @todo   Implement testloadFromAbraFlexi().
     */
    public function testloadFromAbraFlexi(): void
    {
        $this->assertEquals('', $this->object->loadFromAbraFlexi());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::insertToAbraFlexi
     *
     * @todo   Implement testinsertToAbraFlexi().
     */
    public function testinsertToAbraFlexi(): void
    {
        $this->assertEquals('', $this->object->insertToAbraFlexi());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getCustomerDebts
     *
     * @todo   Implement testgetCustomerDebts().
     */
    public function testgetCustomerDebts(): void
    {
        $this->assertEquals('', $this->object->getCustomerDebts());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getCustomerScore
     */
    public function testgetCustomerScore(): void
    {
        $this->assertEquals([], $this->object->getCustomerScore(233));
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::tryToLogin
     *
     * @todo   Implement testtryToLogin().
     */
    public function testtryToLogin(): void
    {
        $this->assertEquals('', $this->object->tryToLogin());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::loginSuccess
     *
     * @todo   Implement testloginSuccess().
     */
    public function testloginSuccess(): void
    {
        $this->assertEquals('', $this->object->loginSuccess());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserName
     *
     * @todo   Implement testgetUserName().
     */
    public function testgetUserName(): void
    {
        $this->assertEquals('', $this->object->getUserName());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserLogin
     *
     * @todo   Implement testgetUserLogin().
     */
    public function testgetUserLogin(): void
    {
        $this->assertEquals('', $this->object->getUserLogin());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserEmail
     *
     * @todo   Implement testgetUserEmail().
     */
    public function testgetUserEmail(): void
    {
        $this->assertEquals('', $this->object->getUserEmail());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::passwordChange
     *
     * @todo   Implement testpasswordChange().
     */
    public function testpasswordChange(): void
    {
        $this->assertEquals('', $this->object->passwordChange());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::encryptPassword
     *
     * @todo   Implement testencryptPassword().
     */
    public function testencryptPassword(): void
    {
        $this->assertEquals('', $this->object->encryptPassword());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserID
     *
     * @todo   Implement testgetUserID().
     */
    public function testgetUserID(): void
    {
        $this->assertEquals('', $this->object->getUserID());
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
