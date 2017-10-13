<?php

/**
 * File: Limit.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 */
class Limit
{

    /**
     * Limit by x items
     *
     * @var int
     */
    private $items;

    /**
     * start from row
     *
     * @var int
     */
    private $start;

    /**
     * GROUP BY parameter initialiser
     *
     * @version 1
     * @author Rick de Man <rick@rickdeman.nl>
     * @param string $items
     *            Items to select/delete
     * @param string $start
     *            Start position
     */
    function __Construct(int $items, int $start)
    {
        $this->items = $items;
        $this->start = $start;
    }

    /**
     * Get the limit items
     *
     * @return int
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get the limit start position
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }
}