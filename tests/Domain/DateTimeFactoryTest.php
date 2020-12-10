<?php

namespace App\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\DateTimeFactory;
use App\Domain\Exception\InvalidArgumentException;

/**
 * @author Karol Gancarczyk
 */
class DateTimeFactoryTest extends TestCase
{
    public function test_creating_date()
    {
		$dateString = '09-12-2020';
        $expected = \DateTimeImmutable::createFromFormat('d-m-Y', $dateString);
        self::assertEquals($expected, DateTimeFactory::createDate($dateString));
    }
	
	public function provideIncorrectDates() {
		return
		[
			[''],
			['1-12-2020'],
			['00-12-2020'],
			['32-12-2020'],
			['01-00-2020'],
			['01-13-2020'],
			['29-02-2019'],
			['01-01-2020r'],
			['01-01-2020 12:00:00'],
		];
	}
	
	/**
	 * @dataProvider provideIncorrectDates
	 */
    public function test_throw_exception_when_creating_date_with_incorrect_format($incorrectDateString)
    {
        $this->expectException(InvalidArgumentException::class);
        $c = DateTimeFactory::createDate($incorrectDateString);
    }
}