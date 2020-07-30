<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-file"></i> Base
            <small>Nuevo</small>
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
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="nuevaBase" action="<?php echo base_url() ?>insertarBase" method="post" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('nombre'); ?>" id="nombre" name="nombre" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="calle">Calle</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('calle'); ?>" id="calle" name="calle">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_exterior">Número exterior</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('numero_exterior'); ?>" id="numero_exterior" name="numero_exterior" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_interior">Número interior</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('numero_interior'); ?>" id="numero_interior" name="numero_interior">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="colonia">Colonia </label>
                                        <input type="text" class="form-control" value="<?php echo set_value('colonia'); ?>" id="colonia" name="colonia" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="municipio">Municipio</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('municipio'); ?>" id="municipio" name="municipio">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad </label>
                                        <input type="text" class="form-control" value="<?php echo set_value('ciudad'); ?>" id="ciudad" name="ciudad" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('estado'); ?>" id="estado" name="estado">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo_postal">Código Postal</label>
                                        <input type="number" class="form-control" value="<?php echo set_value('codigo_postal'); ?>" id="codigo_postal" name="codigo_postal">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pais">País </label>
                                        <input type="text" class="form-control" value="<?php echo set_value('pais'); ?>" id="pais" name="pais" maxlength="128">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('correo'); ?>" id="correo" name="correo">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono </label>
                                        <input type="number" class="form-control" value="<?php echo set_value('telefono'); ?>" id="telefono" name="telefono" maxlength="128">
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
<script src="<?php echo base_url(); ?>assets/js/nuevaBase.js" type="text/javascript"></script>