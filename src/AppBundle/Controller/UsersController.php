<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



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
     * @Route("/users", name="users")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $users = $repository->findAll();
        $usersDesc = $repository->findBy([], ['id' => 'desc']);

        return $this->render('users/index.html.twig', [
            "usersDesc" => $usersDesc,
            "users" => $users,

        ]);
    }

    /**
     * @Route("/users/view/{id}", name="user_view")
     */

    public function view(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);

        if (is_null($user)){
            throw $this->createNotFoundException('No user found');
        }

        return $this->render('users/view.html.twig', [
            "user" => $user,

        ]);

    }


    /**
     * @Route("/users/edit/{id}", name="user_edit")
     */

    public function edit(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);

        if (is_null($user)){
            throw $this->createNotFoundException('No user found');
        }

        return $this->render('users/edit.html.twig', [
            "user" => $user,

        ]);

    }


    /**
     * @Route("/users/delete/{id}", name="user_delete")
     */
    public function delete(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);
        if (is_null($user)){
            throw $this->createNotFoundException('No user found');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('users');

    }

}