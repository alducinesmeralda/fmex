<?php
$id_categoria = $categoriaInfo->id_categoria;
$id_tipo_categoria = $categoriaInfo->id_tipo_categoria;
$descripcion_categoria = $categoriaInfo->descripcion_categoria;
$activo = $categoriaInfo->activo;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-edit"></i>Categorias
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
                        <h3 class="box-title">Categoría</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <form role="form" action="<?php echo base_url() ?>actualizarCategoria" method="post" id="editarCategoria" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcion_categoria">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion_categoria" placeholder="Descripcion" name="descripcion_categoria" value="<?php echo $descripcion_categoria; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $id_categoria; ?>" name="id_categoria" id="id_categoria" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_tipo_categoria">Tipo</label>
                                        <select id="id_tipo_categoria" name="id_tipo_categoria" class="form-control required">
                                            <option value="0" <?php if($id_tipo_categoria == 0) {echo "selected=selected";} ?>>Escuela</option>
                                            <option value="1" <?php if($id_tipo_categoria == 1) {echo "selected=selected";} ?>>Aviones</option>
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
                    <a href="<?php echo base_url() ?>catalogos/categorias" class="btn btn-default">Cancelar</a>
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

<script src="<?php echo base_url(); ?>assets/js/editarCategoria.js" type="text/javascript"></script>