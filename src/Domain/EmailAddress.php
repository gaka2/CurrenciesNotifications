<?php

namespace App\Domain;

use App\Domain\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class EmailAddress {
		
	private string $email;

	public function __construct(string $email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException("Invalid e-mail address: {$email}");
		}

		$this->email = $email;
	}
	
	public function getEmail() : string {
		return $this->email;
	}
	
	public function __toString() : string {
		return $this->getEmail();
	}
}
