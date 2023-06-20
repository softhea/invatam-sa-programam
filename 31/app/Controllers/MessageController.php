<?php

namespace App\Controllers;

use App\Models\Message;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use App\Services\MessageService;
use Core\Auth;

class MessageController
{
    public function __construct()
    {
        redirectIfNotLogged();
    }
    public function sendForm()
    {
        $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
        if (0 === $userId) {
            redirect('users?error=Invalid User ID!');
        }

        $userRepository = new UserRepository();
        $user = $userRepository->find($userId);
        if (!$user->exists()) {
            redirect('users?error=User Not Found!');
        }

        include 'views/send-message.html.php';
    }

    public function send()
    {
        $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
        if (0 === $userId) {
            redirect('users?error=Invalid User ID!');
        }

        $message = new Message();
        $message->senderId = Auth::id();
        $message->receiverId = $userId;
        $message->message = $_POST['message'];
        $message->save();
    
        redirect('users?message=Message sent.');
    }

    public function list()
    {
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        $response = isset($_GET['message']) ? $_GET['message'] : '';

        $messageRepository = new MessageRepository();
        $messages = $messageRepository->findBySenderOrNotHiddenByReceiver(Auth::id());

        $messageIds = [];
        foreach ($messages as $message) {
            if (!$message->isRead) {
                $messageIds[] = $message->id;
            }
        }

        $messageService = new MessageService();
        $messageService->markAsRead($messageIds);

        include 'views/messages.html.php';
    }

    public function hide()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (0 === $id) {
            redirect('messages?error=Invalid Message ID!');
        }

        $messageRepository = new MessageRepository();
        $message = $messageRepository->find($id);
        if (!$message->exists()) {
            redirect('messages?error=Message not found!');
        }

        $message->hide();	

        redirect('messages?message=Message has been hidden.');
    }
}
