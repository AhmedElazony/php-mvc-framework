<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\UserModel;
use Core\ErrorBag;
use Core\Validator as Validate;
use JetBrains\PhpStorm\NoReturn;

class AppController
{
    protected UserModel $userModel;
    protected AppModel $appModel;

    public function __construct()
    {
        $this->userModel = model(UserModel::class);
        $this->appModel = model(AppModel::class);
    }
    public function index()
    {
        $user = $this->userModel->getUser(['id' => $_SESSION['user']['id']]);
        $notes = $this->appModel->getNotes("user_id = :user_id", ['user_id' => $user['id']]);

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
        $user = $this->userModel->getUser(['id' => $_SESSION['user']['id']]);

        $note = $this->appModel->getNote(['id' => $_GET['id']]);

        authorize($user['id'] === ($note['user_id'] ?? false));

        $comments = $this->appModel->getComments('note_id = :note_id', ['note_id' => $note['id']]);

        return view("Notes/show", [
            'heading' => "Note: {$note['title']}",
            'note' => $note,
            'comments' => $comments
        ]);
    }
    public function edit()
    {
        $note = $this->appModel->getNote(['id' => $_GET['id']]);

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
        $inputs = getInputs(['comment']);

        $user = $this->userModel->getUser(['id' => $_SESSION['user']['id']]);

        $note = $this->appModel->getNote(['id' => $_GET['id']]);
        $comments = $this->appModel->getComments('note_id = :note_id', ['note_id' => $note['id']]);

        if (! Validate::string($inputs['comment'], 7, 255)) {
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

        $this->appModel->addComment($inputs['comment'], $note['id'], $user['id']);
    }
    #[NoReturn] public function deleteNote(): void
    {
        $this->appModel->deleteNote(['id' => $_POST['id']]);
    }
    #[NoReturn] public function deleteComment(): void
    {
        $this->appModel->deleteComment(['id' => $_POST['id']]);
    }
}