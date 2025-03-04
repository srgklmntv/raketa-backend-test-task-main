<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Repository;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart;
use Raketa\BackendTestTask\Infrastructure\ConnectorFacade;

class CartManager extends ConnectorFacade
{
    private LoggerInterface $logger;

    public function __construct(string $host, int $port, ?string $password, LoggerInterface $logger)
    {
        parent::__construct($host, $port, $password, 1);
        $this->logger = $logger;
        $this->build();
    }

    /**
     * Saves the cart into storage.
     *
     * @param Cart $cart The cart to save.
     * @return void
     */
    public function saveCart(Cart $cart): void
    {
        try {
            $this->getConnector()->set(session_id(), $cart);
        } catch (Exception $e) {
            $this->logger->error('Error saving cart: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Retrieves the cart from storage.
     *
     * @return ?Cart The cart if found, or a new cart instance otherwise.
     */
    public function getCart(): ?Cart
    {
        try {
            return $this->getConnector()->get(session_id());
        } catch (Exception $e) {
            $this->logger->error('Error retrieving cart: ' . $e->getMessage(), ['exception' => $e]);
            return new Cart(session_id(), []);
        }
    }
}