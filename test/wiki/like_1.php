<?php
$desc = "Starts With";
/**
 *
 * @var \SmartPDO\MySQL\Table\Rows $rows
 */
$rows = $MySQL->getTable ( 'customer' )->like ( 'name', 'Customer a%' )->execute ();

echo sprintf ( "%s/%s%s", $rows->rowCount (), $rows->getTotalRows (), PHP_EOL );
print_r ( $rows->getRows () );
print_r ( $rows->getQuery () );
