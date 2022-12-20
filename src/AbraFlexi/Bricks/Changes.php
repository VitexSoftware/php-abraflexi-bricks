<?php

/**
 * AbraFlexi Bricks - Changes Class
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2022 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * WebHook data Handler class
 * 
 * @see https://podpora.flexibee.eu/cs/articles/4744362-changes-api
 *
 * @author vitex
 */
class Changes {

    /**
     * Reported number of last change 
     * @var int
     */
    public $globalVersion = null;

    /**
     * Stored Changes
     * @var array<Change>
     */
    public $changes = [];

    /**
     * Next chunk ID
     * @var int
     */
    public $next = null;

    /**
     *  
     * @param array $changesData
     */
    public function __construct($changesData) {
        if (array_key_exists('changes', $changesData)) {
            foreach ($changesData['changes'] as $changeData) {
                $this->changes[] = new Change($changeData);
            }
        }
        if (array_key_exists('@globalVersion', $changesData)) {
            $this->globalVersion = intval($changesData['@globalVersion']);
        }
        if (array_key_exists('next', $changesData)) {
            $this->next = intval($changesData['next']);
        }
    }

    /**
     * Result array contains different key with new|old values
     * 
     * @param array $data
     * @param array $datb
     */
    public static function dataDiff($data, $datb) {
        $diff = [];
        $columns = array_merge(array_combine(array_keys($data), array_keys($data)), array_combine(array_keys($datb), array_keys($datb)));
        foreach ($columns as $column) {
            if ((array_key_exists($column, $data) && is_array($data[$column])) || (array_key_exists($column, $datb) && is_array($datb[$column]))) {
                $diff[$column] = self::dataDiff(array_key_exists($column, $data) ? $data[$column] : [], array_key_exists($column, $datb) ? $datb[$column] : []);
            } else {
                if ( (array_key_exists($column, $data) && array_key_exists($column, $datb) && (strval($data[$column]) == strval($datb[$column]))) === false) {
                    $diff[$column] = strval($data[$column]).'|'.strval($datb[$column]);
                }
            }
        }
        return $diff;
    }

}
