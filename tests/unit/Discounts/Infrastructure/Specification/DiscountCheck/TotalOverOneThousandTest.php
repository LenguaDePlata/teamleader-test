<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Infrastructure\Specification\DiscountCheck\TotalOverOneThousand;
use App\Tests\Mother\Discounts\OrderMother;
use PHPUnit\Framework\TestCase;

final class TotalOverOneThousandTest extends TestCase
{
	private TotalOverOneThousand $check;

	protected function setUp(): void
	{
		$this->check = new TotalOverOneThousand();
	}

	public function testItReturnsTrueWhenTotalIsOver1000(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithTotalOver1000AndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertTrue($result);
	}

	public function testItReturnsFalseWhenTotalIsUnder1000(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithOneItemAndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertFalse($result);
	}

	public function testItReturnsFalseWhenTotalIsExactly1000(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithTotalExactly1000AndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertFalse($result);
	}
}