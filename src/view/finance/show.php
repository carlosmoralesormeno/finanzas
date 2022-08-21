<?php
$data     	= $data_view["data"];
$months   	= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$month_now 	= date('m');
?>

<section class="my-5" id="info">

    <div class="row">
        <div class="col-sm-10">
            <h2><i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>&nbsp;Finanzas</h2>
            </h4>
        </div>
        <div class="col-sm-2 text-end mt-4 mt-sm-2">
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary btn-block" id="modal_transaction"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nueva
                    Transacción</button>
            </div>
        </div>
    </div>

</section>

<section>
	<div class="card">
		<div class="card-body">
			<h4 class="card-title"><i class="fas fa-chart-line" aria-hidden="true"></i>&nbsp;Finanzas por mes</h4>
			<div class="mb-3">
			  <label for="" class="form-label">Mes</label>
			  <select class="form-control" name="month" id="month" onchange="document.location.href='index.php?view=finance&date='+this.value">
			  	<?php foreach ($months as $key => $value) :?>
					<?php if($key + 1 >= 3 && $month_now >= $key + 1): ?>
						<option value="<?php echo $key + 1 ?>" <?php if($_GET['date'] == $key + 1){echo 'selected';} ?> ><?php echo $value ?></option>
					<?php endif ?>
				<?php endforeach; ?>
			  </select>
			</div>
		</div>
	</div>
</section>

<?php if($data->monthly_transactions_detail):?>
<section id="content">
    <div class="card my-3">
        <div class="card-body ">
            <h4 class="card-title"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i>&nbsp;Resumen</h4>
			<h6><?php echo $months[date($data->monthly_transactions->month)-1].' '.date($data->monthly_transactions->year)?></h6>
            <div class="row text-center">
                <div class="col-sm-4">
                    <h3 class="text-success"><i class="fas fa-arrow-up" aria-hidden="true">&nbsp;</i>Ingresos</h3>
                    <h4 class="text-success">$<?php echo number_format($data->monthly_transactions->income,0,',','.')?></h4>
                </div>
                <div class="col-sm-4">
                    <h3 class="text-danger"><i class="fas fa-arrow-down" aria-hidden="true">&nbsp;</i>Egresos</h3>
                    <h4 class="text-danger">$<?php echo number_format($data->monthly_transactions->expenses,0,',','.')?></h4>
                </div>
                <div class="col-sm-4">
                    <h3 class="text-primary"><i class="fas fa-funnel-dollar"></i>&nbsp;Resultado</h3>
                    <h4 class="text-primary">$<?php echo number_format($data->monthly_transactions->total,0,',','.')?></h4>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif;?>


<section>
    <div class="card my-3">
        <div class="card-body">
            <h4 class="card-title"><i class="fas fa-comments-dollar" aria-hidden="true">&nbsp;</i>Transacciones</h4>

            <?php if($data->monthly_transactions_detail):?>

            <table class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>


                <?php foreach ($data->monthly_transactions_detail as $key => $value) :?>

                <?php 
                    $type_transactions = NULL;

                    switch ($value->type) {
                        case 'income':
                            $type_transactions = '<span class="text-success"><i class="fas fa-arrow-up" aria-hidden="true">&nbsp;</i>Ingreso</span>';
                            break;
                        case 'expenses':
                            $type_transactions = '<span class="text-danger"><i class="fas fa-arrow-down" aria-hidden="true">&nbsp;</i>Egreso</span>';
                            break;
                        default:
                            $type_transactions = 'NA';
                            break;
                    }
                    
                    ?>

                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo $type_transactions; ?></td>
                        <td>$<?php echo number_format($value->value, 0, ',', '.'); ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm transaction-edit" data-view="finance"
                                data-id="<?php echo $value->id; ?>" data-action="get_json"><i class="fas fa-edit"
                                    aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-danger btn-sm transaction-delete" data-view="finance"
                                data-id="<?php echo $value->id; ?>" data-action="delete_json"><i
                                    class="fas fa-trash-alt" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                <?php else:?>
                    <h5>No existen transacciones</h5>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>

</section>


<?php include('view/index/modal.php') ?>