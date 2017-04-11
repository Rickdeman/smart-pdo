<?php

/**
 * addInnerJoin - Example #3
 *
 * addInnerJoin parameters are all defined
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->addLeftJoin ( 'licences', 'customerID', 'customer', 'ID' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );