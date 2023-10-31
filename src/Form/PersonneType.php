<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Users;
use App\Entity\Profil;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('fistname')
            ->add('age')
            ->add('profile', EntityType::class, [
                'expanded' => false,
                'class' => Profil::class,
                'multiple' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('hobbie', EntityType::class, [
                'expanded' => false,
                'class' => Hobby::class,
                'multiple' => true,
                'query_builder' => function(EntityRepository $er)
                {
                    return $er->createQueryBuilder('h')
                        ->orderBy('h.designation', 'ASC');
                },
                'choice_label' => 'designation',
                'required' => false,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('job', EntityType::class, [
                'required' => false,
                'class' => Job::class,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Votre image de profil (Des fichiers images uniquement)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ])
            ->add('editer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

