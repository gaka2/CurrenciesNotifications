<?php

namespace App\Domain;

use App\Domain\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class DateTimeFactory {
		
	private const REQUIRED_DATE_FORMAT = 'd-m-Y';

	public static function createDate(string $dateString) : \DateTimeInterface {
		$date = \DateTimeImmutable::createFromFormat(self::REQUIRED_DATE_FORMAT, $dateString);
		if ($date === false || $date->format(self::REQUIRED_DATE_FORMAT) !== $dateString) {
			throw new InvalidArgumentException(sprintf("Invalid date: '%s'. Required date format: '%s'", $dateString, self::REQUIRED_DATE_FORMAT));
		}
		
		return $date;
	}
}
