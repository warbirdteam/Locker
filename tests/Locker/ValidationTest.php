<?php
namespace Locker;

use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase {
	/**
	 * @dataProvider dpValidData
	 */
	public function testValidData($input, $expected, $rules) {
		$validation = new \Locker\Validation();
		$validation->validate(['value' => $input], ['value' => $rules]);

		$clean = $validation->getClean();
		$errors = $validation->getErrors();

		$this->assertArrayHasKey('value', $clean);
		$this->assertArrayNotHasKey('value', $errors);
		$this->assertEquals($clean['value'], $expected);
	}

	public function dpValidData() {
		return [
			// Test basic positive case.
			['bear@bear.org', 'bear@bear.org', ['type' => 'email']],
			// Test that trim functionality works.
			[' bear@bear.org ', 'bear@bear.org', ['type' => 'email']],
			// Test that default works.
			['not an email address', 'bear@bear.org', ['type' => 'email', 'default' => 'bear@bear.org']],
			// Test that multiple items work.
			['bear@bear.org', 'bear@bear.org', [['type' => 'string'], ['type' => 'email'], ['type' => 'minLength', 'args' => [5]]]]
		];
	}

	/**
	 * @dataProvider dpInvalidData
	 */
	public function testInvalidData($input, $rules, $message) {
		$validation = new \Locker\Validation();
		$validation->validate(['value' => $input], ['value' => $rules]);

		$clean = $validation->getClean();
		$errors = $validation->getErrors();

		$this->assertArrayNotHasKey('value', $clean);
		$this->assertArrayHasKey('value', $errors);
		$this->assertEquals($errors['value'], $message);
	}

	public function dpInvalidData() {
		return [
			// Test basic negative case.
			['not an email address', ['type' => 'email', 'args' => ['Bad Email']], 'Bad Email'],
			// Test multiple items.
			['not an email address', [['type' => 'minLength', 'args' => [10, 'Too Short']], ['type' => 'email', 'args' => ['Bad Email']]], 'Bad Email'],
			// Test multiple items, failing early.
			['short', [['type' => 'minLength', 'args' => [10, 'Too Short']], ['type' => 'email', 'args' => ['Bad Email']]], 'Too Short']			
		];
	}
}