<style>
#invoice{
    padding: 30px;
	font-family:Arial, Helvetica, sans-serif;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 1.2em;
	margin-left:50px;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
	border:1px solid #CCC;
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
	border:1px solid #CCC;
}

.invoice table th {
    white-space: nowrap;
	border:1px solid #CCC;
    font-weight: 400;
    font-size: 16px;
	font-weight:bold;
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em;
	border:1px solid #CCC;
}

.invoice table .no {
    color: #fff;
    background: #3989c6;
	border:1px solid #CCC;
}

.invoice table .unit {
    background: #ddd;
	border:1px solid #CCC;
}

.invoice table .total {
    background: #3989c6;
    color: #fff;
	border:1px solid #CCC;
}

.invoice table tbody tr:last-child td {
    border:1px solid #CCC;
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1em;
	font-weight:bold;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.1em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<body onload='printWindow();'>
<div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <img src="<?=base_url()?>/assets/img/logo_invoice.png" class="img-fluid">
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <?=TITLE?>
                        </h2>
                        <div><?=ADDRESS?></div>
                        <div>Tel: <?=TELEPHONE?> Fax: <?=FAX?></div>
                        <div><?=EMAIL?></div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h4 class="to"><?=$invoice->customer_name?></h4>
                        <div class="address"><?=$invoice->customer_address?></div>
                        <div class="email"><?=$invoice->customer_mobile?></div>
                    </div>
                    <div class="col invoice-details">
                        <h4 class="invoice-id">INVOICE No: <?=$invoice->bill_number?></h4>
                        <div class="date">Date of Invoice: <?=date('d/m/Y',strtotime($invoice->bill_date))?></div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">NAME</th>
                            <th class="text-left">MODEL</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">UNIT</th>
                            <th class="text-right">UNIT PRICE</th>
                            <th class="text-right">TOTAL (LKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<? 
						$total = 0;
						$count = 0;
						foreach($invoice_data as $row){
						$count++;	
						?>
                        <tr>
                            <td class="no"><?=sprintf('%02d', $count);?></td>
                            <td class="text-left"><?=$row->item_name?></td>
                            <td class="text-left"><?=$row->item_description?></td>
                            <td class="text-center"><?=$row->sale_item_quantity?></td>
                            <td class="text-center"><?=$row->unit_name?></td>
                            <td class="text-right"><?=number_format($row->sale_item_price,2)?></td>
                            <td class="text-right"><?=number_format($row->sale_item_price * $row->sale_item_quantity,2)?></td>
                        </tr>
                        <? 
						$total = $total + ($row->sale_item_price * $row->sale_item_quantity);
						}
						update_total($invoice->sale_id,$total); //custom_helper
						?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td><?=number_format($total,2)?></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">TAX</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td><?=number_format($total,2)?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <!--<div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>-->
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script>
function printWindow(){
	window.print();
	setTimeout(function(){
		window.location.href = "<?=base_url()?>sale/new_sale";
	},200);
}
</script>