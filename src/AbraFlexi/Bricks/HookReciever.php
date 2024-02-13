<?php

/**
 * AbraFlexi - WebHook reciever
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Obtain & process AbraFlexi webhook call
 *
 * @author vitex
 */
class HookReciever extends \AbraFlexi\Changes
{
    public $format        = 'json';
    public $changes       = null;
    public $globalVersion = null;

    /**
     * Posledni zpracovana verze
     * @var int
     */
    public $lastProcessedVersion = null;

    /**
     * Prijmac WebHooku
     */
    public function __construct($id = null, $options = [])
    {
        parent::__construct($id, $options);
        $this->lastProcessedVersion = $this->getLastProcessedVersion();
    }

    /**
     * Poslouchá standartní vstup
     *
     * @return string zaslaná data
     */
    public function listen()
    {
        $input     = null;
        $inputJSON = file_get_contents('php://input');
        if (strlen($inputJSON)) {
            $input     = json_decode($inputJSON, true); //convert JSON into array
            $lastError = json_last_error();
            if ($lastError) {
                $this->addStatusMessage(json_last_error_msg(), 'warning');
            }
        }
        return $input;
    }

    /**
     * Zpracuje změny
     */
    function processChanges()
    {
        if (!empty($this->changes)) {
            $changepos = 0;
            foreach ($this->changes as $change) {
                $changepos++;
                $evidence    = $change['@evidence'];
                $inVersion   = intval($change['@in-version']);
                $operation   = $change['@operation'];
                $id          = intval($change['id']);
                $externalIDs = isset($change['external-ids']) ? $change['external-ids']
                        : [];

                if ($inVersion <= $this->lastProcessedVersion) {
                    $this->addStatusMessage(sprintf(
                        _('Change version %s already processed'),
                        $inVersion
                    ), 'warning');
                    continue;
                }
                $handlerClassName = \AbraFlexi\RO::evidenceToClassName($evidence);
                $handlerClassFile = 'System/whplugins/' . $handlerClassName . '.php';
                if (file_exists($handlerClassFile)) {
                    include_once $handlerClassFile;
                }

                $handlerClass = '\\SpojeNet\\System\\whplugins\\' . $handlerClassName;
                if (class_exists($handlerClass)) {
                    $saver = new $handlerClass(
                        $id,
                        ['evidence' => $evidence, 'operation' => $operation, 'external-ids' => $externalIDs,
                        'changeid' => $inVersion]
                    );
                    $saver->saveHistory();
                    switch ($operation) {
                        case 'update':
                        case 'create':
                        case 'delete':
                            if ($saver->process($operation) && ($this->debug === true)) {
                                $this->addStatusMessage(
                                    $changepos . '/' . count($this->changes),
                                    'success'
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
                            addslashes($handlerClass)
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
     * Převezme změny
     *
     * @link https://www.abraflexi.eu/api/dokumentace/ref/changes-api/ Changes API
     * @param array $changes pole změn
     * @return int Globální verze poslední změny
     */
    public function takeChanges($changes)
    {
        $result = null;
        if (!is_array($changes)) {
            \Ease\Shared::logger()->addToLog(
                _('Empty WebHook request'),
                'Warning'
            );
        } else {
            if (array_key_exists('winstrom', $changes)) {
                $this->globalVersion = intval($changes['winstrom']['@globalVersion']);
                $this->changes       = $changes['winstrom']['changes'];
            }
            $result = is_numeric($changes['winstrom']['next']) ? $changes['winstrom']['next'] - 1 : $this->globalVersion;
        }
        return $result;
    }

    /**
     * Ulozi posledni zpracovanou verzi
     *
     * @param int $version
     */
    public function saveLastProcessedVersion($version)
    {
        $this->lastProcessedVersion = $version;
        $this->myCreateColumn       = null;
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
     * Nacte posledni zpracovanou verzi
     *
     * @return int $version
     */
    public function getLastProcessedVersion()
    {
        $lastProcessedVersion = null;
        if (false) {
            $lastProcessedVersion = 0;
        } else {
            $this->addStatusMessage(
                _("Last Processed Change ID Loading Failed"),
                'warning'
            );
        }
        return $lastProcessedVersion;
    }
}
