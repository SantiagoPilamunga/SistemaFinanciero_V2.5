<?php
namespace App\Service;

class FinancialAnalyzerService {
    private static ?FinancialAnalyzerService $instance = null;

    // Singleton: Constructor privado para evitar instanciación externa
    private function __construct() {}

    // Singleton: Método de acceso global
    public static function getInstance(): FinancialAnalyzerService {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // SRP: Cálculo aislado del Índice de Eficiencia Operativa
    public function calculateEfficiency(float $weightedScore, int $totalCustomers): float {
        if ($weightedScore <= 0) {
            return 0;
        }
        return $totalCustomers / ($weightedScore / 100);
    }
}
