<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain;

final class CartItem
{
    private string $uuid;
    private string $productUuid;
    private float $price;
    private int $quantity;

    /**
     * CartItem constructor.
     *
     * @param string $uuid Unique identifier of the cart item.
     * @param string $productUuid Unique identifier of the product.
     * @param float $price Price of the product.
     * @param int $quantity Quantity of the product.
     */
    public function __construct(
        string $uuid,
        string $productUuid,
        float $price,
        int $quantity
    ) {
        $this->uuid = $uuid;
        $this->productUuid = $productUuid;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}