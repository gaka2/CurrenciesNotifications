<?php

namespace App\Domain;

use App\Domain\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class PhoneNumber {
		
	private string $number;

	public function __construct(string $number) {
		if (preg_match('/^[1-9][0-9]{8}$/', $number) !== 1 ) {
			throw new InvalidArgumentException('Phone number must contain 9 digits and can not start with zero');
		}

		$this->number = $number;
	}
	
	public function getNumber() : string {
		return $this->number;
	}
	
	public function __toString() : string {
		return $this->getNumber();
	}
}
