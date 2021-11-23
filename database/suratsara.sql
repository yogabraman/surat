-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03 Sep 2018 pada 01.55
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suratsara`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_disposisi`
--

CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `isi_disposisi` mediumtext NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `batas_waktu` date NOT NULL,
  `catatan` varchar(250) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_disposisi`
--

INSERT INTO `tbl_disposisi` (`id_disposisi`, `tujuan`, `isi_disposisi`, `sifat`, `batas_waktu`, `catatan`, `id_surat`, `id_user`) VALUES
(3, 'Ir. Gunawan Wicaksono', 'Segera hadiri undangan', 'Penting', '2016-05-17', 'Mohon hadir tepat waktu', 14, 3),
(6, 'aaa', 'xzdf', 'Penting', '2018-06-20', 'assss', 13, 3),
(7, 'Kepala UPTD Pendidikan', 'Diterima Usulannya', 'Segera', '2018-07-02', 'Segera Laksanakan', 15, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_klasifikasi`
--

CREATE TABLE `tbl_klasifikasi` (
  `id_klasifikasi` int(5) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `uraian` mediumtext NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_klasifikasi`
--

INSERT INTO `tbl_klasifikasi` (`id_klasifikasi`, `kode`, `nama`, `uraian`, `id_user`) VALUES
(1, '420', 'PENDIDIKAN', 'PENDIDIKAN', 1),
(2, '420.1', 'Pendidikan Khusus Klasifikasi disini Pendidikan Putra/I Irja', 'Pendidikan Khusus Klasifikasi disini Pendidikan Putra/I Irja', 1),
(3, '421', 'Sekolah', 'Sekolah', 1),
(4, '421.1', 'Pra Sekolah', 'Pra Sekolah', 1),
(5, '421.2', 'Sekolah Dasar', 'Sekolah Dasar', 1),
(6, '421.3', 'Sekolah Menengah', 'Sekolah Menengah', 1),
(7, '421.4', 'Sekolah Tinggi', 'Sekolah Tinggi', 1),
(8, '421.5', 'Sekolah Kejuruan', 'Sekolah Kejuruan', 1),
(9, '421.6', 'Kegiatan Sekolah, Dies Natalis Lustrum', 'Kegiatan Sekolah, Dies Natalis Lustrum', 1),
(10, '421.7', 'Kegiatan Pelajar', 'Kegiatan Pelajar', 1),
(11, '421.71', 'Reuni Darmawisata', 'Reuni Darmawisata', 1),
(12, '421.72', 'Pelajar Teladan', 'Pelajar Teladan', 1),
(13, '421.73', 'Resimen Mahasiswa', 'Resimen Mahasiswa', 1),
(14, '421.8', 'Sekolah Pendidikan Luar Biasa', 'Sekolah Pendidikan Luar Biasa', 1),
(15, '421.9', 'PLS / Pemberantasan Buta Huruf', 'PLS / Pemberantasan Buta Huruf', 1),
(16, '422', 'Administrasi Sekolah', 'Administrasi Sekolah', 1),
(17, '422.1', 'Persyaratan Masuk Sekolah, Testing, Ujian,Pendaftaran, Mapras', 'Persyaratan Masuk Sekolah, Testing, Ujian,Pendaftaran, Mapras', 1),
(18, '422.2', 'Tahun Pelajaran', 'Tahun Pelajaran', 1),
(19, '422.3', 'Hari Libur', 'Hari Libur', 1),
(20, '422.4', 'Uang Sekolah, Klasifikasi Disini SPP', 'Uang Sekolah, Klasifikasi Disini SPP', 1),
(21, '422.5', 'Beasiswa', 'Beasiswa', 1),
(22, '423', 'Metode Belajar', 'Metode Belajar', 1),
(23, '423.1', 'Kuliah', 'Kuliah', 1),
(24, '423.2', 'Ceramah, Simposium', 'Ceramah, Simposium', 1),
(25, '423.3', 'Diskusi', 'Diskusi', 1),
(26, '423.4', 'Kuliah Lapangan, Widyawisata, KKN, Studi Tur', 'Kuliah Lapangan, Widyawisata, KKN, Studi Tur', 1),
(27, '423.5', 'Kurikulum', 'Kurikulum', 1),
(28, '423.6', 'Karya Tulis', 'Karya Tulis', 1),
(29, '423.7', 'Ujian', 'Ujian', 1),
(30, '424', 'Tenaga Pengajar, Guru, Dosen, Dekan, Rektor', 'Tenaga Pengajar, Guru, Dosen, Dekan, Rektor', 1),
(31, '425', 'Sarana Pendidikan', 'Sarana Pendidikan', 1),
(32, '425.1', 'Gedung', 'Gedung', 1),
(33, '425.11', 'Gedung Sekolah', 'Gedung Sekolah', 1),
(34, '425.12', 'Kampus', 'Kampus', 1),
(35, '425.13', 'Pusat Kegiatan Mahasiswa', 'Pusat Kegiatan Mahasiswa', 1),
(36, '425.2', 'Buku', 'Buku', 1),
(37, '425.3', 'Perlengkapan Sekolah', 'Perlengkapan Sekolah', 1),
(38, '426', 'Keolahragaan', 'Keolahragaan', 1),
(39, '426.1', 'Cabang Olah Raga', 'Cabang Olah Raga', 1),
(40, '426.2', 'Sarana', 'Sarana', 1),
(41, '426.21', 'Gedung Olah Raga', 'Gedung Olah Raga', 1),
(42, '426.22', 'Stadion', 'Stadion', 1),
(43, '426.23', 'Lapangan', 'Lapangan', 1),
(44, '426.24', 'Kolam renang', 'Kolam renang', 1),
(45, '426.3', 'Pesta Olah Raga, Klasifikasi nya: PON, Porsade, Olimpiade,', 'Pesta Olah Raga, Klasifikasi nya: PON, Porsade, Olimpiade,', 1),
(46, '426.4', 'KONI', 'KONI', 1),
(47, '427', 'Kepramukaan Meliputi: Organisasi dan Kegiatan Remaja', 'Kepramukaan Meliputi: Organisasi dan Kegiatan Remaja', 1),
(48, '428', 'Kepramukaan', 'Kepramukaan', 1),
(49, '429', 'Pendidikan Kedinasan Untuk Depdagri', 'Pendidikan Kedinasan Untuk Depdagri', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat_keluar`
--

CREATE TABLE `tbl_surat_keluar` (
  `id_surat` int(10) NOT NULL,
  `no_agenda` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_catat` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_surat_keluar`
--

INSERT INTO `tbl_surat_keluar` (`id_surat`, `no_agenda`, `tujuan`, `no_surat`, `isi`, `kode`, `tgl_surat`, `tgl_catat`, `file`, `keterangan`, `id_user`) VALUES
(2, 1, 'Kepala SMP Negeri/Swasta', '421.7/4786', 'Pemberitahuan Lomba Mapsi SMP Tingkat Kota Semarang', '421.7', '2017-08-11', '2017-08-12', '4718-surat keluar 1.jpg', '-', 1),
(3, 2, 'Kepala UPTD Pendidikan ', '421.2/4268', 'Jadwal Akreditasi SD APBD Tahun ANggaran 2017', '421.2', '2017-07-24', '2017-07-28', '7773-surat keluar 2.jpg', '-', 1),
(4, 3, 'Ka. SMP dan Ka.UPTD', '421.7/4558', 'Undangan nformasi Free Seminar', '421.7', '2017-08-01', '2017-08-24', '', 'Penting', 1),
(5, 4, 'Kepala SMP Negeri/Swasta', '421/4633', 'Undangan Kegiatan Fasilitasi Pembinaan Nasionalisme dan Karakter Bangsa\r\n', '421', '2017-08-07', '2017-08-10', '', 'Wajib Hadir', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat_masuk`
--

CREATE TABLE `tbl_surat_masuk` (
  `id_surat` int(10) NOT NULL,
  `no_agenda` int(10) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `asal_surat` varchar(250) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_surat_masuk`
--

INSERT INTO `tbl_surat_masuk` (`id_surat`, `no_agenda`, `no_surat`, `asal_surat`, `isi`, `kode`, `tgl_surat`, `tgl_diterima`, `file`, `keterangan`, `id_user`) VALUES
(13, 3, '973/5077', 'DISPERMADESDUKCAPIL', 'Pelaksanaan Jatuh Tempo Pembayaran PBB', '973', '2017-04-18', '2016-06-24', '', '-', 1),
(14, 4, '560/402.1/411.203/2017', 'Dinas Sosial Tenaga Kerja Dan Transmigrasi Daerah Kabupaten Nganjuk', 'Surat undangan untuk menghadiri acara Pameran Bursa Kerja Untuk Percepatan Penempatan Tenaga Kerja / Job Fair Tahun 2016', '421.3', '2017-07-10', '2016-07-24', '', 'Segera laksanakan', 1),
(15, 1, '942/5081', 'Dinas Pendidikan', 'Permohonan Data Petugas Asistensi dan Verifikasi', '941', '2018-06-27', '2018-06-27', '', '-', 1),
(16, 6, '042/067 / SMK-AH/I/2017', 'Dinas Sosial Tenaga Kerja Dan Transmigrasi Daerah Kabupaten Nganjuk', 'djjghkh', '420', '2018-08-22', '2018-08-22', '', '-', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `nama`, `nip`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Sara', '1501310042', 1),
(5, 'kepdin', '55b9f493eedf2e189d67f2eb47f44e27', 'Drs. Bunyamin, M.Pd.', '196202061987031013', 2),
(8, 'gunawan', 'dc96b97c4ffbead46ca25ef5d4b77cbe', 'Ir. Gunawan Wicaksono', '196202061987031013', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  ADD PRIMARY KEY (`id_disposisi`);

--
-- Indexes for table `tbl_klasifikasi`
--
ALTER TABLE `tbl_klasifikasi`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indexes for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  MODIFY `id_disposisi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_klasifikasi`
--
ALTER TABLE `tbl_klasifikasi`
  MODIFY `id_klasifikasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  MODIFY `id_surat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  MODIFY `id_surat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
