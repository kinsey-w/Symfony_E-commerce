<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur pour les fonctionnalités d'administration
#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    // Liste les paniers non achetés
    #[Route('/unpurchased-carts', name: 'unpurchased_carts')]
    public function listUnpurchasedCarts(EntityManagerInterface $em): Response
    {
        // Vérifie que l'utilisateur a le rôle ROLE_SUPER_ADMIN
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        // Récupère tous les paniers dont le statut est "non payé" (status = false)
        $unpurchasedCarts = $em->getRepository(Cart::class)->findBy(['status' => false]);

        return $this->render('admin/unpurchased_carts.html.twig', [
            'unpurchasedCarts' => $unpurchasedCarts,
        ]);
    }

    // Affiche les utilisateurs inscrits aujourd'hui
    #[Route('/admin/users/today', name: 'today_users')]
    public function todayUsers(EntityManagerInterface $em): Response
    {
        // Définit la plage de temps pour aujourd'hui (minuit à minuit suivant)
        $today = new \DateTimeImmutable('today midnight');
        $tomorrow = $today->modify('+1 day');

        // Création d'une requête SQL pour récupérer les utilisateurs inscrits aujourd'hui
        $query = $em->createQuery(
            'SELECT u
         FROM App\Entity\User u
         WHERE u.createdAt >= :today
           AND u.createdAt < :tomorrow
         ORDER BY u.createdAt DESC'
        );

        // Ajout des paramètres de la plage de dates
        $query->setParameter('today', $today);
        $query->setParameter('tomorrow', $tomorrow);

        $users = $query->getResult();

        return $this->render('admin/today_users.html.twig', [
            'users' => $users,
        ]);
    }
}
