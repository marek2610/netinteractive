<?php

namespace App\Form;

use App\Entity\System;
use App\Entity\User;
use App\Repository\SystemRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class User1Type extends AbstractType
{
    private $em;

    public function __construct(SystemRepository $systemRepository) {
        $this->systemRepository = $systemRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            #->add('roles')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            #->add('isVerified')
            ->add('dob', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'date'
                ],
            ])
            #->add('created_at')
            ->add('programowanie', ChoiceType::class, [
                'multiple'  => true,
                'expanded'  => true,
                'choices'   => [
                    'PHP'	=> 'PHP',
                    'JS'	=> 'JS',
                    'Java'	=> 'Java',
                    'Python'=> 'Python',
                    'C / C++'=> 'C / C++',
                    'inny'	=> 'inny',
                ]
            ])
            ->add('system', EntityType::class, [
                'class' => System::class,
                #'placeholder' => 'Wybierz',
                'required' => true,
                'data'=>$this->systemRepository->findOneBy([
                    'nazwa'    => 'UI',
                ])

            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'UI'    => [],
        ]);
    }
}
