<?php $user = CategoryData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h3>Editar Categoría</h3>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updatecategory" role="form">


  <div class="form-group">
    <label for="inputEmail1" class="col-md-2 control-label">Categoría*</label>
    <div class="col-md-6">
      <input type="text" name="name" required  value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-offset-2 col-md-10">
    <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="javascript:history.back(-1);" class="btn btn-danger">Cancelar</a>
    </div>
  </div>
</form>
	</div>
</div>