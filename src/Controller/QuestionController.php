<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; ///Potzrebne
use Symfony\Component\Routing\Annotation\Route; //Potzrebne do wyznaczania tras
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;
use App\Service\MarkdownHelper;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Sentry\State\HubInterface;

class QuestionController extends AbstractController
{
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }
    
    #[Route('/', name: 'homepage')]
    public function homepage(Environment $twigEnvironment)
    {
        $html = $twigEnvironment->render('/question/question.html.twig');
        return new Response($html);   
        //return $this->render('/question/question.html.twig');
    }   

    #[Route('/questions/{slug} ', name:'app_question_show')]
    public function show($slug, MarkdownHelper $markdownHelper, bool $isDebug, HubInterface $sentryHub)
    {
        $questionText = 'I\'ve been turned into a cat, any *thoughts* on how to turn back? While I\'m **adorable**, I don\'t really care for cat food.'; // **formatowanie
        
        //$parsedQuestionText = $cache->get('markdown_'.md5($questionText), function() use ($questionText, $markdownParser){
       //     return $markdownParser->transformMarkdown($questionText);
        //}); // cache w pamięci podręcznej
       // $parsedQuestionText = $markdownParser->transformMarkdown($questionText); //transformuje '**' buduje znaczniki HTML
        dump($sentryHub->getClient());

        if ($this->isDebug){
                $this->logger->info('We are in debug mode!'); #Jestem w trybie debugowania!;
        }

        //throw new \Exception('bad stuff happened!');
      
        //dump($isDebug);   
        //dump($this->getParameter('cache_adapter'));
        
        
        $answers = ['Make sure your cat is sitting `purrrfectly` still ?',
                    'text nl2',
                    'text nr3'];

        $parsedQuestionText = $markdownHelper->parse($questionText);

        return $this->render('/question/show.html.twig',[
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'questionText' => $parsedQuestionText,
            'answers' => $answers
            
        ]);

        
    }

    #[Route('/page', name:'app_autorpage')]
    public function author(){
        return $this->render('/page/autor.html.twig');
    }

    #[Route('/nowy/{name}', name:'nazwa_produktu')]
    public function name_product($name)
    {
        return new Response(sprintf('Produkt nazwa: %s.' , $name));
    }
    
    #[Route('/test2', name:'test2')] 
    public function test2 ( Request $request): Response
    {
        $greet='';
        if ($name = $request->query->get('dupa')) // pobierz dane z url do zmiennej dupa https://127.0.0.1:8000/test2?dupa=test
        {
            $greet = sprintf('Proszę tak do mnie nie mówić: %s!!!!!!!!!!!', htmlspecialchars($name));
        }else{
            $greet = sprintf('Jakiś text plus slug: %s!', htmlspecialchars($name));
        }
        return new Response($greet);
    }
    
    #[Route('/test', name: 'test')]
    public function test()
    {
        return new Response(<<<EOF
        <html>
            <body>
                <h2>Cześć jesem Robert</h2>
            </body>
        </html>        

        EOF);
    }
}