<?php
require_once __DIR__ . '/../vendor/autoload.php';
/**
 * SmartPDO MySQL handler
 *
 * @var \SmartPDO\Interfaces\Database $MySQL
 */
$MySQL = new \SmartPDO\MySQL ( "smartpdo", "PvZZMGeeAp0UPtC4", "smartpdo", "spdo" );


$inc = $MySQL->getTable('spdo_count')->update()->where('ID', 1)->decrement('count', 5)->set('count2', 15);

print_r($inc->execute()->getRows());
var_dump(__LINE__);