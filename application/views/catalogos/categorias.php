<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-file"></i> Categorias
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>catalogos/nuevaCategoria"><i class="fa fa-plus"></i> Nuevo</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categorias</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>catalogos/categorias" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Descripción categoría</th>
                                <th>Tipo</th>
                                <th>Fecha alta</th>
                                <th>Activo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            <?php
                            if (!empty($categoriaRecords)) {
                                foreach ($categoriaRecords as $record) {
                            ?>
                                    <tr id="tr_<?php echo $record->id_categoria ?>">
                                        <td><?php echo $record->id_categoria ?></td>
                                        <td><?php echo $record->descripcion_categoria ?></td>
                                        <td><?php if ($record->id_tipo_categoria == 0) echo "Escuela"; else echo "Aviones"; ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($record->fecha_alta)) ?></td>
                                        <td>
                                            <?php 
                                            if ($record->activo =="1")  
                                                echo "<i class='fa fa-check'>";
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="<?php echo base_url() . 'catalogos/editarCategoria/' . $record->id_categoria; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger delete" href="#" data-id="<?php echo $record->id_categoria; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                        </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Información</h4>
      </div>
      <div class="modal-body">
        <p>¿Eliminar el registro seleccionado?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnConfirmDelete">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modalMensajes">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Información</h4>
      </div>
      <div class="modal-body">
        <p id="pMensajes"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            
            var value = link.substring(link.lastIndexOf('/') + 1);
            console.log('value ' + value);

            console.log('ir a '  + baseURL + "catalogos/categorias/" + value);
            // debugger;
            jQuery("#searchList").attr("action", baseURL + "catalogos/categorias/" + value);
            jQuery("#searchList").submit();
        });


        jQuery('#btnConfirmDelete').on('click', function(e) {
            e.preventDefault();

            var id_ = jQuery(this).attr('itemid');
            var url_ = jQuery(this).attr('url');

            // debugger;

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: url_,
                data: {
                    id: id_
                }
            }).done(function(data) {
                console.log(data);
                if (data.status = true) {
                
                jQuery('#tr_' + id_).remove();

                jQuery('#btnConfirmDelete').attr('itemid', -1);
                jQuery('#btnConfirmDelete').attr('url', -1);
                jQuery('#modalDelete').modal('hide');


                jQuery('#pMensajes').html('Operación finalizada correctamente.');
                jQuery('#modalMensajes').modal('show');


                } else if (data.status = false) {
                jQuery('#pMensajes').html('No se pudo completar la operación.');
                } else {
                jQuery('#pMensajes').html('Acceso denegado..!');
                }
            });


    });

        jQuery(document).on("click", ".delete", function() {
            var id = $(this).data("id"),
                hitURL = baseURL + "deleteCategoria";

            console.log('hitURL     ' + hitURL);
            console.log('id ' + id);

            jQuery('#btnConfirmDelete').attr('itemid', id);
            jQuery('#btnConfirmDelete').attr('url', hitURL);
            jQuery('#modalDelete').modal('show');


        });



    });//fin de ready
</script>