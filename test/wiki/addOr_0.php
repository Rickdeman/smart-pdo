<?php

/**
 * addOr - Example #1
 *
 * When creating an OR there are 2 options with a Bool ( default: True )
 *  - True		Create a new OR group
 *  - False		Creates a left handed OR
 *
 * @var \SmartPDO\MySQL\Table $table
 */
$table = $MySQL->getTable ( 'customer' )->addWhere ( "ID", 1 )->addOr ()->addWhere ( "ID", 1 );

/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $table->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
