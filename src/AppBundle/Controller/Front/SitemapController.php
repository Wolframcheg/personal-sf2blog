<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Thepixeldeveloper\Sitemap\Output;
use Thepixeldeveloper\Sitemap\Sitemap;
use Thepixeldeveloper\Sitemap\SitemapIndex;
use Thepixeldeveloper\Sitemap\Url;

class SitemapController extends Controller
{
    /**
     * @Route("/sitemap.xml", name="sitemap")
     */
    public function indexAction(Request $request)
    {
        $sitemapIndex = new SitemapIndex();

        $url = (new Url($this->generateUrl('homepage')))
            ->setLastMod(date('c',time()))
            ->setPriority(1)
            ;
        $sitemapIndex->addSitemap($url);

        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->forSitemap();

        /**
         * @var Post $post
         */
        foreach ($posts as $post){
            $url = (new Url($this->generateUrl('post_view', ['slug' => $post->getSlug()])))
                ->setLastMod($post->getUpdatedAt()->format('c'))
                ->setPriority('0.75')
            ;
            $sitemapIndex->addSitemap($url);
        }

        $raw = (new Output())->getOutput($sitemapIndex);

        $response =  new Response($raw);
        $response->headers->set('Content-Type', 'xml');

        return $response;
    }


}
