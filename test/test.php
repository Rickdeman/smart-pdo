<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

/**
 * SmartPDO MySQL handler 
 * 
 * @var \SmartPDO\MySQL $MySQL
 */
$MySQL = new \SmartPDO\MySQL("smartpdo", "PvZZMGeeAp0UPtC4", "smartpdo", "spdo");





/**
 * Get a table from the database
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable('customer')->addWhere('ID', 1)->addInnerJoin('licences', 'customerId');


/** 
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute();

print_r($rows->getRows());
print_r($rows->getQuery());

