<?php

namespace App\Controller;

use App\Repository\MembershipRepository;
use App\Repository\ModalityRepository;
use App\Repository\QuestionnaireRepository;
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
* @Route("/check", name="app_login_check", methods={"POST"})
*/
    public function verifier(
        Request $request, 
        StudentRepository $studentRepository, 
        MembershipRepository $m,
        ModalityRepository $mode,
        QuestionnaireRepository $qr){
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $student = $studentRepository->findOneBy(["email"=>$email, "password"=>$password]);
        if($student!==null){
            $members = $m->findBy(['student'=>$student]);
            return $this->render("student/dashboard.html.twig",
            ["student"=>$student,"members"=>$members, "modal"=>$mode,'qr'=>$qr]);
        }
        return $this->redirectToRoute("app_login_index",['error'=>'Identifiant et mot de passe incorrectent']);
    }
/**
*@Route("/logout", name="app_logout", methods={"GET"})
*/
public function logout(){
    return $this->redirectToRoute("app_login_index");

 }
}
