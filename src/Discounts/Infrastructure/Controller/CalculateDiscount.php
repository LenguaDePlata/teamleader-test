<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CalculateDiscount extends AbstractController
{
	public function __invoke(Request $request): JsonResponse
	{

	}
}