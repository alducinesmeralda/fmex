<?php
$id_producto = $productoInfo->id_producto;
$nombre = $productoInfo->nombre;
$cantidad = $productoInfo->cantidad;
$costo = $productoInfo->costo;
$activo = $productoInfo->activo;
$id_tipo_hora = $productoInfo->id_tipo_hora;

// echo "cantidad = $cantidad";

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-edit"></i>Productos
            <small>Editar</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->



                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Producto</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <form role="form" action="<?php echo base_url() ?>actualizarProducto" method="post" id="editarProducto" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre" value="<?php echo $nombre; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $id_producto; ?>" name="id_producto" id="id_producto" />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Cantidad</label>
                                        <input type="number" class="form-control required" value="<?php echo $cantidad ?>" id="cantidad" name="cantidad">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="costo">Costo</label>
                                        <input type="number" class="form-control required" value="<?php echo $costo ?>" id="costo" name="costo">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_tipo_hora">Tipo hora</label>
                                        <select class="form-control required" value="<?php echo $id_tipo_hora ?>" id="id_tipo_hora" name="id_tipo_hora">

                                            <?php
                                            if (!empty($tipoHoraRecords)) {

                                                foreach ($tipoHoraRecords as $rl) {
                                            ?>
                                                    <option value="<?php echo $rl->id_tipo_hora; ?>" <?php if($rl->id_tipo_hora == $id_tipo_hora) {echo "selected=selected";} ?>>
                                                        <?php echo $rl->nombre?>
                                                    </option>

                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>


                                </div>






                            </div>




                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-check">
                                        <input type="checkbox" id="activo" <?php echo $activo == "1" ? "checked" : "" ?> name="activo" class="form-check-input">
                                        <label for="activo">Activo</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Guardar" />
                    <a href="<?php echo base_url() ?>catalogos/productos" class="btn btn-default">Cancelar</a>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if ($error) {
            ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <?php
            $success = $this->session->flashdata('success');
            if ($success) {
            ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
        </div>
</div>
</section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editarProducto.js" type="text/javascript"></script>