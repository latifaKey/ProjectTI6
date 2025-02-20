-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Des 2024 pada 02.07
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
-- Database: `web_trpl2c`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `nip` varchar(18) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `prodi_id` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`nip`, `nama_dosen`, `prodi_id`, `foto`) VALUES
('099772', 'iuadyia', 3, ''),
('87478487', 'uyoayb', 7, 'SATIK.png'),
('9398789', 'hjfskdn ', 5, 'MBKM.png'),
('uuldsyukuwp', 'keuejshs', 2, 'Screenshot 2024-12-01 022113.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa1`
--

CREATE TABLE `mahasiswa1` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nim` varchar(15) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `hobi` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `prodi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa1`
--

INSERT INTO `mahasiswa1` (`id`, `nama`, `email`, `nim`, `gender`, `hobi`, `alamat`, `prodi_id`) VALUES
(13, 'sayang', 'sayang@gamail.com', '211111', 'P', 'Menggambar', 'jaajajaja', 4),
(15, 'ansor', 'ansor@com', '2331127', 'L', 'Melukis', 'gurun sahara', NULL),
(21, 'susi susanti', 'susi@makn', '08529801', 'P', 'Melukis', 'hay tayo', NULL),
(22, 'almertita', 'almer@tirta', '7286', 'P', 'BasketBall', 'almer jalan mangggis', NULL),
(23, 'pipi', 'pipi@gaha', '8086', 'P', 'Menggambar', 'jajajajaja', NULL),
(25, 'alex', 'alex@anjay.com', '809269', 'L', 'BasketBall', 'jktfuwetfgdhmgj', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_prodi`
--

CREATE TABLE `tb_prodi` (
  `id` int(11) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `jenjang` enum('D2','D3','D4','S1','S2') NOT NULL,
  `keterangan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_prodi`
--

INSERT INTO `tb_prodi` (`id`, `nama_prodi`, `jenjang`, `keterangan`) VALUES
(2, 'teknologi rekayasa perangkat lunak', 'S1', 'kikiiiii'),
(3, 'mi', 'S2', 'gokill'),
(4, 'sistem informasi', 'S1', 'sistem informasi adalah prodi impian'),
(5, 'teknik komputer', 'D2', 'teknik komputer ini merupakan prodi dengan banyak peminat\r\n'),
(6, 'animasi', 'D4', 'wiiiiiii'),
(7, 'manajemen', 'S2', 'ini merupakan prodi yang bgs'),
(8, 'bahasa jepang', 'S1', 'bahasa jepang juga merupakan prodi yang bagus bagi yang minat'),
(9, 'basing', 'D2', 'basing adalah bahasa asing'),
(10, 'bing', 'D3', 'hahh');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(64) NOT NULL,
  `level` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `fk_prodi2` (`prodi_id`);

--
-- Indeks untuk tabel `mahasiswa1`
--
ALTER TABLE `mahasiswa1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `tb_prodi`
--
ALTER TABLE `tb_prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mahasiswa1`
--
ALTER TABLE `mahasiswa1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tb_prodi`
--
ALTER TABLE `tb_prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `fk_prodi2` FOREIGN KEY (`prodi_id`) REFERENCES `tb_prodi` (`id`);

--
-- Ketidakleluasaan untuk tabel `mahasiswa1`
--
ALTER TABLE `mahasiswa1`
  ADD CONSTRAINT `mahasiswa1_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `tb_prodi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
