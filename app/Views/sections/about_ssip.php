<style>
    /* Style Dasar Kartu About (Transparan di awal) */
    .about-card {
        padding: 35px;
        border-radius: 20px;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1); /* Animasi smooth */
        border: 1px solid transparent; /* Tidak ada border di awal */
        height: 100%; /* Agar tinggi kartu menyesuaikan container */
        background-color: transparent; 
    }

    /* EFEK HOVER: Naik, Muncul Shadow, dan Border Biru Tipis */
    .about-card:hover {
        transform: translateY(-10px); /* Translasi ke atas */
        background-color: #ffffff; /* Background jadi putih solid */
        box-shadow: 0 20px 40px rgba(0,0,0,0.08); /* Bayangan lembut */
        border-color: rgba(13, 110, 253, 0.15); /* Border biru transparan */
        z-index: 2; /* Supaya muncul di atas elemen lain */
    }

    /* Dekorasi tambahan: Garis biru di kiri saat hover */
    .about-card:hover {
        border-left: 5px solid #0d6efd;
    }
</style>

<section class="bg-white py-5 mt-4">
    <div class="container py-4">
        <div class="row align-items-stretch"> <div class="col-md-5 mb-4 mb-md-0">
                <div class="about-card d-flex flex-column justify-content-center">
                    <h2 class="text-dark font-weight-bold mb-3" style="font-size: 2.5rem; line-height: 1.2; font-weight: 700;">
                        Smart System & <br>Information Processing <span class="text-primary">Laboratory.</span>
                    </h2>
                    
                    <div class="bg-primary mt-2" style="width: 80px; height: 6px; border-radius: 10px;"></div>
                </div>
            </div>

            <div class="col-md-7"> <div class="about-card">
                    <p class="text-secondary" style="font-size: 1.2rem; line-height: 1.7;">
                        The Smart Systems and Information Processing Laboratory (SSIP Lab) is a research and learning facility that focuses on the development of smart systems and modern information processing technologies. This laboratory embraces various studies related to machine learning, deep learning, artificial intelligence (AI), expert systems, data mining, information retrieval, and natural language processing (NLP).
                    </p>
                    
                    <p class="text-secondary mt-3 mb-0" style="font-size: 1.2rem; line-height: 1.7;">
                        The SSIP Lab is a place where theory and application are integrated, providing an environment for academic exploration, applied research, and industrial collaboration in the areas of smart systems and intelligent data processing.
                    </p>
                    
                    <div class="mt-4">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>