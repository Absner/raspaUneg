var  Raspa = angular.module( 'YourApp',['ngMaterial','ngRoute','md.data.table','ui.grid','ngMessages']);
var chartData = [
	['Maria Carmen', 10],
	['Juanito Alimaña', 70],
	['Absnersito', 3],
	['Jaimito Jiménez', 50],
	['Jorge', 5],
	['Malavé', 50],
	['Juaadnito Alimaña', 70],
	['Absasdnersito', 3],
	['Jaiasdmito Jiménez', 50],
	['Jorgade', 5],
	['Malavsé', 50],
	['Juaaaito Alimaña', 70],
	['Absaasrsito', 3],
	['Jaiasddto Jiménez', 50],
	['Joraade', 5],
	['Malasdsé', 50],
	['Maria Caradsmen', 10],
	['Juaniadto Alimaña', 70],
	['Absadsnersito', 3],
	['Jaiasmito Jiménez', 50],
	['Jorgde', 5],
	['Malasdavé', 50],
	['Juaadniadto adslimaña', 70],
	['Absasdnerasdsito', 3],
	['Jaiasdmito Jiasdménez', 50],
	['Jorgaadsde', 5],
	['Maladsavsé', 50],
	['Juaaaitadso Alimaña', 70],
	['Absaasrsito', 3],
	['Jaiasddto Jiméasdnez', 50],
	['Joraadsade', 5],
	['Masdalasdsé', 50],
	['Madsoisés Aray', 30]
]

/*Raspa.run(function(user) {
	user.init({ appId: '578c31802b019' });
});*/

/* configuracion del sistemas modulos*/
Raspa.config(function($routeProvider,$mdThemingProvider){
    
    /* configuración de rutas */
    $routeProvider.when("/CargaAlumno",{
        templateUrl:"formAlumnos.html"
		
    }).when("/Programacion",{
        templateUrl:"cronograma.html"
		
    }).when("/CargaAlumnoM",{
        templateUrl:"cargaManual.php"
		
    }).when("/Estado",{
		templateUrl:"estadosCronograma.html"
	}).when("/Estadisticas",{
		templateUrl:"graficas.html"
	}).when("/Estadistica",{
		templateUrl:"graficas.html"
	}).when("/Reportes",{
		templateUrl:"reportes.html"
	}).when("/ProgramacionExamen",{
		templateUrl:"programacionExamen.html"
	}).when("/Configuracion",{
		templateUrl:"configuraciones.html"
	}).when("/Configuracion/nuevaMateria",{
		templateUrl:"nuevaMateria.html"
	}).when("/Configuracion/asignarMateria",{
		templateUrl:"asignarMateria.html"
	}).when("/CargaNotas",{
		templateUrl:"cargaNotas.html"
	}).when("/CorreoUploar",{
		templateUrl:"cargaCorreo.html"
	}).when("/Configuracion/deleteMateria",{
		templateUrl:"deleteMateria.html"
	}).when("/Configuracion/updateMateria",{
		templateUrl:"updateMateria.html"
	}).when("/Configuracion/contenidoMateria",{
		templateUrl:"contenidoMateria.html"
	}).when("/Configuracion/listContenidoMateria",{
		templateUrl:"showContenidoMateria.html"
	}).when("/Configuracion/listadoAlumno",{
		templateUrl:"listadoAlumno.html"
	
	}).when("/Configuracion/listadoAlumno/updateAlumno/:cedula",{
		templateUrl:"updateAlumno.html"
	}).when("/Reportes/asistenciaExamen",{
		templateUrl:"asistenciaExamen.html"
	}).when("/Reportes/estisticas",{
		templateUrl:"estadisticas.html"
	}).when("/Configuracion/updateUsuario",{
		templateUrl:"updateUsuario.html"
	})
		.otherwise({
		redirectTo: '/Estado'
	})
    
    /* configuración de los temas de material Design */
    $mdThemingProvider.theme('default')
                      .primaryPalette("blue",{
						'default': '800',
						'hue-1':'600',
						'hue-2':'500',
						'hue-3':'400'
	})
                      .accentPalette("light-green",{
						'hue-1':'A100',
						'hue-2':'A200'
	});
    /* configuración de Satellizer para el manejo de sesiones */
    /*$authProvider.loginUrl      = "http://raspauneg.esy.es/MaterialDesign/php/prueba.php";
    $authProvider.signupUrl     = "MaterialDesign/php/salida.php";
    $authProvider.tokenName     = "token";
    $authProvider.tokePrefix    = "myApp";
    $authProvider.storageType   = "localStorage";*/

    
});

Raspa.controller("GraphicController", function($scope, $http, $mdToast){
    $scope.addChart    =   function(){
    	var Url	=	"php/nota_total.php";
		$http.post(Url,{
			semestre:   $scope.semestre,
			materia:    $scope.materia,
			seccion:    $scope.seccion
		}).success(
			function(res){
				var chartData = new Array(res[0].length);
				var i = 0;
				var j = 0;
				var alta = 0;
				var baja = 100;
				var promedio_nota = 0;
				var aprobado = 0;
				var aplazado = 0;
				var promedio_aprobado = 0;
				while(j < res[0].length){
                    chartData[j] = new Array(2);
					chartData[j][1] = 0;
					j++;
				}
				var q = j;
				j=0;
				while(i < res.length){
					j = 0;
					while(j < res[i].length){
						chartData[j][0] = res[i][j]["nombre"]+" "+res[i][j]["apellido"];
						chartData[j][1] = chartData[j][1] + res[i][j]["nota"];
						promedio_nota += chartData[j][1];
						if(chartData[j][1] > alta && (i == (res.length-1)))
				    		alta = chartData[j][1];
					    if(chartData[j][1] < baja && (i == (res.length-1)))
					    	baja = chartData[j][1];
					    if(chartData[j][1] >= 55 && (i == (res.length-1)))
					    	aprobado++;
					    j++;
					}
					i++;
				}
				promedio_nota = promedio_nota/q;
				$scope.alumnos = q;
				$scope.promedio_nota = promedio_nota.toFixed(2)+"%";
				$scope.alta = alta;
				$scope.baja = baja;
				$scope.aprobados = aprobado;
				$scope.aplazados = q - aprobado;
				aprobado = (aprobado/j)*100;
				$scope.promedio_aprobado = aprobado.toFixed(2)+"%";
				var chart = c3.generate({
		    		bindto: "#chart",
		    		data: {
		    			type: 'bar',
		    			columns: chartData
		    		},
		    		axis: {
				        y: {
				            max: 100
				        }
				    },
				    size: {
				        width: 900
				    },
				    bar: {
				        width: {
				            ratio: 1.0
				        }
				    },
				     grid: {
				        y: {
				            show: true
				        }
				    },
				    regions: [
				        {axis: 'y',start: 0, end: 55}
				    ]
		    	})
		    	console.log(res);
			}
		)
    }
    $scope.print = function(){
		 var divToPrint = document.getElementById('print');
		 var newWin = window.open();
		 newWin.document.write(divToPrint.innerHTML);
		 newWin.focus();
		 newWin.print();
		 newWin.close();
    }
});

/* controlador para el inicio de sesion */

Raspa.factory("menuServicio",function(){
    return{
        data : {
            estado: "",
            logged: false,
        }
    }
});
Raspa.controller("LoginController", function($scope,$http,$mdToast,menuServicio){
    
    $scope.user ={
            id : "",
            passw : ""
        };
    //Funi
	
	this.validar	=	function(){
		
		var Url	=	"php/login.php";

		$http.post(Url,{
			email:		$scope.user.id,
			password:	$scope.user.passw,
		}).success(
			function(res){
				if (res == 1){
					window.location.href="inicio.php#/Estado";
				}else{
					$mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
				}
			})
		
	}
	
	this.limpiar	=	function (){
		$scope.user ={
            id : "",
            passw : ""
        };
		
	}
	
	
	this.login    =   function(){
		
		var Url	=	"php/login.php";
		
		$http.post(Url,{
			email:		this.usuario,
			password:	this.pass
		}).success(
			function(res){
				if (res == 1){
					window.location.href="inicio.html#/Estado";
				}else{
					console.log("error");
				}
			}
		)
        //$auth.login({
        //    email:      this.usuario,
        //    password:   this.pass
        //})
        //.then(function(){
            
        
        
               
        
            //localStorage['myApp_token'];
    
              

        //      })
        //.catch(function(){
            //window.location.href="inicio.html#/Estado";
        //});
    }
    
    this.logout     =   function(){
        //$auth.logout().then(function() {
            // Desconectamos al usuario y lo redirijimos
            window.location.href  =   "php/logout.php";
        //});
    }
    /*this.ingresar = function(){
        console.log("funciona");
        window.location.href="inicio.html";
    }*/
});

/* controlador del sidenav barra lateral */
Raspa.controller("sideNavController",function($scope, $mdSidenav){
    $scope.openLeftMenu = function() {
    $mdSidenav('left').toggle();
  };
});

Raspa.controller("link", function(){
    
    this.ruta = function($d){
        //console.log("Funcka");
        window.location.href = $d;
    }
    
    
});


function DialogController($scope, $mdDialog) {
  $scope.hide = function() {
    $mdDialog.hide();
  };

  $scope.cancel = function() {
    $mdDialog.cancel();
  };

  $scope.answer = function(answer) {
    $mdDialog.hide(answer);
  };
};

/* Controladores, directivas y servicios carga de alumnos automatica, manual */

Raspa.controller("subirFile", function($scope,upload,$http,$routeParams,$mdToast){
    
    $scope.cargaFile  =   function(){
        var file	=	$scope.file;
		var	seccion	=	$scope.seccion;
		var	materia	=	$scope.materia;
		var	semestre=	$scope.semestre;
		//console.log(file);
		upload.uploadFile(file,semestre,seccion,materia).then(function(res){
			console.log(res);
		})
    }
	
	//$scope.Materias;
	$scope.cargarMaterias	=	function(){
		var Url	=	"php/selectMateria.php";
		
		$http.post(Url,{
			semestre:	this.semestre
		}).success(
			function(res){
				$scope.Materias=res;
				console.log(res);
				
			}
		)
	}
	
	//$scope.Secciones;
	$scope.cargarSeccions	=	function(){
		var Url	=	"php/selectSeccion.php";
		
		$http.post(Url,{
			codigoM:	this.materia,
			semestre:	this.semestre
		}).success(
		
			function(res){
				$scope.Secciones=res;
				console.log($scope.Secciones);
			}
		)
	}
	
/* captura de la data por carga manual de alumnos */	
	$scope.monto        =   [0];
    $scope.cedula       =   [$scope.cantidad];
    $scope.nombre       =   [$scope.cantidad];
    $scope.sNombre      =   [$scope.cantidad];
    $scope.apellido     =   [$scope.cantidad];
    $scope.sApellido    =   [$scope.cantidad];
    $scope.correo       =   [$scope.cantidad];
    $scope.cantidad     =   1;
    
    $scope.cambio       =   function(){
        this.monto=[];
        for (var i=0; i<$scope.cantidad; i++){
            $scope.monto.push(i);
        }
    }
    
    $scope.Bdate    =   [];
    $scope.capturarData =   function(){
        var url =   "php/prueba.php";
        $http.post(url,{
            
            cedula:     $scope.Bdate.cedula,
            nombre:     $scope.Bdate.nombre,
            sNombre:    $scope.Bdate.sNombre,
            apellido:   $scope.Bdate.apellido,
            sApellido:  $scope.Bdate.sApellido,
            correo:     $scope.Bdate.correo,
            cant:       $scope.cantidad,
			semestre:	$scope.semestre,
			seccion:	$scope.seccion,
			materia:	$scope.materia
        
        }).success(
            function(res){
                console.log(res);
            }
        );
        console.log($scope.Bdate.cedula);
        //window.location.href="php/prueba.php";
    };
	
/* mostrar listado de los alumnos inscritos en materia/seccion */
	//$scope.ci_alumno="hola mundo";
	$scope.showAlumno	=	function(){
		var Url	=	"php/showAlumnoNota.php";
		
		$http.post(Url,{
			semestre:	$scope.semestre,
			materia:	$scope.materia,
			seccion:	$scope.seccion,
			fechaE:		$scope.fechaE
		}).success(
			
			function(res){
				$scope.listaAlumnos=res;
				console.log($scope.listaAlumnos);
				
				
			}
		
		)
		
	};
	
	$scope.addNota	=	function(cedula,nota){
		var Url	=	"php/updateNota.php";
		
		$http.post(Url,{
			nota:		nota,
			cedula:		cedula,
			idExamen:	$scope.fechaE
		}).success(
			
			function(res){
				console.log(res);
			}
		
		)
			
	}
	
	
	
	
	$scope.cantEval		=	function(){
		var Url	=	"php/cantExamen.php";
		console.log($scope.materia);
		$http.post(Url,{
			semestre:	$scope.semestre,
			materia:	$scope.materia,
			seccion:	$scope.seccion
		}).success(
			
			function(res){
				$scope.fechasEval=res;
				console.log(res);
			}
		
		)
	}
	
	
	$scope.updateCorreo	=	function(){
		var Url	=	"php/updateCorreo.php";
		
		$http.post(Url,{
			correo:	$scope.correos
		}).success(
			
			function(res){
				console.log(res);
			}
		)
	}
	
	$scope.viewNotas	=	function(){
		var Url	= "php/viewNota.php?semestre="+this.semestre+"&materia="+this.materia+"&seccion="+this.seccion;
		//console.log(this.fechaE);
		
		$http.get(Url).success(
			function(res){
				//console.log(res);
				window.open(Url,'_blank');
			}
		)
	}
	
	$scope.sendEmail	=	function (){
		var Url	=	"php/mail.php";
		
		$http.post(Url,{
			idExamen: 	this.fechaE,
			semestre:	this.semestre,
			materia:	this.materia,
			seccion:	this.seccion
		}).success(
			function(res){
				console.log(res);
			}
		)
	}
	
	$scope.showPeriodo	=	function(){
		var Url	=	"php/selectPeriodo.php";
		
		$http.post(Url).success(
			function(res){
				$scope.periodos	=	res;
				console.log(res);
			}
		)
	}
	
	$scope.alumnosMateria	=	function(){
		var Url	=	"php/selectAlumnoMateria.php";
		
		$http.post(Url,{
			semestre:	$scope.semestre,
			materia:	$scope.materia,
			seccion:	$scope.seccion
		}).success(
			function(res){
				$scope.listAlumnoMateria	=	res;
				console.log(res);
			}
		);
	}
	
	//$scope.data={};
	$scope.dataAlumno	=	function(){
		var Url	=	"php/selectAlumno.php";
		
		$http.post(Url,{
			cedula: $routeParams.cedula
		}).success(
			function(res){
				//console.log(res);
				$scope.data	= res;
				console.log($scope.data);
			}
		);
		//console.log($routeParams.cedula);
	}
	
	$scope.updateAlumno	=	function(cedula,nombre,sNombre,apellido,sApellido,correo){
		var Url	=	"php/updateAlumno.php";
		
		$http.post(Url,{
			cedula:			cedula,
			nombre:			nombre,
			sNombre:		sNombre,
			apellido:		apellido,
			sApellido:		sApellido,
			correo:			correo,
			origenCedula:	$routeParams.cedula
		}).success(
			function(res){
				console.log(res);
			}
		);
	}
	
	$scope.deleteAlumno	=	function(cedula){
		var Url	=	"php/deleteAlumno.php";
		
		$http.post(Url,{
			semestre:	$scope.semestre,
			materia:	$scope.materia,
			seccion:	$scope.seccion,
			cedula:		cedula
		}).success(
			function(res){
				console.log(res);
				$scope.alumnosMateria();
			}
		)
	}
	
	$scope.updateNotaFinal	=	function(){
		
		var Url	=	"php/updateNotaFinal.php";
		
		$http.post(Url,{
			semestre:	$scope.semestre,
			materia:	$scope.materia,
			seccion:	$scope.seccion
		}).success(
			function(res){
				console.log(res);
			}
		)
		
	}
	

  
    
});

Raspa.directive("uploaderModel", function($parse){
    return{
        restrict: 'A',
        link: function(scope,iElement,iAttrs){
            iElement.on("change",function(e){
                $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
            });
        }
    }
});

Raspa.service("upload", function($http,$q){
	
	this.uploadFile	=	function(file,semestre,seccion,materia){
		var deferred = $q.defer();
		var formData = new FormData();
		
		formData.append("file",file);
		formData.append("semestre",semestre);
		formData.append("seccion",seccion);
		formData.append("materia",materia);
		return $http.post("php/uploaderFile.php", formData,{
			headers:{
				'content-type': undefined
			},
			transformRequest: angular.identity
		}).success(function(res){
			deferred.resolve(res);
		}).error(function(msg, code)
		{
			deferred.reject(msg);
		})
		return deferred.promise;
	}
});


/* Controlador datapicker y formulario del cronograma */
Raspa.controller('Agenda', function($http,$scope,$mdToast) {
  
	
	this.myDate=	new Date();
	
	//console.log($scope.myDate);
  
  $scope.addEvento	=	function(){
	  
	  
	  var Url	=	"php/addEvento.php";
	  //console.log(this.myDate);
	  $http.post(Url,{
		  
		  fecha:		this.myDate,
		  descripcion:	this.descripcion,
		  actividad:	this.actividad
	  
	  }).success(
		  
		  function(res){
			  //console.log(res);
			  $mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
		  }
	  
	  )
  }
  
  $scope.addExamen	=	function(){
	  var Url	=	"php/addExamen.php";
	  //console.log(this.materia);
	  $http.post(Url,{
		  codMateria: 	this.materia,
		  codSeccion:	this.seccion,
		  porcentaje:	this.porcentaje,
		  descripcion:	this.descripcion,
		  semestre:		this.semestre,
		  fecha:		this.myDate,
		  tipoEval:		this.tipoEval
		  
	  }).success(
		  function(res){
			  console.log(res);
			  $mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
		  }
	  )
  }
  
  $scope.listaExamen;
  $scope.showExamen	=	function(){
	  var Url	=	"php/showExamen.php";
	  
	  $http.post(Url).success(
		  function(res){
			  $scope.listaExamen=res;
			  console.log($scope.listaExamen);
		  }
	  )
  }
  
  
  $scope.listaActividad;
  $scope.showActividad	=	function(){
	  var Url	=	"php/selectActividad.php";
	  
	  $http.post(Url).success(
		  
		  function(res){
			  $scope.listaActividad=res;
		  }
	  
	  )
  }
  
  $scope.showFeriados	=	function(){
	  var Url	=	"php/selectFeriado.php";
	  
	  $http.post(Url).success(
		  function(res){
			  $scope.listaFeriado=res;
			  console.log(res);
		  }
	  )
  }
  
  $scope.showInicioFin	=	function(){
	  var Url	=	"php/selectInicioFin.php";
	  
	  $http.post(Url).success(
		  
		  function (res){
			  $scope.listaInicioFin=res;
			  console.log(res);
		  }
	  )
  }
  
  
  $scope.tipoEvaluacion	=	function(){
	  var Url	=	"php/selectTipoExamen.php";
	  
	  $http.post(Url).success(
		  function(res){
			  $scope.listaEvaluacion=res;
			  console.log(res);
		  }
	  )
  }
  
});

/* Controlador para las materias */
Raspa.controller("materia", function ($http,$scope,$mdDialog, $mdMedia,$mdToast){
	
	$scope.asignaturas	;
	$scope.secciones	;
	$scope.Bdate=[];
	$scope.listaMateriaD=[];
	//$scope.actual = {};
	
	
	$scope.addMateria	=	function(){
		console.log($scope.serial);
		
		var Url		=	"php/addMateria.php";
		
		$http.post(Url,{serial:$scope.serial,nombre:$scope.name,uc:$scope.uc}).success(
			function(res){
				console.log(res);
			}
		);
	}
	
	$scope.addContenido	=	function(){
		var Url =	"php/addContenido.php";
		
		$http.post(Url,{
			materia: 		$scope.materia,
			titulo:			$scope.titulo,
			descripcion:	$scope.descripcion
		}).success(
			function(res){
				console.log(res);
				$mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
			
		});
	}
	
	$scope.showMateria	=	function(){
		var Url		=	"php/salida.php";
		
		$http.post(Url).success(
			function(res){
				$scope.asignaturas	=	res[0];
				$scope.secciones	=	res[1];
				//console.log(res);
			}
		);
	}
	
	$scope.asigMateria	=	function(){
		var Url		=	"php/asignarMateria.php";
		
		$http.post(Url,{
			codMateria:	this.materia,
			codSeccion:	this.seccion,
			semestre:	this.semestre
		}).success(
			function(res){
				console.log(res);
				$mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
			}
		);
	}
	
	$scope.materiaDocente	=	function(){
		var Url	=	"php/showMateriaDocente.php";
		console.log($scope.semestre);
		$http.post(Url,{
			semestre:	this.semestre
		}).success(
			function(res){
				
				$scope.listaMateriaD=res;
				console.log(res);
				//$scope.actual.seria= $scope.listaMateriaD.codigo;
				//$scope.Bdate=res;
				//console.log($scope.listaMateriaD);
			}
		)
	}
	
	$scope.contenidoMateria	=	function(){
		var Url	=	"php/showContenidoMateria.php";
		
		$http.post(Url,{
			materia: $scope.materia
		}).success(
			function(res){
				$scope.contenido=res;
				//console.log("hola munso");
			}
		)
	}
	
	$scope.deleteContenido	=	function(codContenido){
		var Url	=	"php/deleteContenido.php";
		
		$http.post(Url,{
			codContenido:	codContenido,
			materia:		$scope.materia
		}).success(
			function (res){
				console.log(res);
				$mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
				$scope.contenidoMateria();
			}
		)
	}
	
	$scope.deleteMateria	=	function(materia,seccion,semestre){
		var Url	=	"php/deleteMateria.php";
		console.log($scope.semestre);
		$http.post(Url,{
			materia:	materia,
			seccion:	seccion,
			semestre:	semestre
		}).success(
			function(res){
				//console.log(res);
				//
				$mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
				$scope.materiaDocente();
			}
		)
	}
	
	

	//$scope.serial;
	$scope.updateMateria = function(codigo,serial,materia,uc){
		
		var Url	=	"php/updateMateria.php";
		
		$http.post(Url,{
			codigo:		codigo,
			serial:		serial,
			materia:	materia,
			uc:			uc
		}).success(
			function(res){
				delete $scope.edit[codigo];
				console.log(res);
			}
		)
		
	}
	
	$scope.updateContenido	=	function (codigo,titulo,descripcion){
		var Url	=	"php/updateContenido.php";
		
		$http.post(Url,{
			codigo:			codigo,
			titulo:			titulo,
			descripcion:	descripcion
		}).success(
			function(res){
				console.log(res);
				delete $scope.edit[codigo];
			}
		)
	}
	
	$scope.edit = [];
	$scope.showEdition = function($event, id){			
		
	// Asignar valor true la variable representada por el id del usuario
	// Esto provocará que se muestren los elementos respectivos a la edición
	// y se oculten los spans y el botón de eliminar usuario
	$scope.edit[id] = true;

	// Con $event.currentTarget accedemos al elemento que ha lanzado el evento
	// Guiándonos por este elemento accedemos mediante jQuery al input que está debajo del mismo
	var input = angular.element($event.currentTarget).parent().find("input")[0];		

	// Después de 50 milisegundos hacemos que el input tome el foco
	// Y que el texto que contiene se seleccione
	setTimeout(function(){

		input.focus();
		input.select();

	}, 50);

};
	$scope.showPeriodos	=	function(){
		var Url	=	"php/selectPeriodo.php";
		
		$http.post(Url).success(
			function(res){
				$scope.periodos	=	res;
				console.log(res);
			}
		)
	}
	
	
	
});

/* controlador ventanas modales */
Raspa.controller("modal", function($scope, $mdDialog, $mdMedia){
	
	$scope.showAdvanced = function(ev) {
		var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && $scope.customFullscreen;
		$mdDialog.show({
		  controller: DialogController,
		  templateUrl: 'modalcalendario.html',
		  parent: angular.element(document.body),
		  targetEvent: ev,
		  clickOutsideToClose:true,
		  fullscreen: useFullScreen
		})
		.then(function(answer) {
		  $scope.status = 'You said the information was "' + answer + '".';
		}, function() {
		  $scope.status = 'You cancelled the dialog.';
		});
		$scope.$watch(function() {
		  return $mdMedia('xs') || $mdMedia('sm');
		}, function(wantsFullScreen) {
		  $scope.customFullscreen = (wantsFullScreen === true);
		});
	};
});

/* servicio para NgResource */

Raspa.controller("reportes", function ($http,$scope){
	
	$scope.asistenciaExamen	=	function(){
		var Url	=	"php/viewAsistenciaExamen.php?semestre="+this.semestre+"&materia="+this.materia+"&seccion="+this.seccion;
		
		
				window.open(Url,'_blank')
		
	}
});

Raspa.controller("usuario", function($http,$scope,$mdToast){
	
	$scope.user;
	
	$scope.selectUser	=	function (){
		
		var Url	=	"php/selectUsuario.php";
		$http.post(Url).success(
			function (res){
				$scope.user=res;
				console.log($scope.user);
			}
		)
	}
	
	$scope.updateUser	= function(cedula,apellido,nombre,correo,clave){
		var Url 	=	"php/updateUsuario.php";
		
		$http.post(Url,{
			cedula:		cedula,
			apellido:	apellido,
			nombre:		nombre,
			correo:		correo,
			clave:		clave
		}).success(
			function(res){
				$mdToast.show(
					$mdToast.simple()
					.textContent(res)
					.position("bottom right"));
			}
		)
	}
	
	
});