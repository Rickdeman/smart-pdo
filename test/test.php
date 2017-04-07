<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// {"char":"utf8","db":"ricdem1_wms","host":"127.0.0.1","pass":"HwTcuuHFBYR37bjJ","prefix":"wms_","type":"mysql","user":"ricdem1_wms"}
/**
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 *
 * @var \SmartPDO\MySQL $test
 */
$test = new \SmartPDO\MySQL("ricdem1_wms", "HwTcuuHFBYR37bjJ", "ricdem1_wms", "wms");
/**
 *
 * @author Rick de Man <rick@rickdeman.nl>
 * @version 1
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $test->getTable('customer')->addWhere("ID", 1)->addOr(false)->addWhere("ID", 1)->addOr()->addWhere("ID", 1 , ">");

print_r($table);
