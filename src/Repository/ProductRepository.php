<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Raketa\BackendTestTask\Repository\Entity\Product;
use InvalidArgumentException;

class ProductRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Retrieves a product by UUID.
     *
     * @param string $uuid The UUID of the product.
     * @return Product The retrieved product.
     * @throws DBALException|InvalidArgumentException If an error occurs or product is not found.
     */
    public function getByUuid(string $uuid): Product
    {
        $row = $this->connection->fetchAssociative(
            'SELECT * FROM products WHERE uuid = :uuid',
            ['uuid' => $uuid]
        );

        if (!$row) {
            throw new InvalidArgumentException('Product not found for UUID: ' . $uuid);
        }

        return $this->make($row);
    }

    /**
     * Retrieves products by category.
     *
     * @param string $category The category name.
     * @return Product[] List of products.
     * @throws DBALException If a database error occurs.
     */
    public function getByCategory(string $category): array
    {
        $rows = $this->connection->fetchAllAssociative(
            'SELECT * FROM products WHERE is_active = 1 AND category = :category',
            ['category' => $category]
        );

        return array_map([$this, 'make'], $rows);
    }

    /**
     * Creates a Product entity from a database row.
     *
     * @param array $row The database row.
     * @return Product The created product.
     */
    private function make(array $row): Product
    {
        return new Product(
            (int)$row['id'],
            (string)$row['uuid'],
            (bool)$row['is_active'],
            (string)$row['category'],
            (string)$row['name'],
            (string)$row['description'],
            (string)$row['thumbnail'],
            (float)$row['price']
        );
    }
}