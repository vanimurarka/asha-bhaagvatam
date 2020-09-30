<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bhaagavatam First Step</title>
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('js/vue.min.js') }}"></script>
	<style>
		body {
			background-color: #0081A7;
		}
		#header-container {
			/* background-color: peru; */
			background-color: #F2863F;
			z-index: 10;
		}
		#header-container a {
			color: black;
		}
		#nav-drop {
			position: relative;
		}
		#nav-drop-real {
			display: none;
			position: absolute;
			top: 0; left: 0;
			width: 100%;
			background-color: #ffa061;
			z-index: 5;
		}
		#nav-current {
			font-weight: bold;
		}
		#nav-current:hover {
			font-style: italic;
			cursor: pointer;
		}
		.nav-item {
			display: block;
		}
		.nav-item:hover {
			text-decoration: underline;
			cursor: pointer;
		}
		.nav-selected {
			font-weight: bold;
		}
		#content {
			/* background: linear-gradient(rgba(255,235,205,.85), rgba(255,235,205,.85)), url('assets/bg3.jpg'); */
			background: linear-gradient(rgba(255,255,255,.85), rgba(255,255,255,.85)), url('assets/bg3.jpg');
			background-attachment: fixed;
			background-position: center;
			background-size: 90vh auto;
			/* background-size: cover; */
			background-color: blanchedalmond;
			max-width: 90vh;
			margin: auto;
			border: 0.15em solid #F2863F;
			padding: 5px;
		}
		.verse {
			padding: 0.5em;
		}
		td {
			width: 50%;
		}
	</style>
</head>
<body>
	<div id="app">
		<div id="header-container" class="sticky-top">
			<div class="row text-center no-gutters">
				<div class="col"><h4><a href="/">Bhaagavatam First Step</a></h4></div>
			</div>
			<div class="row no-gutters">
				<div class="col text-center" @click="toggleNav" id="nav-current">
					Add Content
				</div>
			</div>
		</div>
		
		<br>
		<div id="content">
			Books<br>
			@foreach ($books as $book)
				@php $chapter = $book->chapters()->orderBy('order','desc')->first(); @endphp
				{{$book->order}} - {{$book->nameE}} - {{$chapter['order']}}<br> 
			@endforeach
			<br>
			Add Book
			<form method="POST" action="{{route('add-book')}}">
				@csrf
				Order <input type="number" name="order">
				English Name<input type="text" name="nameE">
				<input type="submit" name="submit">
			</form>
			<br>
			Add Chapters
			<form method="POST" action="{{route('add-chapters')}}">
				@csrf
				Book <select name="book_id">
					@foreach ($books as $book)
						<option value="{{$book->id}}">{{$book->nameE}}</option>
					@endforeach
				</select>
				Number of Chapters to add <input type="number" name="chapters">
				<input type="submit" name="submit">
			</form>
			<br>
			Import Chapter
			<form method="POST" action="{{route('import-chapter')}}">
				@csrf
				Book <select name="book_id">
					@foreach ($books as $book)
						<option value="{{$book->id}}">{{$book->nameE}}</option>
					@endforeach
				</select>
				Chapter <input type="number" name="chapter">
				Sheet Number <input type="number" name="sheet">
				Filename <input type="text" name="filename">
				<input type="submit" name="submit">
			</form>
		</div>
	</div>
</body>
</html>