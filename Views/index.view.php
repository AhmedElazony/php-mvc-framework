<?php require base_path("Views/Partials/head.view.php"); ?>

<?php require base_path("Views/Partials/nav.view.php"); ?>

<?php require base_path("Views/Partials/header.view.php"); ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <h1>Hello <?= $_SESSION['user']['username'] ?? 'World' ?>,<br>Welcome To Our Awesome Website!</h1>
        <?php if ($_SESSION['user'] ?? false) : ?>
            <a href="/notes" class="mt-5 text-blue-500">Go To Notes Page.</a>
        <?php else : ?>
            <a href="/login" class="mt-5 text-blue-500">Go To Login Page.</a>
        <?php endif; ?>
    </div>
</main>

<?php require base_path("Views/Partials/footer.view.php"); ?>
