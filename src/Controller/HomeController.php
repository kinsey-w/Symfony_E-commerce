<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur de la page d'accueil
class HomeController extends AbstractController
{
    // Affiche la page d'accueil avec les produits et les catégories
    #[Route('/', name: 'homepage')]
    public function index(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        // Récupérer toutes les catégories
        $categories = $categoryRepository->findAll();

        // Obtenir les paramètres de requête
        $categoryId = $request->query->get('category');
        $sortOption = $request->query->get('sort');

        // Définir les critères de tri
        $sortCriteria = [];
        switch ($sortOption) {
            case 'price_asc':
                $sortCriteria = ['prix' => 'ASC']; // Trier par prix croissant
                break;
            case 'price_desc':
                $sortCriteria = ['prix' => 'DESC']; // Trier par prix décroissant
                break;
            case 'name_asc':
                $sortCriteria = ['nom' => 'ASC']; // Trier par nom (A à Z)
                break;
            case 'name_desc':
                $sortCriteria = ['nom' => 'DESC']; // Trier par nom (Z à A)
                break;
        }

        // Récupérer les produits en fonction de la catégorie et du tri
        $products = $categoryId
            ? $productRepository->findBy(['category' => $categoryId], $sortCriteria)
            : $productRepository->findBy([], $sortCriteria);

        return $this->render('home/index.html.twig', [
            'categories' => $categories, // Passer les catégories au template
            'products' => $products,    // Passer les produits au template
            'selectedCategory' => $categoryId, // Passer la catégorie sélectionnée (pour la pré-sélection du menu déroulant)
            'selectedSort' => $sortOption,     // Passer l'option de tri sélectionnée
        ]);
    }
}
