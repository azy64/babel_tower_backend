<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="app_teacher_index", methods={"GET"})
     */
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_teacher_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TeacherRepository $teacherRepository): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->add($teacher, true);

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_teacher_show", methods={"GET"})
     */
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_teacher_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->add($teacher, true);

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_teacher_delete", methods={"POST"})
     */
    public function delete(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $teacherRepository->remove($teacher, true);
        }

        return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
     /**
     * @Route("/login-teacher", name="app_teacher_login", methods={"POST"})
     */

    public function loginTeacher(Request $request, TeacherRepository $teachRep){
        $data = json_decode($request->getContent(),true);
        $result = $teachRep->findOneBy(['email'=>$data['email'],'password'=>$data['password']]);
        return $this->json($result);
     }

     /**
     * @Route("/create", name="app_teacher_create", methods={"POST"})
     */
    public function createTeacher(Request $request, ManagerRegistry $manager, TeacherRepository $teacherRep){

        $data = json_decode($request->getContent(),true);
        $teacher = new Teacher();
        $teacher->setNom($data['nom']);
        $teacher->setPrenom($data['prenom']);
        $teacher->setEmail($data['email']);
        $teacher->setPassword($data['password']);
        $teacher->setLangue($data['langue']);
        $ent = $manager->getManager();
        $retour = $teacherRep->findOneBy(['email'=>$data['email'],'password'=>$data['password']]);
        if($retour==null){
            $ent->persist($teacher);
            $ent->flush();
        }
        else return $this->json(["result"=>"Operation failed: this email:".$teacher->getEmail()." exists already"]);
        return $this->json(['result'=>$teacher]);
     }
}
