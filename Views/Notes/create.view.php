<?php require base_path("Views/Partials/head.view.php"); ?>

<?php require base_path("Views/Partials/nav.view.php"); ?>

<?php require base_path("Views/Partials/header.view.php"); ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <form action="/notes/create" method="POST">
            <div class="space-y-12">
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                            <div class="mt-2">
                                <textarea id="title" name="title" rows="1" style="resize: none;" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                ><?= $_POST['title'] ?? ''; ?></textarea>
                            </div>
                            <?php if ($errors['title'] ?? false) : ?>
                                <div>
                                    <p class="mt-2 text-sm text-red-500"><?= $errors['title']; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-full">
                            <label for="body" class="block text-sm font-medium leading-6 text-gray-900">Note Description</label>
                            <div class="mt-2">
                                <textarea id="body" name="body" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                ><?= $_POST['body'] ?? ''; ?></textarea>
                            </div>
                            <?php if ($errors['body'] ?? false) : ?>
                                <div>
                                    <p class="mt-2 text-sm text-red-500"><?= $errors['body']; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>

            <div>
                <div class="mt-3 flex items-center justify-end gap-x-6">
                    <a href="/notes" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save Note</button>
                </div>
            </div>
        </form>
    </div>
</main>
