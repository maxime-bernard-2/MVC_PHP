<!DOCTYPE html>

<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Base layout</title>
	<link href="https://unpkg.com/tailwindcss@%5E2/dist/tailwind.min.css" rel="stylesheet">
	<script src="https://kit.fontawesome.com/bec3573ec0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    
    use app\core\Application;

    if (Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success">
            <p><?php echo Application::$app->session->getFlash('success') ?></p>
        </div>
    <?php endif; ?>
    {{content}}
</body>
</html>
