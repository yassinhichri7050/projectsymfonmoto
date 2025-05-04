<?php

namespace App\Controller;

use App\Entity\Produit; // Add this use statement for the Produit entity
use App\Form\ProduitType; // Add this import for the ProduitType form class
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface; // Add this use statement for the EntityManager
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Add this use statement for the Request
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,  // Corrected to pass $produits variable
        ]);
    }

    #[Route('/ajouter-produit', name: 'ajouter_produit')]
    public function addProduit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();

        // Create the form using the ProduitType class
        $form = $this->createForm(ProduitType::class, $produit);

        // Handle the form submission
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the new product and save it to the database
            $entityManager->persist($produit);
            $entityManager->flush();

            // Redirect to the product list page after saving the product
            return $this->redirectToRoute('app_produit');
        }

        // Render the form in the template
        return $this->render('produit/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
