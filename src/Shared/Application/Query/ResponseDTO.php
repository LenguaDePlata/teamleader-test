<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

interface ResponseDTO
{
	public function __toArray(): array;
}