<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType as BaseChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ChoiceType extends BaseChoiceType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        if (empty($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] = 'form-control';
        }
    }
}
