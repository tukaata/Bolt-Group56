<?php include 'db_connect.php';
if(isset($_GET['iid'])){
	$conn->query("UPDATE inventory set expired_confirmed = 1 where id = ".$_GET['iid']);
}


?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>expired</h4>
			</div>
			<div class="card-body">
				<form action="" id="manage-expired">
					<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
					<input type="hidden" name="ref_no" value="<?php echo isset($ref_no) ? $ref_no : '' ?>">
					<div class="col-md-12">
						<div class="row mb-3">
								<div class="col-md-4">
									<label class="control-label">Product</label>
									<select name="" id="product" class="custom-select browser-default select2">
										<option value=""></option>
									<?php 
									$cat = $conn->query("SELECT * FROM category_list order by name asc");
										while($row=$cat->fetch_assoc()):
											$cat_arr[$row['id']] = $row['name'];
										endwhile;
									$product = $conn->query("SELECT * FROM product_list  order by name asc");
									while($row=$product->fetch_assoc()):
										$prod[$row['id']] = $row;
									?>
										<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-measurement="<?php echo $row['measurement'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
									<?php endwhile; ?>
									</select>
									<small><a href="javascript:void(0)" id="search_prod">Search product in details.</a></small>
								</div>
								<div class="col-md-2">
									<label class="control-label">Qty</label>
									<input type="number" class="form-control text-right" step="any" id="qty" >
								</div>
								<div class="col-md-3">
									<label class="control-label">&nbsp</label>
									<button class="btn btn-block btn-sm btn-primary" type="button" id="add_list"><i class="fa fa-plus"></i> Add to List</button>
								</div>


						</div>
						<div class="row">
							<table class="table table-bordered" id="list">
								<colgroup>
									<col width="20%">
									<col width="40%">
									<col width="30%">
									<col width="10%">
								</colgroup>
								<thead>
									<tr>
										<th class="text-center">Date Expired</th>
										<th class="text-center">Product</th>
										<th class="text-center">Qty</th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(isset($_GET['iid'])):
										$inv = $conn->query("SELECT i.*,p.name,p.measurement,p.sku,p.description FROM inventory i inner join product_list p on p.id = i.product_id where i.id =".$_GET['iid']);
									while($row = $inv->fetch_assoc()): 
										
									?>
										<tr class="item-row">
											<td>
												<input type="date" name="expiry_date[]" class="text-right" value="<?php echo date("Y-m-d",strtotime($row['expiry_date'])) ?>">
											</td>
											<td>
												<input type="hidden" name="inv_id[]" value="<?php echo $row['id'] ?>">
												<input type="hidden" name="product_id[]" value="<?php echo $row['product_id'] ?>">
												<p class="pname">Name: <b><?php echo $row['name'] ?> <sup><?php echo $row['measurement'] ?></sup></b></p>
												<p class="pdesc"><small><i>Description: <b><?php echo $row['description'] ?></b></i></small></p>
											</td>
											<td>
												<input type="number" min="1" step="any" name="qty[]" value="<?php echo $row['qty'] ?>" class="text-right">
											</td>
											<td class="text-center">
												<buttob class="btn btn-sm btn-danger" onclick = "rem_list($(this))"><i class="fa fa-trash"></i></buttob>
											</td>
										</tr>
									<?php endwhile; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<button class="btn btn-primary col-sm-3 btn-sm btn-block float-right ">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
<div id="tr_clone">
	<table>
	<tr class="item-row">
		<td>
			<input type="date" name="expiry_date[]" class="text-right" value="">
		</td>
		<td>
			<input type="hidden" name="inv_id[]" value="">
			<input type="hidden" name="product_id[]" value="">
			<p class="pname">Name: <b>product</b></p>
			<p class="pdesc"><small><i>Description: <b>Description</b></i></small></p>
		</td>
		<td>
			<input type="number" min="1" step="any" name="qty[]" value="" class="text-right">
		</td>
		<td class="text-center">
			<buttob class="btn btn-sm btn-danger" onclick = "rem_list($(this))"><i class="fa fa-trash"></i></buttob>
		</td>
	</tr>
	</table>
</div>
<style type="text/css">
	#tr_clone{
		display: none;
	}
	td{
		vertical-align: middle !important;
	}
	td p {
		margin: unset;
	}
	td input{
		height: calc(100%);
		width: calc(100%);
		border: unset;

	}
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	  -webkit-appearance: none; 
	  margin: 0; 
	}
</style>
<script>
	$('.select2').select2({
	 	placeholder:"Please select here",
	 	width:"100%"
	})
	$('#pay').click(function(){
		if($("#list .item-row").length <= 0){
			alert_toast("Please insert atleast 1 item first.",'danger');
			end_load();
			return false;
		}
		$('#pay_modal').modal('show')
	})
	$('#search_prod').click(function(){
		uni_modal("Find Available Product.","find_product.php","large")
	})
	$(document).ready(function(){
		if('<?php echo isset($id) ?>' == 1){
			$('[name="supplier_id"]').val('<?php echo isset($supplier_id) ? $supplier_id :'' ?>').select2({
				placeholder:"Please select here",
	 			width:"100%"
			})
			calculate_total()
		}
	})
	function rem_list(_this){
		_this.closest('tr').remove()
	}
	function select_prod($id){
		start_load()
		$('#product').val($id).trigger('change')
		end_load();
		$('.modal').modal('hide')
	}
	$('#add_list').click(function(){
		// alert("TEST");
		// return false;

		var tr = $('#tr_clone tr.item-row').clone();
		var product = $('#product').val(),
			qty = $('#qty').val(),
			price = $('#price').val();
			if($('#list').find('tr[data-id="'+product+'"]').length > 0){
				alert_toast("Product already on the list",'danger')
				return false;
			}

			if(product == '' || qty == ''){
				alert_toast("Please complete the fields first",'danger')
				return false;
			}
				tr.attr('data-id',product)
				tr.find('.pname b').html($("#product option[value='"+product+"']").attr('data-name')+"<sup>"+$("#product option[value='"+product+"']").attr('data-measurement')+"</sup>")
				tr.find('.pdesc b').html($("#product option[value='"+product+"']").attr('data-description'))
				tr.find('[name="product_id[]"]').val(product)
				tr.find('[name="qty[]"]').val(qty)
				
				$('#list tbody').append(tr)
				
				 $('#product').val('').select2({
				 	placeholder:"Please select here",
			 		width:"100%"
				 })
					$('#qty').val('')
					$('#price').val('')
					
		
	})
	function calculate_total(){
		var total = 0;
		$('#list tbody').find('.item-row').each(function(){
			var _this = $(this).closest('tr')
		var amount = parseFloat(_this.find('[name="qty[]"]').val()) * parseFloat(_this.find('[name="price[]"]').val());
		amount = amount > 0 ? amount :0;
		_this.find('p.amount').html(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
		total+=parseFloat(amount);
		})
		$('[name="tamount"]').val(total)
		$('#list .tamount').html(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	}
	$('[name="amount_tendered"]').keyup(function(){
		var tendered = $(this).val();
		var tamount = $('[name="tamount"]').val();
		$('[name="change"]').val(parseFloat(tendered) - parseFloat(tamount))

	})
	$('#manage-expired').submit(function(e){
		e.preventDefault()
		start_load()
		if($("#list .item-row").length <= 0){
			alert_toast("Please insert atleast 1 item first.",'danger');
			end_load();
			return false;
		}
		$.ajax({
			url:'ajax.php?action=save_expired',
		    method: 'POST',
		    data: $(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully submitted",'success')
					
						setTimeout(function(){
							location.href = "index.php?page=expired_product"
						},700)

				}
				
			}
		})
	})
</script>