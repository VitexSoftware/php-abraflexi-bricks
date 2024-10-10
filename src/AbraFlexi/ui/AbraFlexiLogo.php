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

namespace AbraFlexi\ui;

/**
 * AbraFlexi Bricks - AbraFlexi svg logo.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class AbraFlexiLogo extends \Ease\Html\ImgTag
{
    public static $svg = <<<'EOD'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<!-- Created with Inkscape (http://www.inkscape.org/) -->
<svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" height="48" width="48" version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" viewBox="0 0 12.7 12.7">
 <metadata>
  <rdf:RDF>
   <cc:Work rdf:about="">
    <dc:format>image/svg+xml</dc:format>
    <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/>
    <dc:title/>
   </cc:Work>
  </rdf:RDF>
 </metadata>
 <g transform="translate(0,-284.3)">
  <g style="image-rendering:optimizeQuality;shape-rendering:geometricPrecision" clip-rule="evenodd" transform="matrix(.015609 0 0 -.015609 -18.251 294.31)">
   <path d="m1708.7 0 133.8 231.62 133.7-231.62z" fill="#f9ae2d"/>
   <path d="m1708.7 0-133.75 231.62h267.53z" fill="#d28b25"/>
   <path d="m1574.9 231.62 133.75 231.68 133.78-231.68z" fill="#936327"/>
   <path d="m1708.7 463.3h-267.5l-267.6-463.3h267.56l267.47 463.3" fill="#767a7c"/>
  </g>
 </g>
</svg>

EOD;

    /**
     * Inline vector AbraFlexi logo.
     *
     * @param string $style         ignored now
     * @param array  $tagProperties img tag properties
     */
    public function __construct($style = 'default', $tagProperties = [])
    {
        parent::__construct(
            'data:image/svg+xml;base64,'.base64_encode(self::$svg),
            'AbraFlexi',
            $tagProperties,
        );
    }
}
