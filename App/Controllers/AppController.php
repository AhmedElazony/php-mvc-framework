<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\UserModel;
use Core\Database\Database;
use Core\Application as App;
use Core\ErrorBag;
use Core\Validator as Validate;
use JetBrains\PhpStorm\NoReturn;

class AppController
{
    public function index()
    {
        $userModel = model(UserModel::class);
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = model(AppModel::class);
        $notes = $appModel->getNotes("user_id = :user_id", ['user_id' => $user['id']]);

        return view("Notes/index", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }
    public function create()
    {
        return view("Notes/create", [
            'heading' => 'Create Note'
        ]);
    }
    public function show()
    {
        if (! ($_GET['id'] ?? false))
        {
            redirect("/notes");
        }
        $userModel = model(UserModel::class);
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = model(AppModel::class);
        $note = $appModel->getNote(['id' => $_GET['id']]);

        authorize($user['id'] === ($note['user_id'] ?? false));

        $comments = $appModel->getComments('note_id = :note_id', ['note_id' => $note['id']]);

        return view("Notes/show", [
            'heading' => "Note: {$note['title']}",
            'note' => $note,
            'comments' => $comments
        ]);
    }
    public function edit()
    {
        $appModel = model(AppModel::class);
        $note = $appModel->getNote(['id' => $_GET['id']]);

        return view("Notes/edit",[
            'heading' => 'Edit Note',
            'note' => $note
        ]);
    }
    #[NoReturn] public function editNote(): void
    {
        $inputs = getNoteInputs();

        showErrors('edit', ['errors' => $inputs['errors']]);

        $appModel = model(AppModel::class);
        $note = $appModel->getNote(['id' => $_POST['id']]);
        // To Escape The ('). So, It doesn't make a pdo Exception because of the update statement in The AppModel Class.
        $appModel->editNote($note['id'], addslashes($inputs['title']), addslashes($inputs['body']));
    }
    #[NoReturn] public function saveNote(): void
    {
        $inputs = getNoteInputs();

        showErrors("create", ['errors' => $inputs['errors']]);

        $userModel = model(UserModel::class);
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = model(AppModel::class);
        $appModel->saveNote($inputs['title'], $inputs['body'], $user['id']);
    }

    #[NoReturn] public function addComment(): void
    {
        $comment = $_POST['comment'] ?? '';

        $userModel = model(UserModel::class);
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = model(AppModel::class);
        $note = $appModel->getNote(['id' => $_GET['id']]);

        $comments = $appModel->getComments('note_id = :note_id', ['note_id' => $note['id']]);

        if (! Validate::string($comment, 7, 255)) {
            ErrorBag::setError('comment', 'A Comment between 7 and 255 Chars is Required!');
        }

        if (! empty(ErrorBag::errors())) {
            view("Notes/show", [
                'heading' => "Note: {$note['body']}",
                'note' => $note,
                'comments' => $comments,
                'errors' => ErrorBag::errors()
            ]);
            exit;
        }

        $appModel->addComment($comment, $note['id'], $user['id']);
    }
    #[NoReturn] public function deleteNote(): void
    {
        $appModel = model(AppModel::class);
        $appModel->deleteNote(['id' => $_POST['id']]);
    }
    #[NoReturn] public function deleteComment(): void
    {
        $appModel = model(AppModel::class);
        $appModel->deleteComment(['id' => $_POST['id']]);
    }
}