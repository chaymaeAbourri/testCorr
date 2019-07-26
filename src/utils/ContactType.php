<?php


namespace App\utils;


use App\Entity\Contact;
use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->em;
        $departs = $em->getRepository(Departement::class)->findAll();
        $builder
            ->add("nom", TextType::class)
            ->add("prenom", TextType::class)
            ->add("mail", EmailType::class )
            ->add("message", TextareaType::class)
            ->add("departement", ChoiceType::class ,[
                'choices'  => $departs,
                'choice_label' => function(Departement $departement) {
                    return $departement->getNom();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}