<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {

        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
        ]);
    }

    #[Route('/cart/add/{id}/{quantity}', name: 'app_cart_add')]
    #[Route('/cart/add/{id}/{quantity}', name: 'app_cart_addfromcart')]
public function addToCart(Request $request, Product $product, $quantity, CartService $cartService): Response
    {
            $cartService->addProduct($product, $quantity);

            $originRoute = $request->attributes->get('_route');
            $redirection = 'app_customer_index';
            if($originRoute = "app_cart_addfromcart")
            {
                $redirection = 'app_cart';
            }

        return $this->redirectToRoute($redirection);

}
}

//public function removeOneProduct( );
//public function removeProductRow( );
//public function emptyCart();


