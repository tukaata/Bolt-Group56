<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM sales_list where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$$k = $val;
	}
	$inv = $conn->query("SELECT * FROM inventory where type=2 and form_id=".$_GET['id']);
	if($customer_id > 0){
		$cname = $conn->query("SELECT * FROM customer_list where id = $customer_id ");
		$cname = $cname->num_rows > 0 ? $cname->fetch_array()['name']: "Guest";
	}else{
		$cname = "Guest";
	}
}
$product = $conn->query("SELECT * FROM product_list  order by name asc");
	while($row=$product->fetch_assoc()):
		$prod[$row['id']] = $row;
	endwhile;

?>
<div class="container-fluid" id="print-sales">
	<style>
		body * {
			font-size: 10px
		}
		table{
			border-collapse: collapse;
		}
		
		.bbottom{
			border-bottom: 1px solid black
		}
		td p , th p{
			margin: unset
		}
			.text-center{
				text-align: center
			}
			.text-right{
				text-align: right
			}
			.text-left{
				text-align: left
			}
			.clear{
				padding: 10px
			}
			#uni_modal .modal-footer{
				display: none;
			}
	</style>
	<table width="100%">
			
				<tr>
					<th class="text-center">
						<p><b>Pharmacy Sales and Inventory System</b></p>
						<p>
							<b>Unofficial Receipt</b>
						</p>
					</th>
				</tr>
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
				
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
				<tr>
					<table width="100%">
						<tr>
							<th width="5%" class="wborder"></th>
							<th width="30%" class="wborder text-left">Product</th>
							<th width="10%" class="wborder"></th>
							<th width="25%" class="wborder">Amount</th>
						</tr>
						<?php 
						while($row = $inv->fetch_assoc()): 
							foreach(json_decode($row['other_details']) as $k=>$v){
								$row[$k] = $v;
							}
						?>
						<tr>
							<td class="wborder text-center">
								<?php echo $row['qty'] ?>
							</td>
							<td class="wborder">
								<?php echo $prod[$row['product_id']]['name'] ?><sup><?php echo $prod[$row['product_id']]['measurement'] ?></sup>  <span><small><?php echo $row['qty'] > 1 ? "(".(number_format($row['price'],2)).")" : "" ?></small></span>
								
							</td>
							<td class="wborder text-right"></td>
							<td class="wborder text-right"><?php echo number_format($row['price'] * $row['qty'],2) ?></td>

						</tr>
						<?php endwhile;?>
						<tr>
							<th class="text-right wborder" colspan="3">Total</th>
							<th class="text-right wborder" ><?php echo number_format($total_amount,2) ?></th>
						</tr>
						<tr>
							<th class="text-right wborder" colspan="3">Amount Tendered</th>
							<th class="text-right wborder" ><?php echo number_format($amount_tendered,2) ?></th>
						</tr>
						<tr>
							<th class="text-right wborder" colspan="3">Change</th>
							<th class="text-right wborder" ><?php echo number_format($amount_change,2) ?></th>
						</tr>
					</table>
				</tr>
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td width="20%" class="text-right">Customer :</td>
								<td width="40%" class="bbottom"><?php echo ucwords($cname) ?></td>
								<td width="20%" class="text-right">Date :</td>
								<td width="20%" class="bbottom"><?php echo date("Y-m-d",strtotime($date_updated)) ?></td>
							</tr>
							<tr>
								<td width="20%" class="text-right">Reference Number :</td>
								<td width="80%" class="bbottom" colspan="3"><?php echo $ref_no ?></td>
							</tr>
						</table>
					</td>
				</tr>
	</table>


</div>

