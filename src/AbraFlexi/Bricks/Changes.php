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
 * WebHook data Handler class.
 *
 * @see https://podpora.flexibee.eu/cs/articles/4744362-changes-api
 *
 * @author vitex
 */
class Changes
{
    /**
     * Reported number of last change.
     */
    public ?int $globalVersion = null;

    /**
     * Stored Changes.
     *
     * @var array<Change>
     */
    public array $changes = [];

    /**
     * Next chunk ID.
     */
    public ?int $next = null;

    /**
     * @param array<int, mixed> $changesData
     */
    public function __construct(array $changesData)
    {
        if (\array_key_exists('changes', $changesData)) {
            foreach ($changesData['changes'] as $changeData) {
                $this->changes[] = new Change($changeData);
            }
        }

        if (\array_key_exists('@globalVersion', $changesData)) {
            $this->globalVersion = (int) $changesData['@globalVersion'];
        }

        if (\array_key_exists('next', $changesData)) {
            $this->next = (int) $changesData['next'];
        }
    }

    /**
     * Result array contains different key with new|old values.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed> $datb
     */
    public static function dataDiff($data, $datb)
    {
        $diff = [];
        $columns = array_merge(array_combine(array_keys($data), array_keys($data)), array_combine(array_keys($datb), array_keys($datb)));

        foreach ($columns as $column) {
            if ((\array_key_exists($column, $data) && \is_array($data[$column])) || (\array_key_exists($column, $datb) && \is_array($datb[$column]))) {
                $diff[$column] = self::dataDiff(\array_key_exists($column, $data) ? $data[$column] : [], \array_key_exists($column, $datb) ? $datb[$column] : []);
            } else {
                if ((\array_key_exists($column, $data) && \array_key_exists($column, $datb) && ((string) $data[$column] === (string) $datb[$column])) === false) {
                    $diff[$column] = (string) $data[$column].'|'.(string) $datb[$column];
                }
            }
        }

        return $diff;
    }
}
