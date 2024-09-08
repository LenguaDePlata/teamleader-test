<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Application\Query\CalculateDiscount;

use App\Discounts\Application\Exception\ProductNotFoundException as ProductNotFoundApplicationException;
use App\Discounts\Application\Exception\UnexpectedDiscountErrorException;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountHandler;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountResponse;
use App\Discounts\Application\Assembler\CalculateDiscountResponseAssembler;
use App\Discounts\Domain\Builder\OrderBuilder;
use App\Discounts\Domain\Exception\ProductNotFoundException;
use App\Discounts\Domain\Exception\AssignedDiscountThatCouldNotBeAppliedException;
use App\Discounts\Domain\Exception\UndefinedDiscountCheckException;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Infrastructure\Specification\DiscountCheck\FiveProductsOfCategorySwitches;
use App\Discounts\Infrastructure\Specification\DiscountCheck\TwoOrMoreProductsOfCategoryTools;
use App\Discounts\Infrastructure\Specification\DiscountCheck\TotalOverOneThousand;
use App\Tests\Mother\Discounts\CalculateDiscountQueryMother;
use App\Tests\Mother\Discounts\CalculateDiscountResponseMother;
use App\Tests\Mother\Discounts\OrderMother;
use App\Tests\Mother\Discounts\ProductIdMother;
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
		$response = CalculateDiscountResponseMother::aValidResponseWithOneItemAndNoDiscounts();

		$this->givenTheBuilderCreatesThisOrder($order);
		$this->givenTheAssemblerGeneratesThisResponse($response);

		// Act
		$response = $this->handler->handle($query);

		// Assert
		$this->assertInstanceOf(CalculateDiscountResponse::class, $response);
	}

	public function testItThrowsApplicationExceptionIfProductIsNotFound(): void
	{
		// Arrange
		$query = CalculateDiscountQueryMother::aValidQueryWithOneItem();

		$this->givenTheBuilderThrowsProductNotFoundException();
		$this->givenTheResponseNeverGetsBuilt();

		$this->expectException(
			ProductNotFoundApplicationException::class
		);

		// Act
		$this->handler->handle($query);
	}

	public function testItThrowsApplicationExceptionIfDiscountCheckIsUndefined(): void
	{
		// Arrange
		$query = CalculateDiscountQueryMother::aValidQueryWithOneItem();
		$order = $this->createMock(Order::class);
		
		$this->givenTheBuilderCreatesThisOrder($order);
		$this->givenTheOrderThrowsUndefinedDiscountCheckException($order);
		$this->givenTheResponseNeverGetsBuilt();

		$this->expectException(UnexpectedDiscountErrorException::class);

		// Act
		$this->handler->handle($query);
	}

	public function testItThrowsApplicationExceptionIfDiscountCouldNotBeApplied(): void
	{
		// Arrange
		$query = CalculateDiscountQueryMother::aValidQueryWithOneItem();
		$order = $this->createMock(Order::class);
		
		$this->givenTheBuilderCreatesThisOrder($order);
		$this->givenTheOrderThrowsDiscountCouldNotBeAppliedException($order);
		$this->givenTheResponseNeverGetsBuilt();

		$this->expectException(UnexpectedDiscountErrorException::class);

		// Act
		$this->handler->handle($query);
	}

	private function givenTheBuilderCreatesThisOrder(Order $order): void
	{
		$this->orderBuilderMock
			->expects($this->once())
			->method('build')
			->willReturn($order);
	}

	private function givenTheAssemblerGeneratesThisResponse(CalculateDiscountResponse $response): void
	{
		$this->responseAssemblerMock
			->expects($this->once())
			->method('toDTO')
			->with(
				$this->isInstanceOf(Order::class),
				$this->isInstanceOf(CalculateDiscountQuery::class)
			)
			->willReturn($response);
	}

	private function givenTheResponseNeverGetsBuilt(): void
	{
		$this->responseAssemblerMock
			->expects($this->never())
			->method('toDTO');
	}

	private function givenTheOrderThrowsUndefinedDiscountCheckException(Order $order): void
	{
		$order
			->expects($this->once())
			->method('applyDiscounts')
			->willThrowException(new UndefinedDiscountCheckException('UnknownDiscountCheck'));
	}

	private function givenTheBuilderThrowsProductNotFoundException(): void
	{
		$this->orderBuilderMock
			->expects($this->once())
			->method('build')
			->willThrowException(
				new ProductNotFoundException(ProductIdMother::aWeirdId())
			);
	}

	private function givenTheOrderThrowsDiscountCouldNotBeAppliedException(Order $order): void
	{
		$order
			->expects($this->once())
			->method('applyDiscounts')
			->willThrowException(new AssignedDiscountThatCouldNotBeAppliedException('Discount1'));
	}
}