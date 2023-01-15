<?php

namespace App\Controller\admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->disable(Action::NEW, Action::DELETE, Action::EDIT)
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural("Utilisateurs")
            ->setEntityLabelInSingular("utilisateur")
            ->setPageTitle("index","gestion des utilisateurs")
            ->setPaginatorPageSize(20)
            ->setDefaultSort(['lastName' => 'ASC']);
    }

    // Affichage des différents champs
    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName', 'image de profil')
                ->setBasePath('img/user')
                ->setUploadDir('public/img/user')
                ->hideOnForm(),
            TextField::new('firstName', 'Prénom')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('lastName', 'Nom')
                ->setFormTypeOption('disabled', 'disabled'),
            EmailField::new('email', 'Email')
                ->hideOnForm(),
            DateTimeField::new('createdAt', 'Inscription')
                ->hideOnForm(),
            ArrayField::new('likes', 'Tableaux aimés par l\'utilisateur'),
            ArrayField::new('roles', 'Rôle'),
        ];
    }

}
