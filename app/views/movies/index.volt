<div class="page-header">
    <h2>Películas</h2>
</div>
<div class="text-center">
	<button data-toggle="popup" data-target="#create" class="btn btn-primary">Crear película</button>
</div>
<div class="table-responsive">
    <table class="table table-hover" id="DataTable" data-url="{{ url("movies/get") }}">
        <thead>
          	<tr>
          		<th></th>
            	<th>Título</th>
            	<th>Lanzamiento</th>
            	<th>Acciones</th>
          	</tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        	<th></th>
        	<th>título</th>
        	<th>lanzamiento</th>
        	<th></th>
        </tfoot>
    </table>
</div>
<div class="popup" id="create">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">CREAR PELÍCULA</h3>
            <button class="btn btn-transparent popup-close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        </div>
        <div class="panel-body">
        	<form class="ajax" data-action="{{ url("movies/create") }}">
	        	<div class="row">
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="title">Título*</label>
			                <input type="text" autocomplete="off" class="form-control" name="title" id="title">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="released_at">Fecha de lanzamiento*</label>
			                <input type="text" autocomplete="off" class="form-control datepicker" name="released_at" id="released_at">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="picture">Poster</label>
			                <input type="file" name="picture" id="picture">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-md-12">
	        			<div class="form-group">
			                <label class="control-label" for="summary">Resumen*</label>
			                <textarea class="form-control" name="summary" id="summary" rows="5"></textarea>
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-md-6">
	        			<div class="row">
	        				<div class="col-md-12">
			        			<div class="form-group">
					                <label class="control-label" for="directors_search">Director*</label>
					                <input type="text" autocomplete="off" data-url="{{ url("directors/search") }}" data-target="#new-director" data-type="director" class="form-control search" id="directors_search">
					                <span class="help-block"></span>
					            </div>
			        		</div>
			        		<div class="col-md-12 cast-area" id="new-director"></div>
	        			</div>
	        		</div>
	        		<div class="col-md-6">
	        			<div class="row">
	        				<div class="col-md-12">
			        			<div class="form-group">
					                <label class="control-label" for="actors_search">Actores*</label>
					                <input type="text" autocomplete="off" data-url="{{ url("actors/search") }}" data-target="#new-actors" data-type="actors" class="form-control search" id="actors_search">
					                <span class="help-block"></span>
					            </div>
			        		</div>
			        		<div class="col-md-12 cast-area" id="new-actors"></div>
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
            <h3 class="panel-title">EDITAR PELÍCULA</h3>
            <button class="btn btn-transparent popup-close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        </div>
        <div class="panel-body scroll-hidden">
        	<form class="ajax" data-action="{{ url("movies/update") }}">
        		<input type="hidden" id="id_edit" name="id">
	        	<div class="row">
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="title_edit">Título*</label>
			                <input type="text" autocomplete="off" class="form-control" name="title" id="title_edit">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="released_at_edit">Fecha de lanzamiento*</label>
			                <input type="text" autocomplete="off" class="form-control datepicker" name="released_at" id="released_at_edit">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        		<div class="col-md-4">
	        			<div class="form-group">
			                <label class="control-label" for="picture_e">Poster</label>
			                <input type="file" name="picture" id="picture_e">
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-md-12">
	        			<div class="form-group">
			                <label class="control-label" for="summary_edit">Resumen*</label>
			                <textarea class="form-control" name="summary" id="summary_edit" rows="5"></textarea>
			                <span class="help-block"></span>
			            </div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-md-6">
	        			<div class="row">
	        				<div class="col-md-12">
			        			<div class="form-group">
					                <label class="control-label" for="directors_search_edit">Director*</label>
					                <input type="text" autocomplete="off" data-url="{{ url("directors/search") }}" data-target="#old-director" data-type="director" class="form-control search" id="directors_search_edit">
					                <span class="help-block"></span>
					            </div>
			        		</div>
			        		<div class="col-md-12 cast-area" id="old-director"></div>
	        			</div>
	        		</div>
	        		<div class="col-md-6">
	        			<div class="row">
	        				<div class="col-md-12">
			        			<div class="form-group">
					                <label class="control-label" for="actors_search_edit">Actores*</label>
					                <input type="text" autocomplete="off" data-url="{{ url("actors/search") }}" data-target="#old-actors" data-type="actors" class="form-control search" id="actors_search_edit">
					                <span class="help-block"></span>
					            </div>
			        		</div>
			        		<div class="col-md-12 cast-area" id="old-actors"></div>
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