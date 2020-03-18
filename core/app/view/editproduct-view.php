<?php
$product = ProductData::getById($_GET["id"]);
$categories = CategoryData::getAll();
$subcategories = SubCategoryData::getById($product->category_id);
$almacenes = AlmacenData::getAll();



$divisas = DivisaData::getLast();
$valor_dolar = $divisas[0]->monto;
$fecha = $divisas[0]->created_at;

if($product!=null):
?>
<div class="row">
	<div class="col-md-8">
	<h3><?php echo $product->name ?> <small>Editar Producto</small></h3>
  <div class="row">
  <div class=" text-right">
    <button type="buttom" class="btn btn-success">
      Tasa: <?php echo number_format($valor_dolar,2,'.',','); ?><br>
      Fecha :</b> <?php echo date( 'd/m/Y', strtotime($fecha)); ?>

    </button>
<input type="hidden" id="tasa" value="<?php echo $valor_dolar; ?>">
    </div>
</div>
<div class="clearfix"><br></div>

  <?php if(isset($_COOKIE["prdupd"])):?>
    <p class="alert alert-info">La informacion del producto se ha actualizado exitosamente.</p>
  <?php setcookie("prdupd","",time()-18600); endif; ?>

		<form class="form-horizontal" method="post" id="addproduct" enctype="multipart/form-data" action="index.php?view=updateproduct" role="form">

  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Imagen*</label>
      <input type="file" name="images[]" id="images" multiple  placeholder="">
  </div>

<div class="form-group">
         <label for="inputEmail1" class="col-xs-3 control-label">Imagenes*</label>
        <?php 
        $imagenes = ProductData::getImagesProduct($product->id);
        foreach($imagenes as $image):?>
          <div class="col-xs-3 col-sm-4cols">
          <div class="thumbnail profile-pic" >
            <a href="#" title="Eliminar"  > <img class="img-responsive" title="<?php echo $product->name; ?>" src="storage/products/<?php echo $image->image_name;?>" ></a>
            <div class="edit del_img" id="<?php echo $image->id; ?>">
              <a href="#" title="Eliminar"><i class="fa fa-trash fa-lg"></i>
              </a>
            </div>
          </div>
          </div>
        <?php endforeach;?> 
</div>

<input type="hidden" name="images_id" id="images_id">
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Codigo*</label>
    <div class="col-md-8">
      <input type="text" name="barcode" class="form-control" id="barcode" value="<?php echo $product->barcode; ?>" placeholder="Codigo del Producto " style="text-transform:uppercase;" maxlength="15">
    </div>
  </div>
    <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Nombre*</label>
    <div class="col-md-8">
      <input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Nombre del Producto" style="text-transform:capitalize;" maxlength="100">
    </div>
  </div>
<!--     <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Ubicación</label>
    <div class="col-md-8">
      <input type="text" name="location" class="form-control" id="location" value="<?php echo $product->location; ?>" placeholder="Ubicacion en almacen (Separar con - )">
    </div>
  </div>  -->
    <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Categoria</label>
    <div class="col-md-8">
    <select name="category_id" class="form-control select2 category_ajax">
    <option value="">-- NINGUNA --</option>
    <?php foreach($categories as $category):?>
      <option value="<?php echo $category->id;?>" <?php if($product->category_id!=null&& $product->category_id==$category->id){ echo "selected";}?>><?php echo $category->name;?></option>
    <?php endforeach;?>
      </select>    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Subcategoría*</label>
    <div class="col-md-8">
      <select name="subcategory_id" id="subcategory_id" class="form-control select2" readonly>
      <option value="<?php echo $subcategories->id;?>"><?php echo $subcategories->name;?></option>
        </select>    
    </div>
  </div>  
    <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Descripcion</label>
    <div class="col-md-8">
      <input type="text" name="description" class="form-control" id="description" value="<?php echo $product->description; ?>" placeholder="Descripcion del Producto">
    </div>
  </div> 
    <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Atributos</label>
    <div class="col-md-8">
      <input type="text" name="attribute" class="form-control" id="attribute" value="<?php echo $product->attribute; ?>" placeholder="Marca-Modelo-Etc (Separar con - )">
    </div>
  </div> 
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Almacen*</label>
    <div class="col-md-8">
      <select name="almacen_id" id="almacen_id" class="form-control select2 almacen_ajax" required>
      <option value="">-- NINGUNA --</option>
      <?php foreach($almacenes as $almacen):?>
        <option value="<?php echo $almacen->id;?>" <?php if($product->almacen_id!=null&& $product->almacen_id==$almacen->id){ echo "selected";}?>><?php echo $almacen->name;?></option>
      <?php endforeach;?>
        </select>    
    </div>
  </div> 

<div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label" >Precio en Bs.</label>
    <div class="col-md-8">
    <div >
 <label class="customcheck">SI
          <input type="checkbox" name="is_bsf" id="is_bsf" <?php if( $product->is_bsf ==1 ){ echo "checked";}?>>
          <span class="checkmark"></span>
        </label>
        <input type="hidden" name="precio_bs" id="precio_bs">
    </div>
    </div>
</div>
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Precio de Entrada*</label>
    <div class="col-md-8">
      <input type="text" name="price_in" class="form-control allownumericwithdecimal" value="<?php echo $product->price_in; ?>" id="price_in" placeholder="Precio de entrada(use . para los decimales)" maxlength="10">
    </div>
  </div>

 <div class="form-group">
  <label for="inputEmail1" class="col-md-3 control-label">Porcentaje Gan.*</label>
   <div class="col-md-8">
  <select class="form-control" name="percentage" id="percentage" >
    <option value="5">5</option>
    <option value="10" >10</option>
    <option value="15">15</option>
    <option value="20">20</option>
    <option value="25">25</option>
    <option value="30" selected>30</option>
    <option value="40">40</option>
    <option value="50">50</option>
    <option value="60">60</option>
    <option value="70">70</option>
    <option value="80">80</option>
    <option value="90">90</option>
    <option value="100">100</option>
    <option value="120">120</option>
    <option value="150">150</option>
    <option value="200">200</option>
    </select>
    </div>
</div> 

  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Unidad*</label>
    <div class="col-md-8">
      <input type="text" name="unit" class="form-control allownumericwithoutdecimal" id="unit" value="<?php echo $product->unit; ?>" placeholder="Unidad del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Presentacion</label>
    <div class="col-md-8">
      <input type="text" name="presentation" class="form-control" id="inputEmail1" value="<?php echo $product->presentation; ?>" maxlength="50" placeholder="Presentacion del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Minima en inventario:</label>
    <div class="col-md-8">
      <input type="text" name="inventary_min" class="form-control allownumericwithoutdecimal" value="<?php echo $product->inventary_min;?>" id="inputEmail1" placeholder="Minima en Inventario (Default 10)">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label" >Esta activo</label>
    <div class="col-md-8">
<div class="checkbox">
    <label>
      <input type="checkbox" name="is_active" <?php if($product->is_active){ echo "checked";}?>> 
    </label>
  </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-offset-3 col-md-8">
    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
      <button type="submit" class="btn btn-success">Actualizar Producto</button>
      <a href="./?view=products" class="btn btn-danger">Regresar</a>

    </div>
  </div>
</form>

<br><br><br><br><br><br><br><br><br>
	</div>
</div>
<?php endif; ?>