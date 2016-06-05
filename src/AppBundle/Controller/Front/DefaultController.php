<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findBy([],['publishedAt' => 'DESC']);

        return [
            'posts' => $posts
        ];
    }

    /**
     * @Route("/tag/{tag}", name="tags")
     * @Template("AppBundle:Front/Default:index.html.twig")
     */
    public function searchByTagAcrion(Request $request, $tag)
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findByTag($tag);

        return [
            'posts' => $posts,
            'pagetitle' => "Поиск по тегу \"{$tag}\""
        ];
    }

    /**
     * @Route("/search", name="search")
     * @Template("AppBundle:Front/Default:index.html.twig")
     */
    public function searchAction(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findByWord($request->get('q'));

        return [
            'posts' => $posts,
            'pagetitle' => "Поиск по слову \"{$request->get('q')}\""
        ];
    }

    /**
     * @Route("/{slug}", name="post_view")
     * @ParamConverter("post", class="AppBundle:Post", options={"slug" = "slug"})
     * @Template()
     */
    public function postViewAction(Request $request, Post $post)
    {

        return [
            'post' => $post,
        ];
    }

}
