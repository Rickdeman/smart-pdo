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

/**
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->update ()->set ( 'info', '' )->where ( 'ID', 2 );
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();
echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
