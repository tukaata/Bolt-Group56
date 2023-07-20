<?php include('db_connect.php');
	$sku = mt_rand(1,99999999);
	$sku = sprintf("%'08d\n", $sku);
	$i = 1;
	while($i == 1){
		$chk = $conn->query("SELECT * FROM product_list where sku ='$sku'")->num_rows;
		if($chk > 0){
			$sku = mt_rand(1,99999999);
			$sku = sprintf("%'08d\n", $sku);
		}else{
			$i=0;
		}
	}
?>
<style>
	input[type=checkbox]
		{
		  /* Double-sized Checkboxes */
		  -ms-transform: scale(1.5); /* IE */
		  -moz-transform: scale(1.5); /* FF */
		  -webkit-transform: scale(1.5); /* Safari and Chrome */
		  -o-transform: scale(1.5); /* Opera */
		  transform: scale(1.5);
		  padding: 10px;
		}
</style>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-product">
				<div class="card">
					<div class="card-header">
						    Product Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">SKU</label>
								<input type="text" class="form-control" name="sku" value="<?php echo $sku ?>">
							</div>
							
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="control-label">Category</label>
							<select name="category_id[]" id="" class="custom-select browser-default select2" multiple="multiple">
							<?php 

							$cat = $conn->query("SELECT * FROM category_list order by name asc");
							while($row=$cat->fetch_assoc()):
								$cat_arr[$row['id']] = $row['name'];
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Type</label>
							<select name="type_id" id="" class="custom-select browser-default select2">
								<option></option>
							<?php 

							$cat = $conn->query("SELECT * FROM type_list order by name asc");
							while($row=$cat->fetch_assoc()):
								$type_arr[$row['id']] = $row['name'];
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Product Name</label>
							<input type="text" class="form-control" name="name"  required="">
						</div>
						<div class="form-group">
							<label class="control-label">Measurement</label>
							<input type="text" class="form-control" name="measurement"  required="">
						</div>
						<div class="form-group">
							<label class="control-label">Description</label>
							<textarea class="form-control" cols="30" rows="3" name="description" ></textarea>
						</div>
						<div class="form-group">
							<label class="control-label">Product Price</label>
							<input type="number" step="any" class="form-control text-right" name="price" >
						</div>	
						<div class="form-group">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="1" id="prescription" name="prescription">
							  <label class="form-check-label" for="prescription">
							    Medicine requires prescription.
							  </label>
							</div>
						</div>	
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="frm_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Product List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Product Info</th>
									<th class="text-center">Type</th>
									<th class="text-center">Price</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$prod = $conn->query("SELECT * FROM product_list order by id asc");
								while($row=$prod->fetch_assoc()):
									$cat  = '';
									$carr = explode(",", $row['category_id']);
									foreach($carr as $k => $v){
										if(empty($cat)){
											$cat = $cat_arr[$v];
										}else{
											$cat .= ', '.$cat_arr[$v];
										}
										}
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>SKU : <b><?php echo $row['sku'] ?></b></p>
										<p><small>Category : <b><?php echo $cat ?></b></small></p>
										<p><small>Name : <b><?php echo $row['name'] ?></b><sup><?php echo $row['measurement'] ?></sup></small></p>
										<p><small>Description : <b><?php echo $row['description'] ?></b></small></p>
										<?php if($row['prescription'] == 1): ?>
											<span class="badge badge-warning">Medicine requires prescription</span>
										<?php endif; ?>
									</td>
									<td>
										<p><small><b><?php echo $type_arr[$row['type_id']] ?></b></small></p>
										
									</td>
									<td class="text-right">
										<p><small><b><?php echo number_format($row['price'],2) ?></b></small></p>
										
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_product" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-sku="<?php echo $row['sku'] ?>" data-category_id="<?php echo $row['category_id'] ?>" data-description="<?php echo $row['description'] ?>" data-price="<?php echo $row['price'] ?>" data-type_id="<?php echo $row['type_id'] ?>" data-price="<?php echo $row['price'] ?>" data-measurement="<?php echo $row['measurement'] ?>" data-price="<?php echo $row['price'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_product" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin:unset;
	}
</style>
<script>
	$('.select2').select2({
		placeholder: "Please Select here",
		width:"100%"
	})
	function frm_reset(){
		$('#manage-product input, #manage-product select, #manage-product textarea').val('')
		$('#manage-product input, #manage-product select, #manage-product textarea').trigger('change')
	}
	$('#manage-product').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_product',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_product').click(function(){
		start_load()
		var cat = $('#manage-product')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='sku']").val($(this).attr('data-sku'))
		var c = $(this).attr('data-category_id');
		 var cat_arr = []
		 c = c.split(',')
		 c.map(function(k){
		 	cat_arr.push(k.toString())
		 })
		 console.log(cat_arr)
		cat.find("[name='category_id[]']").val(cat_arr)
		cat.find("[name='type_id']").val($(this).attr('data-type_id'))
		cat.find("[name='measurement']").val($(this).attr('data-measurement'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		end_load()
		$('.select2').trigger('change')
	})
	$('.delete_product').click(function(){
		_conf("Are you sure to delete this product?","delete_product",[$(this).attr('data-id')])
	})
	function delete_product($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_product',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>