<?php 

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductController extends AbstractController
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    // Route pour ajouter un nouveau produit
    #[Route('/product/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifie que seul un administrateur peut accéder à cette route
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); 

        $product = new Product(); // Création d'un nouvel objet produit
        $form = $this->createForm(ProductType::class, $product); // Création du formulaire lié à l'entité produit
        $form->handleRequest($request); // Gère la soumission du formulaire

        if ($form->isSubmitted()) { // Vérifie si le formulaire est soumis
            if ($form->isValid()) { // Vérifie si le formulaire est valide
                $entityManager->persist($product); 
                $entityManager->flush();

                $this->addFlash('success', $this->translator->trans('product.flash.add_success')); // Message flash pour succès
                return $this->redirectToRoute('homepage'); // Redirection vers la page d'accueil
            } else {
                foreach ($form->getErrors(true) as $error) { // Ajoute les messages d'erreur en cas d'invalidité
                    $this->addFlash('error', $error->getMessage());
                }
            }
        }

        // Affiche le formulaire
        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour afficher les détails d'un produit
    #[Route('/product/{id}', name: 'product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [ 
            'product' => $product,
        ]);
    }

    // Route pour modifier un produit
    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // Vérifie que seul un administrateur peut accéder à cette route

        $form = $this->createForm(ProductType::class, $product); // Crée le formulaire pour modifier le produit
        $form->handleRequest($request); // Gère la soumission du formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Vérifie si le formulaire est soumis et valide
            $entityManager->flush(); // Sauvegarde les modifications
            $this->addFlash('success', $this->translator->trans('product.flash.update_success')); // Message flash pour succès
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]); // Redirection vers les détails du produit
        }

        // Affiche le formulaire dans la vue
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    // Route pour supprimer un produit
    #[Route('/product/delete/{id}', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // Vérifie que seul un administrateur peut accéder à cette route

        // Vérifie la validité du token CSRF pour sécuriser la suppression
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product); // Supprime le produit de la base de données
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('product.flash.delete_success')); // Message flash pour succès
        } else {
            $this->addFlash('error', $this->translator->trans('product.flash.csrf_error')); // Message flash pour erreur
        }

        return $this->redirectToRoute('homepage'); // Redirection vers la page d'accueil
    }
}
