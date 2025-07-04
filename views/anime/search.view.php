<!-- <pre><?php print_r($_SESSION); ?></pre> -->
<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/nav.php'); ?>

<style>
#flash-message {
    transition: opacity 0.5s;
}
#flash-message.fade-out {
    opacity: 0;
}
</style>

<main class="max-w-7xl mx-auto px-4 py-8">
   

    <?php if ($msg = \Core\Session::get('message')): ?>
        <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?= $msg ?>
        </div>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                var msg = document.getElementById('flash-message');
                if (msg) {
                    setTimeout(function() {
                        msg.classList.add('fade-out');
                        setTimeout(function() {
                            msg.style.display = 'none';
                        }, 500); // Wait for fade-out
                    }, 2000);
                }
            });
        </script>
    <?php endif; ?>

    <?php if (!$searchTerm): ?>
        <div class="flex flex-col items-center justify-center min-h-[70vh]">
            <img src="/logo.png" alt="Jigglylist Logo" class="w-40 h-40 mb-8">
            <form method="GET" action="/anime/search" class="w-full max-w-xl flex flex-col items-center">
                <input
                    type="text"
                    name="search"
                    placeholder="Search anime..."
                    class="border border-gray-300 rounded-full px-6 py-4 w-full text-lg mb-6 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    style="max-width: 500px;"
                >
                <div class="flex space-x-4">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 text-base font-semibold shadow"
                    >
                        Search
                    </button>
                    <button
                        type="button"
                        onclick="window.location.href='/404'"
                        class="bg-gray-200 text-gray-800 px-6 py-2 rounded-full hover:bg-gray-300 text-base font-semibold shadow"
                    >
                        I'm Feeling Lucky
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center mb-8 mt-8">
            <form method="GET" action="/anime/search" class="w-full max-w-xl flex flex-row items-center justify-center space-x-4">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($searchTerm ?? '') ?>"
                    placeholder="Search anime..."
                    class="border border-gray-300 rounded-full px-6 py-4 w-full text-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    style="max-width: 500px;"
                >
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 text-base font-semibold shadow"
                >
                    Search
                </button>
            </form>
        </div>
        <?php if (empty($animes)): ?>
            <p class="text-center">No results found.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($animes as $anime): ?>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm">
                        <img
                            class="rounded-t-lg w-full h-64 object-cover"
                            src="<?= htmlspecialchars($anime['coverImage']['large'] ?? '') ?>"
                            alt="<?= htmlspecialchars($anime['title']['romaji'] ?? 'No title') ?>"
                        >
                        <div class="p-5">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                <?= htmlspecialchars($anime['title']['romaji'] ?? 'No title') ?>
                            </h5>
                            
                            <p class="mb-3 font-normal text-gray-700 text-sm overflow-hidden line-clamp-4">
                                <?= $anime['description'] ?? '<em>No description</em>' ?>
                            </p>

                            <p class="text-sm text-gray-500 mb-2">
                                Episodes: <?= htmlspecialchars($anime['episodes'] ?? 'N/A') ?>
                                | Status: <?= htmlspecialchars($anime['status'] ?? 'N/A') ?>
                            </p>

                            <?php if (isset($_SESSION['user'])): ?>
                                <form method="POST" action="/watchlist/add">
                                    <input type="hidden" name="anime_id" value="<?= htmlspecialchars($anime['id']) ?>">
                                    <input type="hidden" name="search_term" value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300"
                                    >
                                        Add to Watchlist
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require base_path('views/partials/foot.php'); ?>
