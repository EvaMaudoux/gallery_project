<?php

namespace App\Controller\admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')
                -> hideOnDetail(),
            ImageField::new('imageName', 'Photo')
                ->setBasePath('img/articles')
                ->setUploadDir('public/img/articles'),
            TextField::new('name', 'Titre'),
            TextEditorField::new('description', 'Description'),
            TextEditorField::new('content', 'Contenu'),
            DateTimeField::new('createdAt', 'Date de création'),
        ];
    }

}
