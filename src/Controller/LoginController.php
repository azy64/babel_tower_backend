<?php

namespace App\Controller;

use App\Entity\Resolution;
use App\Entity\Student;
use App\Repository\MembershipRepository;
use App\Repository\ModalityRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\ResolutionRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class LoginController extends AbstractController
{
   /**
     * @Route("/", name="app_login_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
/**
* @Route("/dash/{id}", name="app_dash", methods={"GET"})
*/
public function dash(Student $student,
        MembershipRepository $m,
        ModalityRepository $mode,
        QuestionnaireRepository $qr
        ){

    $members = $m->findBy(['student'=>$student]);
            return $this->render("student/dashboard.html.twig",
            ["student"=>$student,"members"=>$members, "modal"=>$mode,'qr'=>$qr]);
}


/**
* @Route("/check", name="app_login_check", methods={"POST"})
*/
    public function verifier(
        Request $request, 
        StudentRepository $studentRepository, 
        ){
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $student = $studentRepository->findOneBy(["email"=>$email, "password"=>$password]);
        if($student!==null){
            return $this->redirectToRoute("app_dash",['id'=>$student->getId()]);
        }
        return $this->redirectToRoute("app_login_index",['error'=>'Identifiant et mot de passe incorrectent']);
    }
/**
*@Route("/logout", name="app_logout", methods={"GET"})
*/
public function logout(){
    return $this->redirectToRoute("app_login_index");

 }

 /**
*@Route("/correction/{id}", name="app_correction", methods={"GET"})
*/
public function correction(Student $student, ResolutionRepository $resolutionRepository){

    $resolutions= $resolutionRepository->findBy(['student'=>$student]);
    if($resolutions!==null){
        $question = $resolutions[0]->getQuestion() ;
        $reponse = strpos($question->getReponse(), $resolutions[0]->getLibelleResponse());
        return $this->render("student/correction.html.twig",
        ['student'=>$student,
        'resolutions'=>$resolutions,
        'response'=>$reponse
        ]);
    }
    return $this->render("student/correction.html.twig",
        ['student'=>$student,
        'resolutions'=>[],
        'response'=>''
        ]);
    
}
}
