<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
use App\Models\Book;

class MailController extends Controller
{

    public function index(){

    	$start_date = date(  session('month')."-01 00:00:00" );
        $end_date   = date(  session('month')."-t 00:00:00" );

    	$books = Book::select('name', \DB::raw('SUM(cost) as total'))->whereBetween('date', array($start_date, $end_date))->groupBy('user_id')->get();
    	foreach ($books as $book) {
    		echo $book['name']."<br>";
    		echo $book['total']."<br>";
    	}

    	Mail::to('paultsao76@gmail.com')->send(new DemoMail($books));//對目標發送
    	dd('信件發送成功！');
    }

}
