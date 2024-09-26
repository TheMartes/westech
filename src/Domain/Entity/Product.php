<?php declare(strict_types=1);

namespace Westech\Domain\Entity;

class Product
{
    public function __construct(
			private int $id,
			private string $name,
			private ?string $description,
			private string $brand,
			private string $category,
			private float $price
		)
    {}

		public function getId(): int
		{
			return $this->id;
		}

		public function getName(): string
		{
			return $this->name;
		}

		public function getDescription(): ?string
		{
			return $this->description;
		}

		public function getBrand(): string
		{
			return $this->brand;
		}

		public function getCategory(): string
		{
			return $this->category;
		}

		public function getPrice(): float
		{
			return $this->price;
		}
}