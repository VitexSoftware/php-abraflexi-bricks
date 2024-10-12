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
 * Description of PotvrzeniUhrady.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class PotvrzeniUhrady extends \Ease\HtmlMailer
{
    /**
     * Odešle potvrzení úhrady.
     *
     * @param \AbraFlexi\FakturaVydana $invoice
     */
    public function __construct($invoice)
    {
        $body = new \Ease\Container();

        $this->addItem(new \Ease\Html\DivTag(_('Dear customer,')));
        $this->addItem(new \Ease\Html\DivTag(sprintf(
            _('we confirm receipt of payment %s %s on %s '),
            $invoice->getDataValue('sumCelkem'),
            \AbraFlexi\Functions::uncode((string)$invoice->getDataValue('mena')),
            $invoice->getDataValue('kod'),
        )));

        parent::__construct(
            $to,
            _('Confirmation of receipt of invoice payment'),
            $body,
        );
    }
}
