<?php
interface KontrakInterviewerPresenter {
    public function tampilkanInterviewer(): string;
    public function tampilkanFormInterviewer(?int $id = null): string;
    public function tambahInterviewer(string $nama, string $jabatan, string $departemen, string $email): void;
    public function ubahInterviewer(int $id, string $nama, string $jabatan, string $departemen, string $email): void;
    public function hapusInterviewer(int $id): void;
}
?>
