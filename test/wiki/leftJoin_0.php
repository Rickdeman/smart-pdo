<?php
$desc = "Fully defined";
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable( 'licences' )->leftJoin ( 'licences', 'customerID', 'customer', 'ID' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
