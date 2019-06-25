<?php
/**
 * This file is part of the Locker project.
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed
 * with this source code.
 *
 * @package Locker
 */
namespace Locker\Monolog\Processor;

use Monolog\Processor\ProcessorInterface;

/**
 * Processor that adds some general context information to monolog entries.
 */
class GeneralInfo implements ProcessorInterface {
	private $rid = null;

    public function __invoke(array $record)
    {
    	if (!defined('REQUEST_ID')) {
    		$this->rid = uniqid();
    	} else {
    		$this->rid = REQUEST_ID;
    	}

        $record['extra']['rid'] = $this->rid;
        $record['extra']['ip'] = $_SERVER['REMOTE_ADDR'];

        return $record;
    }
}
