<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
    .watchlist-card {
        background: #f8fafc; /* subtle off-white */
        border: 1.5px solid #d1d5db; /* slightly darker border */
        box-shadow: 0 4px 16px 0 rgba(0,0,0,0.10), 0 1.5px 4px 0 rgba(0,0,0,0.08);
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .watchlist-card:hover {
        box-shadow: 0 8px 32px 0 rgba(0,0,0,0.16), 0 3px 8px 0 rgba(0,0,0,0.12);
        transform: translateY(-2px) scale(1.02);
    }
    #flash-message {
        transition: opacity 0.5s;
    }
    #flash-message.fade-out {
        opacity: 0;
    }
</style>

<main class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Watchlist</h1>

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

    <!-- Planning Section -->
    <h2 class="text-2xl font-semibold mb-4">Planning to Watch</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
        <?php foreach ($animes as $anime): ?>
            <?php if ($anime['user_status'] === 'Planned'): ?>
                <div class="w-full max-w-sm watchlist-card">
                    <img class="p-4 rounded-t-lg w-full h-64 object-cover" src="<?= htmlspecialchars($anime['coverImage']['large']) ?>" alt="<?= htmlspecialchars($anime['title']['romaji']) ?>" />
                    <div class="px-5 pb-5">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 mb-3"><?= htmlspecialchars($anime['title']['romaji']) ?></h5>

                        <!-- Update form -->
                        <form action="/watchlist/update" method="POST" class="space-y-3">
                            <input type="hidden" name="anime_id" value="<?= $anime['id'] ?>">

                            <select name="status" class="w-full border rounded px-3 py-2">
                                <option value="Planned" selected>Planning</option>
                                <option value="Completed">Completed</option>
                            </select>

                            <input type="number" name="score" min="1" max="10" placeholder="Score (if completed)" class="w-full border rounded px-3 py-2" />

                            <div class="flex justify-between">
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Save</button>
                                <form action="/watchlist/remove" method="POST" onsubmit="return confirm('Remove from watchlist?')">
                                    <input type="hidden" name="anime_id" value="<?= $anime['id'] ?>">
                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded">Remove</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Completed Section -->
    <h2 class="text-2xl font-semibold mb-4">Watched</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($animes as $anime): ?>
            <?php if ($anime['user_status'] === 'Completed'): ?>
                <div class="w-full max-w-sm watchlist-card">
                    <img class="p-4 rounded-t-lg w-full h-64 object-cover" src="<?= htmlspecialchars($anime['coverImage']['large']) ?>" alt="<?= htmlspecialchars($anime['title']['romaji']) ?>" />
                    <div class="px-5 pb-5">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 mb-3"><?= htmlspecialchars($anime['title']['romaji']) ?></h5>

                        <!-- Show rating -->
                        <div class="flex items-center justify-between">
                            <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded">
                                Score: <?= htmlspecialchars($anime['user_score'] ?? 'N/A') ?>/10
                            </span>

                            <!-- Edit and Remove -->
                            <form action="/watchlist/remove" method="POST" onsubmit="return confirm('Remove from watchlist?')">
                                <input type="hidden" name="anime_id" value="<?= $anime['id'] ?>">
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</main>

<?php require base_path('views/partials/foot.php') ?>

