<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromEmail', EmailType::class, [
                'label' => 'Email : ',
                'constraints' => [
                    new Email(['message' => 'Ce n\'est pas un email valide']),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Votre email est trop long',
                        'min' => 6,
                        'minMessage' => 'Votre email est trop court'
                    ])
                ]
            ])
            ->add('fromName', TextType::class, [
                'label' => 'Nom : ',
                'constraints' => [
                    new NotBlank(['message' => 'Ce champ est obligatoire']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Votre nom est trop long',
                        'min' => 30,
                        'minMessage' => 'Votre nom est trop court'
                    ])
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message : ',
                'constraints' => [
                    new Length([
                        'max' => 3000,
                        'maxMessage' => 'Votre message est trop long',
                        'min' => 15,
                        'minMessage' => 'Votre message est trop court',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
