<?php

namespace App\Form;

use App\Entity\Programowanie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            #->add('email')
            #->add('roles')
            #->add('password')
            #->add('isVerified')
            #->add('dob')
            #->add('created_at')
            #->add('system')
            ->add('programowanie', ChoiceType::class, [
                'multiple'  => true,
                'expanded'  => true,
                'choices'   => [
                    'PHP'	=> 'PHP',
                    'JS'	=> 'JS',
                    'Java'	=> 'Java',
                    'Python'=> 'Python',
                    'C / C++'=> 'C',
                    'inny'	=> 'inny',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
