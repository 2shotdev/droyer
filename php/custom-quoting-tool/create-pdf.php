<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// create new PDF document
session_start();
require_once "auth.php";
require_once "utilities.php";
$auth = new Auth();
$db_handle = new DBController();
$util = new Util();
require_once "authcookiesessionvalidate.php";
if(!$isLoggedIn) {
    header("Location: /login/");
}
$products = $db_handle->runBaseQuery("Select * from products");
$my_quote = $db_handle->runBaseQuery("Select * from quotes where id=".$_GET["id"]);
$my_products = $db_handle->runBaseQuery("Select * from quote_products where q_id=".$_GET["id"]);
require_once('pdf/tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Snowsound USA');
$pdf->SetTitle('Snowsound USA Quote');
$pdf->SetSubject('Quote');
$pdf->SetKeywords('Snowsound USA, PDF, Quote, product quote');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(175,175,175), array(255,255,255));
$pdf->setFooterData(array(175,175,175), array(175,175,175));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 10, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// Set some content to print
$html = '
<table style="padding-bottom:20px;">
	<tr style="color:#77777a;font-size:8px;">
		<td>10018 Santa Fe Springs Rd<br />Santa Fe Springs, CA 90670<br />Phone: 562.903.9550 ext. 223<br />Fax: 562.903.9053<br />E-mail: orders@snowsoundusa.com</td>
		<td style="text-align:right;">Date: '. $my_quote[0]["q_date"].'<br />Quote Number: '.$my_quote[0]["q_number"].'<br />Prepared By: '.$my_quote[0]["q_preparer"].'<br />Phone Number: '.$my_quote[0]["q_phone"].'<br />Email: '.$my_quote[0]["q_email"].'</td>
	</tr>
</table>
<table style="width:100%;font-size:9px" cellpadding="4">
	<tr style="">
		<td style="text-align:left;width:15%;"><b>Company Name:</b></td>
		<td style="text-align:left;width:15%;">'. $my_quote[0]["c_name"].'</td>
		<td style="text-align:left;width:13%;"><b>Payment Terms:</b></td>
		<td style="text-align:left;width:16%;">'. $my_quote[0]["p_terms"].'</td>
		<td style="text-align:left;width:15%;"><b><u>Ship To:</u></b></td>
		<td style="text-align:left;width:20%;"></td>
	</tr>
	<tr style="">
		<td style="text-align:left;width:15%;"><b>Attention To:</b></td>
		<td style="text-align:left;width:15%;">'. $my_quote[0]["c_attention"].'</td>
		<td style="text-align:left;width:13%;"><b>Lead Time:</b></td>
		<td style="text-align:left;width:16%;">'. $my_quote[0]["p_lead"].'</td>
		<td style="text-align:left;width:15%;"><b>Company Name:</b></td>
		<td style="text-align:left;width:20%;">'. $my_quote[0]["s_name"].'</td>
	</tr>
	<tr style="">
		<td style="text-align:left;width:15%;"><b>Phone Number:</b></td>
		<td style="text-align:left;width:15%;">'. $my_quote[0]["c_phone"].'</td>
		<td style="text-align:left;width:13%;"><b>Rep:</b></td>
		<td style="text-align:left;width:16%;">'. $my_quote[0]["p_repnumber"].'</td>
		<td style="text-align:left;width:15%;"><b>Address:</b></td>
		<td style="text-align:left;width:20%;">'. $my_quote[0]["s_city"].', '.$my_quote[0]["s_state"].' '.$my_quote[0]["s_zip"].'</td>
	</tr>
	<tr style="">
		<td style="text-align:left;width:15%;"><b>Project Name:</b></td>
		<td style="text-align:left;width:15%;">'. $my_quote[0]["c_project"].'</td>
		<td style="text-align:left;width:13%;"><b>A&D Specifier:</b></td>
		<td style="text-align:left;width:16%;">'. $my_quote[0]["p_specifier"].'</td>
		<td style="text-align:left;width:15%;"><b>Attention:</b></td>
		<td style="text-align:left;width:20%;">'. $my_quote[0]["s_attention"].'</td>
	</tr>
	<tr style="">
		<td style="text-align:left;width:15%;"><b>Project City:</b></td>
		<td style="text-align:left;width:15%;">'. $my_quote[0]["c_city"].'</td>
		<td style="text-align:left;width:13%;">&nbsp;</td>
		<td style="text-align:left;width:16%;"></td>
		<td style="text-align:left;width:15%;"><b>Phone Number:</b></td>
		<td style="text-align:left;width:20%;">'. $my_quote[0]["s_phone"].'</td>
	</tr>
</table>
<br />&nbsp;<br />
<table style="font-size:10px;text-align:center;" cellpadding="4">
	<tr style="font-size:10px;">
		<td style="width:15%;">Item Number</td>
		<td style="width:10%;">Color</td>
		<td style="width:30%;">Description</td>
		<td style="width:10%;">Quantity</td>
		<td style="width:10%;">List</td>
		<td style="width:12%;">Dealer NET</td>
		<td style="width:12%;">Ext NET</td>
	</tr>';

foreach ($my_products as $mp) {
	foreach($products as $product) {
		if($mp["p_id"] == $product["id"]) {
			$html .= '<tr style="font-size:10px;"><td style="width:15%;border:1px solid #757575;">'.$product["i_number"].'</td><td style="width:10%;border:1px solid #757575;">'.$product["i_color"].'</td><td style="width:30%;border:1px solid #757575;">'.$product["i_description"].'</td><td style="width:10%;border:1px solid #757575;">'.$mp["p_quantity"].'</td><td style="width:10%;border:1px solid #757575;">$'.$product["i_list"].'</td>';
			$net = (float) $product["i_list"];
			$dis = (float) $my_quote[0]["q_discount"];
			$gro = (float) $net*($dis/100);
			$quan = (float) $mp["p_quantity"];
			$tot = (float) $gro * $quan;
			$html .= '<td style="width:12%;border:1px solid #757575;">$'.number_format($gro, 2, ".", "").'</td><td style="width:12%;border:1px solid #757575;">$'.number_format($tot, 2, ".", "").'</td></tr>';
		}
	}
}
$html .= '</table>
<br />&nbsp;<br />
<table style="text-align:right;font-size:10px;" cellpadding="4">
	<tr>
		<td style="width:85%;">Product Subtotal:</td>
		<td style="width:15%;text-align:right;">$'.$my_quote[0]["q_subtotal"].'</td>
	</tr>
	<tr>
		<td>Freight:</td>
		<td style="width:15%;text-align:right;">$'.$my_quote[0]["q_freight"].'</td>
	</tr>
	<tr>
		<td><b>Total (USD):</b></td>
		<td style="width:15%;text-align:right;"><b>$'.$my_quote[0]["q_total"].'</b></td>
	</tr>
</table>
<br />&nbsp;<br />
<table style="text-align:left;font-size:8px;" cellpadding="7">
	<tr>
		<td style="font-size:12px;">NOTES: '.$my_quote[0]["q_notes"].'</td>
	</tr>
	<tr>
		<td style="font-size:12px;">Approved By:  ________________________________________________________</td>
	</tr>
	<tr>
		<td style="font-size:12px;">P.O. Number:  ________________________________</td>
	</tr>
	<tr>
		<td>If you have any questions concerning this quote, please contact us at (562) 903-9550 or <a href="mailto:quotes@snowsoundusa.com">quotes@snowsoundusa.com</a></td>
	</tr>
	<tr>
		<td>Please send all Purchase Orders to: orders@snowsoundusa.com</td>
	</tr>
	<tr>
		<td>*** PLEASE REMIT ALL PAYMENTS TO SNOWSOUND USA. ***</td>
	</tr>
	<tr>
		<td>2.5% - 3.0% processing fee will apply to credit card payments</td>
	</tr>
	<tr>
		<td>Please note that all Snowsound Orders cannot be cancelled without the written consent of Snowsound USA. Substantial cancellation/re-stocking charges are applicable.</td>
	</tr>
	<tr>
		<td>F.O.B. Origin:<br />Risk of loss to products furnished hereunder, or any part of the same, shall pass to dealer upon delivery of the products to carrier F.O.B. ORIGIN regardless of whether freight charges are paid by SNOWSOUND U.S.A. OR DEALER. Until SNOWSOUND U.S.A. receives the full payment of Product, Snowsound U.S.A. shall have a security interest in the Product.</td>
	</tr>
	<tr>
		<td>There is a minimum $65 freight charge.</td>
	</tr>
	<tr>
		<td>*Not all products quoted may be in stock. Please verify colors and availability.</td>
	</tr>
</table>
';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
//$pdf->Output('test.pdf', 'I');
//ob_clean();
//$pdf->Output("../all-quotes/".$my_quote[0]["q_number"].'.pdf', 'F');
$pdf->Output("/home/mysnow/current/all-quotes/".$my_quote[0]["q_number"].'.pdf', 'F');
?>