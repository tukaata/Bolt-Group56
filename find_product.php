<?php include 'db_connect.php' ?>
<style>
	table.table-hover tr{
		cursor: pointer !important;
	}
	#uni_modal .modal-footer{
		display: none;
	}
	#uni_modal .modal-footer.display{
		display: block;
	}
</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="form-group col-md-4 ofsset-md-4">
				<small>Seach for product</small>
				<input type="text" class="input-sm form-control" id="search">
			</div>
		</div>
	<div class="row">
		<table class="table table-condensed table-hover" id="plist">
			<colgroup>
				<col width="25%">
				<col width="20%">
				<col width="10%">
				<col width="25%">
				<col width="10%">
				<col width="10%">
			</colgroup>
				<thead>
					<th class="">Product Name</th>
					<th class="">Category</th>
					<th class="">Type</th>
					<th class="">Description</th>
					<th class="">Price</th>
					<th class="">Available</th>
					<th class="">Prescription Need</th>
				</thead>
				<tbody>
					<?php 
						$cat = $conn->query("SELECT * FROM category_list order by name asc");
							while($row=$cat->fetch_assoc()):
								$cat_arr[$row['id']] = $row['name'];
							endwhile;
						$cat = $conn->query("SELECT * FROM type_list order by name asc");
							while($row=$cat->fetch_assoc()):
								$type_arr[$row['id']] = $row['name'];
							endwhile;
						$product = $conn->query("SELECT * FROM product_list r order by name asc");
						while($row=$product->fetch_assoc()):
						$inn = $conn->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$row['id']);
						$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
						$out = $conn->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$row['id']);
						$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;

						$ex = $conn->query("SELECT sum(qty) as ex FROM expired_product where product_id = ".$row['id']);
						$ex = $ex && $ex->num_rows > 0 ? $ex->fetch_array()['ex'] : 0;

						$available = $inn - $out- $ex;
						$cat  = '';
						$carr = explode(",", $row['category_id']);
						foreach($carr as $k => $v){
							if(empty($cat)){
								$cat = $cat_arr[$v];
							}else{
								$cat .= ', '.$cat_arr[$v];
							}
							}
						if($available > 0):
					?>
					<tr data-id='<?php echo $row['id'] ?>'>
						<td class=""><b><?php echo $row['name'] ?></b> <sup><?php echo $row['measurement'] ?></sup></td>
						<td class=""><b><?php echo $cat ?></b></td>
						<td class=""><b><?php echo $type_arr[$row['type_id']] ?></b></td>
						<td class=""><b><?php echo $row['description'] ?></b></td>
						<td class="text-right"><b><?php echo number_format($row['price'],2) ?></b></td>
						<td class=""><b><?php echo $available ?></b></td>
						<?php if($row['prescription'] == 0): ?>
						<td class="text-center"><span class="badge badge-danger text-white"><span class="fa fa-times"></span></span></td>
						<?php else: ?>
						<td class="text-center"><span class="badge badge-success text-white"><span class="fa fa-check"></span></span></td>
						<?php endif; ?>
					</tr>
					<?php endif; ?>
					<?php endwhile; ?>
				</tbody>
		</table>
	</div>
	</div>
</div>
<div class="modal-footer display">
	<div class="col-lg-12">
		<button class="btn btn-secondary float-right" type="button" data-dismiss="modal">Close</button>
	</div>
</div>
<script>

	$('#search').keyup(function(){
		var txt = $(this).val()
		$('#plist tbody tr').each(function(){
			if($(this).text().toLowerCase().includes(txt.toLowerCase()) == true){
				$(this).toggle(true)
			}else{
				$(this).toggle(false)
			}
		})
	})
	$('#plist tbody tr').click(function(){
		select_prod($(this).attr('data-id'))
	})
	$(document).ready(function(){
		$('#search').trigger('click')
	})
</script>