<?php

namespace App\Http\Controllers;

use App\Http\Resources\Book as BookCollectionResource;

class BookApiController extends Controller
{
    public function apiBuku()
    {
        // $books = \App\Models\Book::where('status', 'PUBLISH')
        //     ->orderBy('title', 'asc')
        //     ->limit(10)
        //     ->get();
        $books = new BookCollectionResource(\App\Models\Book::all());
        return $books;
    }

    public function view($id)
    {
        // $book = DB::select('select * from books where id = ?', [$id]);
        $book = new BookCollectionResource(\App\Models\Book::find($id));
        return $book;
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "title" => "required|min:5|max:200",
            "description" => "required|min:10|max:1000",
            "author" => "required|min:3|max:100",
        ])->validate();

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $this->respondCreated('Lesson created successfully');
    }
}
