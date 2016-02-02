<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 02-02-16
 * Time: 11:30
 */

namespace AscensoDigital\Component\Form\Type;


use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;

class IconType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}