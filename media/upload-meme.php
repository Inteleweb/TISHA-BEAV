<?php
// Simple meme upload handler for PHP hosting
$targetDir = __DIR__ . '/user-memes/';
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$memesJson = $targetDir . 'memes.json';
if (!file_exists($memesJson)) {
    file_put_contents($memesJson, '[]');
}
$response = ["success" => false, "error" => "Unknown error."];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = trim($_POST['caption'] ?? '');
    if (!isset($_FILES['image']) || !$caption) {
        $response['error'] = 'Image and caption required.';
    } else {
        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            $response['error'] = 'Invalid file type.';
        } elseif ($file['size'] > 5*1024*1024) {
            $response['error'] = 'File too large (max 5MB).';
        } elseif ($file['error'] !== UPLOAD_ERR_OK) {
            $response['error'] = 'Upload error.';
        } else {
            $filename = 'meme-' . time() . '-' . rand(1000,9999) . '.' . $ext;
            $dest = $targetDir . $filename;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $memes = json_decode(file_get_contents($memesJson), true);
                $memes[] = [
                    'filename' => $filename,
                    'caption' => htmlspecialchars($caption, ENT_QUOTES),
                    'date' => date('c')
                ];
                file_put_contents($memesJson, json_encode($memes, JSON_PRETTY_PRINT));
                $response = ["success" => true, "filename" => $filename];
            } else {
                $response['error'] = 'Failed to save file.';
            }
        }
    }
}
header('Content-Type: application/json');
echo json_encode($response);
