<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Slider;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->disable(Action::EDIT)
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural("Choix de l'image du slider")
            ->setEntityLabelInSingular("image de slider");
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName', 'Image du slider')
                ->setBasePath('img/slider')
                ->setUploadDir('public/img/slider'),
            BooleanField::new('isSelected', 'image du slider active')
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Slider) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::persistEntity($em, $entityInstance);
    }

}
