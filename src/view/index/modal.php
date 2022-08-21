<!-- Modal -->
<div class="modal fade" id="new_transaction" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-comments-dollar" aria-hidden="true">&nbsp;</i>Nueva Transacción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="finance_form">
                <div class="modal-body">

                    <input type="hidden" name="id" id="id" value="0">

                    <div class="mb-3">
                        <label for="" class="form-label"><i class="fas fa-calendar-alt" aria-hidden="true"></i>&nbsp;Fecha</label>
                        <input type="date" class="form-control" name="date" id="date" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><i class="fas fa-comments-dollar" aria-hidden="true">&nbsp;</i>Tipo de Transacción</label>
                        <select class="form-control" name="type" id="type">
                            <option disabled selected>Ingrese Tipo de Transacción</option>
                            <option value="income">Ingreso</option>
                            <option value="expenses">Egreso</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"><i class="fas fa-dollar-sign" aria-hidden="true">&nbsp;</i>Monto</label>
                        <input type="number" class="form-control" name="value" id="value" aria-describedby="helpId"
                            placeholder="12990">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save" aria-hidden="true"></i>&nbsp;Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>