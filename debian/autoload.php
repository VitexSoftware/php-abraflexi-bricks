<?php
/**
 * Autoloader generated for Debian package by phpab-style script.
 * Requires system dependency autoloaders and registers PSR-4 for this package.
 */

// Load dependency autoloaders provided by other Debian packages (if available).
$dependencyAutoloaders = [
    '/usr/share/php/EaseCore/autoload.php',
    '/usr/share/php/AbraFlexi/autoload.php',
];

foreach ($dependencyAutoloaders as $file) {
    if (file_exists($file)) {
        @require_once $file;
    }
}

// Register PSR-4 autoloading for AbraFlexi\Bricks\ namespace
spl_autoload_register(function ($class) {
    $prefix = 'AbraFlexi\\Bricks\\';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Base directory for the namespace prefix
    $base_dir = __DIR__ . '/Bricks/';

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace namespace separators with directory separators, append .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// End of autoload.php
