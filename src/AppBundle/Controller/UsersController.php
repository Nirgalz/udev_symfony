<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class UsersController extends Controller
{


    /**
     * @Route("/users/add")
     */
    public function add(){
        $form = $this->createForm('AppBundle\Form\UserType');

        return $this->render('users/add.html.twig', [
            'form' => $form->createView()
        ]);

    }




    /**
     * @Route("/users")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $user1 = $repository->find(1);
        $user2 = $repository->findOneBy(['id' => 1]);
        $users = $repository->findAll();
        $usersDesc = $repository->findBy([], ['id' => 'desc']);

        return $this->render('users/index.html.twig', [
            "user1" => $user1,
            "user2" => $user2,
            "users" => $users,
            "usersDesc" => $usersDesc,

        ]);
    }


}