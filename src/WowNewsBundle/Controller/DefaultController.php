<?php

namespace WowNewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Firewall\ContextListener;

use WowNewsBundle\Entity\Commentaries;
use WowNewsBundle\Form\CommentariesType;
use WowNewsBundle\Entity\Articles;
use WowNewsBundle\Entity\Image;
use WowNewsBundle\Entity\User;

class DefaultController extends Controller
{
    public function homeAction()
    {
        return $this->render('@WowNews/Default/home.html.twig');
    }

    public function accueilAction()
    {   
        $repository = $this->getDoctrine()->getRepository(articles::class);
        $articles = $repository->findAll();

        return $this->render('@WowNews/Default/accueil.html.twig', array(
            'articles' => $articles,
            'template' => 'espion',
        ));
    }

    public function accueilTemplateAction($template)
    {
        $repository = $this->getDoctrine()->getRepository(articles::class);
        $articles = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(image::class);
        $image = $repository->findAll();

        return $this->render('@WowNews/Default/accueil.html.twig', array(
            'template' => $template,
            'articles' =>  $articles,
            'image' => $image,
        ));
    }

   
    public function articleAction( $template, $id, Request $request)
    {   
    
        //SELECT Commentaries By Article
        $repository = $this->getDoctrine()->getRepository(commentaries::class);
        $commentaires = $repository->findBy(array('article' => $id));

        //SELECT Article by id
        $repository = $this->getDoctrine()->getRepository(articles::class);
        $article = $repository->findOneById($id);

        //CREATE Form Commentaries 
        $commentaries = new commentaries();
        $form = $this->createForm(CommentariesType::class, $commentaries);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaries->setArticle($article);
            $commentaries->setDatePublished( new \DateTime('now'));
            $user = $this->getUser();
            $user->getId();
            $commentaries->setUser($user);

            $commentaries = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaries);
            $entityManager->flush();

            return $this->redirectToRoute('wow_news_article', array(
                'template' => $template,
                'id' => $id,
            ));
        }

        return $this->render('@WowNews/Default/article.html.twig', array(
            'article' => $article,
            'template' => $template,
            'commentaires' => $commentaires,
            'formView' => $formView,
        ));
    }
}
