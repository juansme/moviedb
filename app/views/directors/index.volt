<div class="page-header">
    <h2>Directores</h2>
</div>
<div class="text-center">
	<button data-toggle="popup" data-target="#create" class="btn btn-primary">Crear director</button>
</div>
<div class="table-responsive">
    <table class="table table-hover" id="DataTable" data-url="{{ url("directors/get") }}">
        <thead>
          	<tr>
          		<th></th>
            	<th>Nombre</th>
            	<th>Nacimiento</th>
            	<th>Acciones</th>
          	</tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        	<th></th>
        	<th>nombre</th>
        	<th>nacimiento</th>
        	<th></th>
        </tfoot>
    </table>
</div>
<div class="popup" id="create">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">CREAR ACTOR</h3>
            <button class="btn btn-transparent popup-close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        </div>
        <div class="panel-body scroll-hidden">
        	<form class="ajax" data-action="{{ url("directors/create") }}">
	        	<div class="row col-multi">
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="name">Nombre*</label>
			                <input type="text" autocomplete="off" class="form-control" name="name" id="name">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="birth_date">Fecha de nacimiento*</label>
			                <input type="text" autocomplete="off" class="form-control datepicker" name="birth_date" id="birth_date">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="picture">Foto</label>
			                <input type="file" name="picture" id="picture">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="row col-multi">
	        		<div class="col-md-12">
	        			<div class="form-group">
			                <label class="control-label" for="summary">Biografía*</label>
			                <textarea class="form-control" name="summary" id="summary" rows="5"></textarea>
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="text-center">
	        		<button class="btn btn-success mb" type="submit">GUARDAR</button>
	        	</div>
        	</form>
        </div>
    </div>
</div>
<div class="popup" id="edit">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">EDITAR ACTOR</h3>
            <button class="btn btn-transparent popup-close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        </div>
        <div class="panel-body scroll-hidden">
        	<form class="ajax" data-action="{{ url("directors/update") }}">
        		<input type="hidden" id="id_edit" name="id">
	        	<div class="row col-multi">
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="name_edit">Nombre*</label>
			                <input type="text" autocomplete="off" class="form-control" name="name" id="name_edit">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="birth_date_edit">Fecha de nacimiento*</label>
			                <input type="text" autocomplete="off" class="form-control datepicker" name="birth_date" id="birth_date_edit">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="picture_e">Foto</label>
			                <input type="file" name="picture" id="picture_e">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="row col-multi">
	        		<div class="col-md-12">
	        			<div class="form-group">
			                <label class="control-label" for="summary_edit">Biografía*</label>
			                <textarea class="form-control" name="summary" id="summary_edit" rows="5"></textarea>
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="text-center">
	        		<button class="btn btn-success mb" type="submit">GUARDAR</button>
	        	</div>
        	</form>
        </div>
    </div>
</div>