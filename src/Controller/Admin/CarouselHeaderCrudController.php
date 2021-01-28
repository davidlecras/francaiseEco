<?php

namespace App\Controller\Admin;

use App\Entity\CarouselHeader;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarouselHeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarouselHeader::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre'),
            TextEditorField::new('content','Contenu'),
            ImageField::new('image')
                ->setBasePath('header/')
                ->setUploadDir('public/header/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('btnTitle', 'Titre du bouton'),
            TextField::new('btnUrl','Url à rediriger'),
            BooleanField::new('linkIsInactive','Désactiver le bouton')

        ];
    }

}
