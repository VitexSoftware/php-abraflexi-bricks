<?php

/**
 * AbraFlexi Bricks - Payment confirmation
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2018 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Description of PotvrzeniUhrady
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class PotvrzeniUhrady extends \Ease\HtmlMailer
{
    /**
     * Odešle potvrzení úhrady
     * @param \AbraFlexi\FakturaVydana $invoice
     */
    public function __construct($invoice)
    {
        $body = new \Ease\Container();

        $this->addItem(new \Ease\Html\DivTag(_('Dear customer,')));
        $this->addItem(new \Ease\Html\DivTag(sprintf(
            _('we confirm receipt of payment %s %s on %s '),
            $invoice->getDataValue('sumCelkem'),
            \AbraFlexi\RO::uncode($invoice->getDataValue('mena')),
            $invoice->getDataValue('kod')
        )));


        parent::__construct(
            $to,
            _('Confirmation of receipt of invoice payment'),
            $body
        );
    }
}
