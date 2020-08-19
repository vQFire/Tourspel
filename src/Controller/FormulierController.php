<?php

namespace App\Controller;

use App\Entity\Formulier;
use App\Form\FormulierType;
use App\Repository\FormulierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormulierController extends AbstractController
{
    /**
     * @Route("/regels", name="regel_page")
     */
    public function regels (FormulierRepository $formulierRepository)
    {
        $year = date('Y');

        $formulier = $formulierRepository->findOneBy(['Year' => $year, 'Type' => 'Regels']);

        if ($formulier === null) {
            $formulier = $formulierRepository->findOneBy(['Year' => $year - 1, 'Type' => 'Regels']);
        }

        return $this->render('formulier/index.html.twig', [
            'formulier' => $formulier
        ]);
    }

    /**
     * @Route("/regels/edit/{id}", name="regel_edit")
     */
    public function regelsEdit(Request $request, Formulier $formulier)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(FormulierType::class, $formulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->redirectToRoute('regel_page');
        }

        return $this->render('formulier/edit.html.twig', [
            'formulier' => $formulier,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formulier", name="formulier_page")
     */
    public function formulier (FormulierRepository $formulierRepository)
    {
        return $this->render('formulier/index.html.twig', [
            'formulier' => $formulierRepository->findOneBy(['Type' => 'Formulier']),
        ]);
    }

    /**
     * @Route("/formulier/edit/{id}", name="formulier_edit")
     */
    public function formulierEdit (Request $request, Formulier $formulier)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(FormulierType::class, $formulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->redirectToRoute('formulier_page');
        }

        return $this->render('formulier/edit.html.twig', [
            'formulier' => $formulier,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formulier/new", name="formulier_new")
     * @Route("/regels/new", name="regel_new")
     */
    public function newForm (Request $request)
    {
        $formulier = new Formulier();
        $form = $this->createForm(FormulierType::class, $formulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formulier);
            $entityManager->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render('formulier/edit.html.twig', [
            'etappe' => $formulier,
            'form' => $form->createView(),
        ]);
    }
}
