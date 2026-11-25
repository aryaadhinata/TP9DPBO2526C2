<?php
class Interviewer {
    private ?int $id;
    private string $nama;
    private string $jabatan;
    private string $departemen;
    private string $email;

    public function __construct(
        ?int $id,
        string $nama,
        string $jabatan,
        string $departemen,
        string $email
    ) {
        $this->id = $id;
        $this->nama = $nama;
        $this->jabatan = $jabatan;
        $this->departemen = $departemen;
        $this->email = $email;
    }

    public function getId(): ?int { return $this->id; }
    public function getNama(): string { return $this->nama; }
    public function getJabatan(): string { return $this->jabatan; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getEmail(): string { return $this->email; }
}
?>
