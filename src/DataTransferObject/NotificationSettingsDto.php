<?php

namespace App\DataTransferObject;

use App\DataTransferObject\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class NotificationSettingsDto {
	
	private string $currencyCode;
	private float $minimumRateThreshold;
	private float $maximumRateThreshold;
	
	public function __construct(string $currencyCode, float $minimumRateThreshold, float $maximumRateThreshold) {
		$this->currencyCode = $currencyCode;
		$this->minimumRateThreshold = $minimumRateThreshold;
		$this->maximumRateThreshold = $maximumRateThreshold;
	}

	public function getCurrencyCode() : string {
		return $this->currencyCode;
	}
	
	public function getMinimumRateThreshold() : float {
		return $this->minimumRateThreshold;
	}
	
	public function getMaximumRateThreshold() : float {
		return $this->maximumRateThreshold;
	}
	
}
