<?php

/**
 * AbraFlexi Bricks - Customer Class
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2021 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Description of AbraFlexiUser
 *
 * @author vitex
 */
class Customer extends \Ease\User {

    /**
     *
     * @var \AbraFlexi\Adresar
     */
    public $adresar = null;

    /**
     * Contact
     * @var \AbraFlexi\Kontakt
     */
    public $kontakt = null;

    /**
     * Invoice Issued
     * @var \AbraFlexi\FakturaVydana
     */
    public $invoicer = null;

    /**
     * Loaded Data origin
     * @var string
     */
    public $origin = null;

    /**
     * Přihlašovací jméno uživatele.
     *
     * @var string
     */
    public $userLogin = null;

    /**
     * Sloupeček s loginem.
     *
     * @var string
     */
    public $loginColumn = 'username';

    /**
     * Customer
     * @param mixed $userID
     */
    public function __construct($userID = null) {
        $this->adresar = new \AbraFlexi\Adresar();
        $this->kontakt = new \AbraFlexi\Kontakt();
        parent::__construct();

        if (is_array($userID)) {
            if (isset($userID['username'])) {
                $contactInfo = $this->kontakt->getColumnsFromAbraFlexi('*',
                        ['username' => $userID['username']]);
                if (!is_null($contactInfo)) {
                    $this->kontakt->takeData($contactInfo);
                    $this->takeData($contactInfo);
                    $this->origin = 'kontakt';
                }
            }
            if (isset($userID['email'])) {
                $contactInfo = $this->kontakt->getColumnsFromAbraFlexi('*',
                        ['email' => $userID['email']]);
                if (!empty($contactInfo)) {
                    $this->kontakt->takeData($contactInfo[0]);
                    $this->takeData($contactInfo[0]);
                    $this->origin = 'kontakt';
                } else {
                    $contactInfo = $this->adresar->getColumnsFromAbraFlexi('*',
                            ['email' => $userID['email']]);
                    if (!empty($contactInfo)) {
                        $this->adresar->takeData($contactInfo);
                        $this->takeData($contactInfo);
                        $this->origin = 'adresar';
                    }
                }
            }
        }
    }

    /**
     * Return Cutomers
     * @return array
     */
    public function getCustomerList() {
        return $this->adresar->getColumnsFromAbraFlexi(['id', 'stitky'], null,
                        'id');
    }

    /**
     * Load Customer from AbraFlexi
     *
     * @param id $id AbraFlexi address record ID
     * @return int
     */
    public function loadFromAbraFlexi($id = null) {
        $result = $this->adresar->loadFromAbraFlexi($id);
        $this->takeData($this->adresar->getData());
        return $result;
    }

    public function insertToAbraFlexi($data = null) {
        if (is_null($data)) {
            $data = $this->getData();
        }

        switch ($this->origin) {
            case 'adresar':
                $result = $this->adresar->insertToAbraFlexi($data);
                break;
            case 'kontakt':
                $result = $this->kontakt->insertToAbraFlexi($data);
                break;
            default:
                $result = $this->kontakt->insertToAbraFlexi($data);
                $result = $this->adresar->insertToAbraFlexi($data);
                break;
        }
        return $result;
    }

    /**
     * Vrací nesplacene faktury klienta
     *
     * @param mixed $customer Customer Identifier or Object
     * @return array
     */
    public function getCustomerDebts($customer = null) {
        switch (gettype($customer)) {
            case 'object':
                if (get_class($customer) == 'Customer') {
                    $firma = $customer->adresa;
                } else {
                    $firma = $customer;
                }
                break;
            case 'NULL':
                $firma = $this->adresar;
                break;
            default:
            case 'string':
            case 'int':
                $firma = $customer;
                break;
        }

        if (!is_object($this->invoicer)) {
            $this->invoicer = new \AbraFlexi\FakturaVydana();
        }
        $result = [];
        $this->invoicer->defaultUrlParams['order'] = 'datVyst@A';
        $invoices = $this->invoicer->getColumnsFromAbraFlexi([
            'id',
            'kod',
            'stavUhrK',
            'firma',
            'buc',
            'varSym',
            'specSym',
            'sumCelkem',
            'duzpPuv',
            'typDokl(typDoklK,kod)',
            'datSplat',
            'zbyvaUhradit',
            'mena',
            'zamekK',
            'datVyst'],
                ["datSplat lte '" . \AbraFlexi\RW::dateToFlexiDate(new \DateTime()) . "' AND (stavUhrK is null OR stavUhrK eq 'stavUhr.castUhr') AND storno eq false AND firma=" . (is_numeric($firma) ? $firma : "'" . $firma . "'" )], 'kod');

        if ($this->invoicer->lastResponseCode == 200) {
            $result = $invoices;
        }
        return $result;
    }

    /**
     * Obtain Customer "Score"
     *
     * @param int $addressID AbraFlexi user ID
     * 
     * @return int ZewlScore
     */
    public function getCustomerScore($addressID) {
        $score = 0;
        $debts = $this->getCustomerDebts($addressID);
        $stitkyRaw = $this->adresar->getColumnsFromAbraFlexi(['stitky'],
                ['id' => $addressID]);
        $stitky = $stitkyRaw[0]['stitky'];
        if (!empty($debts)) {
            foreach ($debts as $did => $debt) {
                $ddiff = \AbraFlexi\FakturaVydana::overdueDays($debt['datSplat']);

                if (($ddiff <= 7) && ($ddiff >= 1)) {
                    $score = self::maxScore($score, 1);
                } else {
                    if (($ddiff > 7 ) && ($ddiff <= 14)) {
                        $score = self::maxScore($score, 2);
                    } else {
                        if ($ddiff > 14) {
                            $score = self::maxScore($score, 3);
                        }
                    }
                }
            }
        }
        if ($score == 3 && !strstr($stitky, 'UPOMINKA2')) {
            $score = 2;
        }

        if (!strstr($stitky, 'UPOMINKA1') && !empty($debts)) {
            $score = 1;
        }

        return $score;
    }

    /**
     * Overdue group
     *
     * @param int $score current score value
     * @param int $level current level
     *
     * @return int max of all levels processed
     */
    static private function maxScore($score, $level) {
        if ($level > $score) {
            $score = $level;
        }
        return $score;
    }

    /**
     * Pokusí se o přihlášení.
     * Try to Sign in.
     *
     * @param array $formData pole dat z přihlaš. formuláře např. $_REQUEST
     *
     * @return null|boolean
     */
    public function tryToLogin($formData) {
        $login = array_key_exists($this->loginColumn, $formData) ? trim($formData[$this->loginColumn]) : '';
        $password = array_key_exists($this->passwordColumn, $formData) ? trim($formData[$this->passwordColumn]) : '';
        if (!$login) {
            $this->addStatusMessage(_('missing login'), 'error');

            return;
        }
        if (!$password) {
            $this->addStatusMessage(_('missing password'), 'error');

            return;
        }

        $result = $this->kontakt->authenticate($login, $password);
        if ($result === true) {
            $this->kontakt->defaultUrlParams['detail'] = 'full';
            $contactId = $this->kontakt->loadFromAbraFlexi([
                $this->loginColumn => $login]);
            if (is_array($contactId)) {
                $this->addStatusMessage(sprintf(_('Multiplete ContactID'),
                                serialize($contactId)), 'warning');
                $contactId = current($contactId);
                $this->addStatusMessage(_('Using the first one'));
            }

            $firma = $this->kontakt->getDataValue('firma');
            $this->adresar->loadFromAbraFlexi(['id' => $firma]);

            $this->addStatusMessage($firma . ' ' . $this->adresar->getDataValue('nazev'));

            $result = $this->loginSuccess();
        }
        return $result;
    }

    /**
     * Akce provedené po úspěšném přihlášení
     * pokud tam jeste neexistuje zaznam, vytvori se novy.
     */
    public function loginSuccess() {
        $this->userID = (int) $this->kontakt->getMyKey();
        $this->setUserLogin($this->kontakt->getDataValue($this->loginColumn));
        $this->logged = true;
        $this->addStatusMessage(sprintf(_('Sign in %s all ok'), $this->userLogin),
                'success');

        return true;
    }

    /**
     * Give you user name.
     *
     * @return string
     */
    public function getUserName() {
        return $this->kontakt->getDataValue($this->loginColumn);
    }

    /**
     * Give you user name.
     *
     * @return string
     */
    public function getUserLogin() {
        return $this->getUserName();
    }

    /**
     * Retrun user's mail address.
     *
     * @return string
     */
    public function getUserEmail() {
        return strlen($this->kontakt->getDataValue($this->mailColumn)) ? $this->kontakt->getDataValue($this->mailColumn) : $this->adresar->getDataValue($this->mailColumn);
    }

    /**
     * Změní uživateli uložené heslo.
     *
     * @param string $newPassword nové heslo
     * @param int    $userID      id uživatele
     *
     * @return string password hash
     */
    public function passwordChange($newPassword, $userID = null) {
        $hash = null;
        if (empty($userID)) {
            $userID = $this->getUserID();
        }
        if (!empty($userID)) {
            $hash = self::encryptPassword($newPassword);

            $this->kontakt->insertToAbraFlexi([
                'id' => $userID,
                'username' => $this->getUserLogin(),
                'password' => $hash,
//    'password@hash' => 'sha256',
//    'password@salt' => 'osoleno',
            ]);
            if ($this->kontakt->lastResponseCode == 201) {
                $this->kontakt->addStatusMessage('Password set', 'success');
                $this->kontakt->loadFromAbraFlexi();
            } else {
                $hash = null;
                $this->kontakt->addStatusMessage('Password set failed',
                        'warning');
            }

            $this->addToLog('PasswordChange: ' . $this->getDataValue($this->loginColumn) . '@' . $userID . '#' . $this->getDataValue($this->myIDSColumn) . ' ' . $hash);
            if ($userID == $this->getUserID()) {
                $this->setDataValue($this->passwordColumn, $hash);
            }
        }

        return $hash;
    }

    /**
     * Zašifruje heslo.
     *
     * @param string $plainTextPassword nešifrované heslo (plaintext)
     *
     * @return string Encrypted password
     */
    public static function encryptPassword($plainTextPassword) {
        return $plainTextPassword;
    }
    
    /**
     * Vraci ID přihlášeného uživatele.
     *
     * @return int ID uživatele
     */
    public function getUserID() {
        if (isset($this->userID)) {
            return (int) $this->userID;
        }

        return (int) $this->kontakt->getMyKey();
    }

}
