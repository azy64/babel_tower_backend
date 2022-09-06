<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="app_student_index", methods={"GET"})
     */
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_student_new", methods={"GET", "POST"})
     */
    public function new(Request $request, StudentRepository $studentRepository): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRepository->add($student, true);

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_student_show", methods={"GET"})
     */
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_student_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRepository->add($student, true);

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_student_delete", methods={"POST"})
     */
    public function delete(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $studentRepository->remove($student, true);
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/login", name="app_student_login", methods={"POST"})
     */
     public function loginStudent(Request $request, StudentRepository $studentRep){

        $data = json_decode($request->getContent(),true);
        $result = $studentRep->findOneBy(['email'=>$data['email'],'password'=>$data['password']]);
        return $this->json($result);
     }

     /**
     * @Route("/create", name="app_student_create", methods={"POST"})
     */
    public function createStudent(Request $request, ManagerRegistry $manager, StudentRepository $studentRep){

        $data = json_decode($request->getContent(),true);
        //$result = $studentRep->findOneBy(['email'=>$data['email'],'password'=>$data['password']]);
        $student = new Student();
        $student->setNom($data['nom']);
        $student->setPrenom($data['prenom']);
        $student->setEmail($data['email']);
        $student->setPassword($data['password']);
        $ent = $manager->getManager();
        $retour = $studentRep->findOneBy(['email'=>$data['email'],'password'=>$data['password']]);
        if($retour==null){
          $ent->persist($student);
          $ent->flush();
        }
        else return $this->json(["result"=>"Operation failed: this email ".$student->getEmail()." exists already"]);
        
        return $this->json(['result'=> $student]);
     }
}
