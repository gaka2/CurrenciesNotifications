<?php

namespace App\Tests\DataTransferObject;

use PHPUnit\Framework\TestCase;
use App\DataTransferObject\CurrencyDto;
use App\DataTransferObject\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class CurrencyDtoTest extends TestCase
{
    public function test_creating_currency()
    {
        $code = 'USD';
        $rate = 3.70;
        $currencyDto = new CurrencyDto($code, $rate);

        self::assertEquals($code, $currencyDto->getCode());
        self::assertEquals($rate, $currencyDto->getRate());
    }

    public function test_throw_exception_when_creating_currency_with_empty_code()
    {
        $this->expectException(InvalidArgumentException::class);
        new CurrencyDto('', 1.0);
    }
	
	public function provideIncorrectCurrencyCodes() {
		return
		[
			['USDA'],
			['US3'],
			[' USD'],
			['USDUSD'],
			['US'],
			['123'],
			['USd'],
		];
	}
	
	/**
	 * @dataProvider provideIncorrectCurrencyCodes
	 */
    public function test_throw_exception_when_creating_currency_with_incorrect_code($incorrectCode)
    {
        $this->expectException(InvalidArgumentException::class);
        new CurrencyDto($incorrectCode, 1.0);
    }
	
    public function test_throw_exception_when_creating_currency_with_incorrect_rate()
    {
        $this->expectException(InvalidArgumentException::class);
		$nagativeRate = -0.01;
        new CurrencyDto('USD', $nagativeRate);
    }
}