<?php

namespace App\DataTransferObject;

use App\DataTransferObject\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class ExistingUserDto {
	
	private string $email;
	private string $hashCode;

	public function __construct(string $email, string $hashCode) {
		$this->email = $email;
		$this->hashCode = $hashCode;
	}

	public function getEmail() : string {
		return $this->email;
	}
	
	public function getHashCode() : string {
		return $this->hashCode;
	}

}
