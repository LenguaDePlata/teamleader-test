<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Infrastructure\Specification\DiscountCheck\FiveProductsOfCategorySwitches;
use App\Tests\Mother\Discounts\OrderMother;
use PHPUnit\Framework\TestCase;

final class FiveProductsOfCategorySwitchesTest extends TestCase
{
	private FiveProductsOfCategorySwitches $check;

	protected function setUp(): void
	{
		$this->check = new FiveProductsOfCategorySwitches();
	}

	public function testItRetunsTrueWhenOrderHasItemWithFiveSwitchProducts(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithOneItemAndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertTrue($result);
	}

	public function itReturnsFalseWhenOrderHasNoSwitchProducts(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithMultipleToolItemsAndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertFalse($result);
	}

	public function itReturnsFalseWhenOrderHasItemWithLessThanFiveSwitchProducts(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithMultipleLessThanFiveSwitchItems();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertFalse($result);
	}
}