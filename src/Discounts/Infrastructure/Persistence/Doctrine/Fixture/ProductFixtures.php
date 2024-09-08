<?php

namespace App\Discounts\Infrastructure\Persistence\Doctrine\Fixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Discounts\Domain\Model\Product\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product(
			id: "A101",
			description: "Screwdriver",
			category: 1,
			price: 9.75
		);
        $manager->persist($product);

        $product = new Product(
			id: "A102",
			description: "Electric screwdriver",
			category: 1,
			price: 49.50
		);
        $manager->persist($product);

		$product = new Product(
			id: "B101",
			description: "Basic on-off switch",
			category: 2,
			price: 4.99
		);
        $manager->persist($product);

		$product = new Product(
			id: "B102",
			description: "Press button",
			category: 2,
			price: 4.99
		);
        $manager->persist($product);

		$product = new Product(
			id: "B103",
			description: "Switch with motion detector",
			category: 2,
			price: 12.95
		);
        $manager->persist($product);

        $manager->flush();
    }
}
