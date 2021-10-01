<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
       return $filters
            ->add(EntityFilter::new('subcategory'))
       ;
 }

    public function configureFields(string $pageName): iterable
    {
        $image = ImageField::new('image')->setBasePath('/uploads/images/products');
        $imageFile = TextareaField::new('imageFile')->setFormType(VichImageType::class);
        $fields = [

            TextField::new('nom'),
            IntegerField::new('quantite'),
            TextEditorField::new('description'),
            IntegerField::new('prix'),
            AssociationField::new('category'),
            AssociationField::new('subcategory'),
            AssociationField::new('marque'),
            
    
           
        ];


        if($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL)
        {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }
        return $fields;
    }

}
