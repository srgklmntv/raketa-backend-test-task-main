<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Repository\CartManager;
use Raketa\BackendTestTask\View\CartView;

class GetCartController
{
    public function __construct(
        private CartView $cartView,
        private CartManager $cartManager
    ) {
    }

    /**
     * Retrieves the current cart.
     */
    public function get(RequestInterface $request): ResponseInterface
    {
        $cart = $this->cartManager->getCart();
        $response = new JsonResponse();

        if (!$cart) {
            $response->getBody()->write(json_encode(['message' => 'Cart not found']));
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($this->cartView->toArray($cart)));
        return $response->withStatus(200);
    }
}