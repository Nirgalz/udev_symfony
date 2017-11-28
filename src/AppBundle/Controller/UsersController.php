<?php


namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class UsersController extends Controller
{


    /**
     * @Route("/users/add", name="user_add")
     */
    public function add(Request $request){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();


             $em = $this->getDoctrine()->getManager();
             $em->persist($user);
             $em->flush();

            return $this->redirectToRoute('users');
        }



        return $this->render('users/add.html.twig', [
            'user' =>$user,
            'form' => $form->createView()
        ]);

    }




    /**
     * @Route("/users", name="users")
     */
    public function indexAction(Request $request)
    {

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT u FROM AppBundle:User u";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/

        );

        // parameters to template
        return $this->render('users/index.html.twig', array('pagination' => $pagination));


    }

    /**
     * @Route("/users/view/{id}", name="user_view")
     */

    public function view(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);
        $articles = $user->getArticles();

        if (is_null($user)){
            throw $this->createNotFoundException('No user found');
        }

        return $this->render('users/view.html.twig', [
            "user" => $user,
            'articles' => $articles

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


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users');
        }



        return $this->render('users/edit.html.twig', [
            'user' =>$user,
            'form' => $form->createView()
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


    //returns a list of users
    public function otherUserWidgetAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');
        $queryBuilder = $repository->createQueryBuilder('u')
            ->where ("u.id!= :id")
            ->setParameters(['id'=>$request->get('id')])
            ->setMaxResults(10);
        $query = $queryBuilder->getQuery();
        $users = $query->getResult();
        //return, on donne a la vue correspondante les variable twig
        return $this->render('users/others.html.twig',[
            'users'=>$users
        ]);
    }

}