<?php

/**
 * File: Group.php
 */
namespace SmartPDO\Parameters;

/**
 * SmartPdo Parameter WHERE: BETWEEN
 *
 * @version 1
 * @author Rick de Man <rick@rickdeman.nl>
 *
 */
class Group extends \SmartPDO\Parameters\WhereLogic {

	/**
	 * For opening/closing groups
	 *
	 * @var bool
	 */
	private $open;

	/**
	 * BETWEEN parameter initialiser
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @param bool $and
	 *        	if the AND statement should be used or OR
	 * @param bool $open
	 *        	if boolean is provided, new group will be openened/closed
	 */
	function __Construct($and, $open) {
		$this->and = $and === true;
		$this->open = $open;
	}

	/**
	 * Open/Close group?
	 *
	 * @version 1
	 * @author Rick de Man <rick@rickdeman.nl>
	 *
	 * @return null|boolean
	 */
	function getOpen() {
		return $this->open;
	}
}