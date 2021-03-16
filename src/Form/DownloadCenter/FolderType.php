<?php

namespace App\Form\DownloadCenter;

use App\Entity\DownloadCenter\Folder;
use App\Form\EntityGroupType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FolderType extends AbstractType
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
            ]
        );
        $builder->add('parent',EntityGroupType::class,[
                'label' => 'Übergeordneter Ordner',
                'class' => Folder::class,
                'choice_label' => 'name',
                'choices' => $this->getFolder(),
                'required' => false,
                'choice_attr' => function(Folder $folder) {
                    return ['class' => 'level-'.$folder->getLevel(),'level' => $folder->getLevel()];
                },
            ]
        );

        $builder->add('description',CKEditorType::class,[
                'label' => 'Beschreibung',
                'required' => false,
                'config_name' => 'default'
            ]
        );
    }

    private function getFolder(): array
    {
        $repository = $this->em->getRepository(Folder::class);
        $parents = $repository->findBy(['parent' => null],['name' => 'ASC']);
        return $this->sortGroups($parents);
    }

    /**
     * @param Folder[] $parents
     * @return array
     */
    private function sortGroups($parents): array
    {
        $groups = [];
        foreach ($parents as $parent) {
            $groups[] = $parent;
            $groups = array_merge($groups,$this->addChildren($parent->getChildren(),[]));
        }
        return $groups;
    }

    /**
     * @param null|Folder[] $children
     * @param array $groups
     * @return array
     */
    private function addChildren($children, array $groups): array
    {
        if (empty($children))
            return $groups;

        foreach ($children as $child) {
            $groups[] = $child;
            $groups = array_merge($groups,$this->addChildren($child->getChildren(),[]));
        }
        return $groups;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Folder::class,
        ]);
    }

}
