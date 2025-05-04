<?php
// src/Form/ProduitType.php
namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du produit'])
            ->add('prix', MoneyType::class, ['label' => 'Prix'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('image', TextType::class, ['label' => 'Nom de l\'image (ex: produit1.jpg)'])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter le produit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
