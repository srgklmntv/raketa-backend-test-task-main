<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\View;

use Raketa\BackendTestTask\Repository\Entity\Product;
use Raketa\BackendTestTask\Repository\ProductRepository;

readonly class ProductsView
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * Fetches products by category and converts them to an array representation.
     *
     * @param string $category The category to filter products by.
     * @return array<int, array<string, mixed>> List of products as associative arrays.
     */
    public function toArray(string $category): array
    {
        $products = $this->productRepository->getByCategory($category);

        return array_map(
            fn (Product $product): array => [
                'id' => $product->getId(),
                'uuid' => $product->getUuid(),
                'category' => $product->getCategory(),
                'description' => $product->getDescription(),
                'thumbnail' => $product->getThumbnail(),
                'price' => $product->getPrice(),
            ],
            $products
        );
    }
}