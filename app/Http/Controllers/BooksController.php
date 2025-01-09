<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Mail;
use App\Mail\DemoMail;


class BooksController extends Controller
{

    public function __construct(){

        if ( !session('month') ) {
            $month = date("Y-m");
            session(['month' => $month]);
        }
        
    }



    public function index(Request $request)
    {
        if ($request->month) {
            session(['month' => $request->month]);
        }

        $start_date = date(  session('month')."-01 00:00:00" );
        $end_date   = date(  session('month')."-t 00:00:00" );

        $level = auth()->user()->level;
        $uid    = auth()->user()->id;
        if ($level) {
            $books = Book::whereBetween('date', array($start_date, $end_date))->orderBy('date', 'desc')->simplePaginate(10);
        }else{
            $books = Book::where('user_id', $uid)->whereBetween('date', array($start_date, $end_date))->orderBy('date', 'desc')->simplePaginate(10);
        }

        return view("books.index", compact('books'))->with('notice', '');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();//請款類別
        return view("books.create", compact('categories'))->with('notice', '');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
           'date'     => 'required|date',
           'cost'     => 'required|numeric',
           'category' => 'required',
           'content'  => 'required',
        ]);

        $data = [
           'date'        => $request->date,
           'cost'        => $request->cost,
           'category_id' => $request->category,
           'content'     => $request->content,
           'user_id'     => auth()->user()->id,
        ];

        $result =  Book::create($data);
        return redirect('books')->with('notice', '紀錄新增成功！');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $level = auth()->user()->level;
        if ($level) {
            $book = Book::find($id);
        }else{
            $book = auth()->user()->books->find($id);
        }

        if (!$book) {
            return redirect('books')->with('notice', '沒有檢視權限！');
        }

        $categories = Category::all();//請款類別
        return view("books.show", compact('book', 'categories'))->with('notice', '');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $level = auth()->user()->level;
        if ($level) {
            $book = Book::find($id);
        }else{
            $book = auth()->user()->books->find($id);
        }

        if (!$book) {
            return redirect('books')->with('notice', '沒有編輯權限！');
        }

        $categories = Category::all();//請款類別
        return view("books.edit", compact('book', 'categories'))->with('notice', '');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = auth()->user()->books->find($id);

        $validated = $request->validate([
           'date'     => 'required|date',
           'cost'     => 'required|numeric',
           'category' => 'required',
           'content'  => 'required',
        ]);

        $data = [
           'date'        => $request->date,
           'cost'        => $request->cost,
           'category_id' => $request->category,
           'content'     => $request->content,
           'user_id'     => auth()->user()->id,
        ];
        $result = $book->update($data);
        return redirect('books')->with('notice', '紀錄更新成功！');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $level = auth()->user()->level;

        if ($level) {
            $book = Book::find($id);
        }else{
            $book = auth()->user()->books->find($id);
        }

        if (!$book) {
            return redirect('books')->with('notice', '沒有刪除權限！');
        }

        $book->delete();
        return redirect('books')->with('notice', '紀錄刪除成功！');

    }

    public function report()
    {
        $level = auth()->user()->level;

        if (!$level) {
            return redirect('books')->with('notice', '沒有使用權限！');
        }

        $start_date = date(  session('month')."-01 00:00:00" );
        $end_date   = date(  session('month')."-t 00:00:00" );

        $mailDatas = Book::join('users', 'users.id', '=' , 'books.user_id')->select('name',\DB::raw('SUM(cost) as total'))->whereBetween('date', array($start_date, $end_date))->groupBy('name')->get();

        $count = $mailDatas->count();

        if ($count == 0) {
            return redirect('books')->with('notice', '目前沒有資料！');
        }

        // foreach ($books as $book) {
        //     echo $book['name']."<br>";
        //     echo $book['total']."<br>";
        // }
        // echo $books->count();

        Mail::to('paultsao76@gmail.com')->send(new DemoMail($mailDatas));//對目標發送
        echo '已發送郵件, 請確認！<br>';
        echo '<a href="'.route('books.index').'" title="返回">返回</a>';
        // return redirect()->route('books.index')->with('notice', '已發送郵件, 請確認！');
    }
}
