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
 * Description of AbraFlexiUser.
 *
 * @author vitex
 */
class Customer extends \Ease\User
{
    public \AbraFlexi\Adresar $adresar;

    /**
     * Contact.
     */
    public \AbraFlexi\Kontakt $kontakt;

    /**
     * Invoice Issued.
     */
    public \AbraFlexi\FakturaVydana $invoicer;

    /**
     * Loaded Data origin.
     */
    public string $origin;

    /**
     * User login name.
     */
    public ?string $userLogin;

    /**
     * Column with login.
     */
    public ?string $loginColumn = 'username';

    /**
     * Customer.
     *
     * @param array<string, string> $userInfo
     */
    public function __construct(array $userInfo = [])
    {
        parent::__construct();

        if (isset($userInfo['username'])) {
            $contactInfo = $this->getKontakt()->getColumnsFromAbraFlexi(
                '*',
                ['username' => $userInfo['username']],
            );

            if ($contactInfo) {
                $this->getKontakt()->takeData($contactInfo);
                $this->takeData($contactInfo);
                $this->origin = 'kontakt';
            }
        }

        if (isset($userInfo['email'])) {
            $contactInfo = $this->getKontakt()->getColumnsFromAbraFlexi(
                '*',
                ['email' => $userInfo['email']],
            );

            if (!empty($contactInfo)) {
                $this->getKontakt()->takeData($contactInfo[0]);
                $this->takeData($contactInfo[0]);
                $this->origin = 'kontakt';
            } else {
                $contactInfo = $this->getAdresar()->getColumnsFromAbraFlexi(
                    '*',
                    ['email' => $userInfo['email']],
                );

                if (!empty($contactInfo)) {
                    $this->getAdresar()->takeData($contactInfo);
                    $this->takeData($contactInfo);
                    $this->origin = 'adresar';
                }
            }
        }
    }

    /**
     * Return Customers.
     *
     * @param array<string, string> $conditions
     *
     * @return array<string, string>
     */
    public function getCustomerList(array $conditions = []): array
    {
        return $this->adresar->getColumnsFromAbraFlexi(
            ['id', 'nazev'],
            $conditions,
            'nazev',
        );
    }

    /**
     * Load Customer from AbraFlexi.
     *
     * @param id $id AbraFlexi address record ID
     */
    public function loadFromAbraFlexi($id = null): int
    {
        $result = $this->getAdresar()->loadFromAbraFlexi($id);
        $this->takeData($this->getAdresar()->getData());

        return $result;
    }

    /**
     * Load Customer from AbraFlexi.
     *
     * @param array<string, string> $data to insert to AbraFlexi
     *
     * @return int
     */
    public function insertToAbraFlexi($data = []): bool
    {
        if ($data) {
            $data = $this->getData();
        }

        switch ($this->origin) {
            case 'adresar':
                $result = $this->getAdresar()->insertToAbraFlexi($data);

                break;
            case 'kontakt':
                $result = $this->getKontakt()->insertToAbraFlexi($data);

                break;

            default:
                $result = $this->getKontakt()->insertToAbraFlexi($data);
                $result = $this->getAdresar()->insertToAbraFlexi($data);

                break;
        }

        return $result;
    }

    /**
     * Returns unpaid invoices of the customer.
     *
     * @param mixed $customer Customer Identifier or Object
     *
     * @return array<string, string>
     */
    public function getCustomerDebts($customer): array
    {
        switch (\gettype($customer)) {
            case 'object':
                if (\Ease\Functions::baseClassName($customer) === 'Customer') {
                    $firma = $customer->adresar;
                } else {
                    $firma = $customer;
                }

                break;
            case 'NULL':
                $firma = $this->getAdresar();

                break;

            default:
            case 'string':
            case 'int':
                $firma = $customer;

                break;
        }

        if (isset($this->invoicer) === false) {
            $this->invoicer = new \AbraFlexi\FakturaVydana();
        }

        $result = [];
        $this->getInvoicer()->defaultUrlParams['order'] = 'datVyst@A';
        $invoices = $this->getInvoicer()->getColumnsFromAbraFlexi(
            [
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
            ["datSplat lte '".\AbraFlexi\Functions::dateToFlexiDate(new \DateTime())."' AND (stavUhrK is null OR stavUhrK eq 'stavUhr.castUhr') AND storno eq false AND firma=".(is_numeric($firma) ? $firma : "'".$firma."'")],
            'kod',
        );

        if ($this->getInvoicer()->lastResponseCode === 200) {
            $result = $invoices;
        }

        return $result;
    }

    /**
     * Obtain Customer "Score".
     *
     * @param int    $addressID AbraFlexi user ID
     * @param string $label1    first remind Label
     * @param string $label2    second remind label
     *
     * @return int ZewlScore
     */
    public function getCustomerScore($addressID = null, $label1 = 'UPOMINKA1', $label2 = 'UPOMINKA2')
    {
        $score = 0;
        $debts = $this->getCustomerDebts($addressID ?: $this->adresar);
        $stitkyRaw = $this->adresar->getColumnsFromAbraFlexi(
            ['stitky'],
            ['id' => $addressID ? $addressID : $this->adresar->getRecordID()],
        );
        $stitky = $stitkyRaw[0]['stitky'];

        if (!empty($debts)) {
            foreach ($debts as $did => $debt) {
                $ddiff = \AbraFlexi\FakturaVydana::overdueDays($debt['datSplat']);

                if (($ddiff <= 7) && ($ddiff >= 1)) {
                    $score = self::maxScore($score, 1);
                } else {
                    if (($ddiff > 7) && ($ddiff <= 14)) {
                        $score = self::maxScore($score, 2);
                    } else {
                        if ($ddiff > 14) {
                            $score = self::maxScore($score, 3);
                        }
                    }
                }
            }
        }

        if ($score === 3 && !strstr($stitky, $label2)) {
            $score = 2;
        }

        if (!strstr($stitky, $label1) && !empty($debts)) {
            $score = 1;
        }

        return $score;
    }

    /**
     * Try to Sign in.
     *
     * @param array<string, string> $formData form data e.g. $_REQUEST
     *
     * @return null|bool
     */
    public function tryToLogin(array $formData): bool
    {
        $login = \array_key_exists($this->loginColumn, $formData) ? trim($formData[$this->loginColumn]) : '';
        $password = \array_key_exists($this->passwordColumn, $formData) ? trim($formData[$this->passwordColumn]) : '';

        if ($login) {
            if ($password) {
                $result = $this->kontakt->authenticate($login, $password);

                if ($result === true) {
                    $this->kontakt->defaultUrlParams['detail'] = 'full';
                    $contactId = $this->kontakt->loadFromAbraFlexi([
                        $this->loginColumn => $login]);

                    if (\is_array($contactId)) {
                        $this->addStatusMessage(sprintf(
                            _('Multiplete ContactID'),
                            serialize($contactId),
                        ), 'warning');
                        $contactId = current($contactId);
                        $this->addStatusMessage(_('Using the first one'));
                    }

                    $firma = $this->kontakt->getDataValue('firma');
                    $this->adresar->loadFromAbraFlexi(['id' => $firma]);
                    $this->addStatusMessage($firma.' '.$this->adresar->getDataValue('nazev'));
                    $result = $this->loginSuccess();
                }
            } else {
                $this->addStatusMessage(_('missing password'), 'error');
                $result = false;
            }
        } else {
            $this->addStatusMessage(_('missing login'), 'error');
            $result = false;
        }

        return $result;
    }

    /**
     * Actions performed after successful login
     * if the record does not exist yet, a new one is created.
     */
    public function loginSuccess()
    {
        $this->userID = (int) $this->getKontakt()->getMyKey();
        $this->setUserLogin($this->kontakt->getDataValue($this->loginColumn));
        $this->logged = true;
        $this->addStatusMessage(
            sprintf(_('Sign in %s all ok'), $this->userLogin),
            'success',
        );

        return true;
    }

    /**
     * Give you user name.
     */
    public function getUserName(): string
    {
        return (string) $this->getKontakt()->getDataValue($this->loginColumn);
    }

    /**
     * Give you user name.
     */
    public function getUserLogin(): string
    {
        return $this->getUserName();
    }

    /**
     * Return user's mail address.
     */
    public function getUserEmail(): string
    {
        return \strlen($this->getKontakt()->getDataValue($this->mailColumn)) ? $this->kontakt->getDataValue($this->mailColumn) : $this->adresar->getDataValue($this->mailColumn);
    }

    /**
     * Change the user's stored password.
     *
     * @param string $newPassword new password
     * @param int    $userID      user ID
     */
    public function passwordChange($newPassword, $userID = null): bool
    {
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

            if ($this->kontakt->lastResponseCode === 201) {
                $this->kontakt->addStatusMessage(_('Password set'), 'success');
                $this->kontakt->loadFromAbraFlexi();
            } else {
                $hash = null;
                $this->kontakt->addStatusMessage(_('Password set failed'), 'warning');
            }

            $this->addStatusMessage('PasswordChange: '.$this->getDataValue($this->loginColumn).'@'.$userID.' '.$hash, 'debug');

            if ($userID === $this->getUserID()) {
                $this->setDataValue($this->passwordColumn, $hash);
            }
        }

        return $hash !== null;
    }

    /**
     * Encrypts the password.
     *
     * @param string $plainTextPassword plainext password
     *
     * @todo Enable Encrypted passwords for AbraFlexi
     *
     * @return string Encrypted password
     */
    public static function encryptPassword($plainTextPassword)
    {
        return $plainTextPassword;
    }

    /**
     * Returns the ID of the logged-in user.
     *
     * @return int user ID
     */
    public function getUserID(): int
    {
        if (isset($this->userID)) {
            return (int) $this->userID;
        }

        return (int) $this->kontakt->getMyKey();
    }

    public function getAdresar(): \AbraFlexi\Adresar
    {
        if ((isset($this->adresar) === false) || empty($this->adresar)) {
            $this->adresar = new \AbraFlexi\Adresar();
        }

        return $this->adresar;
    }

    public function getKontakt(): \AbraFlexi\Kontakt
    {
        if ((isset($this->kontakt) === false) || empty($this->kontakt)) {
            $this->kontakt = new \AbraFlexi\Kontakt(['firma' => $this->getAdresar()]);
        }

        return $this->kontakt;
    }

    public function getInvoicer(): \AbraFlexi\FakturaVydana
    {
        if (isset($this->invoicer) === false) {
            $this->invoicer = new \AbraFlexi\FakturaVydana(['firma' => $this->getAdresar()]);
        }

        return $this->invoicer;
    }

    /**
     * Overdue group.
     *
     * @param int $score current score value
     * @param int $level current level
     *
     * @return int max of all levels processed
     */
    private static function maxScore(int $score, int $level): int
    {
        if ($level > $score) {
            $score = $level;
        }

        return $score;
    }
}
