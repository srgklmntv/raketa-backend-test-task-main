<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\CartItem;
use Raketa\BackendTestTask\Repository\CartManager;
use Raketa\BackendTestTask\Repository\ProductRepository;
use Raketa\BackendTestTask\View\CartView;
use Ramsey\Uuid\Uuid;

class AddToCartController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CartView $cartView,
        private CartManager $cartManager,
    ) {
    }

    /**
     * Adds a product to the cart.
     * Expected request format:
     * {
     *     "productUuid": "string",
     *     "quantity": int
     * }
     */
    public function post(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        
        if (!isset($rawRequest['productUuid'], $rawRequest['quantity']) || !is_int($rawRequest['quantity'])) {
            $response = new JsonResponse();
            $response->getBody()->write(json_encode(['error' => 'Invalid request data']));
            return $response->withStatus(400);
        }

        $product = $this->productRepository->getByUuid($rawRequest['productUuid']);
        
        if (!$product) {
            $response = new JsonResponse();
            $response->getBody()->write(json_encode(['error' => 'Product not found']));
            return $response->withStatus(404);
        }

        $cart = $this->cartManager->getCart();
        $cart->addItem(new CartItem(
            Uuid::uuid4()->toString(),
            $product->getUuid(),
            $product->getPrice(),
            $rawRequest['quantity']
        ));

        $response = new JsonResponse();
        $response->getBody()->write(json_encode([
            'status' => 'success',
            'cart' => $this->cartView->toArray($cart)
        ]));
        return $response->withStatus(200);
    }
}