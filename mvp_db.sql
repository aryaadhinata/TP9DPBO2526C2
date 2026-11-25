-- Database: mvp_kandidat_db
CREATE DATABASE IF NOT EXISTS `mvp_kandidat_db`;
USE `mvp_kandidat_db`;

CREATE TABLE IF NOT EXISTS `kandidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `domisili` varchar(100) NOT NULL,
  `skorTes` int(11) NOT NULL DEFAULT 0,
  `pengalamanTahun` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `interviewer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `departemen` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kandidat` (`id`, `nama`, `posisi`, `domisili`, `skorTes`, `pengalamanTahun`) VALUES
(1, 'Raka Pratama', 'Backend Developer', 'Bandung', 92, 3),
(2, 'Sinta Maharani', 'UI/UX Designer', 'Jakarta', 88, 2),
(3, 'Dimas Nugroho', 'Data Analyst', 'Yogyakarta', 85, 1),
(4, 'Nadia Kusuma', 'Frontend Developer', 'Surabaya', 90, 2),
(5, 'Bagas Setiawan', 'QA Engineer', 'Bandung', 81, 1);

INSERT INTO `interviewer` (`nama`, `jabatan`, `departemen`, `email`) VALUES
('Rina Permata', 'HR Manager', 'Talent Acquisition', 'rina.permata@example.com'),
('Budi Santoso', 'Senior Technical Recruiter', 'Engineering', 'budi.santoso@example.com'),
('Maya Putri', 'Lead Interviewer', 'Product and Design', 'maya.putri@example.com');
