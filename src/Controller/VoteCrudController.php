<?php

namespace App\Controller;

use App\Entity\Vote;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vote::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label', 'Intitulé'),
            TextEditorField::new('requirements','Consignes'),
            DateTimeField::new("startDate","Date Ouverture"),
            DateTimeField::new("endDate","Date Cloture")
        ];
    }
    
}
