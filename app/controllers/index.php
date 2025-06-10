<?php
require_once __DIR__ . '/../models/VATNumber.php';
require_once __DIR__ . '/../services/VATProcessor.php';
require_once __DIR__ . '/../utils/FileHandler.php';

$singleVATResult = null;
$uploadMessage = null;

$uploadDir = __DIR__ . '/../../uploads/';
$outputDir = __DIR__ . '/../../output/';

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
    throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
}

if (!is_dir($outputDir) && !mkdir($outputDir, 0777, true) && !is_dir($outputDir)) {
    throw new \RuntimeException(sprintf('Directory "%s" was not created', $outputDir));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file'])) {
        $uploadPath = $uploadDir . basename($_FILES['csv_file']['name']);
        if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $uploadPath)) {
            $processor = new VATProcessor();
            $processor->processCSV($uploadPath);
            [$valid, $corrected, $invalid] = $processor->getResults();

            FileHandler::writeCSV($outputDir . 'valid.csv', $valid);
            FileHandler::writeCSV($outputDir . 'corrected.csv', $corrected);
            FileHandler::writeCSV($outputDir . 'invalid.csv', $invalid);

            $uploadMessage = "File processed. Results generated.";
        } else {
            $uploadMessage = "File upload failed.";
        }
    }

    if (isset($_POST['vat_number'])) {
        $singleVATResult = new VATNumber($_POST['vat_number']);
    }
}

include __DIR__ . '/../views/index.view.php';
