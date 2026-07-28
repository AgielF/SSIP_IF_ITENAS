<?php

namespace App\Libraries;

/**
 * QaReportGenerator
 * 
 * Library untuk memformat hasil analisis AI QA Agent menjadi laporan
 * Markdown profesional yang disimpan ke writable/qa_reports/.
 */
class QaReportGenerator
{
    /** @var array Seluruh hasil pemindaian yang akan diformat */
    private array $results = [];

    /** @var string Timestamp eksekusi */
    private string $executionTime;

    /** @var array Statistik ringkasan */
    private array $stats = [
        'total_controllers' => 0,
        'total_models'      => 0,
        'total_routes'      => 0,
        'total_tests'       => 0,
        'passed'            => 0,
        'warnings'          => 0,
        'errors'            => 0,
    ];

    public function __construct()
    {
        $this->executionTime = date('Y-m-d H:i:s') . ' WIB';
    }

    /**
     * Set statistik ringkasan pemindaian
     */
    public function setStats(array $stats): self
    {
        $this->stats = array_merge($this->stats, $stats);
        return $this;
    }

    /**
     * Tambahkan hasil pemindaian untuk satu modul/controller
     *
     * @param string $moduleName  Nama modul (contoh: "Publikasi Ilmiah")
     * @param string $fileName    Nama file controller
     * @param string $status      PASSED | WARNING | ERROR
     * @param array  $tests       Array of ['id' => 'C-1', 'name' => '...', 'status' => 'PASSED', 'detail' => '...']
     * @param array  $recommendations Rekomendasi perbaikan (opsional)
     */
    public function addModuleResult(
        string $moduleName,
        string $fileName,
        string $status,
        array $tests,
        array $recommendations = []
    ): self {
        $this->results[] = [
            'module'          => $moduleName,
            'file'            => $fileName,
            'status'          => strtoupper($status),
            'tests'           => $tests,
            'recommendations' => $recommendations,
        ];
        return $this;
    }

    /**
     * Generate laporan Markdown lengkap
     */
    public function generateReport(): string
    {
        $overallStatus = $this->getOverallStatus();
        $statusIcon    = $this->getStatusIcon($overallStatus);

        $report = $this->buildHeader($overallStatus, $statusIcon);
        $report .= $this->buildSummary();
        $report .= $this->buildModuleResults();
        $report .= $this->buildFooter();

        return $report;
    }

    /**
     * Simpan laporan ke file
     */
    public function saveReport(string $content): string
    {
        $dir = WRITEPATH . 'qa_reports';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'qa_report_' . date('Y-m-d_H-i-s') . '.md';
        $filepath = $dir . '/' . $filename;

        file_put_contents($filepath, $content);

        return $filepath;
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function getOverallStatus(): string
    {
        if ($this->stats['errors'] > 0) {
            return 'FAILED';
        }
        if ($this->stats['warnings'] > 0) {
            return 'PASSED DENGAN CATATAN';
        }
        return 'PASSED';
    }

    private function getStatusIcon(string $status): string
    {
        return match ($status) {
            'PASSED'               => '✅',
            'PASSED DENGAN CATATAN' => '⚠️',
            'FAILED'               => '❌',
            default                => '❓',
        };
    }

    private function getModuleStatusEmoji(string $status): string
    {
        return match (strtoupper($status)) {
            'PASSED'  => '🟢',
            'WARNING' => '🟡',
            'ERROR'   => '🔴',
            default   => '⚪',
        };
    }

    private function getTestStatusEmoji(string $status): string
    {
        return match (strtoupper($status)) {
            'PASSED'  => '✅',
            'WARNING' => '⚠️',
            'ERROR'   => '❌',
            'INFO'    => 'ℹ️',
            default   => '❓',
        };
    }

    private function buildHeader(string $overallStatus, string $statusIcon): string
    {
        $readinessPercent = $this->calculateReadiness();
        $readinessLabel   = $this->getReadinessLabel($readinessPercent);

        return <<<HEADER
# {$statusIcon} AI QA AGENT: AUTOMATED CRUD & INTEGRITY TEST REPORT

| Field | Value |
|-------|-------|
| **Target Proyek** | SSIP_IF_ITENAS |
| **Waktu Eksekusi** | {$this->executionTime} |
| **Framework** | CodeIgniter 4 |
| **Status Keseluruhan** | **{$overallStatus}** |
| **Kesiapan Rilis** | **{$readinessPercent}%** ({$readinessLabel}) |

---


HEADER;
    }

    private function buildSummary(): string
    {
        $s = $this->stats;

        return <<<SUMMARY
## 📊 RINGKASAN EKSEKUSI

| Metrik | Jumlah |
|--------|--------|
| Total Controller Dipindai | {$s['total_controllers']} |
| Total Model Dipindai | {$s['total_models']} |
| Total Rute Dipetakan | {$s['total_routes']} |
| Skenario Tes Dijalankan | {$s['total_tests']} |
| ✅ Passed | {$s['passed']} |
| ⚠️ Warnings | {$s['warnings']} |
| ❌ Errors | {$s['errors']} |

---


SUMMARY;
    }

    private function buildModuleResults(): string
    {
        $output = "## 📋 HASIL PEMINDAIAN PER MODUL\n\n";

        foreach ($this->results as $idx => $module) {
            $num    = $idx + 1;
            $emoji  = $this->getModuleStatusEmoji($module['status']);
            $status = $module['status'];

            $statusSuffix = '';
            if ($status === 'WARNING') {
                $statusSuffix = ' - MINOR';
            } elseif ($status === 'ERROR') {
                $statusSuffix = ' - KRITIS';
            }

            $output .= "### {$emoji} {$num}. {$module['module']} (`{$module['file']}`) → [{$status}{$statusSuffix}]\n\n";

            // Render individual tests
            foreach ($module['tests'] as $test) {
                $testEmoji = $this->getTestStatusEmoji($test['status']);
                $output .= "- **{$testEmoji} {$test['id']}** ({$test['name']}): {$test['detail']}\n";
            }

            // Render recommendations
            if (!empty($module['recommendations'])) {
                $output .= "\n> **Rekomendasi AI:**\n";
                foreach ($module['recommendations'] as $rec) {
                    $output .= "> - {$rec}\n";
                }
            }

            $output .= "\n---\n\n";
        }

        return $output;
    }

    private function buildFooter(): string
    {
        $readinessPercent = $this->calculateReadiness();
        $readinessLabel   = $this->getReadinessLabel($readinessPercent);
        $recommendation   = $readinessPercent >= 90
            ? 'Kode aman untuk di-commit dan di-push ke branch utama/produksi.'
            : 'Harap perbaiki temuan ERROR sebelum melakukan deploy ke produksi.';

        return <<<FOOTER
## 🏁 KESIMPULAN

| Metrik | Nilai |
|--------|-------|
| **Kesiapan Rilis (Deployment Readiness)** | **{$readinessPercent}%** ({$readinessLabel}) |
| **Rekomendasi** | {$recommendation} |

---

> *Laporan ini digenerate otomatis oleh AI QA Agent pada {$this->executionTime}.*
> *Jalankan ulang dengan `php spark qa:scan` untuk pembaruan.*

FOOTER;
    }

    private function calculateReadiness(): int
    {
        $total = $this->stats['total_tests'];
        if ($total === 0) return 0;

        $passed  = $this->stats['passed'];
        $warnings = $this->stats['warnings'];

        // Warnings dihitung setengah skor
        $score = $passed + ($warnings * 0.5);
        $percent = (int) round(($score / $total) * 100);

        return min(100, max(0, $percent));
    }

    private function getReadinessLabel(int $percent): string
    {
        if ($percent >= 95) return 'SANGAT BAIK';
        if ($percent >= 85) return 'BAIK';
        if ($percent >= 70) return 'CUKUP';
        if ($percent >= 50) return 'PERLU PERBAIKAN';
        return 'KRITIS';
    }
}
