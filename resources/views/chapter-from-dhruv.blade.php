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
			text-align: center;
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
                @switch($line->type)
                	@case('2-CT')
                		{{$line->text1}}<br><br>
                		@break
                	@case('3-CT')
                		{{$line->text1}}<br><br>
                		@break
                	@case('3-PS')
                		{{$line->text1}} -- {{$line->text2}}<br>
                		@break
                	@case('4-S')
						<b>{{$line->text1}}</b>
						<br>
						@break
                	@case('5-B')
                		@if ($line->lineNumber == 1)<br>@endif
                		<div>
                		<div style="display: inline-block;width: 49%;vertical-align: top">{{$line->text1}}</div>
                		<div style="display: inline-block;width: 49%;vertical-align: top">{{$line->text2}}</div>
                		</div>
                		@break                	
                	@case('6-E')
                		<br>
                		{{$line->text1}}<br><br>
                		@break
                	@default
        				{{$line->text1}}<br>
                @endswitch
            @endforeach
		</div>
	</div>

	<script type="text/javascript">		
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