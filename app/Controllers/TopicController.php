<?php

namespace App\Controllers;

use App\Models\PublikasiModel;
use App\Models\ProyekRisetModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TopicController extends BaseController
{
    /**
     * Static data bidang/topik riset
     */
   private function getAllFieldsData(): array
{
    return [
        [
            'title' => 'Machine Learning',
            'slug'  => 'machine-learning',
            'db_value' => 'machine learning',
            'description' => 'Supervised & unsupervised learning, evaluation models, ensemble models.',
            'icon' => 'fa-brain'
        ],
        [
            'title' => 'Data Mining',
            'slug'  => 'data-mining',
            'db_value' => 'data mining',
            'description' => 'Clustering, classification, association, anomalies.',
            'icon' => 'fa-database'
        ],
        [
            'title' => 'Deep Learning',
            'slug'  => 'deep-learning',
            'db_value' => 'deep learning',
            'description' => 'Deep Learning for NLP, Image Processing, Time Series & Signal.',
            'icon' => 'fa-layer-group'
        ],
        [
            'title' => 'Artificial Intelligence',
            'slug'  => 'artificial-intelligence',
            'db_value' => 'artificial intelligence',
            'description' => 'Fuzzy logic, symbolic AI, heuristics, intelligent agents.',
            'icon' => 'fa-robot'
        ],
        [
            'title' => 'Expert System',
            'slug'  => 'expert-system',
            'db_value' => 'expert system',
            'description' => 'Rule-based systems, inference engines, knowledge bases.',
            'icon' => 'fa-cogs'
        ],
        [
            'title' => 'Smart System',
            'slug'  => 'smart-system',
            'db_value' => 'smart system',
            'description' => 'Predictive systems, recommendation systems, adaptive systems.',
            'icon' => 'fa-lightbulb'
        ],
    ];
}

    /**
     * Konversi slug URL ke ENUM database
     * contoh: machine-learning → machine learning
     */
    private function slugToEnum(string $slug): string
    {
        return str_replace('-', ' ', strtolower($slug));
    }

    /**
     * Detail topic
     * URL: /topic/{slug}
     */
   public function detail($slug)
{
    $fields = $this->getAllFieldsData();
    $field = null;

    foreach ($fields as $f) {
        if ($f['slug'] === $slug) {
            $field = $f;
            break;
        }
    }

    if (!$field) {
        throw PageNotFoundException::forPageNotFound();
    }

    $publikasiModel = new PublikasiModel();
    $proyekModel    = new ProyekRisetModel();

    $publications = $publikasiModel
        ->where('topik', $field['db_value'])
        ->findAll();

    $projects = $proyekModel
        ->where('topik', $field['db_value'])
        ->findAll();

    return view('topic_view', [
        'field'        => $field,
        'publications' => $publications,
        'projects'     => $projects,
    ]);
}

}
