<?php

namespace App\Controller;

use App\Entity\TypeContenu;
use App\Form\TypeContenuType;
use App\Repository\TypeContenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/contenu")
 */
class TypeContenuController extends AbstractController
{
    /**
     * @Route("/", name="app_type_contenu_index", methods={"GET"})
     */
    public function index(TypeContenuRepository $typeContenuRepository): Response
    {
        return $this->render('type_contenu/index.html.twig', [
            'type_contenus' => $typeContenuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_contenu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeContenuRepository $typeContenuRepository): Response
    {
        $typeContenu = new TypeContenu();
        $form = $this->createForm(TypeContenuType::class, $typeContenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeContenuRepository->add($typeContenu, true);

            return $this->redirectToRoute('app_type_contenu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_contenu/new.html.twig', [
            'type_contenu' => $typeContenu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_type_contenu_show", methods={"GET"})
     */
    public function show(TypeContenu $typeContenu): Response
    {
        return $this->render('type_contenu/show.html.twig', [
            'type_contenu' => $typeContenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_contenu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeContenu $typeContenu, TypeContenuRepository $typeContenuRepository): Response
    {
        $form = $this->createForm(TypeContenuType::class, $typeContenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeContenuRepository->add($typeContenu, true);

            return $this->redirectToRoute('app_type_contenu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_contenu/edit.html.twig', [
            'type_contenu' => $typeContenu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_type_contenu_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeContenu $typeContenu, TypeContenuRepository $typeContenuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeContenu->getId(), $request->request->get('_token'))) {
            $typeContenuRepository->remove($typeContenu, true);
        }

        return $this->redirectToRoute('app_type_contenu_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/lists", name="app_type_contenu_lists", methods={"GET"})
     */
    public function lists(TypeContenuRepository $typeContenuRepository): Response
    {
        return $this->json(['type_contenus' => $typeContenuRepository->findAll()]);
    }
}
