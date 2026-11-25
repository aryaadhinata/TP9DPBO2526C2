<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../models/Kandidat.php';
require_once __DIR__ . '/../views/KontrakView.php';

class PresenterKandidat implements KontrakPresenter {
    private KontrakModel $model;
    private KontrakView $view;

    public function __construct(KontrakModel $model, KontrakView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Helper untuk merakit 1 baris HTML tabel kandidat.
     * Panggil dari dalam tampilkanKandidat() saat melakukan foreach.
     */
    private function buildRowHtml(int $no, Kandidat $kandidat): string {
        $id = (int)$kandidat->getId();
        $nama = htmlspecialchars($kandidat->getNama(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $posisi = htmlspecialchars($kandidat->getPosisi(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $domisili = htmlspecialchars($kandidat->getDomisili(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $skorTes = number_format($kandidat->getSkorTes()) . ' / 100';
        $pengalaman = number_format($kandidat->getPengalamanTahun()) . ' Tahun';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$posisi}</td>
            <td>{$domisili}</td>
            <td>{$skorTes}</td>
            <td>{$pengalaman}</td>
            <td class='col-actions'>
                <a href='index.php?screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus kandidat ini?')\">
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    public function tampilkanKandidat(): string {
        $listKandidat = $this->model->getAllKandidat();
        $totalKandidat = count($listKandidat);

        $rowsHtml = '';
        if(empty($listKandidat)){
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">
            Belum ada data kandidat.</td></tr>';
        }else{
            $no = 1;
            foreach ($listKandidat as $kandidat){
                $rowsHtml .= $this->buildRowHtml($no, $kandidat);
                $no++;
            }
        }

        return $this->view->renderDaftar($rowsHtml, $totalKandidat);
    }

    public function tampilkanFormKandidat(?int $id = null): ?string {
        if($id !== null){
            $kandidat = $this->model->getKandidatById($id);
            if($kandidat === null){
                return null;
            }

            $formData = [
                'id'                => $kandidat->getId(),
                'nama'              => $kandidat->getNama(),
                'posisi'            => $kandidat->getPosisi(),
                'domisili'          => $kandidat->getDomisili(),
                'skorTes'           => $kandidat->getSkorTes(),
                'pengalamanTahun'   => $kandidat->getPengalamanTahun(),
            ];

            return $this->view->renderForm("Ubah Data Kandidat", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Kandidat Baru", "tambah", []);
    }

    public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        [$nama, $posisi, $domisili] = $this->validateKandidatInput(
            $nama,
            $posisi,
            $domisili,
            $skorTes,
            $pengalamanTahun
        );
        $this->model->addKandidat($nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
    }

    public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->validateId($id);
        [$nama, $posisi, $domisili] = $this->validateKandidatInput(
            $nama,
            $posisi,
            $domisili,
            $skorTes,
            $pengalamanTahun
        );
        $this->model->updateKandidat($id, $nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
    }

    public function hapusKandidat(int $id): void {
        $this->validateId($id);
        $this->model->deleteKandidat($id);
    }

    private function validateId(int $id): void {
        if ($id < 1) {
            throw new InvalidArgumentException("ID kandidat tidak valid.");
        }
    }

    private function validateKandidatInput(
        string $nama,
        string $posisi,
        string $domisili,
        int $skorTes,
        int $pengalamanTahun
    ): array {
        $fields = [
            'nama' => trim($nama),
            'posisi' => trim($posisi),
            'domisili' => trim($domisili),
        ];

        foreach ($fields as $field => $value) {
            if ($value === '' || preg_match('/\A.{1,100}\z/us', $value) !== 1) {
                throw new InvalidArgumentException("Field {$field} wajib diisi maksimal 100 karakter.");
            }
        }

        if ($skorTes < 0 || $skorTes > 100) {
            throw new InvalidArgumentException("Skor tes harus berada pada rentang 0 sampai 100.");
        }

        if ($pengalamanTahun < 0) {
            throw new InvalidArgumentException("Pengalaman kerja harus berupa bilangan non-negatif.");
        }

        return array_values($fields);
    }
}
?>
