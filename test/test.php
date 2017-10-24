<?php
require_once __DIR__ . '/../vendor/autoload.php';
/**
 * SmartPDO MySQL handler
 *
 * @var \SmartPDO\Interfaces\Database $MySQL
 */
$MySQL = new \SmartPDO\MySQL ( "smartpdo", "PvZZMGeeAp0UPtC4", "smartpdo", "spdo" );

/**
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'licences' );
$table->innerJoin ( 'licences', 'customerID', 'customer', 'ID' );
//$table->innerJoin2 ( 'customerID', 'customer' );
//$table->innerJoin3 ( 'customer' );
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
//$rows = $table->execute ();

//print_r ( $rows->getQuery () );
//echo PHP_EOL;

//print_r($rows->getRows());
/**/

\SmartPDO\Config::$readOnly = true;
$data = $MySQL->getTable ( 'customer' );
$data->where('templateID', 0);

print_r( $data->execute()->getRows() );
