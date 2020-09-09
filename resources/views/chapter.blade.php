@php
	$isuser = false;
	$isuser = Auth::check(); 
	$user = Auth::user();

	$root = config('app.url');
	if ($edits == null)
		$totalEdits = 0;
	else
		$totalEdits = $edits->count();
	$editCounter = 0;
	$edited = "";
	if ($isuser)
		$allowEdit = true;
	else
		$allowEdit = false;
@endphp
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{$chapter->book->nameE}} {{$chapter->nameE}} | Bhaagavatam First Step</title>
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('js/jquery-1.12.3.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/vue.min.js') }}"></script>
	<style>
		body {
			background-color: #0081A7;
		}
		a {	color: blue; }
		a:visited { color: black; }
		.edit {
			text-decoration: underline !important;
			cursor: pointer !important;
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
		.sanskrit-alone {
			font-weight: bold;display: inline-block;
		}
		.sanskrit {
			display: inline-block;width: 39%;vertical-align: top;
		}
		.english {
			display: inline-block;width: 50%;vertical-align: top;
		}
		.blue {
			color: blue;
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
				<div class="col text-right">
					@if ($chapter->id > 1)
					<a href="{{$chapter->id - 1}}" class="nav-item">Prev</a>
					@endif
				</div>
				<div class="col text-center" @click="toggleNav" id="nav-current">
					&#9776; {{$chapter->book->nameE}} Chapter {{$chapter->nameE}}
				</div>
				<div class="col text-left">
					@if (!$lastChapter)
					<a href="{{$chapter->id + 1}}" class="nav-item">Next</a>
					@endif
				</div>
			</div>
			<div id="nav-drop">
				<div class="row no-gutters text-center justify-content-center" id="nav-drop-real" style="display: none">
					<div class="col">
						<div v-for="(book, index) in nav.all" :class="{'nav-selected':index===nav.selected.book, 'nav-item':index != nav.selected.book}" @click="nav.selected.book = index">
							@{{book.nameE}}
						</div>
					</div>
					<div class="col">
						<div v-for="(chapter, index) in nav.all[nav.selected.book].chapters" :class="{'nav-selected': chapter.id === nav.selected.chapterid, 'nav-item' : chapter.id != nav.selected.chapterid}" @click="gotoChapter(chapter.id)">
							Chapter @{{chapter.nameE}}
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<br>
		<div id="content">
			@foreach ($lines as $line)
				<!-- o in id means original -->
				@php
					if ($totalEdits > 0)
					{
						if ($line->id == $edits[$editCounter]['originalId'])
						{
							$edited = "blue"; // class if this line is edited
							$txt1 = $edits[$editCounter]['text1'];
							$txt2 = $edits[$editCounter]['text2'];
							if ($editCounter < $totalEdits - 1)
								$editCounter++;
						}
						else
						{
							$edited = ""; // class if this line is edited
							$txt1 = $line->text1;
							$txt2 = $line->text2;
						}
					}
					else
					{
						$edited = ""; // class if this line is edited
						$txt1 = $line->text1;
						$txt2 = $line->text2;
					}
				@endphp
				<span id="{{$line->id}}-1o" style="visibility: hidden;display: none;">{{$txt1}}</span>
				<span id="{{$line->id}}-2o" style="visibility: hidden;display: none;">{{$txt2}}</span>
                @switch($line->type)
                	@case('3-PS')
                		<div>
                			<div class="sanskrit {{$edited}}" id="{{$line->id}}-1">{{$txt1}}</div>
                			<div class="english {{$edited}}" id="{{$line->id}}-2">{{$txt2}}</div>
                			@if ($allowEdit) <a class="edit" onclick="edit({{$line->id}},'{{$line->type}}')" id="e-{{$line->id}}">Edit</a> @endif
                		</div>
                		@break
                	@case('4-S')
						<div class="sanskrit-alone {{$edited}}" id="{{$line->id}}-1">{{$txt1}}</div>
						@if ($allowEdit) <a class="edit" onclick="edit({{$line->id}},'{{$line->type}}')" id="e-{{$line->id}}">Edit</a> @endif
						<br>
						@break
                	@case('5-B')
                		@if ($line->lineNumber == 1)<br>@endif
                		<div>
                			<div class="sanskrit {{$edited}}" id="{{$line->id}}-1">{{$txt1}}</div>
                			<div class="english {{$edited}}" id="{{$line->id}}-2">{{$txt2}} </div>
                			@if ($allowEdit) <a class="edit" onclick="edit({{$line->id}},'{{$line->type}}')" id="e-{{$line->id}}">Edit</a> @endif
                		</div>
                		@break                	
                	@case('6-E')
                		<br>
                		<div class="{{$edited}}" style="display: inline-block;" id="{{$line->id}}-1">{{$txt1}} </div>
                		@if ($allowEdit) <a class="edit" onclick="edit({{$line->id}},'{{$line->type}}')" id="e-{{$line->id}}">Edit</a> @endif
                		<br><br>
                		@break
                	@default
                		<div style="text-align: center;">
        				<div id="{{$line->id}}-1" class="sanskrit-alone {{$edited}}">{{$txt1}}</div>
        				@if ($allowEdit) <a class="edit" onclick="edit({{$line->id}},'{{$line->type}}')" id="e-{{$line->id}}">Edit</a> @endif
        				<br><br>
        				</div>
                @endswitch
            @endforeach
		</div>
	</div>

	<script type="text/javascript">
		var $j = jQuery.noConflict();		
		function edit(id,type)
		{
			eid = "e-"+id;
			div = document.getElementById(id +'-1');
			div.contentEditable = true;
			div.style.border = "1px solid black";

			if ((type == '3-PS') || (type == '5-B'))
			{
				div2 = document.getElementById(id+'-2');
				div2.contentEditable = true;
				div2.style.border = "1px solid black";
			}
			a = document.getElementById(eid);
			a.innerHTML = "Save";
			a.setAttribute('onclick','save('+id+",'"+type+"')");
		}
		function save(id,type)
		{
			div = document.getElementById(id +'-1');
			div.contentEditable = false;
			div.style.border = "";
			txt1 = div.innerHTML;

			txt2='';
			if ((type == '3-PS') || (type == '5-B'))
			{
				div2 = document.getElementById(id +'-2');
				div2.contentEditable = false;
				div2.style.border = "";
				txt2 = div2.innerHTML;
			}

			$j.ajax({
		         url:'{{$root}}/edit-chapter',
		         data: {'id':id,
		          'txt1': txt1,
		          'txt2': txt2,
		          'chapterid': {{$chapter->id}},
		          '_token': '{!! csrf_token() !!}'},
		         type: "POST",
		         dataType: "html",
		         async:   true,
		         success: function(result) 
		         {
		         	// change backup original to new value
		         	div = document.getElementById(id +'-1');
		            span = document.getElementById(id +'-1o'); // backup original texg
		            span.innerHTML = div.innerHTML;
		            @if (($isuser) && ($user->level > 1))
		            	div.style.color = "blue";
		            @endif

					if ((type == '3-PS') || (type == '5-B'))
					{
						div2 = document.getElementById(id+'-2');
						span2 = document.getElementById(id+'-2o'); // backup original texg
						span2.innerHTML = div.innerHTML;
						@if (($isuser) && ($user->level > 1))
			            	div2.style.color = "blue";
			            @endif
					}
		         },
		         error: function( xhr, status)
		         {
		            alert('There was some error. Changes not saved');

		            // restore displayed text to backup original
		            div = document.getElementById(id +'-1');
		            span = document.getElementById(id +'-1o'); // backup original texg
		            div.innerHTML = span.innerHTML;

					if ((type == '3-PS') || (type == '5-B'))
					{
						div2 = document.getElementById(id+'-2');
						span2 = document.getElementById(id+'-2o'); // backup original texg
						div2.innerHTML = span2.innerHTML;
					}
		         },
		    });

			eid = "e-"+id;
			a = document.getElementById(eid);
			a.innerHTML = "Edit";
			a.setAttribute('onclick','edit('+id+",'"+type+"')");
		}
		var vm = new Vue({
			el: '#app',
			data: {
				nav: {
					// Zero indexed, for header
					current: {
						book: {{$chapter->book->id - 1}}, chapterid: {{$chapter->id}}
					},
					// Zero indexed, for nav
					selected: {
						book: {{$chapter->book->id - 1}}, chapterid: {{$chapter->id}}
					},
					all: {!!$booksJson!!}
				},
			},
			methods: {
				toggleNav: function() {
					const navElement = document.getElementById('nav-drop-real');
					const displayNow = navElement.style.display;
					if(displayNow === 'flex')
						navElement.style.display = "none";
					else
					{
						this.nav.selected.book = this.nav.current.book
						navElement.style.display = "flex";
					}
				},
				gotoChapter(id) {
                	window.location.href = id;
			    },
			}
		})
	</script>
</body>
</html>