<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Artist;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArtistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artist::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName', 'Photo')
                ->setBasePath('img/artist')
                ->setUploadDir('public/img/artist'),
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            SlugField::new('slug', 'slug')
                ->setTargetFieldName('lastName')
                ->hideOnIndex(),
            TextareaField::new('biography', 'Biographie')
                -> hideOnIndex()
                ->setRequired(false),
            DateField::new('birthDate', 'Date de naissance'),
            CollectionField::new('painting', 'Oeuvres réalisées')
                ->hideOnForm(),
        ];
    }

}
