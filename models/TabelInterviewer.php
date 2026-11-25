<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakInterviewerModel.php';
require_once __DIR__ . '/Interviewer.php';

class TabelInterviewer extends DB implements KontrakInterviewerModel {
    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    private function mapRowToInterviewer(array $row): Interviewer {
        return new Interviewer(
            (int)$row['id'],
            $row['nama'],
            $row['jabatan'],
            $row['departemen'],
            $row['email']
        );
    }

    public function getAllInterviewer(): array {
        $this->executeQuery("SELECT * FROM interviewer ORDER BY nama ASC, id ASC");
        $rows = $this->getAllResult();
        $list = [];

        foreach ($rows as $row) {
            $list[] = $this->mapRowToInterviewer($row);
        }

        return $list;
    }

    public function getInterviewerById(int $id): ?Interviewer {
        $this->executeQuery("SELECT * FROM interviewer WHERE id = :id LIMIT 1", ['id' => $id]);
        $rows = $this->getAllResult();

        return empty($rows) ? null : $this->mapRowToInterviewer($rows[0]);
    }

    public function addInterviewer(string $nama, string $jabatan, string $departemen, string $email): void {
        $query = "INSERT INTO interviewer (nama, jabatan, departemen, email)
                  VALUES (:nama, :jabatan, :departemen, :email)";
        $this->executeQuery($query, [
            'nama' => $nama,
            'jabatan' => $jabatan,
            'departemen' => $departemen,
            'email' => $email,
        ]);
    }

    public function updateInterviewer(int $id, string $nama, string $jabatan, string $departemen, string $email): void {
        $query = "UPDATE interviewer
                  SET nama = :nama, jabatan = :jabatan, departemen = :departemen, email = :email
                  WHERE id = :id";
        $this->executeQuery($query, [
            'id' => $id,
            'nama' => $nama,
            'jabatan' => $jabatan,
            'departemen' => $departemen,
            'email' => $email,
        ]);
    }

    public function deleteInterviewer(int $id): void {
        $this->executeQuery("DELETE FROM interviewer WHERE id = :id", ['id' => $id]);
    }
}
?>
