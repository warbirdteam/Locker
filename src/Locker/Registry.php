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
namespace Locker;

use Locker\Config;

/**
 * A simple object registry for core objects.
 *
 * @package Locker 
 */
Class Registry {
	/**
	 * @var array Holds references to registered objects, by name.
	 */
	protected static $instances = null;

	/**
	 * @return PDO
	 */
	public function getPdo() : \PDO {
		return $this->get('pdo');
	}

	/**
	 * @param PDO $pdo
	 */
	public function setPdo(\PDO $pdo) : void {
		static::$instances['pdo'] = $pdo;
	}

	/**
	 * @return Config
	 */
	public function getConfig() : Config {
		return $this->get('config');
	}

	/**
	 * @param Config $config
	 */
	public function setConfig(Config $config) {
		static::$instances['config'] = $config;
	}

	protected function get($name) {
		if (!isset(static::$instances[$name])) {
			throw new \RuntimeException("Missing registry instance: $name");
		}
		return static::$instances[$name];
	}	
}
