<?php

/**
 * AbraFlexi - WebHook reciever
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Description of GateKeeper
 * 
 * @version 0.1
 *
 * @author vitex
 */
class GateKeeper extends \Ease\Sand {

    /**
     * Is document accessible by user ?
     *
     * @param \AbraFlexi\RO $document AbraFlexi documnet
     * @param Customer|User|\Ease\Anonym $user Current User
     *
     * @return boolean
     */
    public static function isAccessibleBy($document, $user) {
        $result = null;
        switch (Convertor::baseClassName($user)) {
            case 'User': //Admin
                $result = true;
                break;
            case 'Customer': //Customer
                $result = (self::getDocumentCompany($document) == self::getCustomerCompany($user));
                break;
            case 'Anonym': //Anonymous
                $result = false;
                break;
        }
        return $result;
    }

    /**
     * Get Company code for document
     *
     * @param \AbraFlexi\RO $document
     *
     * @return string documnent code
     */
    public static function getDocumentCompany($document) {
        return $document->getDataValue('firma') ? \AbraFlexi\RO::uncode(
                        $document->getDataValue('firma')) : null;
    }

    /**
     * Obtain customer company code
     *
     * @param Customer $customer
     * 
     * @return int
     */
    public static function getCustomerCompany($customer) {
        return $customer->adresar->getDataValue('kod') ? \AbraFlexi\RO::uncode($customer->adresar->getDataValue('kod')) : null;
    }

}
