<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Library</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/../styles/main.css">
</head>

<body>

<!-- Съобщения за грешки, добавям го тук, защото се използва в във всички view-ове и да не се повтарям -->

  <?php if (isset($_SESSION['error_message'])) : ?>
    <div class="alert alert-danger" role="alert">
      <!-- Извличам съобщението от сесията -->
      <?php echo htmlspecialchars($_SESSION['error_message']); ?>
      <!-- Изчиствам съобщението от сесията -->
      <?php unset($_SESSION['error_message']); 
      ?>
    </div>
  <?php endif; ?>