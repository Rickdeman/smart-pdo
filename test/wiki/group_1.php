<?php
$desc = "with JOIN";
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->innerJoin ( 'licences' )->groupBy ( 'category' )->execute ();

echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
