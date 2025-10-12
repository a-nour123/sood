<?php

namespace Database\Seeders;

use App\Models\CvssScoring;
use Illuminate\Database\Seeder;

class CvssScoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CvssScoring::create([
            "id" => 1,
            "metric_name" => 'AccessComplexity',
            "abrv_metric_name" => 'AC',
            "metric_value" => 'Alto',
            "abrv_metric_value" => 'H',
            "numeric_value" =>  0.35
        ]);
        CvssScoring::create([
            "id" => 2,
            "metric_name" => 'AccessComplexity',
            "abrv_metric_name" => 'AC',
            "metric_value" => 'Medio',
            "abrv_metric_value" => 'M',
            "numeric_value" =>  0.61
        ]);
        CvssScoring::create([
            "id" => 3,
            "metric_name" => 'AccessComplexity',
            "abrv_metric_name" => 'AC',
            "metric_value" => 'Bajo',
            "abrv_metric_value" => 'L',
            "numeric_value" =>  0.71
        ]);
        CvssScoring::create([
            "id" => 4,
            "metric_name" => 'AccessVector',
            "abrv_metric_name" => 'AV',
            "metric_value" => 'Local',
            "abrv_metric_value" => 'L',
            "numeric_value" =>  0.395
        ]);

        CvssScoring::create([
            "id" => 5,
            "metric_name" => 'AccessVector',
            "abrv_metric_name" => 'AV',
            "metric_value" => 'Red Adyacente',
            "abrv_metric_value" => 'A',
            "numeric_value" => 0.646
        ]);
        CvssScoring::create([
            "id" => 6,
            "metric_name" => 'AccessVector',
            "abrv_metric_name" => 'AV',
            "metric_value" => 'Red',
            "abrv_metric_value" => 'N',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 7,
            "metric_name" => 'Authentication',
            "abrv_metric_name" => 'Au',
            "metric_value" => 'Ninguno',
            "abrv_metric_value" => 'N',
            "numeric_value" => 0.704
        ]);
        CvssScoring::create([
            "id" => 8,
            "metric_name" => 'Authentication',
            "abrv_metric_name" => 'Au',
            "metric_value" => 'Instancia',
            "abrv_metric_value" => 'S',
            "numeric_value" => 0.56
        ]);

        CvssScoring::create([
            "id" => 9,
            "metric_name" => 'Authentication',
            "abrv_metric_name" => 'Au',
            "metric_value" => 'Multiples Instancias',
            "abrv_metric_value" => 'M',
            "numeric_value" => 0.45
        ]);
        CvssScoring::create([
            "id" => 10,
            "metric_name" => 'AvailabilityRequirement',
            "abrv_metric_name" => 'AR',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 11,
            "metric_name" => 'AvailabilityRequirement',
            "abrv_metric_name" => 'AR',
            "metric_value" => 'Bajo',
            "abrv_metric_value" => 'L',
            "numeric_value" => 0.5
        ]);
        CvssScoring::create([
            "id" => 12,
            "metric_name" => 'AvailabilityRequirement',
            "abrv_metric_name" => 'AR',
            "metric_value" => 'Medio',
            "abrv_metric_value" => 'M',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 13,
            "metric_name" => 'AvailabilityRequirement',
            "abrv_metric_name" => 'AR',
            "metric_value" => 'Alto',
            "abrv_metric_value" => 'H',
            "numeric_value" => 1.51
        ]);
        CvssScoring::create([
            "id" => 14,
            "metric_name" => 'AvailImpact',
            "abrv_metric_name" => 'A',
            "metric_value" => 'Ninguno',
            "abrv_metric_value" => 'N',
            "numeric_value" => 0
        ]);
        CvssScoring::create([
            "id" => 15,
            "metric_name" => 'AvailImpact',
            "abrv_metric_name" => 'A',
            "metric_value" => 'Parcial',
            "abrv_metric_value" => 'P',
            "numeric_value" => 0.275
        ]);
        CvssScoring::create([
            "id" => 16,
            "metric_name" => 'AvailImpact',
            "abrv_metric_name" => 'A',
            "metric_value" => 'Completado',
            "abrv_metric_value" => 'C',
            "numeric_value" => 0.66
        ]);
        CvssScoring::create([
            "id" => 17,
            "metric_name" => 'CollateralDamagePotential',
            "abrv_metric_name" => 'CDP',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 0
        ]);
        CvssScoring::create([
            "id" => 18,
            "metric_name" => 'CollateralDamagePotential',
            "abrv_metric_name" => 'CDP',
            "metric_value" => 'Ninguno',
            "abrv_metric_value" => 'N',
            "numeric_value" => 0
        ]);
        CvssScoring::create([
            "id" => 19,
            "metric_name" => 'CollateralDamagePotential',
            "abrv_metric_name" => 'CDP',
            "metric_value" => 'BAjo (Baja Perdida)',
            "abrv_metric_value" => 'L',
            "numeric_value" => 0.1
        ]);
        CvssScoring::create([
            "id" => 20,
            "metric_name" => 'CollateralDamagePotential',
            "abrv_metric_name" => 'CDP',
            "metric_value" => 'Medio-Bajo',
            "abrv_metric_value" => 'LM',
            "numeric_value" => 0.3
        ]);
        CvssScoring::create([
            "id" => 21,
            "metric_name" => 'CollateralDamagePotential',
            "abrv_metric_name" => 'CDP',
            "metric_value" => 'Medio-Alto',
            "abrv_metric_value" => 'MH',
            "numeric_value" => 0.4
        ]);
        CvssScoring::create([
            "id" => 22,
            "metric_name" => 'CollateralDamagePotential',
            "abrv_metric_name" => 'CDP',
            "metric_value" => 'Alto',
            "abrv_metric_value" => 'H',
            "numeric_value" => 0.5
        ]);
        CvssScoring::create([
            "id" => 23,
            "metric_name" => 'ConfidentialityRequirement',
            "abrv_metric_name" => 'CR',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 24,
            "metric_name" => 'ConfidentialityRequirement',
            "abrv_metric_name" => 'CR',
            "metric_value" => 'Bajo',
            "abrv_metric_value" => 'L',
            "numeric_value" => 0.5
        ]);
        CvssScoring::create([
            "id" => 25,
            "metric_name" => 'ConfidentialityRequirement',
            "abrv_metric_name" => 'CR',
            "metric_value" => 'Medio',
            "abrv_metric_value" => 'M',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 26,
            "metric_name" => 'ConfidentialityRequirement',
            "abrv_metric_name" => 'CR',
            "metric_value" => 'Alto',
            "abrv_metric_value" => 'H',
            "numeric_value" => 1.51
        ]);
        CvssScoring::create([
            "id" => 27,
            "metric_name" => 'ConfImpact',
            "abrv_metric_name" => 'C',
            "metric_value" => 'Ninguno',
            "abrv_metric_value" => 'N',
            "numeric_value" => 0
        ]);
        CvssScoring::create([
            "id" => 28,
            "metric_name" => 'ConfImpact',
            "abrv_metric_name" => 'C',
            "metric_value" => 'Parcial',
            "abrv_metric_value" => 'P',
            "numeric_value" => 0.275
        ]);
        CvssScoring::create([
            "id" => 29,
            "metric_name" => 'ConfImpact',
            "abrv_metric_name" => 'C',
            "metric_value" => 'Completado',
            "abrv_metric_value" => 'C',
            "numeric_value" => 0.66
        ]);
        CvssScoring::create([
            "id" => 30,
            "metric_name" => 'Exploitability',
            "abrv_metric_name" => 'E',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 31,
            "metric_name" => 'Exploitability',
            "abrv_metric_name" => 'E',
            "metric_value" => 'No comporbadas Estas Funciones',
            "abrv_metric_value" => 'U',
            "numeric_value" => 0.85
        ]);
        CvssScoring::create([
            "id" => 32,
            "metric_name" => 'Exploitability',
            "abrv_metric_name" => 'E',
            "metric_value" => 'Prueba de Concepto',
            "abrv_metric_value" => 'POC',
            "numeric_value" => 0.9
        ]);
        CvssScoring::create([
            "id" => 33,
            "metric_name" => 'Exploitability',
            "abrv_metric_name" => 'E',
            "metric_value" => 'Explotar Funciones Existentes',
            "abrv_metric_value" => 'F',
            "numeric_value" => 0.95
        ]);
        CvssScoring::create([
            "id" => 34,
            "metric_name" => 'Exploitability',
            "abrv_metric_name" => 'E',
            "metric_value" => 'Extendido',
            "abrv_metric_value" => 'H',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 35,
            "metric_name" => 'IntegImpact',
            "abrv_metric_name" => 'I',
            "metric_value" => 'Ninguno',
            "abrv_metric_value" => 'N',
            "numeric_value" => 0
        ]);
        CvssScoring::create([
            "id" => 36,
            "metric_name" => 'IntegImpact',
            "abrv_metric_name" => 'I',
            "metric_value" => 'Parcial',
            "abrv_metric_value" => 'P',
            "numeric_value" => 0.275
        ]);
        CvssScoring::create([
            "id" => 37,
            "metric_name" => 'IntegImpact',
            "abrv_metric_name" => 'I',
            "metric_value" => 'Completado',
            "abrv_metric_value" => 'C',
            "numeric_value" => 0.66
        ]);
        CvssScoring::create([
            "id" => 38,
            "metric_name" => 'IntegrityRequirement',
            "abrv_metric_name" => 'IR',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 39,
            "metric_name" => 'IntegrityRequirement',
            "abrv_metric_name" => 'IR',
            "metric_value" => 'Bajo',
            "abrv_metric_value" => 'L',
            "numeric_value" => 0.5
        ]);
        CvssScoring::create([
            "id" => 40,
            "metric_name" => 'IntegrityRequirement',
            "abrv_metric_name" => 'IR',
            "metric_value" => 'Medio',
            "abrv_metric_value" => 'M',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 41,
            "metric_name" => 'IntegrityRequirement',
            "abrv_metric_name" => 'IR',
            "metric_value" => 'Alto',
            "abrv_metric_value" => 'H',
            "numeric_value" => 1.51
        ]);
        CvssScoring::create([
            "id" => 42,
            "metric_name" => 'RemediationLevel',
            "abrv_metric_name" => 'RL',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 43,
            "metric_name" => 'RemediationLevel',
            "abrv_metric_name" => 'RL',
            "metric_value" => 'Arreglo',
            "abrv_metric_value" => 'OF',
            "numeric_value" => 0.87
        ]);
        CvssScoring::create([
            "id" => 44,
            "metric_name" => 'RemediationLevel',
            "abrv_metric_name" => 'RL',
            "metric_value" => 'Arreglo Temporal',
            "abrv_metric_value" => 'TF',
            "numeric_value" => 0.9
        ]);
        CvssScoring::create([
            "id" => 45,
            "metric_name" => 'RemediationLevel',
            "abrv_metric_name" => 'RL',
            "metric_value" => 'Solucion',
            "abrv_metric_value" => 'W',
            "numeric_value" => 0.95
        ]);
        CvssScoring::create([
            "id" => 46,
            "metric_name" => 'RemediationLevel',
            "abrv_metric_name" => 'RL',
            "metric_value" => 'No disponible',
            "abrv_metric_value" => 'U',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 47,
            "metric_name" => 'ReportConfidence',
            "abrv_metric_name" => 'RC',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 48,
            "metric_name" => 'ReportConfidence',
            "abrv_metric_name" => 'RC',
            "metric_value" => 'Sin Confirmar',
            "abrv_metric_value" => 'UC',
            "numeric_value" => 0.9
        ]);
        CvssScoring::create([
            "id" => 49,
            "metric_name" => 'ReportConfidence',
            "abrv_metric_name" => 'RC',
            "metric_value" => 'No corroborada',
            "abrv_metric_value" => 'UR',
            "numeric_value" => 0.95
        ]);
        CvssScoring::create([
            "id" => 50,
            "metric_name" => 'ReportConfidence',
            "abrv_metric_name" => 'RC',
            "metric_value" => 'Confirmada',
            "abrv_metric_value" => 'C',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 51,
            "metric_name" => 'TargetDistribution',
            "abrv_metric_name" => 'TD',
            "metric_value" => 'No definido',
            "abrv_metric_value" => 'ND',
            "numeric_value" => 1
        ]);
        CvssScoring::create([
            "id" => 52,
            "metric_name" => 'TargetDistribution',
            "abrv_metric_name" => 'TD',
            "metric_value" => 'Ninguno (0%)',
            "abrv_metric_value" => 'N',
            "numeric_value" => 0
        ]);
        CvssScoring::create([
            "id" => 53,
            "metric_name" => 'TargetDistribution',
            "abrv_metric_name" => 'TD',
            "metric_value" => 'Bajo (0-25%)',
            "abrv_metric_value" => 'L',
            "numeric_value" =>  0.25
        ]);
        CvssScoring::create([
            "id" => 54,
            "metric_name" => 'TargetDistribution',
            "abrv_metric_name" => 'TD',
            "metric_value" => 'Medio (26-75%)',
            "abrv_metric_value" => 'M',
            "numeric_value" => 0.75
        ]);
        CvssScoring::create([
            "id" => 55,
            "metric_name" => 'TargetDistribution',
            "abrv_metric_name" => 'TD',
            "metric_value" => 'Alto (76-100%)',
            "abrv_metric_value" => 'H',
            "numeric_value" => 1
        ]);
    }
}
