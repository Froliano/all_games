<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('game')->autocomplete();
        yield AssociationField::new('user')->autocomplete();
        yield BooleanField::new('review', 'Recommended')->renderAsSwitch(false);
        yield TextareaField::new('comment')->hideOnIndex();
        yield DateTimeField::new('createdAt')->hideOnForm();
    }
}
