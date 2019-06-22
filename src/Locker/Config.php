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

use Locker\Utility\ReadOnlyArray;

/**
 * An object with ArrayAccess and Interator implementations.
 * Designed to be read-only; any attempts to change data will
 * cause exceptions to be thrown. Also, any attempts to fetch
 * a configuration item that is missing will throw an exception,
 * which is useful for catching a mis-configured installation.
 *
 * @package Locker 
 */
Class Config extends ReadOnlyArray {
	/**
	 * @var array Internal data.
	 */
	protected $data = [];

	/**
	 * Create a new Config instance, optionally loading a set of files.
	 * Files with an absolute path will be loaded as given. All other files
	 * are relative to the 'config' directory set in the CONFIG_DIR constant.
	 *
	 * @param array $files A list of files to load.
	 */
	public function __construct(array $files = []) {
		if (empty($files)) {
			$files = ['locker.json'];
		}

		foreach ($files as $file) {
			if (strpos($file, 0, 1) !== '/') {
				$file = CONFIG_DIR . '/' . $file;
			}

			if (!is_file($file) || !is_readable($file)) {
				throw new \RuntimeException("Missing/Unreadable configuration file: $file");
			}

			$data = json_decode(file_get_contents($file), true);
			if (json_last_error()) {
				throw new \RuntimeException("JSON Parse Error in $file");
			}
			$this->setValues($data);
		}
	}
}
