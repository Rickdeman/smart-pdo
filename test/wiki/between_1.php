<?php
$desc = "Inverted";
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->between ( 'ID', 2, 3, true )->execute ();

echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );