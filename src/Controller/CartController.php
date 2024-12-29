<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use DateTimeImmutable;

// Contrôleur pour gérer les paniers
class CartController extends AbstractController
{
    private TranslatorInterface $translator;

    // Inject TranslatorInterface in the constructor
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', $this->translator->trans('cart.flash.not_logged_in'));
            return $this->redirectToRoute('app_login');
        }

        // Recherche ou création d'un panier pour l'utilisateur
        $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user, 'status' => false]);
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setStatus(false); // Définit le statut comme "non payé"
            $em->persist($cart);
        }

        // Ajout du produit au panier
        $quantity = (int) $request->request->get('quantity', 1);
        $cartItem = new CartItem();
        $cartItem->setCart($cart);
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);
        $cartItem->setAddedAt(new DateTimeImmutable());

        $em->persist($cartItem);
        $em->flush();

        $this->addFlash('success', $this->translator->trans('cart.flash.product_added'));
        return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
    }

    #[Route('/cart', name: 'cart_show')]
    public function showCart(EntityManagerInterface $em): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', $this->translator->trans('cart.flash.not_logged_in'));
            return $this->redirectToRoute('app_login');
        }

        // Récupère le panier actif de l'utilisateur
        $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user, 'status' => false]);
        $cartItems = $cart ? $cart->getItems()->toArray() : [];

        // Calcul du prix total
        $totalPrice = array_reduce($cartItems, function ($total, $item) {
            return $total + ($item->getQuantity() * $item->getProduct()->getPrix());
        }, 0);

        // Affiche le contenu du panier
        return $this->render('cart/index.html.twig', [
            'cart_items' => $cartItems,
            'total_price' => $totalPrice,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart(Product $product, EntityManagerInterface $em, Request $request): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', $this->translator->trans('cart.flash.not_logged_in'));
            return $this->redirectToRoute('app_login');
        }

        $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user, 'status' => false]);
        if (!$cart) {
            $this->addFlash('error', $this->translator->trans('cart.flash.no_active_cart'));
            return $this->redirectToRoute('cart_show');
        }

        $cartItem = $em->getRepository(CartItem::class)->findOneBy([
            'cart' => $cart,
            'product' => $product,
        ]);

        if ($cartItem) {
            if ($this->isCsrfTokenValid('remove' . $product->getId(), $request->request->get('_token'))) {
                $em->remove($cartItem);
                $em->flush();
                $this->addFlash('success', $this->translator->trans('cart.flash.item_removed'));
            } else {
                $this->addFlash('error', $this->translator->trans('cart.flash.csrf_invalid'));
            }
        } else {
            $this->addFlash('error', $this->translator->trans('cart.flash.item_not_found'));
        }

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/checkout', name: 'cart_checkout', methods: ['POST'])]
    public function checkout(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', $this->translator->trans('cart.flash.not_logged_in'));
            return $this->redirectToRoute('app_login');
        }

        $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user, 'status' => false]);
        if (!$cart) {
            $this->addFlash('error', $this->translator->trans('cart.flash.no_active_cart'));
            return $this->redirectToRoute('cart_show');
        }

        $cart->setStatus(true);
        $cart->setPurchaseDate(new \DateTimeImmutable());
        $em->flush();

        $this->addFlash('success', $this->translator->trans('cart.flash.checkout_success'));
        return $this->redirectToRoute('homepage');
    }
}
