<?php

namespace App\Controller;

use App\Entity\Etappe;
use App\Form\EtappeType;
use App\Repository\EtappeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etappe")
 */
class EtappeController extends AbstractController
{
    /**
     * @Route("/", name="etappe_index", methods={"GET"})
     */
    public function index(EtappeRepository $etappeRepository, Request $request): Response
    {
        $type = $request->query->get("type");

        if ($year = $request->query->get('year')) {
            if ($year === "all") {
                $etappes = $etappeRepository->findAll();
            } elseif ($year > date("Y")) {
                $this->addFlash('danger', 'Sorry, de site kan niet in de toekomst kijken');
            } else {
                $etappes = $etappeRepository->findByYear($year);
            }
        } else {
            $etappes = $etappeRepository->findByYear(date("Y"));
        }

        $filteredEtappes = [];

        if ($type !== null && $type !== "Alles") {
            $notTypes = ["Voorspelling Eindklassement", "Eindstand Tourspel", "Analyse / punten per categorie"];

            foreach ($etappes as $etappe) {
                if ($type === "Etappes" && !in_array($etappe->getType(), $notTypes)) {
                    array_push($filteredEtappes, $etappe);
                } elseif ($type === "Eindklassementen" && in_array($etappe->getType(), $notTypes)) {
                    array_push($filteredEtappes, $etappe);
                }
            }

            $etappes = $filteredEtappes;
        }

        return $this->render('etappe/index.html.twig', [
            'etappes' => $etappes,
            'years' => $etappeRepository->getYears(),
            'vars' => [
                $year, $type
            ]
        ]);
    }

    /**
     * @Route("/new", name="etappe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $etappe = new Etappe();
        $form = $this->createForm(EtappeType::class, $etappe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etappe);
            $entityManager->flush();

            return $this->redirectToRoute('etappe_index');
        }

        return $this->render('etappe/new.html.twig', [
            'etappe' => $etappe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etappe_show", methods={"GET"})
     */
    public function show(Etappe $etappe): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('etappe/show.html.twig', [
            'etappe' => $etappe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etappe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etappe $etappe): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(EtappeType::class, $etappe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etappe_index');
        }

        return $this->render('etappe/edit.html.twig', [
            'etappe' => $etappe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etappe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etappe $etappe): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$etappe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etappe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etappe_index');
    }
}
