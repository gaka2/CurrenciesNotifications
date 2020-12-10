<?php

namespace App\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\EmailAddress;
use App\Domain\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class EmailAddressTest extends TestCase
{
    public function test_creating_email_address()
    {
        $expected = 'name@domain.com';
        $emailAddress = new EmailAddress($expected);

        self::assertEquals($expected, $emailAddress->getEmail());
        self::assertEquals($expected, (string) $emailAddress);
    }
	
	public function provideIncorrectEmailAddresses() {
		return
		[
			[''],
			['name@'],
			['name@domain'],
			['name@.com'],
			['@domain.com'],
			['domain.com'],
		];
	}
	
	/**
	 * @dataProvider provideIncorrectEmailAddresses
	 */
    public function test_throw_exception_when_creating_email_address_with_incorrect_format($incorrectEmail)
    {
        $this->expectException(InvalidArgumentException::class);
        new EmailAddress($incorrectEmail);
    }
}