@extends('layouts.app_book')  <!-- 指定鑲入的檔案  -->


@section('title','View')  <!-- title  -->


<!-- main內容 start -->
@section('main')
    <!-- Rule show-->
    <div class="row mx-auto" style="margin-top: 10px;">
   		<div class="col-12 col-sm-6 mx-auto" align="center">
   			<div>
   				<label for="date" class="form-label"><span class="required">*</span>花費日期</label>
   			</div>
   			<div>
   				<input type="date" id="date" name="date" class="border p-1 book_input" value="{{ $book->date }}" disabled>
   				@if ($errors->has('date')) <br><span class="required">{{ $errors->first('date') }}</span><hr> @endif
   			</div>
   			<div>
   				<label for="cost" class="form-label"><span class="required">*</span>金額</label>
   			</div>
   			<div>
   				<input type="text" id="cost" name="cost" class="border p-1 book_input" value="{{ $book->cost }}" disabled>
   				@if ($errors->has('cost')) <br><span class="required">{{ $errors->first('cost') }}</span><hr> @endif
   			</div>

   			<div>
   				<label for="category" class="form-label"><span class="required">*</span>用途</label>
   			</div>
   			<div>
   				<select id="category" name="category" class="border p-1 book_input" disabled>
   				@foreach($categories as $category)
				<option value="{{ $category->id }}" @if ( $category->id == $book->category_id ) selected @endif>{{ $category->name }}</option>
				@endforeach	
   				</select>
   				@if ($errors->has('category')) <br><span class="required">{{ $errors->first('category') }}</span><hr> @endif
   			</div>

   			<div>
   				<label for="content" class="form-label"><span class="required">*</span>說明</label>
   			</div>
   			<div>
   				<textarea id="content" name="content" class="border p-1 book_textarea" row="10" col="20" disabled>{{ $book->content }}</textarea>
   				@if ($errors->has('content')) <br><span class="required">{{ $errors->first('content') }}</span><hr> @endif
   			</div>
   		</div>
   		<div class="col-12 col-sm-12 mx-auto nav-href" align="center">
			<a href="{{ route('books.index') }}" title="返回">返回</a>
		</div>
   	</div>	
@endsection
<!-- main內容 end -->


