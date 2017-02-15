<?php

namespace TVguideBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

/* @author Gavin Moulton
 * Gets TV listings from ITV api and displays in a certain order using twig template
*/

class DefaultController extends Controller
{
    private $listing;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {


        for ($i=1;$i <= 100;$i++) {
            if($i % 3 === 0 && $i % 5 === 0) {
                echo 'FizzBuzz';
                echo $i;
            }  elseif($i % 5 === 0) {
                echo $i;
                echo 'Buzz';
            }  elseif($i % 3 === 0) {
                echo $i;
                echo 'Fizz';
            }
            echo '<br>';
        }


        $dictionary = array("kayak");

        $anagram = "kayak";

        $anagramSorted = sortString($anagram);


        foreach ($dictionary as $word)
        {
            $wordSorted = sortString($word);
            if ($wordSorted == $anagramSorted)
            {
                echo 'true';
            }
        }




        $url = new Client(['headers' => ['Accept' => 'application/vnd.itv.hubsvc.programme.v3+hal+json']]);

        $feed = $url->get('http://promoted.hubsvc.itv.com/promoted/itvonline/dotcom/programmes/mostpopular?broadcaster=itv&features=rtmpe,subs-ttml&thor=false');

        if($feed->getStatusCode() == '200') {

            $this->listing = json_decode($feed->getBody(), true);

            return $this->render('TVguideBundle:Default:index.html.twig', array('listing' => $this->listing));

        } else {

            return new Response('Sorry, Listings unavailable');

        }
    }
}
