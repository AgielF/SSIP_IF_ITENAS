<?php

namespace App\Controllers;

class TopicController extends BaseController
{
    // Data ini bertindak sebagai database sementara kita
    private function getAllFieldsData()
    {
        return [
            [
                'title' => 'Machine Learning',
                'description' => 'Supervised & unsupervised learning, evaluation models, ensemble models.',
                'icon' => 'fa-brain'
            ],
            [
                'title' => 'Data Mining',
                'description' => 'Clustering, classification, association, anomalies.',
                'icon' => 'fa-database'
            ],
            [
                'title' => 'Deep Learning',
                'description' => 'Deep Learning for NLP, Deep Learning for Image & Visual, and Time Series & Signal.',
                'icon' => 'fa-layer-group'
            ],
            [
                'title' => 'Artificial Intelligence',
                'description' => 'Fuzzy logic, symbolic AI, heuristics, intelligent agents.',
                'icon' => 'fa-robot'
            ],
            [
                'title' => 'Expert Systems',
                'description' => 'Rule-based systems, inference engines, knowledge bases.',
                'icon' => 'fa-cogs'
            ],
            [
                'title' => 'Smart Systems',
                'description' => 'Predictive systems, recommendation systems, adaptive systems.',
                'icon' => 'fa-lightbulb'
            ],
        ];
    }

    /**
     * Menampilkan daftar semua bidang studi.
     */

    /**
     * Menampilkan halaman detail untuk satu bidang studi.
     */
    public function detail($slug)
    {
        helper('url');
        $allFields = $this->getAllFieldsData();
        $foundField = null;

        // Cari bidang studi yang cocok berdasarkan slug
        foreach ($allFields as $field) {
            if (url_title($field['title'], '-', true) === $slug) {
                $foundField = $field;
                break;
            }
        }

        // Jika tidak ditemukan, tampilkan error 404
        if ($foundField === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Data dummy untuk publikasi yang terkait dengan bidang studi ini
        $publicationsData = [
            ['title' => 'Publikasi Terkait ' . $foundField['title'] . ' #1', 'details' => 'Jurnal Internasional - 2024'],
            ['title' => 'Riset ' . $foundField['title'] . ' Kedua', 'details' => 'Prosiding Konferensi - 2023'],
            ['title' => 'Inovasi Ketiga', 'details' => 'Jurnal Nasional - 2023'],
        ];

        $data = [
            'title' => $foundField['title'],
            'field' => $foundField,
            'publications' => $publicationsData
        ];

        return view('topic_view', $data);
    }
}

