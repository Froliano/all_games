<?php

namespace App\Controller\Admin;

use App\Entity\WishlistItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class WishlistItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WishlistItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('game')->autocomplete();
        yield AssociationField::new('user')->autocomplete();
        yield DateTimeField::new('createdAt')->hideOnForm();
    }
}
