<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<title>TT Shape Blender</title>
	
	<script src="js/jquery.js"></script>


	<script src="js/three.min.js"></script>
	<script src="js/three/src/loaders/OBJLoader.js"></script>
	<script src="js/three/src/loaders/MTLLoader.js"></script>
	<script src="js/three/src/loaders/OBJMTLLoader.js"></script>
	<script src="js/three/src/materials/MeshLambertMaterial.js"></script>
	<script src="js/three/src/materials/MeshBasicMaterial.js"></script>
	<script src="js/three/src/materials/MeshDepthMaterial.js"></script>
	<script src="js/three/examples/js/exporters/OBJExporter.js"></script>
	<script src="js/three/examples/js/renderers/Projector.js"></script>
	<script src="js/three/src/core/Raycaster.js"></script>

	<script src='js/three/examples/js/libs/dat.gui.min.js'></script>
	<script src="//js.leapmotion.com/leap-0.6.3.min.js"></script>
	<?php include_once("gana.php"); ?>
	<!--<script type="x-shader/x-vertex" id="vertexShader">

		varying vec3 vWorldPosition;

		void main() {

			vec4 worldPosition = modelMatrix * vec4( position, 1.0 );
			vWorldPosition = worldPosition.xyz;

			gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );

		}

	</script>-->


	<!--<script type="x-shader/x-fragment" id="fragmentShader">

		uniform vec3 topColor;
		uniform vec3 bottomColor;
		uniform float offset;
		uniform float exponent;

		varying vec3 vWorldPosition;

		void main() {

			float h = normalize( vWorldPosition + offset ).y;
			gl_FragColor = vec4( mix( bottomColor, topColor, max( pow( max( h , 0.0), exponent ), 0.0 ) ), 1.0 );

		}

	</script>-->


	<script>
		var scaleX=0,scaleY=0,ScaleZ=0;
		var rotVar = Math.PI * 2;
		var objGotten;
		var exporter, scene, camera;
		var keystate = {}
			mousestate = false;
		var width = 870,
			height = 600,
			far = 900,
			near = 75;

		var movefactor = 100;	

		var canvas;
		var mouseX,mouseY;

		var tX = 1,tY = 2,tZ = 3, tO = 0, tranState = 0;

		var projector,
			mouse_vector,
			mouse,
			ray,
			intersects,
			renderer;

		var ptarray;

		var gui;	
		var params = {
			    wval: 50,
			    hval:50,
			    lval:50,
			    material:'wood',
			    posx:0,
			    posy:0,
			    posz:0,
			    rotx:0,
			    roty:0,
			    rotz:0,
			    cam:0
			};

		function enableListeners(){
			document.addEventListener("keydown",function(evt){
				//keystate[evt.keyCode] = true;

			});

			document.addEventListener("keyup",function(evt){
				//console.log(evt);
				//delete keystate[evt.keyCode];
				//console.log(objGotten);
			});



			//$('#model-area').mousedown(function(evt){
			$('canvas').mousedown(function(evt){	
				//evt.preventDefault();
				mousestate = true;
				mouseX = evt.clientX;
				mouseY = evt.clientY;
				// //console.log(evt);

				// //tutorial stuff
				// mouse.x = (evt.clientX/window.innerWidth)*2 + 1;
				// mouse.y = (evt.clientY/window.innerHeight)*2 + 1;

				// mouse_vector.set(mouse.x,mouse.y,mouse.z);
				// //console.log(mouse_vector);
				// //projector.unprojectVector(mouse_vector,camera);
				// mouse_vector.unproject(camera);
				// var direction = mouse_vector.sub( camera.position ).normalize();
				// ray.set( camera.position, direction );
				//console.log(ray);
				//intersects = ray.intersectObject( scene , true );
				//console.log(intersects);
				// if(interescts && intersects.length && intersects.length > 0){
				// 	alert('hit');
				// }
			});

			//$('#model-area').mouseup(function(evt){
			$('canvas').mouseup(function(evt){
				evt.preventDefault();
				mousestate = false;
				tranState = 0;
			});

			$('canvas').mousemove(function(evt){
				//console.log(evt);
				if(!mousestate) return;
				//evt.preventDefault();

				var difx, dify;

				difx = evt.clientX - mouseX;
				dify = evt.clientY - mouseY;

				mouseX = evt.clientX;
				mouseY = evt.clientY;
				//console.log(difx,dify,mouseX,mouseY);

				//console.log("difx: "+ difx);
				//console.log("dify: "+ dify);

				//objGotten.rotation.y+=(difx/movefactor);

				if(Math.abs(difx) - Math.abs(dify) > 0 && tranState==tO){
					tranState = tX;
				}else if(Math.abs(difx) - Math.abs(dify) < 0 && tranState==tO){
					tranState = tY;
				}else{

				}
				//objGotten.rotation.z+=((difx/movefactor)*(dify/movefactor));
				//if(tranState == tX) objGotten.position.x+=(difx/movefactor);
				//if(tranState == tY) objGotten.position.y-=(dify/movefactor);

				//if(tranState == tX) 

				// console.log("before");
				// console.log(objGotten.rotation);
					objGotten.rotation.z-=(difx/movefactor);
					if(objGotten.rotation.z < 0) objGotten.rotation.z+= (Math.PI*2);
					if(objGotten.rotation.z >= Math.PI*2) objGotten.rotation.z = objGotten.rotation.z%(Math.PI*2);
				//if(tranState == tY) 
					objGotten.rotation.x+=(dify/movefactor);
					if(objGotten.rotation.x < 0) objGotten.rotation.x+= (Math.PI*2);
					if(objGotten.rotation.x >= Math.PI*2) objGotten.rotation.x = objGotten.rotation.x%(Math.PI*2);

				//if(tranState == tX) objGotten.position.x+=(difx/movefactor);//scene.position.x+=(difx/movefactor);
				//if(tranState == tY) objGotten.position.y-=(dify/movefactor);//scene.position.y-=(dify/movefactor);
				// console.log("after");
				// console.log(objGotten.rotation);

				//more complex math
				// if(scene.rotation.x >= 0 && scene.rotation.x <rotVar/4){
				// 	if(tranState == tX) objGotten.position.x+=(difx/movefactor);
				// }else if(scene.rotation.x >= rotVar/4 && scene.rotation.x <(rotVar/4)*2){
				// 	if(tranState == tX) objGotten.position.z+=(difx/movefactor);
				// }else if(scene.rotation.x >= (rotVar/4)*2 && scene.rotation.x <(rotVar/4)*3){
				// 	if(tranState == tX) objGotten.position.x+=(difx/movefactor);
				// }else{
				// 	if(tranState == tX) objGotten.position.z+=(difx/movefactor);
				// }

				// if(scene.rotation.y >= 0 && scene.rotation.y <rotVar/4){
				// 	if(tranState == tY) objGotten.position.y-=(dify/movefactor);
				// }else if(scene.rotation.y >= rotVar/4 && scene.rotation.y <(rotVar/4)*2){
				// 	if(tranState == tY) objGotten.position.z-=(dify/movefactor);
				// }else if(scene.rotation.y >= (rotVar/4)*2 && scene.rotation.y <(rotVar/4)*3){
				// 	if(tranState == tY) objGotten.position.y-=(dify/movefactor);
				// }else{
				// 	if(tranState == tY) objGotten.position.z-=(dify/movefactor);
				// }


				// params.posx = objGotten.position.x;
				// params.posy = objGotten.position.y;
				// params.posz = objGotten.position.z;
				    params.rotx = objGotten.rotation.z;
					params.roty = objGotten.rotation.x;
					//params.rotz = objGotten.rotation.z;
			});

			function minCam(x){
				if (x < near) return near;
				else return x;
			}

			function maxCam(x){
				var y = 300;
				if(x  > far-y) return far-y;
				else return x;
			}

			$( '.scrollable' ).bind( 'mousewheel DOMMouseScroll', function ( e ) {
				//console.log('scroll');
				//console.log(e);
				e.preventDefault();
				var u = null;
			    if(e.originalEvent)u = e.originalEvent;
			    else u = false;
			    //console.log(u);


			    var mf = 20;
			    //if(!u.ctrlKey && !u.altKey){
				    // scene.rotation.y = ((scene .rotation.y + (u.deltaX/mf))%rotVar);
				    // if(scene.rotation.y<0) scene.rotation.y = rotVar+scene.rotation.y;
				    // scene.rotation.x = ((scene.rotation.x + (u.deltaY/mf))%rotVar);
				    // if(scene.rotation.x<0) scene.rotation.x = rotVar+scene.rotation.x;

				    //console.log(scene.rotation.y);
				//}
				// else if(u.ctrlKey){
					var delta = 0;

					if(u && u.deltaY){
						delta = u.deltaY;
					} else if(u && u.wheelDelta){
						delta = u.wheelDelta/(mf*-1);
					}else if(u && u.detail){
						delta = u.detail;
					}

					//console.log(delta);
					//delta = maxCam(delta);
					//delta = minCam(delta);

				 	camera.position.z+= delta;

				 	camera.position.z = maxCam(camera.position.z);
				 	camera.position.z = minCam(camera.position.z);

				 	params.cam = camera.position.z;
				// }
				// else if(u.altKey){
				// 	objGotten.rotation.y+=u.deltaX/mf;
				//     objGotten.rotation.x+=u.deltaY/mf;

				//     if(objGotten.rotation.y >rotVar)objGotten.rotation.y = ((objGotten .rotation.y + (u.deltaX/mf))%rotVar);
				//     if(objGotten.rotation.y<0) objGotten.rotation.y = rotVar+objGotten.rotation.y;
				//     if(objGotten.rotation.x >rotVar)objGotten.rotation.x = ((objGotten.rotation.x + (u.deltaY/mf))%rotVar);
				//     if(objGotten.rotation.x<0) objGotten.rotation.x = rotVar+objGotten.rotation.x;

				
				// }
				//console.log(scene.rotation);

					});


		}

		function updateCam(){
			//up down
			if(keystate[38]) objGotten.rotation.x+=0.02;
			if(keystate[40]) objGotten.rotation.x-=0.02;

			//left right
			if(keystate[37]) objGotten.rotation.y+=0.02;
			if(keystate[39]) objGotten.rotation.y-=0.02;

			//other
			if(keystate[188]) objGotten.position.z+=0.7;
			if(keystate[190]) objGotten.position.z-=0.7;

			
		}	

		function light(){
			var ambient = new THREE.AmbientLight( 0xffffff );
			scene.add( ambient );

			// var light = new THREE.PointLight(0xffffff/*,1,100*/);
	  //       light.position.set(450, 450, 450);
	  //       light.castShadow = true;
	  //       light.shadowDarkness = 0.8;
	  //       light.shadowCameraVisible = true;

	  //       light.shadowCameraRight     =  5;
			// light.shadowCameraLeft     = -5;
			// light.shadowCameraTop      =  5;
			// light.shadowCameraBottom   = -5;
			// // light.target = objGotten;
	  //       scene.add(light);
	  //       console.log(light);

	        var spotLight = new THREE.PointLight( 0xffffff );
			spotLight.position.set( far,far,far);

			//spotLight.castShadow = true;

			spotLight.shadowMapWidth = 1024;
			spotLight.shadowMapHeight = 1024;

			spotLight.shadowCameraNear = 500;
			spotLight.shadowCameraFar = 4000;
			spotLight.shadowCameraFov = 30;
			//spotLight.shadowMap.enabled = true;
			//spotLight.shadowCameraVisible = true;

			scene.add( spotLight );

			// var sunIntensity = 0.3,
			// 	pointIntensity = 1,
			// 	pointColor = 0xffaa00;

			// if ( true ) {

			// 	sunIntensity = 1;
			// 	pointIntensity = 0.5;
			// 	pointColor = 0xffffff;

			// }

			// var ambientLight = new THREE.AmbientLight( 0xffffff );
			// scene.add( ambientLight );

			// var pointLight = new THREE.PointLight( 0xffaa00, pointIntensity, 5000 );
			// pointLight.position.set( 0, 0, 0 );
			// scene.add( pointLight );

			// var sunLight = new THREE.SpotLight( 0xffffff, sunIntensity, 0, Math.PI/2, 1 );
			// sunLight.position.set( 1000, 2000, 1000 );

			// sunLight.castShadow = true;

			// sunLight.shadowDarkness = 0.3 * sunIntensity;
			// sunLight.shadowBias = -0.0002;

			// sunLight.shadowCameraNear = 750;
			// sunLight.shadowCameraFar = 4000;
			// sunLight.shadowCameraFov = 30;

			// sunLight.shadowCameraVisible = false;

			// scene.add( sunLight );

			
		}	

		function addGUI(){
			var dim = gui.addFolder('Dimensions');
			var wcontrol = dim.add(params, 'wval').min(1).max(200).step(1).name('Width');
			var hcontrol = dim.add(params, 'hval').min(1).max(200).step(1).name('Height');
			var lcontrol = dim.add(params, 'lval').min(1).max(200).step(1).name('Length');

			dim.open();

			wcontrol.onChange(function(val){
				objGotten.scale.x = val;
			});
			hcontrol.onChange(function(val){
				objGotten.scale.y = val;
			});
			lcontrol.onChange(function(val){
				objGotten.scale.z = val;
			});

			var mat = gui.addFolder('Material');
			var mcontrol = mat.add(params,'material',['wood','metal']).name('Material');

			mat.open();

			mcontrol.onChange(function(val){
				//console.log(val);
				//console.log(params);
				textureObject(objGotten,loadMaterial(val));
			});

			var meta = gui.addFolder('Live Meta Data');
			meta.open();

			//position
			// params.posx = objGotten.position.x;
			// params.posy = objGotten.position.y;
			// meta.add(params,'posx').name('Position X').listen();
			// meta.add(params,'posy').name('Position Y').listen();
			//meta.add(params,'posz').name('Position Z').listen();

			//rotation
			params.rotx = objGotten.rotation.x;
			params.roty = objGotten.rotation.z;
			meta.add(params,'rotx').name('Rotation X').listen();
			meta.add(params,'roty').name('Rotation Y').listen();
			//meta.add(params,'rotz').name('Rotation Z').listen();
			meta.add(params,'cam').min(near).max(far-300).step(1).name('Camera').listen().onChange(function(val){
				camera.position.z = val;
			});;


		}

		function loadMaterial(name){
			var texture = THREE.ImageUtils.loadTexture(name+'.jpg');
			texture.minFilter = THREE.NearestFilter;
			
        	return new THREE.MeshPhongMaterial({map: texture}/*{color:0x00ff00}*/);
		}

		function textureObject(object,texture){
			//if(object.map) object.map = texture;
			if(object.material) object.material = texture;
			object.traverse(function (child) {
				
	            if (child instanceof THREE.Mesh) {
	                child.material = texture;
		            }

		        });

		}



		window.addEventListener( 'resize', function () {

			var MARGIN = 0;
			var SCREEN_WIDTH = window.innerWidth;
			var SCREEN_HEIGHT = window.innerHeight - 2 * MARGIN;

			camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
			camera.updateProjectionMatrix();

			renderer.setSize( SCREEN_WIDTH, SCREEN_HEIGHT );

			
		}, false );

		function handlePreview(filename){
			
			scene = new THREE.Scene();
			camera = new THREE.PerspectiveCamera( near, window.innerWidth/window.innerHeight, 0.1, far );//new THREE.PerspectiveCamera( 75, width/height, 0.1, 2500 );
			//camera = new THREE.OrthographicCamera( width/-4,width/4,height/4,height/-4,near, far );//new THREE.PerspectiveCamera( 75, width/height, 0.1, 2500 );
			console.log(camera);
			camera.castShadow = camera.receiveShadow =  true;

			renderer = new THREE.WebGLRenderer();
			renderer.shadowMap.enabled = true;
			
			renderer.setSize( window.innerWidth, window.innerHeight );
			$('body').append( renderer.domElement );
			gui = new dat.GUI();
			
			
			enableListeners();

			var geometry = new THREE.BoxGeometry( 1, 1, 1 );


			var manager = new THREE.LoadingManager();
			var loader = new THREE.OBJLoader(manager);

			light();
			//console.log(scene);

			// projector = new THREE.Projector();
			// mouse_vector = new THREE.Vector3();
			// mouse = { x: 0, y: 0, z: 1 };
			// ray = new THREE.Raycaster( new THREE.Vector3(0,0,0), new THREE.Vector3(0,0,0) );
			
			// intersects = [];


			

			//Grid

			// var size = 500, step = 100;

			// var ggeometry = new THREE.Geometry();

			// for ( var i = - size; i <= size; i += step ) {

			// 	ggeometry.vertices.push( new THREE.Vector3( - size, 0, i ) );
			// 	ggeometry.vertices.push( new THREE.Vector3(   size, 0, i ) );

			// 	ggeometry.vertices.push( new THREE.Vector3( i, 0, - size ) );
			// 	ggeometry.vertices.push( new THREE.Vector3( i, 0,   size ) );

			// }



			// var gmaterial = new THREE.LineBasicMaterial( { color: 0xffffff, opacity: 0.0 } );

			// var gline = new THREE.LineSegments( ggeometry, gmaterial );
			// scene.add( gline );

			loader.load(
				filename,//'char.obj',
				// Function when resource is loaded
				function ( object ) {
					object.children[0].geometry.computeBoundingSphere();
					object.children[0].geometry.computeBoundingBox();
					object.castShadow = true;
					object.receiveShadow = true;

					object.position.z = near*2;

					var box = new THREE.Box3().setFromObject( object );

					//console.log(object);
					var aimRadius = 200;
					var bsr = object.children[0].geometry.boundingSphere.radius;
					if (bsr>1000000) bsr = aimRadius;
					var scaleFactor = aimRadius/(bsr*2);
					object.scale.set(scaleFactor,scaleFactor,scaleFactor);
					// object.children[0].geometry.computeBoundingSphere();


					params.wval = scaleX = Math.ceil(object.scale.x);
					//console.log(scaleX);
					//console.log(params.wval);
					params.lval = scaleY = Math.ceil(object.scale.y);
					params.hval = scaleZ = Math.ceil(object.scale.z);
					objGotten = object;

					addGUI();

					
					ptarray= object.children[0].geometry.attributes.position.array;


					textureObject(object,loadMaterial(params.material));

			        // Load the background texture
			        // var texture = THREE.ImageUtils.loadTexture( 'blackbg.jpg' );
			        // texture.minFilter = THREE.LinearFilter;
			        // var backgroundMesh = new THREE.Mesh(
			        //     new THREE.PlaneGeometry(2, 2, 0),
			        //     new THREE.MeshBasicMaterial({
			        //         map: texture
			        //     }));

			        // backgroundMesh.material.depthTest = false;
			        // backgroundMesh.material.depthWrite = false;

			        // // Create your background scene
			        // var backgroundScene = new THREE.Scene();
			        // var backgroundCamera = new THREE.Camera();
			        // backgroundScene .add(backgroundCamera );
			        // backgroundScene .add(backgroundMesh );


					scene.add( object );
					function render() {
						
						updateCam();
						requestAnimationFrame( render );

						//renderer.autoClear = false;
            			//renderer.clear();
						//renderer.render( backgroundScene, backgroundCamera);
						renderer.render( scene, camera );

					}
					
					render();
					
				}


			);

			params.cam = camera.position.z = 400;

			//camera.position.y = 0;
			camera.position.x = 0;

			scene.position.x = 0;
			//scene.rotation.x = Math.PI*1.5;

			
			console.log('ok');

			var walls = new THREE.Object3D();	

			var bg = new THREE.BoxGeometry( far*far, far+100, 0 );
			//console.log(bg)
			var bm = new THREE.MeshPhongMaterial( { color: 0x7777777 } );
			//console.log(bm)
			var bc = new THREE.Mesh( bg,bm );
			bc.receiveShadow=true;
			bc.castShadow=true;
			//bc.position.y= 1;
			walls.children.push(bc);

			//var bg2 = new THREE.CylinderGeometry( far, far, far, 32, 1, true );
			var bg2 = new THREE.BoxGeometry( far*far, far+100, 0 );
			//console.log(bg)
			var bm2 = new THREE.MeshPhongMaterial( { color: 0x888888 } );
			//console.log(bm)
			var bc2 = new THREE.Mesh( bg2,bm2 );
			bc2.receiveShadow=true;
			bc2.castShadow=true;
			bc2.position.y = (far/2);
			console.log(bc2)


			walls.children.push(bc2);
			//walls.position.z = -500;
			//console.log(walls);
			//camera.position.z = 5;
			//walls.add(bc);

			scene.add(walls); 


			console.log(scene);
			scene.fog= new THREE.Fog(0xfffffff,near+150,far+150);

		}

		// Setup Leap loop with frame callback function
		var controllerOptions = {enableGestures: false};
		var X=0,Y=1,Z=2,temper=35;
		var controller = Leap.loop(controllerOptions, function(frame) {
		  // Body of callback function
		  //console.log(frame);

		  var hands = frame.hands;
		  if(hands.length > 0){
		  	//console.log(hands.length);
		  	//console.log(hands[0].pinchStrength);
		  	//console.log(hands[0].grabStrength);
		  	//console.log(hands[0].translation(controller.frame(1)));
		  	var delta = hands[0].translation(controller.frame(1));
		  	if(objGotten && hands[0].pinchStrength > 0.98 && grabStrength < 0.5){
		  		objGotten.rotation.y -=(delta[X]/temper);
		  		params.roty = objGotten.rotation.y;
		  		objGotten.rotation.x +=(delta[Y]/temper);
		  		params.rotx = objGotten.rotation.x;
		  	}
		  }

		  if(true){

		  }

		});


		$(document).ready(function(){

			var file = $('#filename').text();

			if(file.length < 3){
				$('body').append('No file selected');
				//return;
			}

			else handlePreview(file);
			
			// $('#btn-download').click(function(evt){
			
			// });

			// $('#height-control').change(function(evt){
			// 	console.log(evt);
			// 	var newnum = evt.originalEvent.target.valueAsNumber;
			// 	objGotten.scale.y = newnum; 
			// 	$('#height-num').text(Math.floor(newnum));
			// });

			// $('#width-control').change(function(evt){
			// 	console.log(evt);
			// 	var newnum = evt.originalEvent.target.valueAsNumber;
			// 	objGotten.scale.x = newnum; 
			// 	$('#width-num').text(Math.floor(newnum));
			// });

			// $('#depth-control').change(function(evt){
			// 	console.log(evt);
			// 	var newnum = evt.originalEvent.target.valueAsNumber;
			// 	objGotten.scale.z = newnum; 
			// 	$('#depth-num').text(Math.floor(newnum));
			// });


			console.log('loaded');
			console.log('ok ' + Math.PI);


			// setTimeout(function(){
			// 	move();
			// },1000);
		});

	
	</script>


	<style>

	body,html{
	    overflow: hidden;
	    padding:0px;
	    margin:0px;
	}


	</style>
</head>
<body id='body' class='scrollable'>
	<?php //var_dump($_GET); ?>
	<div id='filename' style='display:none'>
		<?php

			if(isset($_GET)){
				if(isset($_GET['file'])){
					echo $_GET['file'];
				}
			}
		?>
	</div>


		
</body>
</html>