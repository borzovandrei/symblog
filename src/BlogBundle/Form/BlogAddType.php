<?php
/**
 * Created by PhpStorm.
 * User: AndreiBorzov
 * Date: 12.09.17
 * Time: 19:34
 */

namespace BlogBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder -> add("title")
            ->add("author")
            ->add("blog")
            ->add("tags")
            ->add("image")
            ->add("save", SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver -> setDefaults([
          "data_class" => 'BlogBundle\Entity\Blog'
        ]);
    }

}