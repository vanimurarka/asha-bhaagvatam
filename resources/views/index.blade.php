<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bhaagavatam First Step</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="js/verse.js"></script>
	<script type="text/javascript" src="js/vue.min.js"></script>
	<style>
		body {
			background-color: #0081A7;
		}
		#header-container {
			background-color: #F2863F;
			padding: 0.5em;
            margin-bottom: 2em;
            position: sticky;
            top: 0;
            z-index: 10;
		}
        .book {
            padding: 0.8em;
            display: inline-block;
        }
        .book:hover {
            text-decoration: underline;
            cursor: pointer;
        }
		.nav-selected {
			font-weight: bold;
		}
		.chapter:hover {
			text-decoration: underline;
            cursor: pointer;
		}
		#content {
			background-color: #F2863F;
            margin-bottom: 2em;
		}
	</style>
</head>
<body>
    <div class="text-center" id="header-container">
        <div class="col"><h4>Bhaagavatam First Step</h4></div>
    </div>
    <div class="container" id="app">
        <div class="row">
            <!-- Visible on md and above, two column layout -->
            <div class="d-none d-md-block col-md-6">
                <img src="images/bg3.jpg" style="max-height: 90vh; max-width: 100%; position: sticky; top: 5em;">
            </div>
            <div class="col-xs-12 col-md-6 text-center" id="content">
                <!-- Visible below md, for single column layout -->
                <div class="d-md-none col-12 text-center">
                    <img src="images/bg3.jpg" style="max-height: 90vh; max-width: 100%">
                </div>
                <br>
                <!-- div class="col-12 text-center">
                    <span> Introduction </span> | 
                    <span> About the Website </span>
                </div -->
                <br>
                <hr>
                <div class="col-12">
                    <div v-for="(book, index) in nav.all" @click="nav.selected.book = index" class="book col-4" :class="{'nav-selected': index === nav.selected.book}">
                        @{{book.nameE}}
                    </div>
                </div>
                <hr>
                <div class="col-12">
                    <div class="col-6 col-lg-4 text-center chapter" v-for="chapter in nav.all[nav.selected.book].chapters" @click="gotoChapter(chapter.id)" style="display: inline-block;">
                        Chapter @{{chapter.nameE}}
                    </div>
                </div>
                <hr>
                <!-- div class="col-12 text-center">
                    Feedback |  @if (Route::has('login')) <a href="{{ route('login') }}">Login</a> @endif
                </div -->
                <br>
            </div>
        </div>
    </div>

	<script type="text/javascript">		
		var vm = new Vue({
			el: '#app',
			data: {
				nav: {
					// Zero indexed, for nav
					selected: {
						book: 0, chapter: 0
					},

					all: {!!$json!!}
				}
			},
            methods: {
                gotoChapter(id) {
                	window.location.href = 'chapter/'+id;
			    }
            }
		})
	</script>
</body>
</html>