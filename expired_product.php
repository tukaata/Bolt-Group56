<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Exprired Product List</b>
			<button class="col-md-2 float-right btn btn-primary btn-sm" id="new_expired"><i class="fa fa-plus"></i> New Entry</button>
					</div>
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Date Encoded</th>
								<th class="text-center">Date Expired</th>
								<th class="text-center">Product</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Action</th>
							</thead>
							<tbody>
							<?php 
							$i = 1;
								$expired = $conn->query("SELECT e.*,p.name,p.sku,p.measurement FROM expired_product e inner join product_list p on p.id = e.product_id order by date(e.date_created) desc");
								while($row=$expired->fetch_assoc()):
							?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class=""><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
									<td class=""><?php echo date("M d, Y",strtotime($row['date_expired'])) ?></td>
									<td class="">
										<p>SKU: <b><?php echo $row['sku'] ?></b></p>
										<p>Name: <b><?php echo $row['name'] ?> <sup><?php echo $row['measurement'] ?></sup></b></p>
									</td>
									<td class=""><?php echo $row['qty'] ?></td>
									<td class="text-center">
										<a class="btn btn-sm btn-danger delete_expired" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
									</td>
								</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$('table').dataTable()
	$('#new_expired').click(function(){
		location.href = "index.php?page=manage_expired"
	})
	$('.delete_expired').click(function(){
		_conf("Are you sure to delete this data?","delete_expired",[$(this).attr('data-id')])
	})
	function delete_expired($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_expired',
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
</script>