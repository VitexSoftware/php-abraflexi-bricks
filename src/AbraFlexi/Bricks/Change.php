<?php

/**
 * AbraFlexi Bricks - One Change Class
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2022-2023 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Handle one AbraFlexi change record
 *
 * @author vitex
 */
class Change
{
    /**
     * Evidence of record
     * @var string
     */
    public $evidence = null; // "faktura-vydana",

    /**
     * Change IN Version
     * @var int
     */
    public $inVersion = null; // "3",

    /**
     * create, update, delete
     * @var string
     */
    public $operation = null; //"create",

    /**
     *
     * @var \AbraFlexi\DateTime
     */
    public $timestamp = null; // "2019-01-01 00:00:00.0",

    /**
     *
     * @var integer
     */
    public $id = null; // "1",

    /**
     * Ext-IDs for record
     * @var array
     */
    public $extIds = []; // []

    /**
     * One AbraFlexi change
     *
     * @param array $changeData
     */
    public function __construct($changeData = [])
    {
        if ($changeData) {
            $this->setData($changeData);
        }
    }

    /**
     * Give your data back
     *
     * @return array
     */
    public function getData()
    {
        return [
            "@evidence" => $this->evidence,
            "@in-version" => $this->inVersion,
            "@operation" => $this->operation,
            "@timestamp" => $this->timestamp,
            "id" => $this->id,
            "external-ids" => $this->extIds
        ];
    }

    /**
     * Store data
     * @param array $changeData
     */
    public function setData($changeData)
    {
        $this->evidence = $changeData['@evidence'];
        $this->inVersion = $changeData['@in-version'];
        $this->operation = $changeData['@operation'];
        $this->timestamp = $changeData['@timestamp'];
        $this->id = $changeData['id'];
        $this->id = $changeData['external-ids'];
    }
}
