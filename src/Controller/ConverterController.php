<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use GuzzleHttp\Exception\ClientException;

class ConverterController extends AbstractController
{
    public function ajax(Request $request): Response
    {
        $form = $this->createFormBuilder(null)
            ->add('sekValue', MoneyType::class,[
                'currency' => 'SEK',
                'constraints'=> [
                    new NotBlank(),
                    new GreaterThan(['value' => 0])
                ],
                'label' => 'Amount to convert:'
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'convert'
            ])
            ->getForm();

        return $this->render(
            'front/ajax.html.twig',[
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]
        );
    }

    public function getCurrentRates(int $amount,string $currency = 'sek'): Response
    {
        $client = new \GuzzleHttp\Client();
        try{
            $req = $client->request('GET','api.nbp.pl/api/exchangerates/rates/a/'. $currency .'/',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'json'
                ]
            ]);
            $json = json_decode($req->getBody());
        } catch (ClientException $e) {

            return new Response('error');
        }
        $plnValue =  round($json->rates[0]->mid * $amount,2);

        return new Response($plnValue);
    }
}
