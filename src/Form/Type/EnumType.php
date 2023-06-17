<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnumType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(['class'])
            ->setAllowedTypes('class', 'string')
            ->setAllowedValues('class', enum_exists(...))
            ->setDefault('choices', static fn (Options $options): array => $options['class']::cases())
            ->setDefault('choice_label', static fn (\UnitEnum $choice): string => $choice->name)
            ->setDefault('choice_value', static function (Options $options): ?\Closure {
                if (!is_a($options['class'], \BackedEnum::class, true)) {
                    return null;
                }

                return static function (?\BackedEnum $choice): ?string {
                    if (null === $choice) {
                        return null;
                    }

                    return (string) $choice->value;
                };
            })
        ;
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
