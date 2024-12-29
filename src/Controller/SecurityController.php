<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // Route pour gérer la connexion de l'utilisateur
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupération de la dernière erreur d'authentification (si elle existe)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupération du dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        // Génération d'un token CSRF pour sécuriser le formulaire de connexion
        $tokenManager = $this->container->get('security.csrf.token_manager');
        $csrfToken = $tokenManager->getToken('authenticate');
        dump('Generated CSRF Token Object:', $csrfToken); // Débogage de l'objet du token CSRF
        dump('Generated CSRF Token Value:', $csrfToken->getValue()); // Débogage de la valeur du token CSRF

        // Rendu du formulaire de connexion avec les informations nécessaires
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, // Dernier nom d'utilisateur saisi
            'error' => $error,               // Erreur d'authentification (le cas échéant)
        ]);
    }

    // Route pour gérer la déconnexion de l'utilisateur
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // La déconnexion est gérée par le système de sécurité de Symfony.
    }
}
