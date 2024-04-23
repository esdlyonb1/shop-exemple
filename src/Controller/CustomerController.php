<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    #[Route('/', name: 'app_customer_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('customer/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    #[Route('/{id}', name: 'app_customer_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('customer/show.html.twig', ['product' => $product]);
    }
}
