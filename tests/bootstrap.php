<?php

/**
 * AbraFlexi-Bricks - Unit Test bootstrap
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright (c) 2018-2024, Vítězslav Dvořák
 */

define('EASE_LOGGER', 'syslog|console');
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


#new \Ease\Locale(\Ease\Shared::instanced()->getConfigValue('MATCHER_LOCALIZE'), '../i18n', 'abraflexi-widgets');
