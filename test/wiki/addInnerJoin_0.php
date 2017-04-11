<?php

/**
 * addInnerJoin - Example #1
 *
 * Since addInnerJoin only holds 1 paramter:
 * - @param $targetColumn  = customerID ( %masterTable%ID )
 * - @param $sourceTable   = customer	( %masterTable )
 * - @param $sourceColumn  = ID
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->addInnerJoin ( 'licences' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
