<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $news=$this->container->get('blog.api.test')->APIRequest('GET','https://newsapi.org/v2/everything?domains=wsj.com&apiKey=3f01a6b1bf744c15817c84f60c20322c',false);
//        print_r($news['articles']);
        return $this->render('@Blog/Default/index.html.twig', ["newses"=>$news]);
    }
}
