<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\PaymentMethod;
use App\Form\AddressType;
use App\Form\PaymentMethodType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile', priority: 5)]
    public function index(): Response
    {
        $newAddress = new Address();
        $newPayementMethod = new PaymentMethod();
        $formPayment = $this->createForm(PaymentMethodType::class, $newPayementMethod);
        $formAddress = $this->createForm(AddressType::class, $newAddress);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'formPayment' => $formPayment->createView(),
            'formAddress' => $formAddress->createView(),
        ]);
    }

    #[Route('/profile/address', name: 'app_profile_address', priority: 5)]
public function addAddress(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newAddress = new Address();
        $formAddress = $this->createForm(AddressType::class, $newAddress);
        $formAddress->handleRequest($request);
        if ($formAddress->isSubmitted() && $formAddress->isValid()) {
            $newAddress->setOwner($this->getUser());
            $entityManager->persist($newAddress);
            $entityManager->flush();

        }
        return $this->redirectToRoute('app_profile');

    }


    #[Route('/profile/paymentmethod', name: 'app_profile_paymentmethod', priority: 5)]
    public function addPaymentMethods(Request $request, EntityManagerInterface $entityManager): Response
    {

        $newPayementMethod = new PaymentMethod();
        $formPayment = $this->createForm(PaymentMethodType::class, $newPayementMethod);
            $formPayment->handleRequest($request);
            if ($formPayment->isSubmitted() && $formPayment->isValid()) {

                $newPayementMethod->setOwner($this->getUser());
                $entityManager->persist($newPayementMethod);
                $entityManager->flush();
            }



        return $this->redirectToRoute('app_profile');

    }

}
