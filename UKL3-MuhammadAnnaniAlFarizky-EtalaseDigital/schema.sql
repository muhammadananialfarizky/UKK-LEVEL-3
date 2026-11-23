CREATE DATABASE IF NOT EXISTS db_etalase_digital;
USE db_etalase_digital;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin', 'siswa') DEFAULT 'siswa'
);

CREATE TABLE IF NOT EXISTS students (
    id_siswa INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNIQUE,
    nis VARCHAR(30) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    kelas_jurusan VARCHAR(50) NOT NULL,
    foto_profile VARCHAR(255),
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS karya (
    id_karya INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    judul VARCHAR(150) NOT NULL,
    deskripsi TEXT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES students(id_siswa) ON DELETE CASCADE
);


INSERT IGNORE INTO users (username, password, role) VALUES
('superadmin@stella.sch.id', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1x1b1G5X5K8d.V0eQO6b3Ff9p5K9e.', 'super_admin'),
('admin@stella.sch.id', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1x1b1G5X5K8d.V0eQO6b3Ff9p5K9e.', 'admin'),
('siswa@stella.sch.id', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1x1b1G5X5Ksd.V0eQO6b3Ff9p5K9e.', 'siswa');