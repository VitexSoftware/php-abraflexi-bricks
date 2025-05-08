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
 * Handle one AbraFlexi change record.
 *
 * @author vitex
 */
class Change
{
    /**
     * Evidence of record.
     */
    public ?string $evidence = null; // "faktura-vydana",

    /**
     * Change IN Version.
     */
    public ?int $inVersion = null; // "3",

    /**
     * create, update, delete.
     */
    public ?string $operation = null; // "create",
    public ?\AbraFlexi\DateTime $timestamp = null; // "2019-01-01 00:00:00.0",
    public ?int $id = null; // "1",

    /**
     * Ext-IDs for record.
     *
     * @var array<string>
     */
    public array $extIds = []; // []

    /**
     * One AbraFlexi change.
     *
     * @param array<string, string> $changeData
     */
    public function __construct(array $changeData = [])
    {
        if ($changeData) {
            $this->setData($changeData);
        }
    }

    /**
     * Give your data back.
     *
     * @return array<string, null|\AbraFlexi\DateTime|array<string>|int|string>
     */
    public function getData(): array
    {
        return [
            '@evidence' => $this->evidence,
            '@in-version' => $this->inVersion,
            '@operation' => $this->operation,
            '@timestamp' => $this->timestamp,
            'id' => $this->id,
            'external-ids' => $this->extIds,
        ];
    }

    /**
     * Store data.
     *
     * @param array<string, string, null|\AbraFlexi\DateTime|array<string>|int|string> $changeData
     */
    public function setData($changeData): void
    {
        $this->evidence = $changeData['@evidence'];
        $this->inVersion = $changeData['@in-version'];
        $this->operation = $changeData['@operation'];
        $this->timestamp = $changeData['@timestamp'];
        $this->id = $changeData['id'];
        $this->id = $changeData['external-ids'];
    }
}
