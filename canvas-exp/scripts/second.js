(function(doc){
	var width=0, height = 0,num = 0;
	var canvas, ctx;

	var rows = [];
	var rowXs = [0,0,0];
	var rowYs = [0,80,160];
	var rowHeight = rowYs[1];
	var oneWidth = rowYs[1];
	var vel = 0.5;
	var dir = 1;
	var disPort = 4;
	var numRows = 3;
	var offset = 0;
	var r1x = 0;


	rows.push([]);
	rows.push([]);
	rows.push([]);

	function getJPG(folder,name){
		var jpg = new Image();
		jpg.src = 'images/'+folder+'/'+name+'.jpg';
		//console.log(jpg.src);
		return jpg;
	}

	function getRow(name,num,row){
		for(var x = 0;x<num;x++){
			rows[row].push(getJPG(name,x+1));
		}
	}

	var width, height;

	$(doc).ready(
		function(){
			canvas = document.getElementById('canvas');
			height = rowHeight*numRows;
			canvas.height = height;
			ctx = canvas.getContext('2d');
			ctx.canvas.width  = oneWidth*disPort;//window.innerWidth;
			ctx.canvas.height = height;
			width = ctx.canvas.width;

			init();

			var loop = function(){
				update();
				draw();

				window.requestAnimationFrame(loop,canvas);
			};

			window.requestAnimationFrame(loop,canvas);
		});

	function init(){
		getRow('rings',9,0);
		getRow('rings',9,1);
		getRow('rings',9,2);
		offset = width - rows[1].length*oneWidth; 
		rowXs[1] = offset;

	}


	function update(){
		//console.log('width: '+width+' height: '+height);
		//ctx.canvas.width  = window.innerWidth;
		//width = ctx.canvas.width;
		//if(rowXs[0]>0 || rowXs[0]<offset) dir*=-1;
		//rowXs[1] = rowYs[0] +(vel*dir);
		//rowXs[0] = rowXs[2] = rowXs[0] -(vel*dir);
		rowXs[0] = rowXs[0] - (vel*dir);
		rowXs[1] = rowXs[1] + (vel*dir);
		rowXs[2] = rowXs[2] - (vel*dir);

		if(rowXs[0] < offset || rowXs[0]>0)dir*=-1;

	}

	function drawImg(image,x,y){
		ctx.drawImage(image,x,y,oneWidth,rowHeight);
	}

	function draw(){
		ctx.fillStyle = '#fff';
		ctx.fillRect(0,0,width,height);
		ctx.save();//
		
		for(var b = 0; b<numRows;b++){
			for(var a = 0;a<rows[0].length;a++){
				drawImg(rows[b][a],a*oneWidth + rowXs[b],rowYs[b]);
			}
		}
		//ctx.drawImage(image,imgdet.x,imgdet.y,200,150);



		ctx.restore();
	}

})();