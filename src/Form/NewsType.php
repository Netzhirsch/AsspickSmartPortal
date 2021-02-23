<?php

namespace App\Form;

use App\Entity\News;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel',TextType::class,[
                'label' => 'Titel'
            ])
            ->add('subtitel',TextType::class,[
                'label' => 'Überschrift',
                'required' => false
            ])
            ->add('text',CKEditorType::class,[
                'label' => 'Text',
                'required' => false,
                'config_name' => 'default'
            ])
            ->add('files', FileType::class, [
                'label' => 'Bild',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
            ])
            ->add('tmpFolder', HiddenType::class, [
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
