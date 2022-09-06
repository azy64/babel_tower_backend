<?php

namespace App\Controller;

use App\Entity\Contenu;
use App\Entity\Lesson;
use App\Entity\Modality;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Form\LessonType;
use App\Repository\LectureRepository;
use App\Repository\LessonRepository;
use App\Repository\TeacherRepository;
use App\Repository\TypeContenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lesson")
 */
class LessonController extends AbstractController
{
    /**
     * @Route("/", name="app_lesson_index", methods={"GET"})
     */
    public function index(LessonRepository $lessonRepository): Response
    {
        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_lesson_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LessonRepository $lessonRepository): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessonRepository->add($lesson, true);

            return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_lesson_show", methods={"GET"})
     */
    public function show(Lesson $lesson): Response
    {
        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_lesson_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessonRepository->add($lesson, true);

            return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_lesson_delete", methods={"POST"})
     */
    public function delete(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $lessonRepository->remove($lesson, true);
        }

        return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/lists", name="app_lesson_lists", methods={"GET"})
     */
    public function lists(LessonRepository $lessonRepository): Response
    {
        return $this->json([
            'lessons' => $lessonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="app_lesson_create", methods={"POST"})
     */
    public function createLesson(
        Request $request , 
        TypeContenuRepository $type,
         LessonRepository $lessonRepository, 
         TeacherRepository $teacher,
         LectureRepository $lectureRepository,
         ManagerRegistry $managerRegistry
         ): Response
    {
        $data =  json_decode($request->request->get('lesson'), true);
        $userId = (int) $data['userId'];
        $manager = $managerRegistry->getManager();
        $prof = $teacher->find($userId);
        $contents = $data['contents'];
        $lesson = new Lesson();
        $lesson->setTitle($data['title'])->setConsigneOne($data['consigneOne']);
        $lesson->setConsigneTwo($data['consigneTwo'])->setTeacher($prof);
        $manager->persist($lesson);
        $manager->flush();
        foreach($contents as $content){
            $contenu = new Contenu();
            $contenu->setLibelle($content['libelle']);
            $lecture_content = $content['lecture'];
            $lecture = $lectureRepository->findOneBy(['libelle'=>$lecture_content]);
            $tt = $content['typeContenu'];
            $typeContenu = $type->findOneBy(['libelle'=> $tt]);
            $contenu->setTypeContenu($typeContenu);
            $id = $content['id'];
            $name = $this->uploadFileTunaweza($request->files->get("fichier_$id"));
            $contenu->setFileName($name);
            $manager->persist($contenu);
            $manager->flush();
            $contenu->addLesson($lesson);
            $modality = new Modality();
            
            $modality->setContenu($contenu)->setLecture($lecture)->setLesson($lesson);
            $manager->persist($modality);
            $manager->flush();
            $this->saveQuestions(
                ['manager'=>$manager, 
                'lesson'=>$lesson,
                'contenu'=>$contenu,
                'questions'=>$content['questions']]
            );
            
        }
        return $this->json([
            'lesson' => $lesson,
            'contenus' => $contents,//->files->get("fichier")->getClientOriginalName(),
            'lessons' => $lessonRepository->findBy(['teacher'=>$prof])??[],
            'message' => 'here is data'
        ], 200, ['groups'=>'tunaweza']);
    }

    public function uploadFileTunaweza($fichier){
        $originalFilename = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = time().'-'.uniqid().'.'.$fichier->guessExtension();
        try {
            $fichier->move(
                $this->getParameter('contenus_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            $e->getMessage();
        }
        return $newFilename;

    }
    public function saveQuestions($donnees =[]){
        $manager = $donnees['manager'];
        $lesson = $donnees['lesson'];
        $contenu = $donnees['contenu'];
        $questions = $donnees['questions'];
        foreach($questions as $question){
            $quest = new Question();
            $quest->setLibelle($question['question'])
             ->setReponse($question['reponse'])
             ->setAssertion1($question['assertion1'])
             ->setAssertion2($question['assertion2'])
             ->setAssertion3($question['assertion3']);
            $manager->persist($quest);
            $manager->flush();
            $questionnaire = new Questionnaire();
            $questionnaire->setQuestion($quest)
             ->setLesson($lesson)
             ->setContenu($contenu)
             ->setTitre($lesson->getTitle());
            $manager->persist($questionnaire);
            $manager->flush();
        }
    }
}
