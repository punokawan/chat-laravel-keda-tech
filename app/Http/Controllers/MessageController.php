<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageEvent;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\MessageSendRequest;
use DB;

class MessageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:api', 'scopes:Customer']);
    // }

    protected function user(Request $request, $query)
    {
        $field = ['id', 'email'];
        $id = auth()->user()->id;
        // return response()->json($query);

        if ($query === 'all') {
            
            $users = Message::with(['userFrom', 'userTo'])
                ->where('messages.to_id', $id)
                ->orWhere('messages.from_id', $id)
                ->latest();
            
            $keys = [];

            foreach ($users->get() as $key => $user) {
                if ($user->userFrom->id == $id) {
                    $keys[$key] = $user->userTo->id;
                } else {
                    $keys[$key] = $user->userFrom->id;
                }
            }

            $keys = array_unique($keys);

            $ids = implode(',', $keys);

            $users = User::whereIn('id', $keys);

            if (!empty($key)) {
                $users = $users->orderByRaw(\DB::raw("(id, $ids)"));
            }

        } else {

            $users = User::where('email', 'like', "%{$query}%")->where('id', '!=', $id);

        }

        $users = UserResource::collection($users->get($field));

        return response()->json($users);
    }

    protected function message($id)
    {
        $to = [
            ['from_id', $id],
            ['to_id', auth()->user()->id]
        ];

        $messages = Message::with('users')->where($to);

        $first = $messages;

        if ($first->exists()) {

            DB::table('messages')->where($to)->update(['read_at' => now()]);

        }

        $messages = $messages->orWhere([
            ['from_id', auth()->user()->id],
            ['to_id', $id]
        ])->get();

        $messages = MessageResource::collection($messages);

        return response()->json($messages);
    }

    protected function send(MessageSendRequest $request)
    {
        $request->merge(['from_id' => auth()->user()->id]);

        $message = Message::create($request->all());

        event(new MessageEvent($message));

        $message = new MessageResource($message);

        return response()->json($message);
    }

    protected function read($id)
    {
        $to = [
            ['from_id', $id],
            ['to_id', auth()->user()->id]
        ];
        DB::table('messages')->where($to)->update(['read_at' => now()]);
    }
}
