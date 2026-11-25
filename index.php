<?php
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';

$model = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
$view = new ViewKandidat();
$presenter = new PresenterKandidat($model, $view);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $readString = static function (string $field): string {
        $value = $_POST[$field] ?? null;
        if (!is_string($value)) {
            throw new InvalidArgumentException("Data formulir tidak valid.");
        }

        return $value;
    };

    $readInteger = static function (string $field, int $default = 0): int {
        $value = $_POST[$field] ?? (string)$default;
        if (!is_string($value) || $value === '') {
            if ($value === '') {
                return $default;
            }
            throw new InvalidArgumentException("Data numerik tidak valid.");
        }

        $number = filter_var($value, FILTER_VALIDATE_INT);
        if ($number === false) {
            throw new InvalidArgumentException("Data numerik tidak valid.");
        }

        return $number;
    };

    try {
        $action = $_POST['action'] ?? null;
        if (!is_string($action)) {
            throw new InvalidArgumentException("Aksi formulir tidak valid.");
        }

        if ($action === 'hapus') {
            $presenter->hapusKandidat($readInteger('id'));
        } elseif ($action === 'tambah' || $action === 'ubah') {
            $nama = $readString('nama');
            $posisi = $readString('posisi');
            $domisili = $readString('domisili');
            $skorTes = $readInteger('skorTes');
            $pengalamanTahun = $readInteger('pengalamanTahun');

            if ($action === 'tambah') {
                $presenter->tambahKandidat($nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
            } else {
                $presenter->ubahKandidat(
                    $readInteger('id'),
                    $nama,
                    $posisi,
                    $domisili,
                    $skorTes,
                    $pengalamanTahun
                );
            }
        } else {
            throw new InvalidArgumentException("Aksi formulir tidak dikenal.");
        }

        header("Location: index.php");
        exit();
    } catch (InvalidArgumentException $exception) {
        http_response_code(400);
        echo htmlspecialchars($exception->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
} else {
    $screen = $_GET['screen'] ?? 'list';
    if ($screen === 'add') {
        echo $presenter->tampilkanFormKandidat();
    } elseif ($screen === 'edit' && isset($_GET['id'])) {
        $form = $presenter->tampilkanFormKandidat((int)$_GET['id']);
        if ($form === null) {
            header("Location: index.php");
            exit();
        }
        echo $form;
    } else {
        echo $presenter->tampilkanKandidat();
    }
}
?>

