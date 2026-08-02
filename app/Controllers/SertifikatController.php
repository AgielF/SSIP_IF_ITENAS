<?php

namespace App\Controllers;

use App\Models\ConfigSertifikatModel;
use App\Models\AsistenPeriodeModel;
use App\Models\UserModel;
use App\Libraries\JwtHelper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SertifikatController extends BaseController
{
    protected ConfigSertifikatModel $configModel;
    protected AsistenPeriodeModel   $asistenPeriodeModel;

    private const UPLOAD_PATH = WRITEPATH . 'uploads/sertifikat/';

    public function __construct()
    {
        $this->configModel         = new ConfigSertifikatModel();
        $this->asistenPeriodeModel = new AsistenPeriodeModel();
    }

    // =========================================================================
    // BAGIAN ADMIN: Manajemen Konfigurasi Sertifikat
    // =========================================================================
    
    public function admin()
    {
        $data = [
            'title'  => 'Konfigurasi Sertifikat',
            'config' => $this->configModel->getConfig()
        ];
        return view('sertifikat_admin_view', $data); 
    }

    public function updateConfig()
    {
        $data = [
            'judul'               => $this->request->getPost('judul'),
            'deskripsi_template'  => $this->request->getPost('deskripsi_template'),
            'nama_kepala_lab'     => $this->request->getPost('nama_kepala_lab'),
            'nama_ketua_prodi'    => $this->request->getPost('nama_ketua_prodi'),
            'updated_at'          => date('Y-m-d H:i:s'),
        ];

        // Proses Background
        $templateFile = $this->request->getFile('template_gambar');
        if ($templateFile && $templateFile->isValid() && ! $templateFile->hasMoved()) {
            if (! in_array($templateFile->getMimeType(), ['image/jpeg', 'image/png'])) {
                return redirect()->back()->with('error', 'File template hanya boleh berformat JPG atau PNG.');
            }
            $newName = 'template_' . time() . '.' . $templateFile->getExtension();
            $templateFile->move(self::UPLOAD_PATH, $newName);
            $data['template_gambar'] = 'sertifikat/' . $newName;
        }

        // Proses TTD Kepala Lab
        $ttdKepala = $this->request->getFile('ttd_kepala_lab');
        if ($ttdKepala && $ttdKepala->isValid() && ! $ttdKepala->hasMoved()) {
            if ($ttdKepala->getMimeType() !== 'image/png') {
                return redirect()->back()->with('error', 'File TTD Kepala Lab harus berformat PNG (transparan).');
            }
            $newName = 'ttd_kepala_' . time() . '.png';
            $ttdKepala->move(self::UPLOAD_PATH, $newName);
            $data['ttd_kepala_lab'] = 'sertifikat/' . $newName;
        }

        // Proses TTD Ketua Prodi
        $ttdProdi = $this->request->getFile('ttd_ketua_prodi');
        if ($ttdProdi && $ttdProdi->isValid() && ! $ttdProdi->hasMoved()) {
            if ($ttdProdi->getMimeType() !== 'image/png') {
                return redirect()->back()->with('error', 'File TTD Ketua Prodi harus berformat PNG (transparan).');
            }
            $newName = 'ttd_prodi_' . time() . '.png';
            $ttdProdi->move(self::UPLOAD_PATH, $newName);
            $data['ttd_ketua_prodi'] = 'sertifikat/' . $newName;
        }

        $existing = $this->configModel->getConfig();
        if ($existing) {
            $this->configModel->update($existing['id'], $data);
        } else {
            $this->configModel->insert($data);
        }

        return redirect()->to('/sertifikat_admin')->with('success', 'Konfigurasi sertifikat berhasil diperbarui.');
    }

    public function deleteConfig()
    {
        $existing = $this->configModel->getConfig();

        if ($existing) {
            $filesToDelete = [
                $existing['template_gambar'],
                $existing['ttd_kepala_lab'],
                $existing['ttd_ketua_prodi']
            ];

            foreach ($filesToDelete as $file) {
                if (!empty($file)) {
                    $filePath = WRITEPATH . 'uploads/' . $file;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $this->configModel->delete($existing['id']);
            return redirect()->to('/sertifikat_admin')->with('success', 'Konfigurasi sertifikat beserta aset gambar berhasil dihapus.');
        }

        return redirect()->to('/sertifikat_admin')->with('error', 'Tidak ada konfigurasi yang bisa dihapus.');
    }

    public function updateStatusTugas(int $id_asisten_periode)
    {
        $input      = $this->request->getJSON(true) ?? $this->request->getPost();
        $statusBaru = $input['status_tugas'] ?? null;
        $allowed    = ['selesai', 'belum selesai'];

        if (! in_array($statusBaru, $allowed)) {
            return $this->response->setJSON(['status' => 'error', 'message' => "Nilai status tidak valid."])->setStatusCode(422);
        }

        $record = $this->asistenPeriodeModel->find($id_asisten_periode);
        if (! $record) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.'])->setStatusCode(404);
        }

        $this->asistenPeriodeModel->update($id_asisten_periode, ['status_tugas' => $statusBaru]);
        return $this->response->setJSON(['status' => 'success', 'message' => "Status tugas asisten berhasil diubah."]);
    }

    /**
     * Endpoint untuk merender Pratinjau Sertifikat (Inline Image) di halaman Admin
     */
    public function preview()
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $config = $this->configModel->getConfig();
        if (! $config || empty($config['template_gambar'])) {
            header('Content-Type: text/plain');
            die('ERROR 1: Template gambar belum diatur di database.');
        }

        $templatePath = WRITEPATH . 'uploads/' . $config['template_gambar'];
        if (!file_exists($templatePath)) {
            header('Content-Type: text/plain');
            die('ERROR 2: File fisik template tidak ditemukan di path: ' . $templatePath);
        }

        $canvas = $this->buildCertificateCanvas('NAMA ASISTEN CONTOH', '152022032', $config);
        if (!$canvas) {
            header('Content-Type: text/plain');
            die('ERROR 3: Fungsi buildCertificateCanvas() gagal. Kemungkinan file gambar corrupt atau format tidak didukung.');
        }

        ob_start();
        imagejpeg($canvas, null, 85); 
        $imageData = ob_get_clean();
        imagedestroy($canvas);

        header('Content-Type: image/jpeg');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        echo $imageData;
        exit(); 
    }

    // =========================================================================
    // HELPER: Penangkap ID User Multi-Jalur (Mendukung uid & id)
    // =========================================================================
    private function getCurrentUserId()
    {
        $session = session();
        
        // 1. Jalur Utama: Coba dari Token JWT (Mendukung 'id' atau 'uid')
        $token = $session->get('token');
        if ($token) {
            try {
                $decoded = JWT::decode($token, new Key(JwtHelper::getSecretKey(), 'HS256'));
                if (isset($decoded->id)) return (int) $decoded->id;
                if (isset($decoded->uid)) return (int) $decoded->uid;
            } catch (\Exception $e) {}
        }

        // 2. Jalur Alternatif: Session Key Standar CI4 ['user']['id']
        $user = $session->get('user');
        if (is_array($user) && isset($user['id'])) return (int) $user['id'];
        if (is_object($user) && isset($user->id)) return (int) $user->id;

        // 3. Jalur Cadangan Lainnya
        if ($session->has('id')) return (int) $session->get('id');
        if ($session->has('id_user')) return (int) $session->get('id_user');
        if ($session->has('user_id')) return (int) $session->get('user_id');

        return null;
    }

    // =========================================================================
    // BAGIAN ASISTEN: Halaman & Download Sertifikat
    // =========================================================================

    public function index()
    {
        $status = 'belum selesai';
        $userId = $this->getCurrentUserId();

        

        // ---------------------------------------------------------

        if ($userId) {
            $record = $this->asistenPeriodeModel
                           ->where('id_user', $userId)
                           ->orderBy('id', 'DESC')
                           ->first();
                           
            if ($record) {
                $status = $record['status_tugas'];
            }
        }

        $data = [
            'title'        => 'Sertifikat Apresiasi',
            'status_tugas' => $status
        ];
        
        return view('sertifikat_view', $data);
    }

    public function generate()
    {
        // 1. SAPU BERSIH SEMUA BUFFER AGAR TIDAK ADA ERROR/SPASI TERSELIP
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $userId = $this->getCurrentUserId();
        
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Sesi login tidak valid atau sudah berakhir. Silakan login ulang.'
            ])->setStatusCode(401);
        }

        $userModel = new UserModel();
        $userData  = $userModel->find($userId);

        if (!$userData) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Data pengguna tidak ditemukan di sistem.'
            ])->setStatusCode(404);
        }
        
        // Role authorization sudah ditangani oleh Route Filter (role:1,2) di Routes.php


        $namaUser = $userData['nama'];
        $nrpUser  = $userData['nomor'];

        $rekorAsisten = $this->asistenPeriodeModel
                             ->where('id_user', $userId)
                             ->where('status_tugas', 'selesai')
                             ->first();
                             
        if (! $rekorAsisten) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Sertifikat belum tersedia. Masa tugas Anda belum ditandai selesai oleh Admin.'
            ])->setStatusCode(403);
        }

        $config = $this->configModel->getConfig();
        if (! $config || empty($config['template_gambar'])) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Template sertifikat belum diatur oleh Kepala Lab.'
            ])->setStatusCode(503);
        }

        $canvas = $this->buildCertificateCanvas($namaUser, $nrpUser, $config);

        if (! $canvas) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Gagal memproses gambar sertifikat. Hubungi teknisi.'
            ])->setStatusCode(500);
        }

        $namaFile = 'Sertifikat_' . preg_replace('/\s+/', '_', $namaUser) . '_' . $nrpUser . '.jpg';

        ob_start();
        imagejpeg($canvas, null, 95); 
        $imageData = ob_get_clean();
        imagedestroy($canvas);

        return $this->response
            ->setHeader('Content-Type', 'image/jpeg')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->setHeader('Content-Length', (string) strlen($imageData))
            ->setBody($imageData);
    }
    /**
     * Endpoint pratinjau sertifikat khusus untuk asisten yang sedang login (Real Data)
     */
    public function previewAsisten()
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $userId = $this->getCurrentUserId();
        if (!$userId) {
            return $this->response->setStatusCode(401, 'Unauthorized');
        }

        $userModel = new UserModel();
        $userData  = $userModel->find($userId);
        if (!$userData) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        // Role authorization sudah ditangani oleh Route Filter (role:1,2) di Routes.php


        // Pastikan statusnya sudah selesai
        $rekorAsisten = $this->asistenPeriodeModel
                             ->where('id_user', $userId)
                             ->where('status_tugas', 'selesai')
                             ->first();
                             
        if (! $rekorAsisten) {
            return $this->response->setStatusCode(403, 'Certificate not available');
        }

        $config = $this->configModel->getConfig();
        if (! $config || empty($config['template_gambar'])) {
            return $this->response->setStatusCode(503, 'Template not configured');
        }

        // Render menggunakan data asli asisten (Nama & NRP)
        $canvas = $this->buildCertificateCanvas($userData['nama'], $userData['nomor'], $config);

        if (!$canvas) {
            return $this->response->setStatusCode(500, 'Canvas generation failed');
        }

        ob_start();
        imagejpeg($canvas, null, 85); 
        $imageData = ob_get_clean();
        imagedestroy($canvas);

        header('Content-Type: image/jpeg');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        echo $imageData;
        exit();
    }

    // =========================================================================
    // FUNGSI INTI: Image Processing GD Library
    // =========================================================================

    private function buildCertificateCanvas(string $namaUser, string $nrpUser, array $config)
    {
        $templatePath = WRITEPATH . 'uploads/' . $config['template_gambar'];
        if (! file_exists($templatePath)) return false;

        $imgInfo = getimagesize($templatePath);
        if ($imgInfo === false) return false;
        
        $mime = $imgInfo['mime'];
        $canvas = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($templatePath),
            'image/png'  => imagecreatefrompng($templatePath),
            default      => false,
        };

        if (! $canvas) return false;

        $imgWidth  = imagesx($canvas);
        $imgHeight = imagesy($canvas);
        
        $fontPath = FCPATH . 'assets/fonts/OpenSans-Bold.ttf';
        
        if (!file_exists($fontPath)) {
            $fontPath = '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf'; 
            if (!file_exists($fontPath)) {
                $fontPath = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'; 
            }
        }
        $hasFont = file_exists($fontPath);
        
        $colorBlack = imagecolorallocate($canvas, 30, 30, 30);
        $colorGray  = imagecolorallocate($canvas, 80, 80, 80);
        $colorLine  = imagecolorallocate($canvas, 180, 150, 80);

        $scale = $imgWidth / 2000;
        
        $fsJudul    = 70 * $scale;  
        $fsPreamble = 28 * $scale;  
        $fsNama     = 100 * $scale; 
        $fsNrp      = 28 * $scale;  
        $fsDesc     = 26 * $scale;  
        $fsSig      = 24 * $scale;  

        $printCenter = function($text, $fontSize, $y, $color) use ($canvas, $fontPath, $hasFont, $imgWidth) {
            if ($hasFont) {
                $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
                $txtWidth = abs($bbox[2] - $bbox[0]);
                $x = (int) (($imgWidth - $txtWidth) / 2);
                imagettftext($canvas, $fontSize, 0, $x, $y, $color, $fontPath, $text);
            } else {
                $charWidth = imagefontwidth(5) * strlen($text);
                $x = (int) (($imgWidth - $charWidth) / 2);
                imagestring($canvas, 5, $x, $y, $text, $color);
            }
        };
        
        $judul = strtoupper($config['judul'] ?? 'SERTIFIKAT APRESIASI');
        $printCenter($judul, $fsJudul, (int)($imgHeight * 0.22), $colorBlack);

        $preamble = "Dengan bangga dipersembahkan kepada:";
        $printCenter($preamble, $fsPreamble, (int)($imgHeight * 0.32), $colorGray);

        $printCenter($namaUser, $fsNama, (int)($imgHeight * 0.44), $colorBlack);

        $lineY = (int)($imgHeight * 0.48);
        $lineStartX = (int)($imgWidth * 0.25);
        $lineEndX = (int)($imgWidth * 0.75);
        imagesetthickness($canvas, max(2, (int)(4 * $scale)));
        imageline($canvas, $lineStartX, $lineY, $lineEndX, $lineY, $colorLine);

        $printCenter($nrpUser, $fsNrp, (int)($imgHeight * 0.53), $colorBlack);

        $deskripsi = $config['deskripsi_template'] ?? '';
        $wrappedDesc = wordwrap($deskripsi, 75, "\n"); 
        $descLines = explode("\n", $wrappedDesc);
        $yDesc = (int)($imgHeight * 0.60);
        $lineHeightDesc = (int)(45 * $scale);
        
        foreach ($descLines as $line) {
            $printCenter(trim($line), $fsDesc, $yDesc, $colorBlack);
            $yDesc += $lineHeightDesc;
        }
        
        $yTtdImg  = (int)($imgHeight * 0.70);
        $yTtdName = (int)($imgHeight * 0.86);
        $yTtdRole = (int)($imgHeight * 0.89);

        $xLeftCenter  = (int)($imgWidth * 0.30);
        $xRightCenter = (int)($imgWidth * 0.70);

        $printSigText = function($text, $fontSize, $centerX, $y, $color) use ($canvas, $fontPath, $hasFont) {
            if (empty($text)) return;
            
            if ($hasFont) {
                $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
                $txtWidth = abs($bbox[2] - $bbox[0]);
                $x = (int) ($centerX - ($txtWidth / 2));
                imagettftext($canvas, $fontSize, 0, $x, $y, $color, $fontPath, $text);
            } else {
                $charWidth = imagefontwidth(4) * strlen($text);
                $x = (int) ($centerX - ($charWidth / 2));
                imagestring($canvas, 4, $x, $y, $text, $color);
            }
        };

        $printSigText($config['nama_kepala_lab'] ?? '', $fsSig, $xLeftCenter, $yTtdName, $colorBlack);
        $printSigText("Kepala Laboratorium", $fsSig * 0.8, $xLeftCenter, $yTtdRole, $colorGray);

        $printSigText($config['nama_ketua_prodi'] ?? '', $fsSig, $xRightCenter, $yTtdName, $colorBlack);
        $printSigText("Ketua Prodi", $fsSig * 0.8, $xRightCenter, $yTtdRole, $colorGray);

        $renderTtd = function($ttdPath, $centerX, $yPos) use ($canvas, $scale) {
            if (!empty($ttdPath) && file_exists(WRITEPATH . 'uploads/' . $ttdPath)) {
                $ttdImg = imagecreatefrompng(WRITEPATH . 'uploads/' . $ttdPath);
                if ($ttdImg) {
                    $ttdW = imagesx($ttdImg);
                    $ttdH = imagesy($ttdImg);
                    
                    $targetH = (int)(150 * $scale);
                    $targetW = (int)($ttdW * ($targetH / $ttdH));
                    
                    $ttdResized = imagecreatetruecolor($targetW, $targetH);
                    imagealphablending($ttdResized, false);
                    imagesavealpha($ttdResized, true);
                    $transparent = imagecolorallocatealpha($ttdResized, 0, 0, 0, 127);
                    imagefilledrectangle($ttdResized, 0, 0, $targetW, $targetH, $transparent);
                    
                    imagecopyresampled($ttdResized, $ttdImg, 0, 0, 0, 0, $targetW, $targetH, $ttdW, $ttdH);
                    
                    $x = (int)($centerX - ($targetW / 2));
                    imagecopy($canvas, $ttdResized, $x, $yPos, 0, 0, $targetW, $targetH);
                    
                    imagedestroy($ttdResized);
                    imagedestroy($ttdImg);
                }
            }
        };

        $renderTtd($config['ttd_kepala_lab'] ?? '', $xLeftCenter, $yTtdImg);
        $renderTtd($config['ttd_ketua_prodi'] ?? '', $xRightCenter, $yTtdImg);

        return $canvas;
    }
}