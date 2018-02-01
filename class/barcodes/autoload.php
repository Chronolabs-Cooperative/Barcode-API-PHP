<?php
/**
 * autoload.php
 *
 * Autoloader for Tecnick.com libraries
 *
 * @since       2015-03-04
 * @category    Library
 * @package     Barcode
 * @author      Nicola Asuni <info@tecnick.com>
 * @copyright   2015-2015 Nicola Asuni - Tecnick.com LTD
 * @license     http://www.gnu.org/copyleft/lesser.html GNU-LGPL v3 (see LICENSE.TXT)
 * @link        https://github.com/tecnickcom/tc-lib-barcode
 *
 * This file is part of tc-lib-barcode software library.
 */

    require_once __DIR__ . DS . 'Barcode.php';
    require_once __DIR__ . DS . 'Exception.php';

    function autoload($class) {
        $prefix = '\\Com\\Tecnick\\Barcode\\';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }
        $relative_class = substr($class, $len);
        if (file_exists($fdir = dirname(dirname(__DIR__.'/'.str_replace('\\', '/', $relative_class))) . '/Convert.php'))
        {
            require_once $fdir;
        } else
            die("File not found: ".$fdir);
        if (file_exists($fdir = dirname(dirname(__DIR__.'/'.str_replace('\\', '/', $relative_class))) . '.php'))
        {
            require_once $fdir;
        } else
            die("File not found: ".$fdir);
        if (file_exists($fdir = dirname(__DIR__.'/'.str_replace('\\', '/', $relative_class)) . '.php'))
        {
            require_once $fdir;
        } else
            die("File not found: ".$fdir);
        if (is_dir($dir = __DIR__.'/'.str_replace('\\', '/', $relative_class)))
        {
            require_once dirname(__DIR__) . DS . 'apilists.php';
            foreach(APILists::getFileListAsArray($dir) as $file)
            {
                if ($file == 'Process.php')
                    if (file_exists($dir . DS . $file)) {
                        require $dir . DS . $file;
                    } else
                        die("File not found: ".$dir . DS . $file);
            }
            
        }
        $file = __DIR__.'/'.str_replace('\\', '/', $relative_class).'.php';
        if (file_exists($file)) {
            require $file;
        } else 
            die("File not found: $file");
        
    }

