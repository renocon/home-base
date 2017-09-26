<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>TT Shape Blender</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>

<!--	<script src="js/three/src/Three.js"></script>
	<script src="js/three/src/scenes/Scene.js"></script>
	<script src="js/three/src/loaders/Loader.js"></script>
	<script src="js/three/src/loaders/ObjectLoader.js"></script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js"></script>
	<script src="http://threejs.org/examples/js/loaders/OBJLoader.js"></script>
	<script src="js/three/src/materials/MeshLambertMaterial.js"></script>
	<script src="js/three/src/materials/MeshBasicMaterial.js"></script>
	<?php include_once("gana.php"); ?>
	<script>
		(function(window){

			var width = 200, height = 200;



			function addObjCanvas(data,el){
				var name = data[el];
				var element = "<div class='col-xs-3 wpanel' id='"+name+"'><div class='col-xs-12'>"+name+"</div><img style='height:200;width:200px'src='dataset/"+name+"/"+name+".png'></div>";
				
				$('#model-area').append(element);
				return;	
				var scene = new THREE.Scene();
				var camera = new THREE.PerspectiveCamera( 75, width/height, 0.1, 1000 );

				var renderer = new THREE.WebGLRenderer();
				renderer.setSize( width, height );
				$('#'+name).append( renderer.domElement );

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
				
				
				loader.load(
						// resource URL
						'dataset/'+name+'/'+name+'.obj',
						//'http://localhost:3000/api/objects/1',
						// Function when resource is loaded
						function ( object ) {
							//object.material = material;
							object.traverse(function (child) {
							og2 = object;
				            if (child instanceof THREE.Mesh) {
				                child.material = material;
					            }

					        });
							console.log(object);
							object.scale.set(0.01,0.01,0.01);
							object.position.x = 200;
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
					camera.position.x = 100;

					//console.log(camera.rotation);

					function render() {
						//updateCam();
						requestAnimationFrame( render );
						renderer.render( scene, camera );


						//cube.rotation.x += 0.1;
						//cube.rotation.y += 0.1;
					}
					render();	
				}


			

			function popObjs(data){
				for(var x = 0; x< data.length;x++){
					addObjCanvas(data,x);
					if (x>8) return;
				}
			}


			$(document).ready(function(){
				console.log('ready');
				var request = $.ajax({
			         type: 'GET',
			         url: "getobjs.php",
			         dataType: 'json',
			         success: function(data) {
			                       
			                       popObjs(data);
			                   },
			                   error: function(jqXHR, textStatus, errorThrown) {

			                     console.log(error);
			                 }
			             });

			    $.ajax(request);
				
			});
		})(this);
	</script>

	<style>

		body,html{
			min-width: 1200px;
		}

		.wpanel{
			border-style: solid;
    		border-width: 1px;
    		padding-right:1px;
    		padding-left:3px;
		}

	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="col-xs-12">TT Shape Blender</div>
		<div class="col-xs-9 wpanel" id='model-area-meh'>
		
			<a href="editor.php?file=char.obj">Charizard</a>
			<a href="editor.php?file=Bed1.obj">Bed</a>
			<a href="editor.php?file=robot1.obj">Robot</a>
			
			<!--<div class="col-xs-3">
				<div class="col-xs-12">item</div>
				<canvas style="height:200px"></canvas>
			</div>-->
			
		</div>
		<div class="col-xs-3" >
			<!-- <div class="col-xs-12 wpanel">
				<div class="col-xs-12">Choose type of product</div>
				<div class="col-xs-12">
					<select>
						<option value="chair" selected>Chair</option>
						<option value="box">Box</option>
						<option value="bottle">Bottle</option>
					</select>
				</div>

				<div class="col-xs-12">OR</div>
				<div class="col-xs-12">
					Upload
					<input class="col-xs-12" type="file"></input>
				</div>
			</div> -->
			<!-- <div class="col-xs-12 wpanel">
				<form>
					<div class="col-xs-12">Cost <input type="range" min="1" max="100"></div>
					<div class="col-xs-12">Volume <input type="range" min="1" max="100"></div>
					<div class="col-xs-12">
						Material	
						<select name="" id="">
							<option value="steel">Steal</option>
							<option value="carboard">Cardboard</option>
							<option value="plastic">Plastic</option>
						</select>
					</div>
					<button type="submit" class="btn btn-default">Search</button>
				</form> -->
			</div>
		</div>
	</div>
</body>
</html>