<?php require base_path("Views/Partials/head.view.php"); ?>

<?php require base_path("Views/Partials/nav.view.php"); ?>

<?php require base_path("Views/Partials/header.view.php"); ?>

    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="    flex items-center justify-end gap-x-6">
                <a href="/notes" class="text-small text-blue-500 hover:underline">Go Back To Notes</a>
            </div>
            <h1>Note Body:</h1>
            <p class="mt-6"><?= nl2br(htmlspecialchars($note['body'] ?? '')); ?></p>
            <div class="mt-4">

                <div class="mt-3">
                    <a href="/notes/edit?id=<?= $note['id']; ?>" class="text-blue-500 hover:underline">Edit Note!</a>
                </div>

                <div class="mt-2">
                    <form action="/note?id=<?= $note['id'] ?>" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $note['id']; ?>">
                        <button type="submit" class="text-red-500 hover:underline">Delete Note!</button>
                    </form>
                </div>
                <div class="mt-6 sm:col-span-4">
                    <form method="POST">
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Comment</label>
                        <div class="mt-2">
                            <textarea id="comment" name="comment" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder=" Write a comment..."></textarea>
                        </div>
                        <?php if ($errors['comment'] ?? false) : ?>
                            <div>
                                <p class="mt-2 text-sm text-red-500"><?= $errors['comment']; ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="mt-3 flex items-center justify-end gap-x-6">
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Comment</button>
                        </div>
                    </form>
                </div>
                <div class="mt-4">
                    <h1>Comments: </h1>
                    <?php foreach ($comments ?? [] as $comment) : ?>
                        <li>
                            <?= htmlspecialchars($comment['body']); ?>
                            <form action="/note/deleteComment" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="id" value="<?= $comment['id']; ?>">
                                <button type="submit" class="text-red-500 hover:underline">Delete Comment!</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

<?php require base_path("Views/Partials/footer.view.php"); ?>