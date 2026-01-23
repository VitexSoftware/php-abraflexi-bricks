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
 * Customer entity bridging Ease\User with AbraFlexi Kontakt and Adresar.
 *
 * This class provides authentication and customer management functionality
 * by integrating with AbraFlexi's contact (Kontakt) and address book (Adresar) entities.
 *
 * @author vitex
 */
class Customer extends \Ease\User
{
    /**
     * Column with login (must be public per parent class requirement).
     */
    public ?string $loginColumn = 'username';

    /**
     * Column with email (must be public per parent class requirement).
     */
    public ?string $mailColumn = 'mail';
    private ?\AbraFlexi\Adresar $adresar = null;

    /**
     * Contact entity.
     */
    private ?\AbraFlexi\Kontakt $kontakt = null;

    /**
     * Invoice Issued entity.
     */
    private ?\AbraFlexi\FakturaVydana $invoicer = null;

    /**
     * Loaded Data origin (either 'kontakt' or 'adresar').
     */
    private ?string $origin = null;

    /**
     * AbraFlexi firma (company) identifier.
     */
    private mixed $firma = null;

    /**
     * Customer constructor.
     *
     * @param array<string, string> $userInfo User identification data (username or email)
     * @param mixed                 $firma    AbraFlexi firma identifier (optional)
     */
    public function __construct(array $userInfo = [], mixed $firma = null)
    {
        parent::__construct();
        $this->firma = $firma;

        if (isset($userInfo['username']) && !empty($userInfo['username'])) {
            $this->loadByUsername($userInfo['username']);
        } elseif (isset($userInfo['email']) && !empty($userInfo['email'])) {
            $this->loadByEmail($userInfo['email']);
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
        return $this->getAdresar()->getColumnsFromAbraFlexi(
            ['id', 'nazev'],
            $conditions,
            'nazev',
        );
    }

    /**
     * Load Customer from AbraFlexi by address ID.
     *
     * @param mixed $id AbraFlexi address record ID
     *
     * @return mixed Result from AbraFlexi load operation
     */
    public function loadFromAbraFlexi($id = null): mixed
    {
        $result = $this->getAdresar()->loadFromAbraFlexi($id);
        $adresarData = $this->getAdresar()->getData();

        if ($adresarData !== null) {
            $this->takeData($adresarData);
        }

        $this->origin = 'adresar';

        return $result;
    }

    /**
     * Insert customer data to AbraFlexi.
     *
     * @param array<string, mixed> $data Data to insert (empty array uses internal data)
     *
     * @return mixed Insert result from AbraFlexi
     */
    public function insertToAbraFlexi(array $data = []): mixed
    {
        // Use internal data if no data provided
        if (empty($data)) {
            $internalData = $this->getData();
            $data = $internalData ?? [];
        }

        // Insert based on origin
        switch ($this->origin) {
            case 'adresar':
                return $this->getAdresar()->insertToAbraFlexi($data);
            case 'kontakt':
                return $this->getKontakt()->insertToAbraFlexi($data);

            default:
                // No origin set - this shouldn't happen in normal flow
                $this->addStatusMessage('No origin set for customer data insertion', 'warning');

                return false;
        }
    }

    /**
     * Returns unpaid invoices of the customer.
     *
     * @return array<int, array<string, mixed>> Array of unpaid invoices
     */
    public function getCustomerDebts(): array
    {
        $firmaId = $this->getAdresar()->getMyKey();

        if (empty($firmaId)) {
            $this->addStatusMessage('Cannot load debts: no firma ID available', 'warning');

            return [];
        }

        $invoicer = $this->getInvoicer();
        $invoicer->defaultUrlParams['order'] = 'datVyst@A';
        $invoicer->defaultUrlParams['limit'] = 0;

        // Build proper query with firma identifier
        $firmaFilter = is_numeric($firmaId) ? "firma={$firmaId}" : "firma='{$firmaId}'";
        $dateFilter = "datSplat lte '".(new \DateTime())->format('Y-m-d')."'";
        $statusFilter = "(stavUhrK is null OR stavUhrK eq 'stavUhr.castUhr')";
        $conditions = "{$dateFilter} AND {$statusFilter} AND storno eq false AND {$firmaFilter}";

        $invoices = $invoicer->getColumnsFromAbraFlexi(
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
                'datVyst',
            ],
            [$conditions],
            'kod',
        );

        if ($invoicer->lastResponseCode === 200 && \is_array($invoices)) {
            return $invoices;
        }

        return [];
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
        $debts = $this->getCustomerDebts();
        $stitkyRaw = $this->getAdresar()->getColumnsFromAbraFlexi(
            ['stitky'],
            ['id' => $addressID ? $addressID : $this->getAdresar()->getRecordID()],
        );
        $stitky = (!empty($stitkyRaw) && isset($stitkyRaw[0]['stitky'])) ? $stitkyRaw[0]['stitky'] : '';

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

        if ($score === 3 && !strstr((string) $stitky, $label2)) {
            $score = 2;
        }

        if (!strstr((string) $stitky, $label1) && !empty($debts)) {
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
        $loginValue = $this->getKontakt()->getDataValue($this->loginColumn);

        if ($loginValue !== null) {
            $this->setUserLogin((string) $loginValue);
        }

        $this->logged = true;
        $this->addStatusMessage(
            sprintf(_('Sign in %s all ok'), $this->userLogin ?? $this->getUserLogin()),
            'success',
        );

        return true;
    }

    /**
     * Get username from Kontakt.
     *
     * @return string Username or empty string if not available
     */
    public function getUserName(): string
    {
        $value = $this->getKontakt()->getDataValue($this->loginColumn);

        return $value !== null ? (string) $value : '';
    }

    /**
     * Get user login (alias for getUserName).
     *
     * @return string Username or empty string if not available
     */
    public function getUserLogin(): string
    {
        return $this->getUserName();
    }

    /**
     * Return user's email address.
     * Tries Kontakt first, falls back to Adresar.
     *
     * @return string Email address or empty string if not available
     */
    public function getUserEmail(): string
    {
        $kontaktEmail = $this->getKontakt()->getDataValue($this->mailColumn);

        if ($kontaktEmail !== null && $kontaktEmail !== '') {
            return (string) $kontaktEmail;
        }

        $adresarEmail = $this->getAdresar()->getDataValue($this->mailColumn);

        return $adresarEmail !== null ? (string) $adresarEmail : '';
    }

    /**
     * Change the user's password in AbraFlexi.
     *
     * @param mixed $newPassword New password
     * @param mixed $userID      User ID (uses current user if not provided)
     *
     * @return bool True if password was changed successfully
     */
    public function passwordChange($newPassword, $userID = null): bool
    {
        if (empty($userID)) {
            $userID = $this->getUserID();
        }

        if (empty($userID)) {
            $this->addStatusMessage('Cannot change password: no user ID', 'error');

            return false;
        }

        $hash = self::encryptPassword($newPassword);

        $kontakt = $this->getKontakt();
        $kontakt->insertToAbraFlexi([
            'id' => $userID,
            'username' => $this->getUserLogin(),
            'password' => $hash,
            // TODO: Enable proper password hashing when AbraFlexi supports it
            // 'password@hash' => 'sha256',
            // 'password@salt' => 'osoleno',
        ]);

        if ($kontakt->lastResponseCode === 201) {
            $kontakt->addStatusMessage(_('Password set'), 'success');
            $kontakt->loadFromAbraFlexi();

            $loginValue = $this->getDataValue($this->loginColumn);
            $this->addStatusMessage(
                'PasswordChange: '.($loginValue ?? 'unknown').'@'.$userID,
                'debug',
            );

            if ($userID === $this->getUserID()) {
                $this->setDataValue($this->passwordColumn, $hash);
            }

            return true;
        }

        $kontakt->addStatusMessage(_('Password set failed'), 'warning');

        return false;
    }

    /**
     * Encrypts the password.
     *
     * WARNING: Currently returns plaintext password as AbraFlexi does not
     * support encrypted passwords via API. This is a known limitation.
     *
     * @param mixed $plainTextPassword Plaintext password
     *
     * @return mixed Password (currently plaintext)
     *
     * @todo Implement proper password hashing when AbraFlexi API supports it
     */
    public static function encryptPassword($plainTextPassword)
    {
        // AbraFlexi currently does not support encrypted passwords via API
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

        return (int) $this->getKontakt()->getMyKey();
    }

    /**
     * Get or initialize Adresar (address book) entity.
     * Automatically loads data from AbraFlexi if firma is set but data isn't loaded yet.
     */
    public function getAdresar(): \AbraFlexi\Adresar
    {
        if ($this->adresar === null) {
            $this->adresar = new \AbraFlexi\Adresar($this->firma);
        }

        // If adresar doesn't have data loaded yet and we have a firma, load it
        // This ensures external IDs and other data are available
        if (empty($this->adresar->getMyKey()) && !empty($this->firma)) {
            $this->adresar->loadFromAbraFlexi($this->firma);
        }

        return $this->adresar;
    }

    /**
     * Get or initialize Kontakt (contact) entity.
     */
    public function getKontakt(): \AbraFlexi\Kontakt
    {
        if ($this->kontakt === null) {
            $this->kontakt = new \AbraFlexi\Kontakt(['firma' => $this->getAdresar()]);
        }

        return $this->kontakt;
    }

    /**
     * Get or initialize FakturaVydana (invoice) entity.
     */
    public function getInvoicer(): \AbraFlexi\FakturaVydana
    {
        if ($this->invoicer === null) {
            $this->invoicer = new \AbraFlexi\FakturaVydana(['firma' => $this->getAdresar()]);
        }

        return $this->invoicer;
    }

    /**
     * Set the firma (company) identifier.
     *
     * @param mixed $firma Firma identifier
     */
    public function setFirma(mixed $firma): void
    {
        $this->firma = $firma;

        // Reset entities so they reinitialize with new firma
        $this->adresar = null;
        $this->kontakt = null;
        $this->invoicer = null;
    }

    /**
     * Get the current firma identifier.
     */
    public function getFirma(): mixed
    {
        return $this->firma;
    }

    /**
     * Load customer by username from Kontakt.
     *
     * @return bool True if customer found
     */
    private function loadByUsername(string $username): bool
    {
        $contactInfo = $this->getKontakt()->getColumnsFromAbraFlexi(
            '*',
            ['username' => $username],
        );

        if (!empty($contactInfo)) {
            // Handle array of results - take first match
            $data = \is_array($contactInfo) && isset($contactInfo[0]) ? $contactInfo[0] : $contactInfo;
            $this->getKontakt()->takeData($data);
            $this->takeData($data);
            $this->origin = 'kontakt';

            return true;
        }

        return false;
    }

    /**
     * Load customer by email from Kontakt or Adresar.
     *
     * @return bool True if customer found
     */
    private function loadByEmail(string $email): bool
    {
        // Try Kontakt first
        $contactInfo = $this->getKontakt()->getColumnsFromAbraFlexi(
            '*',
            ['email' => $email],
        );

        if (!empty($contactInfo)) {
            $data = \is_array($contactInfo) && isset($contactInfo[0]) ? $contactInfo[0] : $contactInfo;
            $this->getKontakt()->takeData($data);
            $this->takeData($data);
            $this->origin = 'kontakt';

            return true;
        }

        // Fallback to Adresar
        $addressInfo = $this->getAdresar()->getColumnsFromAbraFlexi(
            '*',
            ['email' => $email],
        );

        if (!empty($addressInfo)) {
            $data = \is_array($addressInfo) && isset($addressInfo[0]) ? $addressInfo[0] : $addressInfo;
            $this->getAdresar()->takeData($data);
            $this->takeData($data);
            $this->origin = 'adresar';

            return true;
        }

        return false;
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
