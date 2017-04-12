<?php

/**
 * leftJoin - Example #1
 *
 * Since addInnerJoin only holds 1 paramter:
 * - @param $targetColumn  = customerID ( %rootTable%%ID )
 * - @param $sourceTable   = customer	( %rootTable% )
 * - @param $sourceColumn  = ID
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->leftJoin ( 'licences' )->execute ();

echo $rows->rowCount () . " - ";
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
