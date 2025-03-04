<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain;

final class Cart
{
    private string $uuid;
    private Customer $customer;
    private string $paymentMethod;
    /** @var CartItem[] */
    private array $items;

    /**
     * Cart constructor.
     *
     * @param string $uuid Unique identifier of the cart.
     * @param Customer $customer Customer associated with the cart.
     * @param string $paymentMethod Payment method used in the cart.
     * @param CartItem[] $items List of items in the cart.
     */
    public function __construct(
        string $uuid,
        Customer $customer,
        string $paymentMethod,
        array $items = []
    ) {
        $this->uuid = $uuid;
        $this->customer = $customer;
        $this->paymentMethod = $paymentMethod;
        $this->items = $items;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @return CartItem[] List of items in the cart.
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Adds an item to the cart.
     *
     * @param CartItem $item Item to add.
     * @return void
     */
    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }
}