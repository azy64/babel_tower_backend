<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Entity\Resolution;
use App\Form\QuestionnaireType;
use App\Repository\ContenuRepository;
use App\Repository\LessonRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResolutionRepository;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
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

     /**
     * @Route("/answer", name="app_questionnaire_answer", methods={"POST"})
     */
    public function answerToQustion(Request $request,
     LessonRepository $lessonRepository,
     ContenuRepository $contenuRepository,
     QuestionRepository $questionRepository,
     StudentRepository $studentRepository,
     ManagerRegistry $register,
     ResolutionRepository $resolutionRepository): Response
    {
        $manager = $register->getManager();
        $question_id = $request->request->get('idQuestion');
        $contenu_id = $request->request->get('idContenu');
        $student_id = $request->request->get('idStudent');
        $lesson_id = $request->request->get('idLesson');
        $answer = $request->request->get('reponse');
        $lesson = $lessonRepository->find($lesson_id);
        $contenu = $contenuRepository->find($contenu_id);
        $question = $questionRepository->find($question_id);
        $student = $studentRepository->find($student_id);
        $resolutionFind= $resolutionRepository->findBy(['question'=>$question]);
        if($resolutionFind===null){
            $resolution = new Resolution();
            $resolution->setLesson($lesson)->setLibelleResponse($answer)
            ->setQuestion($question)->setStudent($student);
            $manager->persist($resolution);
            $manager->flush();
        }
        return $this->redirectToRoute('app_correction',['id'=> $student->getId()]);
        //return $this->render("student/thanks.html.twig");
    }
}
