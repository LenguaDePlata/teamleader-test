<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Infrastructure\Specification\DiscountCheck\TwoOrMoreProductsOfCategoryTools;
use App\Tests\Mother\Discounts\OrderMother;
use PHPUnit\Framework\TestCase;

final class TwoOrMoreProductsOfCategoryToolsTest extends TestCase
{
	private TwoOrMoreProductsOfCategoryTools $check;

	protected function setUp(): void
	{
		$this->check = new TwoOrMoreProductsOfCategoryTools();
	}

	public function testItReturnsTrueIfThereAreTwoOrMoreToolProductsInOrder(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithMultipleToolItemsAndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertTrue($result);
	}

	public function testItReturnsFalseIfThereIsOnlyOneToolProductInOrder(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithOneToolItemAndNoDiscounts();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertFalse($result);
	}

	public function testItReturnsFalseIfThereAreNoToolProductsInOrder(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithMultipleLessThanFiveSwitchItems();

		// Act
		$result = $this->check->isSatisfiedBy($order);

		// Assert
		$this->assertFalse($result);
	}
}