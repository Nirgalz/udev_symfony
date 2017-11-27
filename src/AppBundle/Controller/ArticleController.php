<?php
/**
 * Created by PhpStorm.
 * User: IPI
 * Date: 21/11/2017
 * Time: 16:19
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;


class ArticleController extends Controller
{

    /**
     * @Route("/articles/", name="articles")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');

        $articles = $repository->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);

    }



    /**
     * @Route("/articles/add", name="articles_add")
     */
    public function add(Request $request){

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('articles');
        }



        return $this->render('articles/add.html.twig', [
            'article' =>$article,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/article/view/{id}", name="article_view")
     */

    public function view(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');

        $article = $repository->findOneById($id);

        if (is_null($article)){
            throw $this->createNotFoundException('No user found');
        }

        return $this->render('articles/view.html.twig', [
            "article" => $article,

        ]);

    }


    /**
     * @Route("/article/edit/{id}", name="article_edit")
     */

    public function edit(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');

        $article = $repository->findOneById($id);

        if (is_null($article)){
            throw $this->createNotFoundException('No user found');
        }

        return $this->render('articles/edit.html.twig', [
            "article" => $article,

        ]);

    }


    /**
     * @Route("/articles/delete/{id}", name="article_delete")
     */
    public function delete(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');

        $article = $repository->findOneById($id);

        if (is_null($article)){
            throw $this->createNotFoundException('No user found');
        }

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('articles');

    }



}

