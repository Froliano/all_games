<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $mappingsParams = $this->getParameter('vich_uploader.mappings');
        $gamesImagePath = $mappingsParams['games']['uri_prefix'];

        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield TextEditorField::new('description')->setSortable(true)->hideOnIndex();
        yield DateTimeField::new('releaseDate');
        yield AssociationField::new('editor')->autocomplete();
        yield AssociationField::new('genres')->autocomplete();
        yield TextareaField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->hideOnIndex();
        yield ImageField::new('imageName')
            ->setBasePath($gamesImagePath)
            ->hideOnForm();
    }
}
