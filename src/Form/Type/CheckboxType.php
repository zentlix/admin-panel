<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType as BaseCheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CheckboxType extends BaseCheckboxType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (empty($view->vars['label_attr']['class'])) {
            $view->vars['label_attr']['class'] = 'custom-control-label';
        }

        if (empty($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] = 'custom-control-input';
        }
    }
}
