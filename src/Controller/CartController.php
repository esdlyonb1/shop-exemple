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
            'total' => $cartService->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}/{quantity}', name: 'app_cart_add')]
    #[Route('/cart/addfromcart/{id}/{quantity}', name: 'app_cart_addfromcart')]
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

#[Route('/cart/removeone/{id}', name: 'app_cart_remove_one')]
public function removeOneFromCart(Product $product, CartService $cartService): Response
{
    $cartService->removeOneProduct($product);
    return $this->redirectToRoute('app_cart');
}
    #[Route('/cart/removerow/{id}', name: 'app_cart_remove_row')]
    public function removeRowFromCart(Product $product, CartService $cartService): Response
    {
        $cartService->removeProductRow($product);
        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/empty', name: 'app_cart_empty')]
    public function emptyCart(CartService $cartService): Response
    {
        $cartService->emptyCart();
        return $this->redirectToRoute('app_cart');
    }
}

//public function removeOneProduct( );
//public function removeProductRow( );
//public function emptyCart();


