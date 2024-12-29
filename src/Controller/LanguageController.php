<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    #[Route('/language/{_locale}', name: 'switch_language')]
    public function switchLanguage(string $_locale, Request $request): RedirectResponse
    {
        // Set the user's selected locale in the session
        $request->getSession()->set('_locale', $_locale);

        // Redirect back to the previous page or homepage
        $referer = $request->headers->get('referer', $this->generateUrl('homepage'));
        return $this->redirect($referer);
    }
}
