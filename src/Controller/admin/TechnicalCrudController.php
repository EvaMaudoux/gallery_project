<?php

namespace App\Controller\admin;

use App\Entity\Technical;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnicalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technical::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
