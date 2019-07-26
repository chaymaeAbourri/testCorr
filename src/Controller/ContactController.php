<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Departement;
use App\utils\ContactServices;
use App\utils\ContactType;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer, ContactServices $contactServices)
    {
        //creation de form
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->add("save", SubmitType::class, ['label' => 'Envoyer']);

        $sended = $contactServices->getAndHandleData($request,$mailer,$contact,$form);

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'sended' => $sended,
        ]);
    }

}
