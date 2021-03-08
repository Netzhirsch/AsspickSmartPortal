<?php

namespace App\Form\DownloadCenter;

use App\Entity\DownloadCenter\Folder;
use App\Repository\DownloadCenter\FolderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FolderType extends AbstractType
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
            ->add('parent',EntityType::class,[
                'label' => 'Übergeordneter Ordner',
                'class' => Folder::class,
                'choice_label' => 'name',
                'query_builder' => function(FolderRepository $repository){
                    return $repository->getQueryBuilder();
                },
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Folder::class,
        ]);
    }
}
