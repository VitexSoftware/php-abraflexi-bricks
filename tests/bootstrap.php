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

\define('EASE_LOGGER', 'syslog|console');

if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';

    if (file_exists('../tests/test.env')) {
        \Ease\Shared::instanced()->loadConfig('../tests/test.env', true);
    }

    new \Ease\Locale(\Ease\Shared::cfg('LOCALE'), '../i18n', 'abraflexi-matcher');
} else {
    require_once './vendor/autoload.php';

    if (file_exists('./tests/test.env')) {
        \Ease\Shared::instanced()->loadConfig('./tests/test.env', true);
    }

    new \Ease\Locale(\Ease\Shared::cfg('LOCALE'), './i18n', 'abraflexi-matcher');
}

// new \Ease\Locale(\Ease\Shared::instanced()->getConfigValue('MATCHER_LOCALIZE'), '../i18n', 'abraflexi-widgets');
