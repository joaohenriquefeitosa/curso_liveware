<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tweet;

class ShowTweets extends Component
{
    use WithPagination;

    public $content;

    protected $rules = [
        'content' => 'required|min:3|max:255'
    ];
    
    public function render()
    {
        $tweets = Tweet::with('user')->latest()->paginate(10);
        return view('livewire.show-tweets', compact(['tweets']));
    }

    public function create()
    {
        $this->validate();

        // Tweet::create([
        //     'content' => $this->content,
        //     'user_id' => auth()->user()->id
        // ]);

        auth()->user()->tweets()->create([
            'content' => $this->content,
        ]);
        

        $this->content = '';
    }

    public function like($idTweet)
    {
        $tweet = Tweet::find($idTweet);
        $tweet->likes()->create([
            'user_id' => auth()->user()->id,   
        ]);
    }

    public function unlike(Tweet $tweet)
    {
        $tweet->likes()->delete();
    }
}
