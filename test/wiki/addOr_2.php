<?php

/**
 * addOr - Example #1
 *
 * When creating an OR there are 2 options with a Bool ( default: True )
 *  - True		Create a new OR group
 *  - False		Creates a left handed OR
 *
 *  Try no to end with an 'addOr' even though its rejected
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' );
$table->addWhere ( "ID", 1 )->addOr ( false )->addWhere ( "ID", 1 )->addWhere ( "ID", 1 );
$table->addOr ();
$table->addWhere ( "ID", 1 )->addWhere ( "ID", 1 )->addOr ( false )->addWhere ( "ID", 1 )->addOr ();

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
