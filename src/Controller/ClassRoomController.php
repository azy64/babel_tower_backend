<?php

namespace App\Controller;

use App\Entity\ClassRoom;
use App\Entity\Teacher;
use App\Form\ClassRoomType;
use App\Repository\ClassRoomRepository;
use App\Repository\LessonRepository;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classroom")
 */
class ClassRoomController extends AbstractController
{
    /**
     * @Route("/", name="app_class_room_index", methods={"GET"})
     */
    public function index(ClassRoomRepository $classRoomRepository): Response
    {
        return $this->render('class_room/index.html.twig', [
            'class_rooms' => $classRoomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_class_room_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ClassRoomRepository $classRoomRepository): Response
    {
        $classRoom = new ClassRoom();
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classRoomRepository->add($classRoom, true);

            return $this->redirectToRoute('app_class_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('class_room/new.html.twig', [
            'class_room' => $classRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_class_room_show", methods={"GET"})
     */
    public function show(ClassRoom $classRoom): Response
    {
        return $this->render('class_room/show.html.twig', [
            'class_room' => $classRoom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_class_room_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ClassRoom $classRoom, ClassRoomRepository $classRoomRepository): Response
    {
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classRoomRepository->add($classRoom, true);

            return $this->redirectToRoute('app_class_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('class_room/edit.html.twig', [
            'class_room' => $classRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_class_room_delete", methods={"POST"})
     */
    public function delete(Request $request, ClassRoom $classRoom, ClassRoomRepository $classRoomRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classRoom->getId(), $request->request->get('_token'))) {
            $classRoomRepository->remove($classRoom, true);
        }

        return $this->redirectToRoute('app_class_room_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/lists", name="app_class_room_lists", methods={"GET"})
     */
    public function lists(ClassRoomRepository $classRoomRepository): Response
    {
        return $this->json(['class_rooms' => $classRoomRepository->findAll()]);
    }
    /**
     * @Route("/create", name="app_class_room_create", methods={"POST"})
     */

    public function createClassRoom (
        Request $request, 
        ManagerRegistry $managerRegistry, 
        TeacherRepository $teacherRep,
        LessonRepository $lessonRep,
        ClassRoomRepository $classRoomRep
        ){
        $data =  json_decode($request->request->get('classroom'), true);
        $manager = $managerRegistry->getManager();
        $teacher = $teacherRep->findOneBy(['id'=> $data['userId']]);
        $lessons = $data['lessons'];
        $classRoom = new ClassRoom();
        $classRoom->setNom(($data['nom']))->setTeacher($teacher);
        foreach($lessons as $lesson){
            $element = $lessonRep->find($lesson['id']);
            $classRoom->addLesson($element);
        }
        $manager->persist(($classRoom));
        $manager->flush();
        return $this->json([
            "lessons"=> $lessonRep->findBy(["teacher"=>$teacher]),
            "classrooms" => $classRoomRep->findBy(['teacher'=>$teacher]),
            'message' => 'here is data'
        ], 200,[], ['groups'=>'tunaweza']);

    }
     /**
     * @Route("/all", name="app_class_room_all", methods={"POST"})
     */

    public function getClassRooms (
        Request $request, 
        TeacherRepository $teacherRep,
        ClassRoomRepository $classRoomRep
        ){
        $id = (int) $request->request->get('userId');
        $teacher = $teacherRep->find($id);
        $classRooms = $classRoomRep->findBy(['teacher'=> $teacher]);

        return $this->json([
            "classrooms" => $classRooms,
            'message' => 'here is data'
        ], 200,[], ['groups'=>'tunaweza']);

    }
}
