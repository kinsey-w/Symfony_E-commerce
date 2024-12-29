<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Cart;
use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/user')]
final class UserController extends AbstractController
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    // Affiche la liste des utilisateurs
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // Permet de créer un nouvel utilisateur
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('user.flash.create_success'));
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // Supprime un utilisateur spécifique
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', $this->translator->trans('user.flash.delete_success'));
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    // Affiche le profil d'un utilisateur spécifique
    #[Route('/user/{id}', name: 'user_profile')]
    public function show(User $user, EntityManagerInterface $em): Response
    {
        // Vérifie si l'utilisateur est connecté
        $loggedInUser = $this->getUser();
        if (!$loggedInUser) {
            $this->addFlash('error', $this->translator->trans('user.flash.access_denied'));
            return $this->redirectToRoute('app_login');
        }

        // Récupère les commandes passées par l'utilisateur
        $orders = $em->getRepository(Cart::class)->findBy(['user' => $loggedInUser, 'status' => true]);

        return $this->render('user/show.html.twig', [
            'user' => $loggedInUser,
            'orders' => $orders,
        ]);
    }

    // Affiche les détails d'une commande spécifique
    #[Route('/account/order/{id}', name: 'order_details')]
    public function orderDetails(Cart $cart): Response
    {
        $user = $this->getUser();
        if (!$user || $cart->getUser() !== $user) {
            $this->addFlash('error', $this->translator->trans('user.flash.order_access_denied'));
            return $this->redirectToRoute('user_account');
        }

        return $this->render('user/order_details.html.twig', [
            'cart' => $cart,
        ]);
    }

    // Affiche la page de compte de l'utilisateur connecté
    #[Route('/account', name: 'user_account', methods: ['GET'])]
    public function account(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', $this->translator->trans('user.flash.access_denied'));
            return $this->redirectToRoute('app_login');
        }

        // Récupère les commandes passées par l'utilisateur
        $orders = $em->getRepository(Cart::class)->findBy(['user' => $user, 'status' => true]);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    // Permet à l'utilisateur de modifier son profil
    #[Route('/profile/edit', name: 'user_profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', $this->translator->trans('user.flash.access_denied'));
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', $this->translator->trans('user.flash.update_success'));
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
