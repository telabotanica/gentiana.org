<?php
// $Id: simple_include.php,v 1.1 2005-09-30 14:58:00 ddelon Exp $
if (!defined('SIMPLE_TEST')) {
    define('SIMPLE_TEST', '../../../simpletest/');
}

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');
require_once(SIMPLE_TEST . 'mock_objects.php');
?>