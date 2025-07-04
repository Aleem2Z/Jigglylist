<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<main class="flex flex-col items-center justify-center min-h-[70vh]">
    <img src="/logo.png" alt="Jigglylist Logo" class="w-32 h-32 mb-6">
    <h1 class="text-4xl font-bold mb-4 text-center">Welcome to Jigglylist</h1>
    <a href="<?= isset($_SESSION['user']) ? '/anime/search' : '/login' ?>"
       class="mt-4 px-8 py-3 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
        Proceed
    </a>
</main>

<?php require base_path('views/partials/foot.php') ?>
