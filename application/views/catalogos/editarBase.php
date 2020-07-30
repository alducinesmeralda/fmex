<?php
$id_base = $baseInfo->id_base;
$nombre = $baseInfo->nombre;
$calle = $baseInfo->calle;
$numero_exterior = $baseInfo->numero_exterior;
$numero_interior = $baseInfo->numero_interior;
$colonia = $baseInfo->colonia;
$municipio = $baseInfo->municipio;
$ciudad = $baseInfo->ciudad;
$estado = $baseInfo->estado;
$codigo_postal = $baseInfo->codigo_postal;
$pais = $baseInfo->pais;
$correo = $baseInfo->correo;
$telefono = $baseInfo->telefono;
$activo = $baseInfo->activo;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-edit"></i>Bases
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
                        <h3 class="box-title">Base</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <form role="form" action="<?php echo base_url() ?>actualizarBase" method="post" id="editarBase" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre" value="<?php echo $nombre; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $id_base; ?>" name="id_base" id="id_base" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="calle">Calle</label>
                                        <input type="text" class="form-control" id="calle" placeholder="Calle" name="calle" value="<?php echo $calle; ?>" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_exterior">Número exterior</label>
                                        <input type="text" class="form-control" id="numero_exterior" placeholder="Numero exterior" name="numero_exterior" value="<?php echo $numero_exterior; ?>" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_interior">Número interior</label>
                                        <input type="text" class="form-control" id="numero_interior" placeholder="Numero interior" name="numero_interior" value="<?php echo $numero_interior; ?>" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="colonia">Colonia</label>
                                        <input type="text" class="form-control" id="colonia" placeholder="Colonia" name="colonia" value="<?php echo $colonia; ?>" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="municipio">Municipio</label>
                                        <input type="text" class="form-control" id="municipio" placeholder="Municipio" name="municipio" value="<?php echo $municipio; ?>" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad" placeholder="Ciudad" name="ciudad" value="<?php echo $ciudad; ?>" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <input type="text" class="form-control" id="estado" placeholder="Estado" name="estado" value="<?php echo $estado; ?>" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo_postal">Código postal</label>
                                        <input type="number" class="form-control" id="codigo_postal" placeholder="Codigo postal" name="codigo_postal" value="<?php echo $codigo_postal; ?>" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pais">País</label>
                                        <input type="text" class="form-control" id="pais" placeholder="Pais" name="pais" value="<?php echo $pais; ?>" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input type="text" class="form-control" id="correo" placeholder="Correo" name="correo" value="<?php echo $correo; ?>" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="number" class="form-control" id="telefono" placeholder="Telefono" name="telefono" value="<?php echo $telefono; ?>" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-check">
                                        <input type="checkbox" id="activo" <?php echo $activo == "1" ? "checked" : "" ?>  name="activo" class="form-check-input">
                                        <label for="activo">Activo</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Guardar" />
                    <a href="<?php echo base_url() ?>catalogos/bases" class="btn btn-default">Cancelar</a>
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

<script src="<?php echo base_url(); ?>assets/js/editarBase.js" type="text/javascript"></script>