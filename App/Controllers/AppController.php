<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\UserModel;
use Core\Database\Database;
use Core\Application as App;
use Core\ErrorBag;
use Core\Validator;
use JetBrains\PhpStorm\NoReturn;

class AppController
{
    public function index()
    {
        $userModel = new UserModel(App::resolve(Database::class));
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = new AppModel(App::resolve(Database::class));
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
        $userModel = new UserModel(App::resolve(Database::class));
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = new AppModel(App::resolve(Database::class));
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
        $appModel = new AppModel(App::resolve(Database::class));
        $note = $appModel->getNote(['id' => $_GET['id']]);

        return view("Notes/edit",[
            'heading' => 'Edit Note',
            'note' => $note
        ]);
    }
    #[NoReturn] public function editNote(): void
    {
        $title = $_POST['title'] ?? '';
        $body = $_POST['body'] ?? '';

        $userModel = new UserModel(App::resolve(Database::class));
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);
        $currentUserId = $user['id'];

        if (! Validator::string($title, 7, 25)) {
            ErrorBag::setError('title', 'A Title between 7 and 55 Chars is Required!');
        }
        if (! Validator::string($body, 7, 255)) {
            ErrorBag::setError('body', 'A Note Body between 7 and 255 Chars is Required!');
        }

        if (! empty(ErrorBag::errors())) {
            view('Notes/edit',[
                'errors' => ErrorBag::errors()
            ]);
            exit;
        }

        $appModel = new AppModel(App::resolve(Database::class));
        $appModel->saveNote($title, $body, $currentUserId);

    }
    #[NoReturn] public function saveNote(): void
    {
        $title = $_POST['title'] ?? '';
        $body = $_POST['body'] ?? '';

        $userModel = new UserModel(App::resolve(Database::class));
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);
        $currentUserId = $user['id'];

        if (! Validator::string($title, 7, 25)) {
            ErrorBag::setError('title', 'A Title between 7 and 25 Chars is Required!');
        }
        if (! Validator::string($body, 7, 255)) {
            ErrorBag::setError('body', 'A Note Body between 7 and 255 Chars is Required!');
        }

        if (! empty(ErrorBag::errors())) {
            view('Notes/create',[
                'errors' => ErrorBag::errors()
            ]);
            exit;
        }

        $appModel = new AppModel(App::resolve(Database::class));
        $appModel->saveNote($title, $body, $currentUserId);
    }

    #[NoReturn] public function addComment(): void
    {
        $comment = $_POST['comment'] ?? '';

        $userModel = new UserModel(App::resolve(Database::class));
        $user = $userModel->getUser(['id' => $_SESSION['user']['id']]);

        $appModel = new AppModel(App::resolve(Database::class));
        $note = $appModel->getNote(['id' => $_GET['id']]);

        $comments = $appModel->getComments('note_id = :note_id', ['note_id' => $note['id']]);

        if (! Validator::string($comment, 7, 255)) {
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
        $appModel = new AppModel(App::resolve(Database::class));
        $appModel->deleteNote(['id' => $_POST['id']]);
    }
    #[NoReturn] public function deleteComment(): void
    {
        $appModel = new AppModel(App::resolve(Database::class));
        $appModel->deleteComment(['id' => $_POST['id']]);
    }
}