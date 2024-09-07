<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Application\Query\CalculateDiscount;

use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountHandler;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountResponse;
use App\Discounts\Application\Assembler\CalculateDiscountResponseAssembler;
use App\Discounts\Domain\Builder\OrderBuilder;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Infrastructure\Specification\DiscountCheck\FiveProductsOfCategorySwitches;
use App\Discounts\Infrastructure\Specification\DiscountCheck\TwoOrMoreProductsOfCategoryTools;
use App\Discounts\Infrastructure\Specification\DiscountCheck\TotalOverOneThousand;
use App\Tests\Mother\Discounts\OrderMother;
use App\Tests\Mother\Discounts\CalculateDiscountQueryMother;
use App\Tests\Mother\Discounts\CalculateDiscountResponseMother;
use PHPUnit\Framework\TestCase;

final class CalculateDiscountHandlerTest extends TestCase
{
	private CalculateDiscountHandler $handler;

	private OrderBuilder $orderBuilderMock;
	private CalculateDiscountResponseAssembler $responseAssemblerMock;
	private iterable $discountChecks;

	protected function setUp(): void
	{
		$this->orderBuilderMock = $this->createMock(OrderBuilder::class);
		$this->responseAssemblerMock = $this->createMock(CalculateDiscountResponseAssembler::class);
		$this->discountChecks = [
			new FiveProductsOfCategorySwitches(),
			new TotalOverOneThousand(),
			new TwoOrMoreProductsOfCategoryTools()
		];

		$this->handler = new CalculateDiscountHandler(
			$this->orderBuilderMock,
			$this->responseAssemblerMock,
			$this->discountChecks
		);
	}

	public function testItChecksAndAppliesDiscountsOnAValidOrder(): void
	{
		// Arrange
		$query = CalculateDiscountQueryMother::aValidQueryWithOneItem();

		$order = OrderMother::aValidOrderWithOneItemAndNoDiscounts();
		$this->orderBuilderMock
			->expects($this->once())
			->method('build')
			->willReturn($order);

		$response = CalculateDiscountResponseMother::aValidResponseWithOneItemAndNoDiscounts();
		$this->responseAssemblerMock
			->expects($this->once())
			->method('toDTO')
			->with(
				$this->isInstanceOf(Order::class),
				$this->isInstanceOf(CalculateDiscountQuery::class)
			)
			->willReturn($response);

		// Act
		$response = $this->handler->handle($query);

		// Assert
		$this->assertInstanceOf(CalculateDiscountResponse::class, $response);
	}

	public function testItThrowsApplicationExceptionIfProductIsNotFound(): void
	{
		// Arrange

		// Act

		// Assert
	}

	public function testItThrowsApplicationExceptionIfDiscountCheckIsUndefined(): void
	{
		// Arrange

		// Act

		// Assert

	}
}