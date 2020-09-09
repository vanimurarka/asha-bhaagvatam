@php
function get_decorated_diff($old, $new){
    $from_start = strspn($old ^ $new, "\0");        
    $from_end = strspn(strrev($old) ^ strrev($new), "\0");

    $old_end = strlen($old) - $from_end;
    $new_end = strlen($new) - $from_end;

    $start = substr($new, 0, $from_start);
    $end = substr($new, $new_end);
    $new_diff = substr($new, $from_start, $new_end - $from_start);  
    $old_diff = substr($old, $from_start, $old_end - $from_start);

    $new = "$start<ins style='background-color:#ccffcc'>$new_diff</ins>$end";
    $old = "$start<del style='background-color:#ffcccc'>$old_diff</del>$end";
    return array("old"=>$old, "new"=>$new);
}
$chapter = null;
@endphp

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
		a {	color: black; }
		a:visited { color: black; }
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
					Manage Edits by {{$user->name}}
				</div>
			</div>
		</div>
		
		<br>
		<div id="content">
			@foreach ($edits as $edit)
				@php
					if (!$chapter || ($chapter->id == $edit->chapterid))
						$chapter = App\Chapter::with('book')->find($edit->chapterid);
				@endphp
				<a href="{{route('chapter',['chapterid'=>$chapter->id])}}" target="_blank"><b>{{$chapter->book->nameE}} Chapter {{$chapter->nameE}} Shloka {{$edit->chapterText->number}}</b></a><br>
				@if (($edit->chapterText->type == '3-PS') || ($edit->chapterText->type == '5-B'))
					@php
						$diff2 = get_decorated_diff($edit->chapterText->text2, $edit->text2);
					@endphp
					{{-- !! $diff1['old'] !!} {!! $diff2['old'] !! --}}
					{{$edit->chapterText->text1}} {!! $diff2['old'] !!}<br>
					{{$edit->text1}} {!! $diff2['new'] !!}<br>
					<br>
				@elseif ($edit->chapterText->type == '6-E')
					@php
						$diff1 = get_decorated_diff($edit->chapterText->text1, $edit->text1);
					@endphp
					{{-- !! $diff1['old'] !!} {!! $diff2['old'] !! --}}
					{!! $diff1['old'] !!}<br>
					{!! $diff1['new'] !!}<br>
					<br>
				@else
					{{$edit->chapterText->text1}} {{$edit->chapterText->text2}}<br>
					{{$edit->text1}} {{$edit->text2}}<br>
				@endif
			@endforeach
		</div>
	</div>
</body>
</html>