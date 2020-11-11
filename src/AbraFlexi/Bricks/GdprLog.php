<?php
/**
 * AbraFlexi Bricks - GDPR Logger support
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2019 Vitex Software
 */

namespace AbraFlexi\Bricks;
/**
 * Description of CustomerLog
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class GdprLog extends \Ease\GdprLog
{
    /**
     * Log FlexiBee event
     * 
     * @param \AbraFlexi\FlexiBeeRW $flexibee
     * @param array $columns
     */
    public function logFlexiBeeEvent($flexibee, $columns)
    {
        foreach ($columns as $columnName) {
            $this->logEvent($columnName,
                empty($flexibee->lastInsertedID) ? 'update' : 'create', null,
                $flexibee->getApiURL().'#'.$columnName);
        }
    }

    /**
     * Log Change in FlexiBee
     * 
     * @param \AbraFlexi\FlexiBeeRW $flexibee
     * @param array $originalData
     * @param array $columns
     */
    public function logFlexiBeeChange($flexibee, $originalData, $columns)
    {
        foreach ($columns as $columnName) {
            if ($originalData[$columnName] != $flexibee->getDataValue($columnName)) {
                $this->logEvent($columnName, $flexibee->getLastOperationType(), null,
                    $flexibee->getApiURL().'#'.$columnName);
            }
        }
    }

}
