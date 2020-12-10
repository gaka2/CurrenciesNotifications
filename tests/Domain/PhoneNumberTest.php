<?php

namespace App\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\PhoneNumber;
use App\Domain\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class PhoneNumberTest extends TestCase
{
    public function test_creating_phone_number()
    {
        $expected = '123456789';
        $phoneNumber = new PhoneNumber($expected);

        self::assertEquals($expected, $phoneNumber->getNumber());
        self::assertEquals($expected, (string) $phoneNumber);
    }
	
	public function provideIncorrectPhoneNumbers() {
		return
		[
			[''],
			['12345678'],
			[' 12345678'],
			['12345678 '],
			['012345678'],
			['1234567891'],
			['1234AbC8D'],
			['+48570122'],
		];
	}
	
	/**
	 * @dataProvider provideIncorrectPhoneNumbers
	 */
    public function test_throw_exception_when_creating_phone_number_with_incorrect_format($incorrectNumber)
    {
        $this->expectException(InvalidArgumentException::class);
        new PhoneNumber($incorrectNumber);
    }
}