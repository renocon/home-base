(function(window){
	
	$(document).ready(function(){


		var objGotten;
		var keystate = {};

		document.addEventListener("keydown",function(evt){
			keystate[evt.keyCode] = true;

		});

		document.addEventListener("keyup",function(evt){
			//console.log(evt);
			delete keystate[evt.keyCode];
			//console.log(objGotten);
		});

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

		var scene = new THREE.Scene();
		var camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

		var renderer = new THREE.WebGLRenderer();
		renderer.setSize( window.innerWidth, window.innerHeight );
		document.body.appendChild( renderer.domElement );

		var geometry = new THREE.BoxGeometry( 1, 1, 1 );
		var material = new THREE.MeshBasicMaterial( { color: 0xB39EB5 } );
		material.wireframe = true;
		// var material = new THREE.MeshLambertMaterial({
		//         map: THREE.ImageUtils.loadTexture('images/moon.jpg')
		//       });
		var cube = new THREE.Mesh( geometry, material );
		//scene.add( cube );


		var manager = new THREE.LoadingManager();
		// instantiate a loader
		var loader = new THREE.OBJLoader(manager);
		//var loader = new THREE.JSONLoader();
		// load a resource
		loader.load(
			// resource URL
			//'http://utt-renocon.rhcloud.com/api/objects/1',
			'http://utt-renocon.rhcloud.com/api/objects/1',
			// Function when resource is loaded
			function ( object ) {
				//object.material = material;
				object.traverse(function (child) {
				objGotten = object;
	            if (child instanceof THREE.Mesh) {
	                child.material = material;
		            }

		        });
				//console.log(object);
				scene.add( object );
				//object.position.x = object.position.y = 10;
			}
			// function ( geometry, materials ) {
			// 	var material = new THREE.MeshFaceMaterial( materials );
			// 	var object = new THREE.Mesh( geometry, material );
			// 	scene.add( object );
			// }
		);

		camera.position.z = 64;
		//camera.position.y = 16;
		//camera.position.x = 16;

		//console.log(camera.rotation);

		function render() {
			updateCam();
			requestAnimationFrame( render );
			renderer.render( scene, camera );


			//cube.rotation.x += 0.1;
			//cube.rotation.y += 0.1;
		}
		render();
		console.log('ok');
	});
})(this);