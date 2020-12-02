<?php
/**
 * AbraFlexi Bricks - Document Link
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */

namespace AbraFlexi\ui;

/**
 * Description of DocumentLink
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class DocumentLink extends \Ease\Html\ATag
{
    /**
     * A Href to document in AbraFlexi web interface
     * 
     * @param string $idCode
     * @param \AbraFlexi\RO $engine
     * @param string $format
     */
    public function __construct($idCode,$engine,$format=null){
        $engine->setMyKey($idCode);
        parent::__construct( $engine->getApiUrl($format), \AbraFlexi\RO::uncode($engine->getRecordIdent()) );
    }
}
