<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{



    public function __construct(
        private ProductRepository $productRepository,
        private RequestStack $requestStack
    )
    {

    }

    public function addProduct(Product $product, int $quantity)
    {
       $cart = $this->requestStack->getSession()->get("cart", []);
       $productId = $product->getId();

       if(isset($cart[$productId])) {
           $cart[$productId] = $cart[$productId]+$quantity;
       }else  {
           $cart[$productId] = $quantity;

       }

       $this->requestStack->getSession()->set("cart",$cart);

    }
    public function getCart()
    {
        $cart = $this->requestStack->getSession()->get("cart", []);
        $objectCart = [];
        foreach ($cart as $productId => $quantity) {
            $item = [
                "product" => $this->productRepository->find($productId),
                "quantity" => $quantity

            ];
            $objectCart[] = $item;
        }

        return $objectCart;
    }

}