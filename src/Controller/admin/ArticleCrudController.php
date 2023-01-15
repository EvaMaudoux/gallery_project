<?php

namespace App\Controller\admin;

use App\Entity\Article;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
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
            ImageField::new('imageName', 'Photo')
                ->setBasePath('img/articles')
                ->setUploadDir('public/img/articles')
                ->setRequired(false),
            TextField::new('name', 'Titre'),
            TextEditorField::new('description', 'Description'),
            TextEditorField::new('content', 'Contenu'),
            SlugField::new('slug', 'slug')
                ->setTargetFieldName('name')
                ->hideOnIndex(),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            BooleanField::new('isPublished', 'Publication')
        ];
    }


    /** Méthode du CrudAbstractControl pour persister la date de création + le slug
     * @param EntityManagerInterface $em
     * @param $entityInstance
     * @return void
     */
    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
{
    if(!$entityInstance instanceof Article) return;
    $entityInstance->setCreatedAt(new \DateTimeImmutable());
    parent::persistEntity($em, $entityInstance);
}

}
