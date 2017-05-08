<?php
$desc = "By column";
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->groupBy ( 'category' )->execute ();

echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
