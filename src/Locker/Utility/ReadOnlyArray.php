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
namespace Locker\Utility;

/**
 * An object with ArrayAccess and Iterator interfaces that will
 * complain if you try to change any of the values. Used for any
 * data that should be immutable and you want to know if your code
 * tries to alter something.
 */
Class ReadOnlyArray implements \ArrayAccess, \Iterator {
	/**
	 * @var array Internal data.
	 */
	protected $data = [];

	/**
	 * @param array $data Data you'd like to store.
	 */
	public function __construct(array $data = []) {
		$this->setValues($data);
	}

	/**
	 * @see \Iterator::offsetSet
	 * @throws RuntimeException
	 */
	public function offsetSet($offset, $value): void {
		throw new \RuntimeException("This object is read-only. Attempted to set '$offset' to '$value'.");
	}

	/**
	 * @throws RuntimeException
	 */
	public function offsetUnset($offset): void {
		throw new \RuntimeException("This object is read-only. Attempted to unset '$offset' to '$value'.");
	}

	/**
	 * @return bool True if an offset exists, false otherwise.
	 */
	public function offsetExists($offset): bool {
		return isset($this->data[$offset]);
	}

	/**
	 * @param string|int $offset whose value to return.
	 * @return mixed The value present at $offset.
	 * @throws RuntimeException if the offset is not set.
	 */
	public function offsetGet($offset) {
		if (!isset($this->data[$offset])) {
			throw new \RuntimeException("Expected offset '$offset' is missing.");
		}
		return $this->data[$offset];
	}

	/**
	 * Utility function for storing values into the internal
	 * data element. Casts objects into an array and then stores
	 * keys/values.
	 *
	 * @param array|object $data to set.
	 * @throws InvalidArgumentException
	 */
	protected function setValues($data) : void {
		if (!is_array($data) && !is_object($data)) {
			throw new \InvalidArgumentException(gettype($data));
		}

		if (is_object($data)) {
			$data = (array) $data;
		}

		foreach ($data as $key => $value) {
			if (is_array($value) && isset($value[0])) {
				$this->data[$key] = $value;
			} else if (is_array($value)) {
				$this->data[$key] = new ReadOnlyArray($value);
			} else if (is_object($value)) {
				$this->data[$key] = new ReadOnlyArray((array) $value);
			} else {
				$this->data[$key] = $value;
			}
		}
	}

	/**
	 * @see \ArrayIterator::rewind()
	 */
	public function rewind() {
		return reset($this->data);
	}
	
	/**
	 * @see \ArrayIterator::current()
	 */
	function current() {
		return current($this->data);
	}

	/**
	 * @see \ArrayIterator::rewind()
	 */
	function key() {
		return key($this->data);
	}

	/**
	 * @see \ArrayIterator::next()
	 */
	function next() {
		return next($this->data);
	}

	/**
	 * @see \ArrayIterator::valid()
	 */
	function valid() {
		return key($this->data) !== null;
	}

	/**
	 * @return string A string representation of the object.
	 */
	public function __toString() {
		return get_class($this) . ' [' . join(',', array_keys($this->data)) . ']';
	}

	/**
	 * @return array An array representation of the internal data.
	 */
	public function toArray() {
		$out = [];
		foreach ($this->data as $key => $value) {
			if ($value instanceof ReadOnlyArray) {
				$value = $value->toArray();
			}
			$out[$key] = $value;
		}
		return $out;
	}
}
