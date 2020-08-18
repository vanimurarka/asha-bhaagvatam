<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bhaagavatam First Step</title>
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('js/verse.js') }}"></script>
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
				<div class="col"><h4>Bhaagavatam First Step</h4></div>
			</div>
			<div class="row no-gutters">
				<!-- div class="col text-right"><a href="#">Prev Chapter</a></div -->
				<div class="col text-center" @click="toggleNav" id="nav-current">
					<!-- Hamburger: &#9776; Down Arrow: &#x25BC; -->
					&#9776; {{$chapter->book->nameE}} Chapter {{$chapter->nameE}}
				</div>
				<!-- div class="col text-left"><a href="#">Next Chapter</a></div -->
			</div>
			<!--div id="nav-drop">
				<div class="row no-gutters text-center justify-content-center" id="nav-drop-real" style="display: none">
					<div class="col">
						<div v-for="(chapters, index) in nav.data" @click="nav.selected.book = index" :class="{'nav-selected': index === nav.selected.book}">
							Book @{{index + 1}}
						</div>
					</div>
					<div class="col">
						<div v-for="(n, index) in nav.data[nav.selected.book]" :class="{'nav-selected': index === nav.selected.chapter}">
							Chapter @{{index + 1}}
						</div>
					</div>
				</div>
			</div -->
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
			<!-- div class="row verse text-center" v-for="verse in verseData">
				<div class="col">
					<div v-for="line in verse.hindiPara">
						@{{line}}
					</div>
					<br>
				</div>
				<div class="w-100"></div>
				<div class="col table-responsive table-borderless table-sm">
					<table class="table">
						<tbody>
							<tr v-for="line in verse.lines">
								<td class="">@{{line[0]}}</td>
								<td class="">@{{line[1]}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="w-100"></div>
				<div class="col">@{{verse.englishPara}}</div>
				<div class="w-100"><br></div>
			</div -->
		</div>
	</div>

	<script type="text/javascript">		
		var vm = new Vue({
			el: '#app',
			data: {
				nav: {
					// Number of chapters in each book
					data: [11, 12, 13, 14, 15],
					// Zero indexed, for header
					current: {
						book: 2, chapter: 6
					},
					// Zero indexed, for nav
					selected: {
						book: 2, chapter: 6
					}
				},
				verseData: [
					verse1, verse2, verse3, verse4, verse5
				]
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
			}
		})
	</script>
</body>
</html>