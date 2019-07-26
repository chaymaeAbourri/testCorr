<?php


namespace App\utils;


use App\Entity\Contact;
use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormRendererEngineInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class ContactServices
{

    private  $twig;
    public function __construct(EntityManagerInterface $em,Environment $twig)
    {
        $this->em = $em;
        $this->twig = $twig;
    }
    public function getAndHandleData(Request $request, \Swift_Mailer $mailer, Contact $contact,Form $form) {

        //entregistrer contact dans la db
        $em = $this->em;
        $form->handleRequest($request);
        $sended = false;
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            // Envoyer email
            $message = (new \Swift_Message('Nouveau demande de contact'))
                ->setFrom($contact->getMail())
                ->setTo($contact->getDepartement()->getResponsable()->getEmail())
                ->setBody($this->twig->render('contact/contact.html.twig', array('contact' => $contact), 'text/html'));
            if (!$mailer->send($message, $failures)) {
                $sended = false;
            } else {
                $sended = true;
            }
        }
        return $sended;
    }

}