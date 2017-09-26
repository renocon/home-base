<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Warren Pong JS</title>
</head>
<body onload='main()'>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<?php include_once("gana.php"); ?>
	<script>
		var width=700, height = 600, pi=Math.PI, upA = 38,downA = 40;
		var canvas, ctx, keystate;
		var player, ai, ball;

		player = {
			x:null,
			y:null,
			width:20,
			height:100,
			update: function(){

				if(keystate[upA]){
					this.y -= 7;
				}

				if(keystate[downA]){
					this.y+=7;
				}

				if(this.y<0) this.y = 0;
				if(this.y+this.height>height) this.y = height - this.height;
			},
			draw: function(){

				ctx.fillRect(this.x,this.y,this.width,this.height);
			}
		}
		ai = {
			x:null,
			y:null,
			width:20,
			height:100,
			update: function(){
				var dest = ball.y - (this.height - ball.width)/2;
				this.y += (dest - this.y) * 0.1;

				if(this.y<0) this.y = 0;
				if(this.y+this.height>height) this.y = height - this.height;
			},
			draw: function(){

				ctx.fillRect(this.x,this.y,this.width,this.height);
			}
		}

		ball = {
			x:null,
			y:null,
			width:20,
			height:20,
			speed:12,
			update: function(){

				this.x += this.vel.x;
				this.y += this.vel.y;

				if(this.y < 0 || this.y+this.width > height){
					var offset = this.vel.y < 0 ? 0-this.y : height- (this.y+this.width);
					this.y+=(2*offset);
					this.vel.y*=-1;
				} 

				var AABBIntersect = function(ax,ay,aw,ah,bx,by,bw,bh){
					return ax<bx+bw && ay<by+bh && bx<ax+aw && by<ay+ah;
				};
				var paddle = this.vel.x < 0 ? player: ai;
				if(AABBIntersect(paddle.x,paddle.y,paddle.width,paddle.height,this.x,this.y,this.width,this.height)){
					this.x = paddle === player ? player.x +player.width : ai.x-this.width;
					
					var n = (this.y+this.width - paddle.y)/(paddle.height+this.width);
					var phi = 0.25*pi*(2*n- 1);
					var smash = Math.abs(phi)> 0.2*pi ? 1.5 : 1;

					this.vel.x = smash*(paddle===player ? 1 :-1)*this.speed*Math.cos(phi);
					this.vel.y = smash*this.speed*Math.sin(phi);
				}

				if(this.x+this.width < 0 || this.x>width){
					ball.x = (width - ball.width)/2;
					ball.y = (height - ball.width)/2;
					ball.vel = {
						x: ball.speed,
						y: 0
					}
				}

			},
			draw: function(){

				ctx.fillRect(this.x,this.y,this.width,this.height);
			}
		}

		function main(){
			canvas = document.getElementById('canvas');
			canvas.width = width;
			canvas.height = height;
			ctx = canvas.getContext('2d');
			//document.body.appendChild(canvas);

			keystate = {};

			document.addEventListener("keydown",function(evt){
				keystate[evt.keyCode] = true;
			});

			document.addEventListener("keyup",function(evt){
				delete keystate[evt.keyCode];
			});

			init();

			var loop = function(){
				update();
				draw();

				window.requestAnimationFrame(loop,canvas);
			};

			window.requestAnimationFrame(loop,canvas);
		}

		function init(){
			player.x = player.width;
			player.y = (height - player.height)/2;

			ai.x = width - (player.width + ai.width);
			ai.y = (height - ai.height)/2;
			
			ball.x = (width - ball.width)/2;
			ball.y = (height - ball.width)/2;
			ball.vel = {
				x: ball.speed,
				y: 0
			}

		}


		function update(){
			ball.update();
			player.update();
			ai.update();
		}

		function draw(){
			ctx.fillRect(0,0,width,height);
			ctx.save();
			ctx.fillStyle = '#fff';


			ball.draw();
			player.draw();
			ai.draw();

			var w = 4;
			var x = (width - w)*0.5;
			var y = 0;
			var step = height/15;

			while(y < height){
				ctx.fillRect(x, y + step*0.25,w,step*0.5);
				y+=step;
			}

			ctx.restore();
		}
	</script>
	<div class="container"><a href="/">Home base</a></div>
	<div class="container">
		<canvas id='canvas' class='container canvas' style='height:600px;width:700px;'></canvas>	
	</div>
	
</body>
</html>