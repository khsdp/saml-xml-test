<?php

namespace SimpleSAML;

function loadClass($className) {

	$nsEnd = strripos($className, '\\');
	$path = dirname(dirname(__FILE__));
	if ($nsEnd !== FALSE) {
		$ns = substr($className, 0, $nsEnd);
		$className = substr($className, $nsEnd + 1);
		$path .= DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $ns);
	}
	$path .= DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	if (file_exists($path)) {
		require_once($path);
	}
}
\spl_autoload_register('\\SimpleSAML\loadClass');
