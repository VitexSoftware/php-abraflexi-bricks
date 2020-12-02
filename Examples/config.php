<?php
/**
 * AbraFlexi - Example how to configure Connection
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017 Vitex Software
 */

/**
 * Write logs as:
 */
define('EASE_APPNAME', 'AbraFlexi-Example');

/**
 * Write logs TO: one of memory,console,file,syslog or combinations like "console|syslog"
 */
define('EASE_LOGGER', 'console');

/*
 * URL AbraFlexi API
 */
define('ABRAFLEXI_URL', 'https://demo.abraflexi.eu');
//define('ABRAFLEXI_URL', 'https://localhost:5434/');

/*
 * AbraFlexi API User Login
 */
define('ABRAFLEXI_LOGIN', 'winstrom');
//define('ABRAFLEXI_LOGIN', 'admin');
/*
 * AbraFlexi API User Password
 */
define('ABRAFLEXI_PASSWORD', 'winstrom');
//define('ABRAFLEXI_PASSWORD', 'admin123');
/*
 * AbraFlexi API Company
 */
define('ABRAFLEXI_COMPANY', 'demo');
//define('ABRAFLEXI_COMPANY', 'spoje_net_s_r_o_');
