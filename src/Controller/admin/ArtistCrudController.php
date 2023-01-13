<?php

namespace App\Controller\admin;

use App\Entity\Artist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
            TextareaField::new('biography', 'Biographie')
                -> hideOnIndex(),
            DateTimeField::new('birthDate', 'année de naissance'),
        ];
    }
}
