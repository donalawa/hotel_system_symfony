<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('title'),
            Field::new('beds'),
            Field::new('baths'),
            Field::new('price'),
            Field::new('wifi'),
            Field::new('available'),
            Field::new('totalPeople'),
            ImageField::new('image')->setUploadedFileNamePattern(md5(uniqid()) . '.[extension]')->setBasePath('public/images/')->setUploadDir('public/images/'),
            TextEditorField::new('description'),
        ];
    }

}
