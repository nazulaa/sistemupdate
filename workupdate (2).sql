-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Mar 2025 pada 05.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workupdate`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `absensi_datang` timestamp NOT NULL DEFAULT current_timestamp(),
  `absensi_pulang` timestamp NULL DEFAULT NULL,
  `lembur` varchar(100) DEFAULT 'Tidak',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `name`, `absensi_datang`, `absensi_pulang`, `lembur`, `created_at`) VALUES
(5, 'Rifda Najla Azzahra', '2025-01-24 05:52:47', '2025-01-23 23:52:50', NULL, '2025-01-24 12:52:47'),
(32, 'shxxbi', '2025-02-06 13:07:22', '2025-02-06 13:07:26', 'Lembur', '2025-02-06 20:07:22'),
(33, 'Rifda Najla Azzahraq', '2025-02-15 12:40:22', NULL, 'Tidak', '2025-02-15 19:40:22'),
(34, 'karyawan1', '2025-02-15 12:40:31', '2025-02-15 12:40:49', 'Lembur', '2025-02-15 19:40:31'),
(35, 'kadiv999', '2025-02-15 12:43:40', '2025-02-15 12:44:04', 'Lembur', '2025-02-15 19:43:40'),
(36, 'karyawan', '2025-02-18 15:21:35', '2025-02-18 15:36:05', 'Tidak', '2025-02-18 22:21:35'),
(37, 'karyawan', '2025-02-18 15:31:11', '2025-02-18 15:36:05', 'Tidak', '2025-02-18 22:31:11'),
(38, 'karyawan', '2025-02-18 15:35:51', '2025-02-18 15:36:05', 'Tidak', '2025-02-18 22:35:51'),
(39, 'karyawan', '2025-02-18 16:23:07', '2025-02-18 16:23:11', 'Tidak', '2025-02-18 23:23:07'),
(40, 'karyawan', '2025-02-18 16:52:30', '2025-02-28 13:49:10', 'Tidak', '2025-02-18 23:52:30'),
(41, 'karyawan', '2025-02-24 04:06:11', '2025-02-28 13:49:10', 'Tidak', '2025-02-24 11:06:11'),
(42, 'karyawan', '2025-02-28 13:48:48', '2025-02-28 13:49:10', 'Tidak', '2025-02-28 20:48:48'),
(43, 'karyawan', '2025-02-28 14:33:46', NULL, 'Tidak', '2025-02-28 21:33:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin`
--

CREATE TABLE `izin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('kepala_divisi','karyawan') NOT NULL,
  `divisi` enum('kreatif','administrasi','produksi') NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin`
--

INSERT INTO `izin` (`id`, `nama`, `role`, `divisi`, `tanggal`, `keterangan`) VALUES
(1, 'Rifda Najla Azzahra', 'kepala_divisi', 'kreatif', '2025-01-24', 'Malassss'),
(5, 'Rifda Najla ', 'kepala_divisi', 'produksi', '2025-02-22', 'jalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lembur`
--

CREATE TABLE `lembur` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('kepala_divisi','karyawan') NOT NULL,
  `divisi` enum('kreatif','administrasi','produksi') NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_lembur` time NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lembur`
--

INSERT INTO `lembur` (`id`, `nama`, `role`, `divisi`, `tanggal`, `jam_mulai`, `jam_lembur`, `keterangan`) VALUES
(1, 'Rifda Najla Azzahra', 'karyawan', 'administrasi', '2025-02-28', '22:18:00', '22:21:00', 'mmm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resi`
--

CREATE TABLE `resi` (
  `id` int(11) NOT NULL,
  `nomor_resi` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'belum dijalani'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `resi`
--

INSERT INTO `resi` (`id`, `nomor_resi`, `tanggal`, `status`) VALUES
(5, '09909', '2025-02-05', 'udah rampung'),
(6, '120705', '2025-02-11', 'belom');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `nama_tugas` varchar(255) NOT NULL,
  `tanggal_penugasan` date NOT NULL,
  `tanggal_deadline` date NOT NULL,
  `detail_tugas` text DEFAULT NULL,
  `divisi` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `nama_tugas`, `tanggal_penugasan`, `tanggal_deadline`, `detail_tugas`, `divisi`, `created_at`) VALUES
(8, 's', '2025-02-01', '2025-02-25', 's', 'Kreatif', '2025-02-25 14:59:10'),
(11, 'okokok', '2025-02-28', '2025-02-01', '999999', 'Administrasi', '2025-02-28 13:52:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `status` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `bukti_gambar` varchar(255) DEFAULT NULL,
  `divisi` enum('Kreatif','Administrasi','Produksi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `updates`
--

INSERT INTO `updates` (`id`, `user_id`, `tanggal`, `jam`, `status`, `deskripsi`, `bukti_gambar`, `divisi`) VALUES
(36, NULL, '2025-02-13', '14:30:00', 'Selesai', 'Update sistem', 'bukti.jpg', ''),
(38, NULL, '2025-02-14', '23:11:46', 'on going bro', 'mantap', '', 'Administrasi'),
(39, NULL, '2025-02-15', '19:42:53', 'sedang dikerjakan', 'tugas90', '1739623373_Screenshot 2024-12-25 202734.png', 'Produksi'),
(40, NULL, '2025-02-24', '11:07:25', 'on going bro', 'eeeee', '', 'Kreatif'),
(42, NULL, '2025-02-25', '16:59:49', 'iuy', 'wwwwwww', '1740477589_Screenshot 2025-02-19 093415.png', 'Kreatif'),
(43, NULL, '2025-02-25', '21:13:46', 'akhirnya selesaiiiiiiii', 'update_web', '1740492826_Screenshot 2025-01-31 190705.png', 'Kreatif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` enum('admin','kepala_divisi','karyawan') NOT NULL,
  `divisi` enum('kreatif','administrasi','produksi','general') DEFAULT 'general',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `fullname`, `role`, `divisi`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '123', 'adminutama', 'admin', 'general', '2025-01-19 12:52:00'),
(6, 'karyawan', 'karyawan@gmail.com', '123', 'karyawansatuu', 'karyawan', 'kreatif', '2025-02-11 11:34:24');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lembur`
--
ALTER TABLE `lembur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `resi`
--
ALTER TABLE `resi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_resi` (`nomor_resi`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updates_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `izin`
--
ALTER TABLE `izin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `lembur`
--
ALTER TABLE `lembur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `resi`
--
ALTER TABLE `resi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `updates`
--
ALTER TABLE `updates`
  ADD CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
