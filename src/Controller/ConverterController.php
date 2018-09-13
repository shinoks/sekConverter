<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConverterController extends AbstractController
{
    public function index(Request $request): Response
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
            'front/index.html.twig',[
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]
        );
    }
}
