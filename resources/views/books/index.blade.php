@extends('layouts.app_book')  <!-- 指定鑲入的檔案  -->


@section('title','Pocket Money Management')  <!-- title  -->


<!-- main內容 start -->
@section('main')
		<div class="row mx-auto list_show" style="margin-top: 10px;">
			@if ( Session::get('notice') != "" )<div class="col-12 col-sm-12 notice_area">{{ Session::get('notice') }}</div>@endif
			<div class="col-12 col-sm-12 nav-href">
				<a href="{{ route('books.create') }}" title="新增" style="margin-right: 30px;">新增紀錄</a>
				查詢月份：<input type="month" id="month" name="month" value="{{ Session::get('month') }}" onchange="month_search(this.value)" style="margin-right: 30px;">
			@if ( auth()->user()->level )<a href="{{ route('report') }}" title="匯出報表">匯出報表</a>@endif
			</div>
			<div class="col-1 col-sm-1" align="center"></div>
			<div class="col-3 col-sm-3" align="center">花費日期</div>
			<div class="col-2 col-sm-2" align="center">金錢</div>
			<div class="col-2 col-sm-2" align="center">用途</div>
			<div class="col-2 col-sm-2" align="center">使用人</div>
			<div class="col-2 col-sm-2" align="center"></div><hr>
		@foreach($books as $book)
			<div class="col-1 col-sm-1 nav-href" align="center">
				<a href="{{ route('books.show', $book) }}" title="檢視">檢視</a>
			</div>
			<div class="col-3 col-sm-3" align="center">{{ $book->date }}</div>
			<div class="col-2 col-sm-2" align="center">{{ $book->cost }}</div>
			<div class="col-2 col-sm-2" align="center">{{ $book->category->name }}</div> 
			<div class="col-2 col-sm-2" align="center">{{ $book->user->name }}</div>
			<div class="col-2 col-sm-2 nav-href flex" align="center">
				<a href="{{ route('books.edit', $book) }}" title="編輯">編輯</a>
				<form action="{{ route('books.destroy', $book) }}" method="post" accept-charset="utf-8" style="display: inline-block;">
				@csrf
				@method('delete')
				<button type="submit" class="border">刪除</button>
				</form>
			</div><hr>
		@endforeach	
			<div class="col-12 col-sm-12" align="center">
				{{ $books->render(); }}
			</div>
		</div>
@endsection
<!-- main內容 end -->
<script>
	function month_search(vaule){
		location.href = '{{ route('books.index') }}?month='+vaule;
	}
</script>
