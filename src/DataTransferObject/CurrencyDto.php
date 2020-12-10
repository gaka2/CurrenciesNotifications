<?php

namespace App\DataTransferObject;

use App\DataTransferObject\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class CurrencyDto {
	
	private string $code;
	private float $exchangeRate;
	
	public function __construct(string $code, float $exchangeRate) {

		if (preg_match('/^[A-Z]{3}$/', $code) !== 1) {
            throw new InvalidArgumentException('Currency code must be 3-letter');
        }
		
		$this->code = $code;
		
        if ($exchangeRate < 0.0) {
            throw new InvalidArgumentException('Exchange rate must be non-negative number');
        }

		$this->exchangeRate = $exchangeRate;
	}   
	
	public function getCode(): string {
		return $this->code;
	}

	public function getRate() : float {
		return $this->exchangeRate;
	}
}
  