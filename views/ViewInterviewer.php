<?php
require_once __DIR__ . '/KontrakInterviewerView.php';

class ViewInterviewer implements KontrakInterviewerView {
    private string $skinPath;
    private string $formPath;

    public function __construct(string $skinPath = '', string $formPath = '') {
        $this->skinPath = $skinPath ?: __DIR__ . '/../template/interviewer_skin.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/interviewer_form.html';
    }

    public function renderDaftar(string $tableRowsHtml, int $totalData): string {
        $template = file_get_contents($this->skinPath);
        $tokens = [
            '{{TABLE_ROWS}}' => $tableRowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalData,
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    public function renderForm(string $title, string $action, array $formData = []): string {
        $template = file_get_contents($this->formPath);
        $tokens = [
            '{{FORM_TITLE}}' => htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
            '{{ACTION}}' => htmlspecialchars($action, ENT_QUOTES, 'UTF-8'),
            '{{ID}}' => htmlspecialchars((string)($formData['id'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{NAMA}}' => htmlspecialchars($formData['nama'] ?? '', ENT_QUOTES, 'UTF-8'),
            '{{JABATAN}}' => htmlspecialchars($formData['jabatan'] ?? '', ENT_QUOTES, 'UTF-8'),
            '{{DEPARTEMEN}}' => htmlspecialchars($formData['departemen'] ?? '', ENT_QUOTES, 'UTF-8'),
            '{{EMAIL}}' => htmlspecialchars($formData['email'] ?? '', ENT_QUOTES, 'UTF-8'),
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>
