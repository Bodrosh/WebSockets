<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index() {
        $messages = Message::orderBy('created_at', 'desc')->get();
        $messages = MessageResource::collection($messages)->resolve();
        return Inertia::render('Message/Index', compact('messages'));
    }

    public function store(StoreRequest $request) {
        $data = $request->validated();
        $message = Message::create($data);

        broadcast(new StoreMessageEvent($message))->toOthers();

        return MessageResource::make($message)->resolve();
    }
}
