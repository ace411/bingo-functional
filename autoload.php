<?php
/**
 * This is an bingo-functional autoloader.
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Chemem\\Bingo\\Functional\\';

    // base directory for the namespace prefix
    $baseDir = __DIR__.'/src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relativeClass = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir.str_replace('\\', '/', $relativeClass).'.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Chemem\\Bingo\\Functional\\Tests\\';

    // base directory for the namespace prefix
    $baseDir = __DIR__.'/tests/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relativeClass = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir.str_replace('\\', '/', $relativeClass).'.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
