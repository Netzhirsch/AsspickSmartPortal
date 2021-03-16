<?php

namespace App\Form\DownloadCenter;

use App\Entity\DownloadCenter\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isVisible',ChoiceType::class,[
                'label' => 'Sichtbar',
                'choices' => [
                    'ja' => true,
                    'nein' => false
                ],
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
            ])
            ->add('tmpFolder', HiddenType::class, [
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
