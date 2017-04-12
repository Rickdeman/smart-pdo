<?php

/**
 * or - Example #1
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
$table->where ( "ID", 1 )->group ( false )->where ( "ID", 1 )->where ( "ID", 1 );
$table->group ();
$table->where ( "ID", 1 )->where ( "ID", 1 )->group ( false )->where ( "ID", 1 )->group ();

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
