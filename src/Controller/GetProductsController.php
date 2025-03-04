<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\View\ProductsView;

class GetProductsController
{
    public function __construct(
        private ProductsView $productsView
    ) {
    }

    /**
     * Retrieves a list of products based on category.
     */
    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $response = new JsonResponse();

        if (!isset($rawRequest['category']) || !is_string($rawRequest['category'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid category']));
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode($this->productsView->toArray($rawRequest['category'])));
        return $response->withStatus(200);
    }
}