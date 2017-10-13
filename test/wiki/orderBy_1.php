<?php
$desc = "OrderBY in JOIN";
/**
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'licences' )->innerJoin3 ( 'customer' );
$table->orderBy ( "ID" )->orderBy ( "ID", false, 'licences' );

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );