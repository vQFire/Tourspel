<?php

namespace App\Controller;

use App\Entity\Formulier;
use App\Form\FormulierType;
use App\Repository\FormulierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formulier")
 */
class FormulierController extends AbstractController
{
    /**
     * @Route("/", name="formulier_page")
     */
    public function index (FormulierRepository $formulierRepository)
    {
        $year = date('Y');

        $formulier = $formulierRepository->findOneBy(['Year' => $year]);

        if ($formulier === null) {
            $formulier = $formulierRepository->findOneBy(['Year' => $year - 1]);
        }

        return $this->render('formulier/index.html.twig', [
            'formulier' => $formulier
        ]);
    }

    /**
     * @Route("/edit/{id}", name="formulier_edit")
     */
    public function edit(Request $request, Formulier $formulier)
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
}
