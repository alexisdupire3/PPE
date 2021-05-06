<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Form\LitType;
use App\Repository\LitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lit")
 */
class LitController extends AbstractController
{
    /**
     * @Route("/", name="lit_index", methods={"GET"})
     */
    public function index(LitRepository $litRepository): Response
    {
        return $this->render('lit/index.html.twig', [
            'lits' => $litRepository->findAll(),'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="lit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lit = new Lit();
        $form = $this->createForm(LitType::class, $lit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lit);
            $entityManager->flush();

            return $this->redirectToRoute('lit_index');
        }

        return $this->render('lit/new.html.twig', [
            'lit' => $lit,
            'form' => $form->createView(),'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}", name="lit_show", methods={"GET"})
     */
    public function show(Lit $lit): Response
    {
        return $this->render('lit/show.html.twig', [
            'lit' => $lit,'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lit $lit): Response
    {
        $form = $this->createForm(LitType::class, $lit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lit_index');
        }

        return $this->render('lit/edit.html.twig', [
            'lit' => $lit,
            'form' => $form->createView(),'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}", name="lit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lit $lit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lit_index');
    }
}
