<?php

// src/Controller/PanierController.php
namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository; // Add this import for the repository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    // Injecting the ProduitRepository
    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    #[Route('/ajouter-panier/{id}', name: 'ajouter_panier')]
    public function ajouterPanier($id, Request $request): Response
    {
        // Find the product by ID using the injected repository
        $produit = $this->produitRepository->find($id);

        if (!$produit) {
            // If the product doesn't exist, throw an error
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        // Get the cart from the session
        $panier = $request->getSession()->get('panier', []);

        // Add the product to the cart (by its ID)
        $panier[$id] = [
            'id' => $produit->getId(),
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'quantite' => isset($panier[$id]) ? $panier[$id]['quantite'] + 1 : 1, // Increment the quantity
        ];

        // Save the cart back to the session
        $request->getSession()->set('panier', $panier);

        return $this->redirectToRoute('afficher_panier');
    }

    #[Route('/panier', name: 'afficher_panier')]
    public function afficherPanier(Request $request): Response
    {
        // Get the cart from the session
        $panier = $request->getSession()->get('panier', []);

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
        ]);
    }
    #[Route('/supprimer-panier/{id}', name: 'supprimer_panier')]
    public function supprimerPanier($id, Request $request): Response
    {
        // Récupérer le panier de la session
        $panier = $request->getSession()->get('panier', []);

        // Si le produit existe dans le panier, on le supprime
        if (isset($panier[$id])) {
            unset($panier[$id]);
            $request->getSession()->set('panier', $panier);
        }

        return $this->redirectToRoute('afficher_panier');
    }
}
