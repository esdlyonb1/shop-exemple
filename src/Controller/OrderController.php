<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\AddressRepository;
use App\Repository\PaymentMethodRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/order')]
class OrderController extends AbstractController
{

    #[Route('/selection', name: 'app_selection', methods: ['GET'])]
    public function selection(): Response
    {
        $addresses = $this->getUser()->getAddresses();
        $paymentMethods = $this->getUser()->getPaymentMethods();

        $form = $this->createFormBuilder()
            ->add("billing", ChoiceType::class, [
                "choices" => $addresses,
                'choice_label' => "street",
                'choice_value' => "id",
            ])
            ->add("delivery", ChoiceType::class, [
                "choices" => $addresses,
                'choice_label' => "street",
                'choice_value' => "id",
            ])
            ->add("payment", ChoiceType::class, [
                "choices" => $paymentMethods,
                'choice_label' => "cardNumber",
                'choice_value' => "id",
            ])
            ->add('submit', SubmitType::class, [])
            ->setMethod('POST')
            ->setAction($this->generateUrl("app_recap"))
            ->getForm();




        return $this->render('order/selection.html.twig', [
            'controller_name' => 'OrderController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/recap', name: 'app_recap', methods: ['POST'])]
    public function recap(Request $request,
                          AddressRepository $addressRepository,
                          PaymentMethodRepository $paymentMethodRepository,
                          EntityManagerInterface $entityManager,
                            CartService $cartService,
    ): Response
    {

      $infos = $request->get('form');
      $deliveryAddress = $addressRepository->find($infos['delivery']);
      $billingAddress = $addressRepository->find($infos['billing']);
      $paymentMethod = $paymentMethodRepository->find($infos['payment']);

      $order = new Order();
      $order->setCustomer($this->getUser());
      $order->setBillingAddress($billingAddress);
      $order->setDeliveryAddress($deliveryAddress);
      $order->setPaymentMethod($paymentMethod);
      $order->setStatus(0);
      $order->setDeliveryStatus(0);

      $entityManager->persist($order);
      $entityManager->flush();




        return $this->render('order/recap.html.twig', [
            'order' => $order,
            'total' =>$cartService->getTotal(),
            'items' =>$cartService->getCart()
        ]);
    }
}
