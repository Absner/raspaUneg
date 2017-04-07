<?php 
require ('php/conexion2.php');

if (!isset($_SESSION["cedula"])){
	header("location:index.html");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Raspa Uneg 2.1</title>
	<link rel="stylesheet" href="bower_components/angular-material/angular-material.css">
	<link rel="stylesheet" href="bower_components/angular-material-data-table/dist/md-data-table.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="bower_components/angular-ui-grid/ui-grid.min.css">
	<link rel="stylesheet" href="css/style.css">
	<!--<link rel="stylesheet" href="style.css">-->
</head>
<body ng-app="YourApp" layout="row" ng-cloak class="docs-body">
   
    
    <!-- Barra lateral -->
    <div id="sideNavContainer" layout="row" ng-cloak ng-controller=" link as vm">
           <md-sidenav class="sideNav md-sidenav-left md-whiteframe-z2" md-component-id="left" hide-print md-is-locked-open="$mdMedia('gt-sm')">
           <md-toolbar></md-toolbar>
               <md-list>
                   <md-subheader class="md-no-sticky">Opciones</md-subheader>
                   <md-divider></md-divider>
                   
                   <md-list-item ng-click="vm.ruta('#/Estado')" ng-model="alumnos">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/home.svg"></md-icon>
                       <p>Inicio</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/CargaAlumno')" ng-model="alumnos">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/add.svg"></md-icon>
                       <p>Cargar Alumnos</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/CargaAlumnoM')" ng-model="alumnos">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/add.svg"></md-icon>
                       <p>Cargar Alumnos Manual</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/Programacion')">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/calendario.svg"></md-icon>                      <p>Programación Semestre</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/ProgramacionExamen')">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/calendario.svg"></md-icon>                      <p>Programación Examenes</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/CorreoUploar')">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/ic_cloud_upload_black_48px.svg"></md-icon>                      <p>Cargar E-mail</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/CargaNotas')">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/ic_cached_black_48px.svg"></md-icon> <p>Cargar Notas</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <md-list-item ng-click="vm.ruta('#/Reportes')">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/reportes.svg"></md-icon> <p>Reportes</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <!--<md-list-item ng-click="null">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/ic_mail_outline_black_24px.svg"></md-icon>                      <p>Difusión de Notas</p>
                       <div class="md-secondary"></div>
                   </md-list-item>-->
                   
                   
                   <md-divider></md-divider>
                   
                   <md-list-item ng-click="vm.ruta('#/Configuracion')">
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/config.svg"></md-icon>                      <p>Configuraciones</p>
                       <div class="md-secondary"></div>
                   </md-list-item>
                   
                   <div ng-controller="LoginController as vm">
                   <md-list-item ng-click="vm.logout()" >
                       <md-icon class="md-default-theme" class="material-icons" md-svg-src="img/logout.svg"></md-icon>                      <p>Log out</p>
                       
                   </md-list-item>
                   </div>
               
               
               
               
               
               </md-list>



                
            </md-sidenav>
            
            <md-content></md-content>
    </div>
       <!-- Barra lateral -->
       <!-- Barra  -->
       <div layout="column" tabIndex="-1" role="main" flex ng-controller="sideNavController as navCtrl">
          <md-content>
            <md-toolbar class="md-hue-2">
              <div class="md-toolbar-tools">
                <md-button class="md-icon-button" aria-label="Settings" ng-click="openLeftMenu()"
                           hide-gt-sm aria-label="Toggle Menu">
                  <md-icon md-svg-src="img/sidebar.svg"></md-icon>
                </md-button>

                <span flex></span>
                	<div ng-controller=" link as vm">
                <md-button class="md-icon-button" aria-label="More">
                  <md-icon md-svg-src="img/user.svg" ng-click="vm.ruta('#/Configuracion/updateUsuario')"></md-icon>
                </md-button>
				  </div>
              </div>
            </md-toolbar>
          </md-content>
        <md-content md-scroll-y layout="column" flex>
          <div ng-view layout-padding flex="noshrink"></div>
        </md-content> 
      </div>
       <!-- Barra  -->
    <!-- div para generar las vistas -->
    
    


</body>
<script src="bower_components/angular/angular.js"></script>
<script src="bower_components/angular-route/angular-route.js"></script>
<script src="bower_components/angular-aria/angular-aria.js"></script>
<script src="bower_components/angular-animate/angular-animate.js"></script>
<script src="bower_components/angular-material/angular-material.js"></script>
<script src="bower_components/angular-messages/angular-messages.js"></script>
<script src="bower_components/angular-material-data-table/dist/md-data-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
<script src="bower_components/angular-ui-grid/ui-grid.min.js"></script>
<script src="bower_components/angular-resource/angular-resource.js"></script>
<script src="js/app.js"></script>
</html>