THREE.Vertex=function(a,b){this.position=a||new THREE.Vector3();this.positionWorld=new THREE.Vector3();this.positionScreen=new THREE.Vector3();this.normal=b||new THREE.Vector3();this.normalWorld=new THREE.Vector3();this.normalScreen=new THREE.Vector3();this.__visible=true};
THREE.Vertex.prototype={toString:function(){return"THREE.Vertex ( position: "+this.position+", normal: "+this.normal+" )"}};
