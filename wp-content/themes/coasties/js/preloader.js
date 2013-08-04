var App = {};
App.intervals = {};
App.timers = {};

(function() {
				
			// display preloader
			
			var self = this;
			var canvas = null;
			var ctx = null;

			var frame = 0;
			var frameCounter = 0;
			var X_OFFSET = 0;
			var Y_OFFSET = 0;
			var FRAME_WIDTH = 270;
			var FRAME_HEIGHT = 270;
			var TOTAL_FRAMES = 130;
			var FRAMES_PER_ROW = 15;
			var LOOP_FRAME = 80;

			var INITIAL_DELAY = 25; // frames

			var preloaderImage = new Image();      
			preloaderImage.onLoad = initCanvas();
			preloaderImage.src = "./img/coast.png";

			App.timers.preloadTime = (new Date()).getTime();

			// create canvas

			function initCanvas(){

				canvas = document.createElement('canvas');
				var preloaderContainer = document.getElementById('preloader-container');
				preloaderContainer.appendChild(canvas);

				canvas.id = 'preloader-canvas';
				canvas.width = FRAME_WIDTH;
				canvas.height = FRAME_HEIGHT;

				ctx = canvas.getContext("2d");
				var frameDelay = 1000/50;
				
				App.intervals.siteLoader = setInterval(animatePreloader, frameDelay);        

				animatePreloader();

				// load main site library

				console.log('derpin');
			}

			function animatePreloader(){

					if(frameCounter > INITIAL_DELAY){

						var frameRow = parseInt(frame / FRAMES_PER_ROW);
						var frameCol = frame % FRAMES_PER_ROW;

						var x = clipX = frameCol * FRAME_WIDTH;
						var y = clipY = frameRow * FRAME_HEIGHT;
						var width = clipWidth = FRAME_WIDTH;
						var height = clipHeight = FRAME_HEIGHT;

						clipX += X_OFFSET;
						clipY += Y_OFFSET;
						
						if(preloaderImage.src){
							ctx.clearRect(0, 0, canvas.width, canvas.height);
							ctx.drawImage(preloaderImage, clipX, clipY, clipWidth, clipHeight, 0, 0, width, height);
						}

						if(frame >= TOTAL_FRAMES){ frame = LOOP_FRAME; }
						else { frame++; }
				}

				frameCounter++;
			}

}).call(this);