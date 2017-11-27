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
    public function createArticle(){
        $article = new Article();
        $article->setContent("blalsdofkspoeslejfseijf");
        $article->setDateWritten(new \DateTime());
        $article->setTitle('un article');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');

        $user = $repository->findOneBy(['id' => 1]);

        $article->setUser($user);

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->render('add.html.twig', [
            'message' => 'sauvegardé ?',
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

