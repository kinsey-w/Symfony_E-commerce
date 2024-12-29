<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'product.label.name',
                'translation_domain' => 'messages',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'product.error.name_not_blank',
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'product.error.name_length',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'product.label.description',
                'translation_domain' => 'messages',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'product.error.description_not_blank',
                    ]),
                ],
            ])
            ->add('prix', NumberType::class, [
                'label' => 'product.label.price',
                'translation_domain' => 'messages',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'product.error.price_not_blank',
                    ]),
                    new Assert\Positive([
                        'message' => 'product.error.price_positive',
                    ]),
                ],
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'product.label.stock',
                'translation_domain' => 'messages',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'product.error.stock_not_blank',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'product.error.stock_non_negative',
                    ]),
                ],
            ])
            ->add('photo', UrlType::class, [
                'label' => 'product.label.photo',
                'translation_domain' => 'messages',
                'required' => false,
                'constraints' => [
                    new Assert\Url([
                        'message' => 'product.error.photo_url',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'product.label.category',
                'translation_domain' => 'messages',
                'required' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'product.error.category_not_null',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
