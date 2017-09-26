var width=700, height = 600, pi=Math.PI, upA = 38,downA = 40;
		var canvas, ctx, keystate;
		var player, ai, ball;

		var image,
			imgdet= {
				x : 0,
				y : 0
			};
		var	dir = 1;

		function main(){
			canvas = document.getElementById('canvas');
			canvas.width = width;
			canvas.height = height;
			ctx = canvas.getContext('2d');

			init();

			var loop = function(){
				update();
				draw();

				window.requestAnimationFrame(loop,canvas);
			};

			window.requestAnimationFrame(loop,canvas);
		}

		function init(){
			image = new Image();
			image.src="../img/bg2.jpg"
			imgdet.x = 0;
			imgdet.y = 0;


		}


		function update(){
			imgdet.x+=(dir);
			//console.log(imgdet.x);
			//image.y+=5;
			if(imgdet.x< 0 || imgdet.x> width-200) dir*=-1;
			ctx.canvas.width  = window.innerWidth;
			width = ctx.canvas.width;
			//console.log('update');
		}

		function draw(){
			ctx.fillStyle = '#fff';
			ctx.fillRect(0,0,width,height);
			ctx.save();
			

			ctx.drawImage(image,imgdet.x,imgdet.y,200,150);



			ctx.restore();
		}