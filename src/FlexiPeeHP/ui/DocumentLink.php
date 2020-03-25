<?php
/**
 * FlexiPeeHP Bricks - Document Link
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */

namespace FlexiPeeHP\ui;

/**
 * Description of DocumentLink
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class DocumentLink extends \Ease\Html\ATag
{
    /**
     * A Href to document in FlexiBee web interface
     * 
     * @param string $idCode
     * @param \FlexiPeeHP\FlexiBeeRO $engine
     * @param string $format
     */
    public function __construct($idCode,$engine,$format=null){
        $engine->setMyKey($idCode);
        parent::__construct( $engine->getApiUrl($format), \FlexiPeeHP\FlexiBeeRO::uncode($engine->getRecordIdent()) );
    }
}
