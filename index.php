<?php
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';
require_once __DIR__ . '/models/TabelInterviewer.php';
require_once __DIR__ . '/views/ViewInterviewer.php';
require_once __DIR__ . '/presenters/PresenterInterviewer.php';

$requestModule = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? ($_POST['module'] ?? 'kandidat')
    : ($_GET['module'] ?? 'kandidat');

if ($requestModule === 'interviewer') {
    $model = new TabelInterviewer('localhost', 'mvp_kandidat_db', 'root', '');
    $view = new ViewInterviewer();
    $presenter = new PresenterInterviewer($model, $view);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'tambah') {
            $presenter->tambahInterviewer(
                $_POST['nama'] ?? '',
                $_POST['jabatan'] ?? '',
                $_POST['departemen'] ?? '',
                $_POST['email'] ?? ''
            );
        } elseif ($action === 'ubah') {
            $presenter->ubahInterviewer(
                (int)($_POST['id'] ?? 0),
                $_POST['nama'] ?? '',
                $_POST['jabatan'] ?? '',
                $_POST['departemen'] ?? '',
                $_POST['email'] ?? ''
            );
        } elseif ($action === 'hapus') {
            $presenter->hapusInterviewer((int)($_POST['id'] ?? 0));
        }

        header("Location: index.php?module=interviewer");
        exit();
    } else {
        $screen = $_GET['screen'] ?? 'list';
        if ($screen === 'add') {
            echo $presenter->tampilkanFormInterviewer();
        } elseif ($screen === 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormInterviewer((int)$_GET['id']);
        } else {
            echo $presenter->tampilkanInterviewer();
        }
    }
} else {
    $model = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
    $view = new ViewKandidat();
    $presenter = new PresenterKandidat($model, $view);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'tambah') {
            $presenter->tambahKandidat(
                $_POST['nama'] ?? '',
                $_POST['posisi'] ?? '',
                $_POST['domisili'] ?? '',
                (int)($_POST['skorTes'] ?? 0),
                (int)($_POST['pengalamanTahun'] ?? 0)
            );
        } elseif ($action === 'ubah') {
            $presenter->ubahKandidat(
                (int)($_POST['id'] ?? 0),
                $_POST['nama'] ?? '',
                $_POST['posisi'] ?? '',
                $_POST['domisili'] ?? '',
                (int)($_POST['skorTes'] ?? 0),
                (int)($_POST['pengalamanTahun'] ?? 0)
            );
        } elseif ($action === 'hapus') {
            $presenter->hapusKandidat((int)($_POST['id'] ?? 0));
        }

        header("Location: index.php");
        exit();
    } else {
        $screen = $_GET['screen'] ?? 'list';
        if ($screen === 'add') {
            echo $presenter->tampilkanFormKandidat();
        } elseif ($screen === 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormKandidat((int)$_GET['id']);
        } else {
            echo $presenter->tampilkanKandidat();
        }
    }
}
?>

