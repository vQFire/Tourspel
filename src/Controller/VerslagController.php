<?php

namespace App\Controller;

use App\Entity\Etappe;
use App\Entity\Verslag;
use App\Form\VerslagType;
use App\Repository\VerslagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/verslag")
 */
class VerslagController extends AbstractController
{
    /**
     * @Route("/", name="verslag_index", methods={"GET"})
     */
    public function index(VerslagRepository $verslagRepository): Response
    {
        return $this->render('verslag/index.html.twig', [
            'verslags' => $verslagRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="verslag_new", methods={"GET","POST"}, defaults={"id": 1})
     */
    public function new(Request $request, Etappe $etappe): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $verslag = new Verslag();

        if ($etappe->getId() !== 1) {
            $verslag->setEtappe($etappe);
        }

        $form = $this->createForm(VerslagType::class, $verslag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($verslag);
            $entityManager->flush();

            return $this->redirectToRoute('etappe_index');
        }

        return $this->render('verslag/new.html.twig', [
            'verslag' => $verslag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="verslag_show", methods={"GET"})
     */
    public function show(Verslag $verslag): Response
    {
        return $this->render('verslag/show.html.twig', [
            'verslag' => $verslag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="verslag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Verslag $verslag): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(VerslagType::class, $verslag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('verslag_index');
        }

        return $this->render('verslag/edit.html.twig', [
            'verslag' => $verslag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="verslag_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Verslag $verslag): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$verslag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($verslag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('verslag_index');
    }
}
