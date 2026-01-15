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

namespace AbraFlexi\Bricks;

/**
 * Description of GateKeeper.
 *
 * @version 0.1
 *
 * @author vitex
 */
class GateKeeper extends \Ease\Sand
{
    /**
     * Is document accessible by user ?
     *
     * @param \AbraFlexi\RO              $document AbraFlexi documnet
     * @param Customer|\Ease\Anonym|User $user     Current User
     *
     * @return bool
     */
    public static function isAccessibleBy($document, $user)
    {
        $result = null;

        switch (Convertor::baseClassName($user)) {
            case 'User': // Admin
                $result = true;

                break;
            case 'Customer': // Customer
                $result = (self::getDocumentCompany($document)->getRecordCode() === self::getCustomerCompany($user)->getRecordCode());

                break;
            case 'Anonym': // Anonymous
                $result = false;

                break;
        }

        return $result;
    }

    /**
     * Get Company code for document.
     *
     * @param \AbraFlexi\RO $document
     *
     * @return string documnent code
     */
    public static function getDocumentCompany($document)
    {
        return $document->getDataValue('firma') ? \AbraFlexi\Code::strip(
            (string)
            $document->getDataValue('firma'),
        ) : null;
    }

    /**
     * Obtain customer company code.
     *
     * @param Customer $customer
     *
     * @return int
     */
    public static function getCustomerCompany($customer)
    {
        return $customer->getAdresar()->getDataValue('kod') ? \AbraFlexi\Code::strip((string) $customer->getAdresar()->getDataValue('kod')) : null;
    }
}
