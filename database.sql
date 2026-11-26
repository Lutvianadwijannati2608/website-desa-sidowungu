CREATE TABLE profil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_desa VARCHAR(150) NOT NULL,
    kecamatan VARCHAR(100) NOT NULL,
    kabupaten VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    visi TEXT,
    misi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);