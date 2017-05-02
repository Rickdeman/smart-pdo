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
 * addOrderBy - Example #2
 *
 * When creating an ORDER BY there are 2 options with a Bool ( default: True )
 * - True Create a new OR group
 * - False Creates a left handed OR
 *
 * Try no to end with an 'addOr' even though its rejected
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->andIn ( 'ID', explode ( ",", "1,3" ) );

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();
echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
