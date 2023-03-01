<?php

namespace App\Controller\Admin;

use App\Entity\HotelContact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HotelContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HotelContact::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
