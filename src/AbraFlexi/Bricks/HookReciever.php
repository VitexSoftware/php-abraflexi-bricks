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
 * Obtain & process AbraFlexi webhook call.
 *
 * @author vitex
 */
class HookReciever extends \AbraFlexi\Changes
{
    public string $format = 'json';

    /**
     * Changes Array.
     *
     * @var array<string, mixed>
     */
    public array $changes = [];
    public ?int $globalVersion = null;

    /**
     * Posledni zpracovana verze.
     */
    public int $lastProcessedVersion = 0;

    /**
     * Prijmac WebHooku.
     *
     * @param null|mixed $id
     * @param mixed      $options
     */
    public function __construct($id = null, $options = [])
    {
        parent::__construct($id, $options);
        $this->lastProcessedVersion = $this->getLastProcessedVersion();
    }

    /**
     * Poslouchá standartní vstup.
     *
     * @return string zaslaná data
     */
    public function listen()
    {
        $input = null;
        $inputJSON = file_get_contents('php://input');

        if (\strlen($inputJSON)) {
            $input = json_decode($inputJSON, true); // convert JSON into array
            $lastError = json_last_error();

            if ($lastError) {
                $this->addStatusMessage(json_last_error_msg(), 'warning');
            }
        }

        return $input;
    }

    /**
     * Zpracuje změny.
     */
    public function processChanges(): void
    {
        if (!empty($this->changes)) {
            $changepos = 0;

            foreach ($this->changes as $change) {
                ++$changepos;
                $evidence = $change['@evidence'] ?? null;
                $inVersion = (int) ($change['@in-version'] ?? 0);
                $operation = $change['@operation'] ?? '';
                $id = (int) ($change['id'] ?? 0);
                $externalIDs = $change['external-ids']
                        ?? [];

                if (empty($evidence)) {
                    $this->addStatusMessage('Empty evidence in change', 'warning');

                    continue;
                }

                if ($inVersion <= $this->lastProcessedVersion) {
                    $this->addStatusMessage(sprintf(
                        _('Change version %s already processed'),
                        $inVersion,
                    ), 'warning');

                    continue;
                }

                $handlerClassName = \AbraFlexi\Functions::evidenceToClassName($evidence);
                $handlerClassFile = 'System/whplugins/'.$handlerClassName.'.php';

                if (file_exists($handlerClassFile)) {
                    include_once $handlerClassFile;
                }

                $handlerClass = '\\SpojeNet\\System\\whplugins\\'.$handlerClassName;

                if (class_exists($handlerClass)) {
                    $saver = new $handlerClass(
                        $id,
                        ['evidence' => $evidence, 'operation' => $operation, 'external-ids' => $externalIDs,
                            'changeid' => $inVersion],
                    );
                    $saver->saveHistory();

                    switch ($operation) {
                        case 'update':
                        case 'create':
                        case 'delete':
                            if ($saver->process($operation) && ($this->debug === true)) {
                                $this->addStatusMessage(
                                    $changepos.'/'.\count($this->changes),
                                    'success',
                                );
                            }

                            break;

                        default:
                            $this->addStatusMessage('Unknown operation', 'warning');

                            break;
                    }
                } else {
                    if ($this->debug === true) {
                        $this->addStatusMessage(sprintf(
                            _('Handler Class %s does not exist'),
                            addslashes($handlerClass),
                        ), 'warning');
                    }
                }

                $this->saveLastProcessedVersion($inVersion);
            }
        } else {
            $this->addStatusMessage('No Data To Process', 'warning');
        }
    }

    /**
     * Převezme změny.
     *
     * @see https://www.abraflexi.eu/api/dokumentace/ref/changes-api/ Changes API
     *
     * @param array $changes pole změn
     *
     * @return int Globální verze poslední změny
     */
    public function takeChanges(array $changes)
    {
        $result = null;

        if (!\is_array($changes)) {
            \Ease\Shared::logger()->addToLog(
                _('Empty WebHook request'),
                'Warning',
            );
        } else {
            if (\array_key_exists('winstrom', $changes)) {
                $this->globalVersion = (int) $changes['winstrom']['@globalVersion'];
                $this->changes = $changes['winstrom']['changes'] ?? [];
            }

            $result = is_numeric($changes['winstrom']['next']) ? $changes['winstrom']['next'] - 1 : $this->globalVersion;
        }

        return $result;
    }

    /**
     * Ulozi posledni zpracovanou verzi.
     *
     * @param int $version
     */
    public function saveLastProcessedVersion($version): void
    {
        $this->lastProcessedVersion = $version;
        $this->myCreateColumn = null;
        //        $this->deleteFromSQL(['serverurl' => constant('ABRAFLEXI_URL')]);
        //        if (is_null($this->insertToSQL(['serverurl' => constant('ABRAFLEXI_URL'),
        //                    'changeid' => $version]))) {
        //            $this->addStatusMessage(_("Last Processed Change ID Saving Failed"),
        //                'error');
        //        } else {
        //            if ($this->debug === true) {
        //                $this->addStatusMessage(sprintf(_('Last Processed Change ID #%s Saved'),
        //                        $version));
        //            }
        //        }
    }

    /**
     * Nacte posledni zpracovanou verzi.
     *
     * @return int $version
     */
    public function getLastProcessedVersion()
    {
        $lastProcessedVersion = 0;

        if (false) {
            $lastProcessedVersion = 0;
        } else {
            $this->addStatusMessage(
                _('Last Processed Change ID Loading Failed'),
                'warning',
            );
        }

        return $lastProcessedVersion;
    }
}
