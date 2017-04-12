<?php

/**
 * orderBy - Example #1
 *
 * When creating an ORDER BY you must specify which colum, and can specify ASC|DESC
 *
 * OrderBY will validate if the provided Column And Table exist
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->innerJoin ( 'licences' );
$table->orderBy ( "ID" )->orderBy ( "licenseID", false, 'licences' );

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );