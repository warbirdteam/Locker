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

use Assert\Assertion;

/**
 * A thin wrapper over the beberlei/assert library to
 * allow for easy validation of multiple values at once.
 *
 * $validation = new Validation();
 * $validation->validate($values, ['key1' => [...], 'key2' => [...]);
 * $clean = $validation->getClean();
 * $errors = $validation->getErrors();
 *
 * @package Locker 
 */
Class Validation {
	private $clean = [];
	private $errors = [];

	/**
	 * Validation library that sits on top of beberlei/assert, providing
	 * the ability to create arrays of clean, sanitized data and a list of
	 * invalid data.
	 *
	 * Accepts an array of data and configuration on how to validate
	 * the data therein. The configuration is structured like so:
	 *
	 * ['key' => [validation configuration], 'key2' => [validation configuration]]
	 *
	 * Configuration is an array with the following key / values:
	 *
	 * - type: The type of validation to attempt, for example, 'email' or 'digit.'
	 *   For a list of possible types see the Assert documentation.
	 * - trim: A boolean; defaults to true. This will trim whitespace off the value
	 *   before attempting validation (useful for form inputs where users may add
	 *   additional spaces that we want to strip out).
	 * - default: If the value fails validation, then instead of reporting
	 *   an error, use this default value instead in the clean array.
	 * - args: Additional arguments to pass to the validation method if necessary.
	 *   For example, ['type' => 'max', 'args' => [100]] to validate that something
	 *   isnot larger than 100.
	 *
	 * You can pass an array of validation rules to enforce multiple rules. For example,
	 * ['someInteger' => [
	 *   ['type' => 'integer', 'args' => ['This is not an integer']],
	 *   ['type' => 'between', 'args' => [10, 100, 'Incorrect range.']]
	 * ]
	 *
	 * In this case, validation will stop at the first failure.
	 *
	 * A full example:
	 *
	 * $validation = new \Locker\Validation();
	 * $validation->validate($_POST, [
	 *    'email' => ['type' => 'email', 'args' => ['Invalid Email Address']],
	 *    'password' => ['type' => 'minLength', 'args' => [8, 'Password is Too Short']]
	 * ]);
	 * $clean = $validation->getClean();
	 * $errors = $validation->getErrors();
	 *
	 * @param array $data Incoming data to validate.
	 * @param array $config Validation configuration.
	 * @throws RuntimeException If you attempt to use a validation type that doesn't exist.
	 * @see https://packagist.org/packages/beberlei/assert
	 */
	public function validate(array $data, array $config) : void {
		$this->clean = [];
		$this->errors = [];

		foreach ($config as $key => $args) {
			if (isset($args['type'])) {
				$args = [$args];
			}

			$item = isset($data[$key]) ? $data[$key] : null;

			if (!is_null($item) && (!isset($arg['trim']) || $arg['trim'] === true)) {
				$item = trim($item);
			}

			foreach ($args as $arg) {
				if (!isset($arg['type'])) {
					throw new \RuntimeException("Missing validation type for '$key'");
				}

				if (!method_exists('\Assert\Assertion', $arg['type'])) {
					throw new \RuntimeException("Invalid Assertion: Assertion::{$arg['type']}");
				}

				$methodArgs = array_merge([$item], isset($arg['args']) ? $arg['args'] : []);

				try {
					call_user_func_array(['\Assert\Assertion', $arg['type']], $methodArgs);
				} catch (\Exception $ex) {
					if (isset($arg['default'])) {
						$item = $arg['default'];
					} else {
						$this->errors[$key] = $ex->getMessage();
						continue 2;
					}
				}
			}
			$this->clean[$key] = $item;
		}
	}

	/**
	 * @return array Sanitized input.
	 */
	public function getClean() : array {
		return $this->clean;
	}

	/**
	 * @return array Invalid keys.
	 */
	public function getErrors() : array {
		return $this->errors;
	}
}
