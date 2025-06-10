<!DOCTYPE html>
<html lang="en">
<head>
  <title>Italian VAT Validator</title>
</head>
<body>
<h1>Upload VAT Numbers CSV</h1>

<?php if (!empty($uploadMessage)) {
    echo "<p><strong>$uploadMessage</strong></p>";
} ?>

<form action="" method="post" enctype="multipart/form-data">
  <h2>Upload CSV File</h2>
  <label for="csv_file">Select CSV File:</label>
  <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
  <button type="submit">Process File</button>
</form>

<?php if (!empty($uploadMessage)): ?>
  <h3>Download Results</h3>
  <ul>
    <li><a href="../output/valid.csv" download>Download Valid VATs</a></li>
    <li><a href="../output/corrected.csv" download>Download Corrected VATs</a></li>
    <li><a href="../output/invalid.csv" download>Download Invalid VATs</a></li>
  </ul>
<?php endif; ?>

<hr>

<h2>Single VAT Number Test</h2>
<form method="POST">
  <label>
    <input type="text" name="vat_number" placeholder="Enter VAT number" required>
  </label>
  <button type="submit">Validate</button>
</form>

<?php if ($singleVATResult): ?>
  <h3>Result</h3>
  <p>Status: <strong><?= htmlspecialchars($singleVATResult->status->value) ?></strong></p>
  <p>Value: <strong><?= htmlspecialchars($singleVATResult->getDisplayValue()) ?></strong></p>
    <?php if ($singleVATResult->reason): ?>
    <p>Reason: <?= htmlspecialchars($singleVATResult->reason) ?></p>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>
