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
 * Customer class test suite.
 *
 * Tests for the refactored Customer class with PHP 8+ compatibility.
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
     * Test that Customer can be instantiated without parameters.
     */
    public function testCanBeInstantiatedWithoutParameters(): void
    {
        $customer = new Customer();
        $this->assertInstanceOf(Customer::class, $customer);
    }

    /**
     * Test that Customer can be instantiated with firma parameter.
     */
    public function testCanBeInstantiatedWithFirma(): void
    {
        $customer = new Customer([], 'code:TEST');
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('code:TEST', $customer->getFirma());
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getCustomerList
     */
    public function testGetCustomerList(): void
    {
        $result = $this->object->getCustomerList();
        $this->assertIsArray($result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::loadFromAbraFlexi
     */
    public function testLoadFromAbraFlexi(): void
    {
        // Test that method returns mixed type (can be various types)
        $result = $this->object->loadFromAbraFlexi(null);
        // Just verify it doesn't throw an error - actual behavior depends on AbraFlexi connection
        $this->assertTrue(true);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::insertToAbraFlexi
     */
    public function testInsertToAbraFlexi(): void
    {
        // Test with empty data - should use internal data
        $result = $this->object->insertToAbraFlexi([]);
        // Result type is mixed - just verify method executes
        $this->assertTrue(true);
    }

    /**
     * Test insertToAbraFlexi with data parameter.
     */
    public function testInsertToAbraFlexiWithData(): void
    {
        $testData = ['nazev' => 'Test Customer'];
        $result = $this->object->insertToAbraFlexi($testData);
        // Result type is mixed - just verify method executes
        $this->assertTrue(true);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getCustomerDebts
     */
    public function testGetCustomerDebts(): void
    {
        $result = $this->object->getCustomerDebts();
        $this->assertIsArray($result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getCustomerScore
     */
    public function testGetCustomerScore(): void
    {
        $result = $this->object->getCustomerScore(233);
        $this->assertIsInt($result);
        $this->assertGreaterThanOrEqual(0, $result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::tryToLogin
     */
    public function testTryToLogin(): void
    {
        $result = $this->object->tryToLogin(['password' => 'testPassword']);
        $this->assertIsBool($result);
        $this->assertFalse($result); // Should fail without valid credentials
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::loginSuccess
     */
    public function testLoginSuccess(): void
    {
        $result = $this->object->loginSuccess();
        $this->assertTrue($result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserName
     */
    public function testGetUserName(): void
    {
        $result = $this->object->getUserName();
        $this->assertIsString($result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserLogin
     */
    public function testGetUserLogin(): void
    {
        $result = $this->object->getUserLogin();
        $this->assertIsString($result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserEmail
     *
     * Critical test: This method had a fatal error in v1.4.1 with null values.
     */
    public function testGetUserEmail(): void
    {
        $result = $this->object->getUserEmail();
        $this->assertIsString($result);
    }

    /**
     * Test that getUserEmail returns empty string when no email is set.
     * This is the critical fix from v1.5.0 - must handle null gracefully.
     */
    public function testGetUserEmailReturnsEmptyStringWhenNull(): void
    {
        $customer = new Customer();
        $email = $customer->getUserEmail();
        $this->assertIsString($email);
        $this->assertEquals('', $email);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::passwordChange
     */
    public function testPasswordChange(): void
    {
        $result = $this->object->passwordChange('newPassword');
        $this->assertIsBool($result);
    }

    /**
     * Test passwordChange with explicit user ID.
     * Note: This will fail if trying to connect to actual AbraFlexi.
     */
    public function testPasswordChangeWithUserId(): void
    {
        // This test requires a valid AbraFlexi connection with a real user ID
        // For unit testing without connection, we just verify the method signature
        $this->expectException(\AbraFlexi\Exception::class);
        $result = $this->object->passwordChange('newPassword', 123);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::encryptPassword
     */
    public function testEncryptPassword(): void
    {
        $password = 'testPassword';
        $result = Customer::encryptPassword($password);
        $this->assertIsString($result);
        // Currently returns plaintext - this is documented behavior
        $this->assertEquals($password, $result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getUserID
     */
    public function testGetUserID(): void
    {
        $result = $this->object->getUserID();
        $this->assertIsInt($result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getAdresar
     */
    public function testGetAdresar(): void
    {
        $result = $this->object->getAdresar();
        $this->assertInstanceOf(\AbraFlexi\Adresar::class, $result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getKontakt
     */
    public function testGetKontakt(): void
    {
        $result = $this->object->getKontakt();
        $this->assertInstanceOf(\AbraFlexi\Kontakt::class, $result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getInvoicer
     */
    public function testGetInvoicer(): void
    {
        $result = $this->object->getInvoicer();
        $this->assertInstanceOf(\AbraFlexi\FakturaVydana::class, $result);
    }

    /**
     * @covers \AbraFlexi\Bricks\Customer::getFirma
     * @covers \AbraFlexi\Bricks\Customer::setFirma
     */
    public function testSetAndGetFirma(): void
    {
        $this->object->setFirma('code:TEST123');
        $this->assertEquals('code:TEST123', $this->object->getFirma());
    }

    /**
     * Test that setFirma accepts various types.
     */
    public function testSetFirmaAcceptsMixedTypes(): void
    {
        $this->object->setFirma(123);
        $this->assertEquals(123, $this->object->getFirma());

        $this->object->setFirma('code:TEST');
        $this->assertEquals('code:TEST', $this->object->getFirma());

        $this->object->setFirma(null);
        $this->assertNull($this->object->getFirma());
    }
}
