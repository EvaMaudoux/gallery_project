<?php

namespace App\Controller\admin;

use App\Entity\Painting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class PaintingCrudController extends AbstractCrudController
{
    public const PAINTING_BASE_PATH = 'img/paintings';
    public const PAINTING_UPLOAD_DIR = 'public/img/paintings';

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
            ->setPaginatorPageSize(20)
            ->setSearchFields(['title'])
            ->setDefaultSort(['created' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName', 'Tableau')
                ->setBasePath(self::PAINTING_BASE_PATH)
                ->setUploadDir(self::PAINTING_UPLOAD_DIR),
            TextField::new('title', 'Nom'),
            AssociationField::new('artist', 'Artiste'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('technical', 'Technique'),
            IntegerField::new('height', 'Hauteur'),
            IntegerField::new('width', 'Largeur'),
            BooleanField::new('isSold', 'Vendu'),
            AssociationField::new('likes', 'Nombre de likes')->hideOnForm(),
            TextEditorField::new('smallDescription', 'Description'),
            TextEditorField::new('fullDescription', 'Description complète')
                ->hideOnIndex()
                ->setRequired(false),
            MoneyField::new('price', 'prix')->setCurrency('EUR')->setStoredAsCents(false),
            DateField::new('created', 'Création'),
        ];
    }
}
