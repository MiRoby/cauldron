<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; ///Potzrebne
use Symfony\Component\Routing\Annotation\Route; //Potzrebne do wyznaczania tras


class QuestionController extends AbstractController
{
    #[Route('/', name: 'Homepage')]
    public function homepage()
    {
            return new Response('Test test');
    }   

    #[Route('/questions/{slug} ', name:'')]
    public function show($slug)
    {
        return new Response(sprintf('test schow "%s"!', $slug));
    }
}