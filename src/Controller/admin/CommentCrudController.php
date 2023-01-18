<?php

namespace App\Controller\admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->disable(Action::NEW, Action::DELETE)
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre')
                ->hideOnForm(),
            TextEditorField::new('content', 'Contenu')
                ->hideOnForm(),
            BooleanField::new('isPublished', 'Publication'),
            AssociationField::new('user', 'auteur du commentaire')
                ->hideOnForm(),
            AssociationField::new('painting', 'Peinture commentée')
                ->hideOnForm(),
        ];
    }
}
