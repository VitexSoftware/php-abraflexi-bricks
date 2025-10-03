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
 * Description of CustomerLog.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class GdprLog extends \Ease\Sand
{
    /**
     * Log GDPR event.
     *
     * @param mixed $oldValue
     */
    public function logEvent(string $columnName, string $operation, $oldValue, string $url): void
    {
        // Basic GDPR logging implementation - could be enhanced
        $this->addStatusMessage("GDPR Log: {$operation} on {$columnName} at {$url}", 'debug');
    }

    /**
     * Log AbraFlexi event.
     *
     * @param array<string> $columns
     */
    public function logAbraFlexiEvent(\AbraFlexi\RW $abraflexi, $columns): void
    {
        foreach ($columns as $columnName) {
            $this->logEvent(
                $columnName,
                empty($abraflexi->lastInsertedID) ? 'update' : 'create',
                null,
                $abraflexi->getApiURL().'#'.$columnName,
            );
        }
    }

    /**
     * Log Change in AbraFlexi.
     *
     * @param \AbraFlexi\RW         $abraflexi
     * @param array<string, string> $originalData
     * @param array<string>         $columns
     */
    public function logAbraFlexiChange($abraflexi, $originalData, $columns): void
    {
        foreach ($columns as $columnName) {
            if ($originalData[$columnName] !== $abraflexi->getDataValue($columnName)) {
                $this->logEvent(
                    $columnName,
                    $abraflexi->getLastOperationType(),
                    null,
                    $abraflexi->getApiURL().'#'.$columnName,
                );
            }
        }
    }
}
