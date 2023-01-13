<?php

namespace App\Controller\admin;

use App\Entity\Painting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PaintingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Painting::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural("Peintures")
            ->setEntityLabelInSingular("peinture")
            ->setPageTitle("index","gestion des peintures")
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName', 'Tableau')
                ->setBasePath('img/paintings')
                ->setUploadDir('public/img/paintings'),
            TextField::new('title', 'Nom'),
            TextEditorField::new('smallDescription', 'Description'),
            TextEditorField::new('fullDescription', 'Description complète'),
            DateTimeField::new('created', 'Création'),
        ];
    }
}
