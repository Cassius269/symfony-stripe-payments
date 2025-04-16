<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class OrderController extends AbstractController
{
    #[Route(
        path: '/order',
        name: 'order',
        methods: ['GET', 'POST']
    )]
    public function index(Request $request): Response
    {
        // Créer une nouvelle instance de l'objet Commande
        $order = new Order;

        // Créer le formulaire
        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request); // Récuillir les données de la requête

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
