<?php
namespace App\Factory;

// Interfaz para cumplir con OCP (Abierto a extensión)
interface StatusEvaluatorInterface {
    public function getStatus(array $deptData): string;
}

// Implementación de regla por defecto
class StandardEvaluator implements StatusEvaluatorInterface {
    public function getStatus(array $deptData): string {
        $overBudget = ($deptData['total_spent'] > $deptData['total_budget'] && $deptData['total_budget'] > 0);
        
        if ($overBudget || $deptData['efficiency_index'] < 1.5) {
            return 'CRÍTICO';
        }
        if ($deptData['efficiency_index'] > 3) {
            return 'EXCELENTE';
        }
        return 'ESTABLE';
    }
}

// Patrón Factory Method
class StatusEvaluatorFactory {
    public static function make(string $type = 'standard'): StatusEvaluatorInterface {
        return match ($type) {
            'standard' => new StandardEvaluator(),
            default => throw new \InvalidArgumentException("Tipo de evaluador no soportado"),
        };
    }
}
