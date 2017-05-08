<?php
use SmartPDO\Config;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * SmartPDO MySQL handler
 *
 * @var \SmartPDO\MySQL $MySQL
 */
$MySQL = new \SmartPDO\MySQL ( "smartpdo", "PvZZMGeeAp0UPtC4", "smartpdo", "spdo" );

Config::$readOnly = true;

$where = new \SmartPDO\Where ( $MySQL, 'customer' );
print_r ( $where );
diE ();
/**
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->distinct ()->columns ( 'category' );
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();
echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
