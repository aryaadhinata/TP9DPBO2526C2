<?php
require_once __DIR__ . '/KontrakInterviewerPresenter.php';
require_once __DIR__ . '/../models/KontrakInterviewerModel.php';
require_once __DIR__ . '/../models/Interviewer.php';
require_once __DIR__ . '/../views/KontrakInterviewerView.php';

class PresenterInterviewer implements KontrakInterviewerPresenter {
    private KontrakInterviewerModel $model;
    private KontrakInterviewerView $view;

    public function __construct(KontrakInterviewerModel $model, KontrakInterviewerView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    private function buildRowHtml(int $no, Interviewer $interviewer): string {
        $id = (int)$interviewer->getId();
        $nama = htmlspecialchars($interviewer->getNama(), ENT_QUOTES, 'UTF-8');
        $jabatan = htmlspecialchars($interviewer->getJabatan(), ENT_QUOTES, 'UTF-8');
        $departemen = htmlspecialchars($interviewer->getDepartemen(), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($interviewer->getEmail(), ENT_QUOTES, 'UTF-8');

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$jabatan}</td>
            <td>{$departemen}</td>
            <td>{$email}</td>
            <td class='col-actions'>
                <a href='index.php?module=interviewer&amp;screen=edit&amp;id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus interviewer ini?')\">
                    <input type='hidden' name='module' value='interviewer'>
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    public function tampilkanInterviewer(): string {
        $listInterviewer = $this->model->getAllInterviewer();
        $rowsHtml = '';

        if (empty($listInterviewer)) {
            $rowsHtml = '<tr><td colspan="6" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data interviewer.</td></tr>';
        } else {
            foreach ($listInterviewer as $index => $interviewer) {
                $rowsHtml .= $this->buildRowHtml($index + 1, $interviewer);
            }
        }

        return $this->view->renderDaftar($rowsHtml, count($listInterviewer));
    }

    public function tampilkanFormInterviewer(?int $id = null): string {
        if ($id !== null) {
            $interviewer = $this->model->getInterviewerById($id);
            if ($interviewer === null) {
                header("Location: index.php?module=interviewer");
                exit();
            }

            $formData = [
                'id' => $interviewer->getId(),
                'nama' => $interviewer->getNama(),
                'jabatan' => $interviewer->getJabatan(),
                'departemen' => $interviewer->getDepartemen(),
                'email' => $interviewer->getEmail(),
            ];

            return $this->view->renderForm("Ubah Data Interviewer", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Interviewer", "tambah", []);
    }

    public function tambahInterviewer(string $nama, string $jabatan, string $departemen, string $email): void {
        $this->model->addInterviewer($nama, $jabatan, $departemen, $email);
        header("Location: index.php?module=interviewer");
        exit();
    }

    public function ubahInterviewer(int $id, string $nama, string $jabatan, string $departemen, string $email): void {
        $this->model->updateInterviewer($id, $nama, $jabatan, $departemen, $email);
        header("Location: index.php?module=interviewer");
        exit();
    }

    public function hapusInterviewer(int $id): void {
        $this->model->deleteInterviewer($id);
        header("Location: index.php?module=interviewer");
        exit();
    }
}
?>
