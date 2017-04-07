<h2>Carga Manual de Alumnos</h2>

<section ng-controller="subirFile">
    
    <form method="post">
    <!-- encabezado para seleccionar la cantidad de alumnos a agregar -->
     <div layout="row" layout-align="center center" ng-init="showPeriodo();">

        <md-input-container>
			<label>Semestre</label>   
			<md-select ng-change="cargarMaterias();" ng-model="semestre">
			<md-option ng-repeat="item in periodos"  value="{{item.codigo}}">{{item.descripcion}}</md-option>
			</md-select>
        </md-input-container>
        
        <md-input-container flex-gt-sm="15" flex-gt-xs="15">
        <label>Materia</label>  
         <md-select ng-model="materia" ng-change="cargarSeccions();">
            <md-option ng-repeat="Materia in Materias"  value="{{Materia.codigoM}}">{{Materia.nombreM}}</md-option>
         </md-select>
        </md-input-container> 
        <md-input-container flex-gt-sm="15" flex-gt-xs="15">
        <label>Sección</label> 
         <md-select ng-model="seccion">
            <md-option ng-repeat="seccion in Secciones" value="{{seccion.codigoS}}">{{seccion.codigoS}}</md-option>
         </md-select>
        </md-input-container>
        <md-input-container flex-gt-sm="15" flex-gt-xs="15" id="marginTop">
           <label>Cantidad</label>
            <input type="number" min="1" max="15" ng-model="cantidad" ng-change="cambio();">
        </md-input-container> 
        <!--<p ng-repeat="item in monto"></p>-->
        
     </div>
     <md-divider class="marginTopBottom"></md-divider>
      
      <div layout="column">
      
       <div layout="row" class="width" ng-repeat="item in monto">
           
            
            <md-input-container flex="10" required>
                <input type="text" placeholder="Cédula" ng-model="Bdate.cedula[item]">
            </md-input-container>
            
        
            <md-input-container flex="11">
                <input type="text" placeholder="Primer nombre" ng-model="Bdate.nombre[item]">
            </md-input-container>
        
        
            <md-input-container flex="11">
                <input type="text" placeholder="S. nombre" ng-model="Bdate.sNombre[item]">
            </md-input-container>
        
        
        
            <md-input-container flex="11">
                <input type="text" placeholder="Primer apellido" ng-model="Bdate.apellido[item]">
            </md-input-container>
        
        
        
            <md-input-container flex="11">
                <input type="text" placeholder="S. Apellido" ng-model="Bdate.sApellido[item]">
            </md-input-container>
        
        
        
            <md-input-container flex="10">
                <input type="email" placeholder="E-mail" required ng-model="Bdate.correo[item]">
            </md-input-container>
        
        </div>
        </div>
        <md-input-container>
        	<md-button type class="md-raised md-primary" ng-click="capturarData();">Cargar</md-button>
        </md-input-container>
        <!--<input type="submit" value="enviar">-->
        </form>
        
    
</section>