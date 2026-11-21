<?php
require_once '../db.php'; // Reba inzira ya db.php

header('Content-Type: application/json');

$search = trim($_GET['search'] ?? '');

if (empty($search)) {
    echo json_encode(['data' => []]);
    exit;
}

$stmt = $pdo->prepare("SELECT ebook_id, title, author, category, file_url FROM ebooks WHERE title LIKE ? OR author LIKE ?");
$stmt->execute(["%$search%", "%$search%"]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['data' => $books]);
?>