<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use App\Repository\QuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/questionnaire")
 */
class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/", name="app_questionnaire_index", methods={"GET"})
     */
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->render('questionnaire/index.html.twig', [
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_questionnaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, QuestionnaireRepository $questionnaireRepository): Response
    {
        $questionnaire = new Questionnaire();
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaireRepository->add($questionnaire, true);

            return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/new.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_questionnaire_show", methods={"GET"})
     */
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('questionnaire/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_questionnaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository): Response
    {
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaireRepository->add($questionnaire, true);

            return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/edit.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_questionnaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionnaire->getId(), $request->request->get('_token'))) {
            $questionnaireRepository->remove($questionnaire, true);
        }

        return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
    }
     /**
     * @Route("/lists", name="app_questionnaire_lists", methods={"GET"})
     */
    public function lists(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->json([
            'questionnaires' => $questionnaireRepository->findAll()
        ]);
    }
}
