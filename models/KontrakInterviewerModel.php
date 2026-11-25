<?php
require_once __DIR__ . '/Interviewer.php';

interface KontrakInterviewerModel {
    /** @return Interviewer[] */
    public function getAllInterviewer(): array;

    public function getInterviewerById(int $id): ?Interviewer;
    public function addInterviewer(string $nama, string $jabatan, string $departemen, string $email): void;
    public function updateInterviewer(int $id, string $nama, string $jabatan, string $departemen, string $email): void;
    public function deleteInterviewer(int $id): void;
}
?>
