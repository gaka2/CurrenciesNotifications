<?php

namespace App\DataTransferObject;


use App\DataTransferObject\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class UserDto {
	
	private string $name;
	private string $surname;
	private string $phoneNumber;
	private string $email;
	private string $birthDate;
	private array $notificationsSettngs;

	public function __construct(string $name, string $surname, string $phoneNumber, string $email, string $birthDate, array $notificationsSettngs) {
		$this->name = $name;
		$this->surname = $surname;
		$this->phoneNumber = $phoneNumber;
		$this->email = $email;
		$this->birthDate = $birthDate;
		$this->notificationsSettngs = $notificationsSettngs;
	}
	
	public function getName() : string {
		return $this->name;
	}
	
	public function getSurname() : string {
		return $this->surname;
	}
	
	public function getPhoneNumber(): string {
		return $this->phoneNumber;
	}
	
	public function getEmail() : string {
		return $this->email;
	}
	
	public function getBirthDate() : string {
		return $this->birthDate;
	}

	public function getNotificationsSettings() : array {
		return $this->notificationsSettngs;
	}
	
}
