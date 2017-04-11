<?php

/**
 * addInnerJoin - Example #2
 *
 * Since addInnerJoin only holds 2 paramter:
 * - @param $sourceTable   = customer	( %masterTable )
 * - @param $sourceColumn  = ID
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->addInnerJoin ( 'licences', 'customerID' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );