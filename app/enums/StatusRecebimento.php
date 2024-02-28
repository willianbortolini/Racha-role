<?php

namespace app\enums;

enum StatusRecebimento: int
{
    case Criado = 0;
    case Pendente = 1;
    case Aprovado = 2;
    case Cancelado = 3;
    case EmAnalise = 4;

    public static function getName(self $status): string
    {
        return match($status) {
            self::Criado => 'criado',
            self::Pendente => 'pendente',
            self::Aprovado => 'aprovado',
            self::Cancelado => 'cancelado',
            self::EmAnalise => 'em análise',
        };
    }

    public static function fromName(string $name): ?self
    {
        return match($name) {
            'criado' => self::Criado,
            'pendente' => self::Pendente,
            'aprovado' => self::Aprovado,
            'cancelado' => self::Cancelado,
            'em análise' => self::EmAnalise,
            default => null,
        };
    }
}
