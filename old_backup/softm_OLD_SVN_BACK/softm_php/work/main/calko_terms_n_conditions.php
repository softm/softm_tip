<?
/*
 Filename       : /calko/calko_spec_interface_write.php
 Fuction        : Characteristic Code 조회
 Comment        :
 Make   Date    : 2009-08-21,
 Update Date    : 2009-11-27, v1.0 first
 Writer         : 김지훈
 Updater        :
 @version       : 1.0
*/
?>
<?php
define ("HOME_DIR" , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE'  , 'CALKO' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../service');

require_once '../inc/calko.lib'   ; // calko.lib
require_once '../inc/calko_array.lib'   ; // calko_array.lib

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
$op = strtolower(trim($_REQUEST["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance

$backurl = $_GET['backurl']?$_GET['backurl']:$REQUEST_URI ;
if ( $backurl ) Session::setSession('backurl',$backurl);
$backurl = Session::getSession('backurl');

if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( !$grant[$_SERVER['PHP_SELF']][$memInfor[user_level]] ) {
    require_once '../inc/inner_header.php'; // header
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    window.onload = function() {
        Alert.show({id:'message_box',message:'This identification is not authorized..'});
    }
//-->
</SCRIPT>
<?
    require_once '../inc/footer.php'; // footer
} else {
if ( $op == 'default' ) {
    require_once '../inc/header.php'   ; // header
?>
<link type="text/css" rel="stylesheet" href="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT LANGUAGE="JavaScript">
<!--
var _info = {};
var _url = '<?print $_SERVER['PHP_SELF']?>';
var destGory = {};
var accounting_year = '<?=ACCOUNTING_YEAR?>';
function fConfirm() {
    if(!$('agreement').checked) {
        alert('You must agree to contract');
        Effect.twinkle($('agreement'));
        Effect.twinkle($('agreement_content'));
        $('agreement').focus();
    } else {
        if ( confirm('Do you accept the terms?') ) {
            var ajaxS = new asyncConnector('xmlhttp');
            var url = _url
                    + '?op=exec_agreement_confirm'
            ;
            var params  ='p_agreement=Y';
            ajaxS.httpOpen('POST', url, true,params, null,
                function() {
                    var info = ajaxS.responseText().split('|');
                    var s = info[0];
                    var m = info[1];
                    var k = info[2];
                    var msg = info[3];
                    if (s == 'SUCCESS') { // success
                        document.location.href = "calko_spec_interface_write.php";
                    } else if (s == 'ERROR') {
                        alert(info[3]); // error
                    }
                }
            );
        }

    }
}
window.onload = function() {
    document.title = 'Standard Terms and Conditions of Sales Elevators';
    $('confirmBtn').attachEvent('onclick', fConfirm)
}
//-->
</SCRIPT>
<Style>
* {font-family:'Arial';font-size:10pt}
textarea { width:100% }
.content {
    margin:5px;
    padding:10px;
    font-weight:normal;
    width:795px;
    height:<?print ($memInfor['agreement'] == 'Y'?'355':'318');?>px;
    word-break:break-all;
    word-wrap:break-word;
    overflow-x:hidden;overflow-y:auto;
    border:1px solid black;
    background-color:#FFFFFF;
}
.content * {
    font-size:9pt;
    font-weight:normal;
}

pre {white-space:pre-wrap;}
span.title { font-weight:bold;font-size:12pt }

#signed, #confirm {
    width:817px;
    border-collapse:collapse;
    /*border:1px solid blue;*/
    margin:5px;

}

#signed td{
    padding:5px
}

#definitions {
    width:745px;
    margin-left:8px;
    border-collapse:collapse;
    /*border:1px solid blue;*/
    table-layout:fixed;

}
#definitions td{
    padding:5px
}
#definitions td.title{
    font-size:9pt;
    width:260px;
    /*color:red;
    background-color:red;*/
}
</Style>
<h2 style='width:795px;font-size:14pt;text-align:center'>Standard Terms and Conditions of Sales
<BR>Elevators</h2>

<div class=content style=''>
<pre>
This Agreement is made by

<span class=title>THYSSENKRUPP ELEVATOR FIELD OPERATION</span>
refers to the respective sales organization under each Business Unit of ThyssenKrupp Elevator around the world.

(hereinafter referred to as “BUYER”)

and

<span class=title>THYSSENKRUPP ELEVATOR (KOREA) LTD.</span>, a corporation established and existing under the laws of the Republic of Korea, having its registered office at 55-30, Oryu-dong, Guro-gu, Seoul 152-100, Korea and its factory at 115-24, Shindu-ri, Yibjang-myeon, Seobuk-gu, Cheonan-city, Chungcheongnamdo 330-820, Korea.

(hereinafter referred to as “SELLER”)

BUYER and SELLER are hereinafter referred to as “PARTIES” or “PARTY”, as the case may be.

<span class=title>WHEREAS</span>
The PARTIES wish to facilitate their business by determining certain framework principles containing general terms and conditions for the execution of orders between them.

<span class=title>§ 1 – Definitions</span>
<TABLE border=1 id=definitions>
<TR><TD class=title>“BINDING ORDER”                    </TD><TD class=value>PURCHASE ORDER and final SPECIFICATION MEMORANDUM provided by the BUYER to the SELLER within the respective ORDER PERIOD</TD></TR>
<TR><TD class=title>“BY-PARTS”                         </TD><TD class=value>No-Warranty Spare parts ordered by the BUYER and shipped together with the PRODUCT</TD></TR>
<TR><TD class=title>“CIF”                              </TD><TD class=value>Cost, Insurance, and Freight (named destination port): the SELLER must pay the costs, procure and pay insurance and freight to bring the goods to the port of destination. Risk is transferred to the BUYER once the goods have crossed the ship’s rail. Based on INCOTERMS 2000</TD></TR>
<TR><TD class=title>“CIP”                              </TD><TD class=value>Carriage, Insurance Paid to (named destination dry port): the SELLER must pay the costs, procure and pay insurance and freight to bring the goods to the dry port of destination. Risk is transferred to the BUYER once the goods have been handed over to the first carrier. Based on INCOTERMS 2000  </TD></TR>
<TR><TD class=title>“CONTRACT GAD”/”Scaled GAD”        </TD><TD class=value>General Arrangement Drawing with reference to the specific building dimensions.</TD></TR>
<TR><TD class=title>“DDP”                              </TD><TD class=value>Delivered Duty Paid (named destination): the SELLER must deliver the goods to the BUYER cleared for import, but not unloaded, to the destination. Based on INCOTERMS 2000</TD></TR>
<TR><TD class=title>“EXW”                              </TD><TD class=value>Ex Works (named place): the SELLER makes the goods available at his premises and risk passes to the BUYER on the agreed date. Based on INCOTERMS 2000</TD></TR>
<TR><TD class=title>“FOB”                              </TD><TD class=value>Free on Board (named shipping port): the SELLER is responsible for all costs and risks to the shipped PRODUCTS until it is placed on board the BUYER-designated vessel. “On board” is defined as crossing the ship’s rail. The SELLER is also responsible for export clearance. Based on INCOTERMS 2000</TD></TR>
<TR><TD class=title>“FORECASTED DELIVERY DATE”         </TD><TD class=value>Shipment Date out of SELLER’s facility as stated in the BUYER’s PURCHASE ORDER</TD></TR>
<TR><TD class=title>“NON STANDARD PRODUCTS”            </TD><TD class=value>PRODUCTS which require additional engineering work by the SELLER; normally the price cannot be calculated directly on the basis of the SELLER’s calculation program NON-STANDARD Elevators are not included in the SELLER’s standard QUOTATION SYSTEM</TD></TR>
<TR><TD class=title>“ORDER PERIOD”                     </TD><TD class=value>Period of time, starting from the date of the SELLER’s PRICE QUOTATION, which is available for the BUYER to make effect a BINDING ORDER</TD></TR>
<TR><TD class=title>“PRICE QUOTATION”                  </TD><TD class=value>Binding offer of the SELLER to the BUYER confirming the price of a specific Project</TD></TR>
<TR><TD class=title>“PRODUCTION START NOTICE”          </TD><TD class=value>Written request of the BUYER to the SELLER that triggers production. By the PRODUCTION START NOTICE, the BUYER announces to the SELLER the requested date of shipment, the REQUESTED DELIVERY DATE</TD></TR>
<TR><TD class=title>“PRODUCTS”                         </TD><TD class=value>100% complete or significantly completed Elevator Systems</TD></TR>
<TR><TD class=title>“PURCHASE ORDER”                   </TD><TD class=value>Written request from BUYER to SELLER to supply PRODUCTS at a specified price at the FORECASTED DELIVERY DATE</TD></TR>
<TR><TD class=title>“QUOTATION SYSTEM”                 </TD><TD class=value>CALKO, a web-based calculation program directly linked to the ERP (SAP) system of SELLER</TD></TR>
<TR><TD class=title>“QUALITY STANDARD”                 </TD><TD class=value>SELLER’s quality standard like ISO 9001 etc.</TD></TR>
<TR><TD class=title>“REQUESTED DELIVERY DATE”          </TD><TD class=value>Shipment Date out of SELLER’s facility as stated in the PRODUCTION START NOTICE</TD></TR>
<TR><TD class=title>“REQUESTED MANUFACTURING LEAD TIME”</TD><TD class=value>Period of time from PRODUCTION START NOTICE  until REQUESTED DELIVERY DATE                                                                                   </TD></TR>
<TR><TD class=title>“SERVICE”                          </TD><TD class=value>On-site works, including but not limited to installation, modernization, maintenance, and trouble-shooting, that is provided by the SELLER at the request of the BUYER                                                                                                                                 </TD></TR>
<TR><TD class=title>“SPARE PARTS”                      </TD><TD class=value>Components of PRODUCTS or other apparatus that are not BY-PARTS or WARRANTY PARTS, but which are ordered by the BUYER in the course of the BUYER’s service business                                                                                                                                    </TD></TR>
<TR><TD class=title>“SPECIFICATION MEMORANDUM”         </TD><TD class=value>Technical product description reflecting technical and aesthetic details as a base for the price quotation. The SPECIFICATION MEMORANDUM has to be agreed in writing between SELLER and BUYER                                                                                                          </TD></TR>
<TR><TD class=title>“STANDARD GAD”/”NON-Scaled GAD”    </TD><TD class=value>General Arrangement Drawing prepared by the SELLER to the BUYER, showing an overview drawing of the equipment not related to the actual building dimension                                                                                                                                             </TD></TR>
<TR><TD class=title>“STANDARD MANUFACTURING LEAD TIME” </TD><TD class=value>The standard period of time required by the SELLER to prepare and perform the manufacture of the desired PRODUCTS from the date of issue of the PRODUCTION START NOTICE (prior notified by SELLER)                                                                                                     </TD></TR>
<TR><TD class=title>“STANDARD PRODUCTS”                </TD><TD class=value>PRODUCTS which do not require additional engineering work by the SELLER; normally the price can be calculated on the basis of the SELLER’s QUOTATION SYSTEM                                                                                                                                            </TD></TR>
<TR><TD class=title>“WARRANTY PARTS”                   </TD><TD class=value>The extra components of PRODUCTS or other apparatus that are required to be supplied by the SELLER in order to meet the contractually agreed warranty obligations                                                                                                                                      </TD></TR>
</TABLE>

<span class=title>§ 2 – Scope</span><UL type=1><LI>This agreement governs the terms and conditions at which PRODUCTS are sold by ThyssenKrupp Elevator (Korea) Ltd. (“TKEK”) as SELLER to affiliated TKE Field companies as BUYER. Any direct sales of TKEK to entities other than affiliated TKE Field companies are not subject of this agreement.</LI>
      <LI>The terms and conditions set out in this agreement will be the only applicable terms and conditions. Any exceptions must be mutually agreed between the PARTIES in writing.</LI>
      <LI>The SELLER agrees to supply the PRODUCTS and SPARE PARTS to the BUYER. SPARE PARTS are excluded from the terms and conditions of this agreement.</LI>
      <LI>The SELLER and the BUYER will negotiate under the “Arm’s Length” principle to determine the applicable selling price for the sale of PRODUCTS, SPARE PARTS or SERVICES.</LI>
    </UL>
<span class=title>§ 3 – Function and Responsibilities</span><UL type=1><LI>The BUYER will be solely responsible for ensuring the payment from the third party end customers for any project. The payment status or schedule between the BUYER and the third party customer will not in any way have any adverse impact on the SELLER’s financial position, cash flow, or risk exposure. Razonable</LI>
      <LI>The BUYER will be solely responsible for providing guarantees to the third party end customer. The SELLER will not be required to provide any bidding guarantees, advance payment guarantees, performance guarantees, warranty guarantees, or any financing facilities, directly or indirectly to the third party customer. Razonable</LI>
      <LI>The BUYER will designate a technical country code coordinator and experts on the particular product line ?? ( Inaceptable. No estamos en condiciones de designar en todos los paises un experto en el producto comprado).The BUYER will supply all the relevant country code documents and any other necessary technical documents, with particular relevance for biddings, to the SELLER. The SELLER will evaluate the product technical compliance of any specific country code other than European and Korean. On the SELLER’s request, the BUYER provides support for technical clarification and coordination with the third party end customer. Any deviation from the country code and/or specification will have to be explicitly specified in the quotation from the SELLER to the BUYER.</LI>
      <LI>The BUYER will provide the project management service to the third party end customer if required with the SELLER’s assistance.</LI>
      <LI>The BUYER will promptly obtain building or any other necessary licenses at his own cost and apply for official approval of the equipment system to ensure the prompt project execution.</LI>
      <LI>The SELLER will provide without extra charge the STANDARD GAD to the BUYER.</LI>
    </UL>
<span class=title>§ 4 – Order / Quotation Procedures</span><UL type=1><LI>The BUYER will contact the SELLER directly or through the QUOTATION SYSTEM, as appropriate, to purchase a PRODUCT and contact the SELLER’s Overseas Sales Field Support team for SPARE PARTS or SERVICES.</LI>
  <LI>The technical specifications, duration of quotation validity and delivery schedule for NON-STANDARD PRODUCTS will be agreed in writing before a quotation price can be provided.</LI>
  <LI>The SELLER’s quotation price includes all taxes applicable in Korea. SELLER will inform BUYER in a proper way about the taxes included.</LI>
  <LI>System-based quotations, i.e. derived from the QUOTATION SYSTEM, are considered as budgetary offer and should be confirmed by SELLER prior to contract signing with BUYER’s customer ( si esta dentro del periodo de validez de la oferta y cotizado a traves del sistema, por que hay que pedir confirmacion a fabrica antes de contratar??. Si no nos podemos fiar del sistema para que lo usamos??). Any quotations provided by the SELLER outside of the QUOTATION SYSTEM must be in writing. For NON-STANDARD PRODUCTS the SELLER will provide to the BUYER a price quotation based on the individual specification within a time period not longer than 5 (five) working days.</LI>
  <LI>The SELLER will make quotation prices available to the BUYER through the QUOTATION SYSTEM. This price is subject to updates by the SELLER, which shall become effective immediately. All prices will be denominated in United States Dollar (USD), but other hard currencies can also be used upon mutual agreement between SELLER and BUYER.</LI>
  <LI>Price quotations for projects will be based on the SELLER’s QUOTATION SYSTEM and/or quotation provided directly by SELLER. At the end of the period of validity, a price quotation will automatically expire. All price quotations will be denominated in USD and will be valid for a period of 60 (sixty) calendar days from the date of quotation, but the period of the validity of price can be adjusted by the SELLER’s own discretion in abnormal circumstances.</LI>
  <LI>In the following circumstances, the BUYER should request in writing a special quotation from the SELLER’s Overseas Sales team:
<UL type=disc >
<LI>Technically complex, NON-STANDARD and such PRODUCTS incorporating special imported parts,
whereas for the latter the SELLER has to inform BUYER regularly in writing about the respective PRODUCTS</LI>
<LI>Projects with ORDER PERIOD of more than 60 (sixty) days and projects requiring significantly different than
the STANDARD MANUFACTURING LEAD TIME</LI>
<LI>Projects with expected payment dates later than 12 (twelve) months after PURCHASE ORDER</LI>
<LI>Projects with an unusual Liquidated Damage clause, in which the indemnification by the SELLER exceeds 5%.</LI>
</UL>
For any of the above mentioned special cases, price quotations are to be agreed separately and the remaining STANDARD TERMS AND CONDITIONS OF SALES shall be applicable unless it is explicitly stated otherwise within the price quotation.</LI>
    <LI>In order to place a BINDING ORDER, the BUYER must provide to the SELLER within the respective ORDER PERIOD the PURCHASE ORDER and the SPECIFICATION MEMORANDUM.
The PURCHASE ORDER shall specify for each bank of units with the same shipment date, the FORECASTED DELIVERY DATE. After receipt of these documents, the SELLER will confirm the order in writing to the BUYER. Failure to provide either of the documents by the BUYER before the end of the relevant ORDER PERIOD will render the offer invalid. In the event of an expired quotation, the SELLER’S Overseas Sales team will provide a new quotation upon the BUYER’s request or the BUYER will get it through the QUOTATION SYSTEM where applicable.
The SELLER will confirm all system-based orders within 3 (three) working day after receiving a BINDING ORDER. Non system-based orders will be confirmed within 5 (five) working days after receiving a BINDING ORDER.</LI>
    <LI>In case the BUYER asks the SELLER to provide the CONTRACT GAD, this has to be done latest within 10 (ten) working days after receipt of all relevant documents from the BUYER.</LI>
    <LI>In order to trigger actual production, the BUYER must issue to the SELLER the PRODUCTION START NOTICE. This notice specifies the REQUESTED DELIVERY DATE for each bank of units with the same shipment date. The time from the PRODUCTION START NOTICE until the REQUESTED DELIVERY DATE cannot be shorter than the STANDARD MANUFACTURING LEAD TIME if not explicitly agreed between the SELLER and the BUYER. The SELLER has to confirm to the BUYER the receipt of the PRODUCTION START NOTICE within 3 (three) working day.
Along with the PRODUCTION START NOTICE, the BUYER will provide to the SELLER the approved CONTRACT GAD.</LI>
    <LI>In case the PRODUCTION START NOTICE is delayed and the agreed lead time is not sufficient to reach the forecasted payment date, then the project schedule has to be renegotiated between BUYER and SELLER and the BUYER has to bear all costs associated with such delay and prolongation.</LI>
</UL>
<span class=title>§ 5 – Commercial Terms</span><UL type=1><LI>SELLER’s standard term is FOB or CIF and CIP in combined transport.</LI>
  <LI><FONT COLOR="RED">For every order whose contract value exceeds 100 TEUR, an advance payment of 10% of the contract value shall be applicable in accordance with TKE Payment Term Policy</FONT><FONT COLOR="#007297"> ???? Normalmente no pagábamos anticipo salvo para proyectos muy grandes donde se consensuaba un anticipo. En todo caso 100 TEUR parece bastante baja la cifra. Aumentar el monto gatillo a por ejemplo 350 TEUR. Brasil no nos exige anticipo para ningún contrato.</FONT></LI>
  <LI>The SELLER will issue and date the commercial invoice to the BUYER upon the actual shipment date. <FONT COLOR="red">The payment term is net 30 (thirty) days after the date of bill of lading.</FONT> <FONT COLOR="#007297">En algunos casos y dependiendo del tiempo del flete hay que pagar antes de recibir la mercadería en nuestro puerto lo que nos acarrea problemas de encajes con los pagos del cliente que en general son a la llegada de los equipos a obra. Deberíamos rectificar a 60 días fecha de factura para darnos tiempo a cobrar con el cliente. Brasil nos lo ha concedido y hemos consensuado en todos los caso 60 días fecha de factura. Este punto para nosotros es fundamental para cumplir con las normas de autofinanciamiento de las obras.</FONT></LI>
  <LI>Under special circumstances, payment terms longer than 30 (thirty) days are possible for SELLER and BUYERS and require the written approval of the SELLER. In this case, the SELLER will factor the applicable interest charges into the price quotation and invoice amount based on the applicable interest rate mentioned under § 5 (12) of this agreement.</LI>
  <LI>Invoices will be issued in USD or other agreed currencies between SELLER and BUYER in necessary cases.</LI>
  <LI>The SELLER is not permitted to conduct partial deliveries unless the BUYER explicitly authorizes the SELLER in writing. If the partial delivery is not explicitly requested by the BUYER, the SELLER has to bear all verifiable costs incurred by the BUYER.</LI>
  <LI><FONT COLOR="red">The BUYER is entitled to 30 (thirty) calendar days of free storage starting from the REQUESTED DELIVERY DATE. Upon the expiration of the free storage period, the SELLER will move all goods produced to an outside warehouse of logistics provider and charge the BUYER all the associated cost at an actual expenses base.</FONT> <FONT COLOR="#007297">Razonble. Agregar al texto “ siempre y cuando sean fehacientemente demostrados los extracostes”.</FONT></LI>
  <LI><FONT COLOR="red">In addition to the aforementioned fees, the SELLER reserves the right to levy additional charges on the BUYER to cover additional finance costs and exchange rate fluctuations where the date of delivery is postponed from the FORECASTED DELIVERY DATE at the fault of the BUYER or third party end customer.</FONT> <FONT COLOR="#007297">Idem anterior.</FONT></LI>
  <LI>In case of cancellation of the PURCHASE ORDER prior to the PRODUCTION START NOTICE, the SELLER reserves the right to levy additional charges on the BUYER to cover cost from the cancellation of the hedging arrangement.</LI>
  <LI><FONT COLOR="red">In case of cancellation of the PURCHASE ORDER after the PRODUCTION START NOTICE, the following rules shall apply;

SELLER is entitled to receive a maximum of 50% of the agreed PURCHASE ORDER price from the BUYER against verifiable actual cost. For all NON-STANDARD PRODUCTS, the SELLER will charge to the BUYER the total of the verifiable actual costs incurred to the SELLER plus a mark-up of 10%.</FONT>

<FONT COLOR="#007297">Por que el mark up. Creemos que no nos deberían cobrar un mark up por ser una empresa del grupo.</FONT></LI>
  <LI><FONT COLOR="red">In case PRODUCTS are not picked up by the BUYER after 180 (one hundred and eighty) days starting from the REQUESTED DELIVERY DATE, the SELLER has the right to cancel the order upon prior information and charge verifiable actual costs to the BUYER with a mark-up of 10%.</FONT> <FONT COLOR="#007297">Idem anterior.</FONT></LI>
  <LI>The SELLER will charge interest on late payments by the BUYER at an annual rate equivalent to the prevailing TKE AG WACC (weighted average cost of capital) plus any additional finance cost (such as roll-over hedging expenses). In case of repeated delays in payment, the SELLER reserves the right to continue supplying the BUYER only against advance payment or collateral security.</LI>
  <LI><FONT COLOR="red">As soon as BINDING ORDER is made effective by the BUYER, the SELLER arranges hedging of the respective foreign currency risk based on the information provided by the BUYER. Such information comprises the FORECASTED DELIVERY DATE as per PURCHASE ORDER and the payment term. In monitoring the hedging arrangement, the SELLER’s Overseas Sales team will have to reconfirm with the BUYER the latest project schedule. Should there be any changes in the payment dates or payment amounts due to reasons the SELLER is not responsible for then the BUYER shall bear all such costs referring to interest expenses and/or additional hedging cost/income of the SELLER.</FONT> <FONT COLOR="#007297">Razonable siempre y cuando sean fehacientemente demostrados los mayores costos incurridos.</FONT></LI>
</UL>
<span class=title>§ 6 – Spare Parts</span><UL type=1><LI>The SELLER and the BUYER will mutually agree on the BY-PARTS. The BY-PARTS are shipped together with the PRODUCT and must be included in the PURCHASE ORDER.</LI>
  <LI>Agreed WARRANTY PARTS required for meeting warranty obligations will be provided by the SELLER upon the request of the BUYER as soon as reasonably possible free of any charge (under reasonable conditions) based on DDP terms . The BUYER will perform any required customs formalities and procedures while the SELLER is obliged to compensate the BUYER for any verifiable costs which the BUYER incurs in the performance of this duty. The standard warranty period will be applied for these WARRANTY PARTS starting at the date of delivery <FONT COLOR="#007297">( no estoy de acuerdo. Tendria que ser a partir que la pieza reemplace la original. Por favor corregir). </FONT>The SELLER will also supply SPARE PARTS which may be required by the BUYER for the maintenance and repair work beyond the warranty period. The BUYER agrees to place separate PURCHASE ORDERS for additional SPARE PARTS, subject to separate terms and conditions.</LI>
  <LI>In any event where the SELLER proves the cause of the Warranty case being due to a failure of the BUYER, the BUYER shall bear all related costs.
</UL>
<span class=title>§ 7 – Delivery</span><UL type=1><LI>The delivery of PRODUCTS has to be fulfilled according to the conditions as set out in the PURCHASE ORDER (from the SELLER accepted and confirmed) and in this agreement.</LI>
  <LI>The SELLER will supply in English language spare part catalog, installation manual, electrical diagram, type test certificate and CONTRACT GAD to the BUYER. Production drawings, process quality control documentation, or any other engineering work will not be included in the scope of delivery, but can be delivered with separate agreement if BUYER is explicitly requesting it.</LI>
  <LI><FONT COLOR="red">The SELLER shall be liable to pay 0.1% of total PURCHASE ORDER price to the BUYER as liquidated damage for each day of delay of the agreed delivery if the delay was apparently caused by SELLER’s fault, but the total amount of liquidated damage shall not exceed 5% of the total PURCHASE ORDER amount and the SELLER shall not be responsible for any consequential damage from the delayed delivery.</FONT> <FONT COLOR="#007297">0.1% diario es muy poco. 10 días de atraso que para nosotros puede ser muy importante les representa 1% de multa. El tope es razonable. Seria razonable un 0.2% diario y si el atraso supero los 15 días, el tope se vaya a 10%. De esta manera seria similar a las clausulas que nosotros aceptamos con nuestros clientes.</FONT></LI>
  <LI><FONT COLOR="red">The delivery period shall reasonably be extended or prolonged in the event of an “act of God” or other unforeseeable events (“force majeure”) which occurs beyond the SELLER’s control, and the SELLER shall be released from any obligations and liabilities to the BUYER. </FONT><FONT COLOR="#007297">( siempre y cuando la causal sea fehacientemente demostrada)</FONT></LI>
</UL>
<span class=title>§ 8 – Product Inspection & Claims</span><UL type=1><LI>The BUYER will be entitled to inspect the PRODUCTS manufactured by the SELLER on site pursuant to any delivery and will have access to further production and testing information for the purpose of assessing the product quality.

The BUYER should inspect the packaging and quantity of the shipped goods immediately ( asap) after the goods arrived at site, and should raise any claims against physical and visible damage to the packaging and missing parts or short shipment immediately it found, but not later than one week after the arrival date.</LI>

  <LI>The SELLER’s Overseas Sales Field Support team will be engaged to indentify the causes of the claim and approve any claims against the SELLER. Any claims against the SELLER will be processed independently from the payment of the purchase. The payment of the claim will not be offset against the equipment payment or any other payment unless mutually agreed between SELLER and BUYER.</LI>
  <LI>For any claims, the following principles shall apply:<UL type=a>
<LI>The SELLER confirms the receipt of the claim within 2 (two) working days and replies to the BUYER’s claim within 5 (five) working days with a solution to the raised issue.</LI>
<LI><FONT SIZE="red" COLOR="red">In all cases where the reason for the claim is caused by the SELLER, the BUYER and the SELLER will find a mutual agreement on the rectification of the damage. In any case, the SELLER will bear all costs associated with the claim, including but not limited to material and shipping costs. The BUYER will provide SELLER’s Overseas Sales Field Support team with evidences, e.g. photos. The SELLER’s Overseas Sales Field Support team will determine the root causes of the problem and will clarify whether this root cause of the claim is the result of the SELLER’s or the BUYER’s faults. All associated costs shall be borne by the party determined faulty.</FONT> <FONT COLOR="#007297">En el caso que la responsabilidad sea del SELLER, los costos incurridos asociados serán facturados y deberán cancelarse a los 30 días de fecha de factura. Los costos a pagar deberán incluir no solamente materiales , sino cualquier costo derivado del fallo incluyendo trabajos realizados localmente, mano de obra, posibles multas por retrasos, etc.</FONT></LI>
</UL></LI>
<LI>The SELLER will supply in accordance with the agreed delivery schedules (REQUESTED DELIVERY DATE). In the event that the SELLER cannot meet the agreed delivery schedule or can only partially supply, then the SELLER shall immediately inform the BUYER and agree to earliest revised shipment schedule. <FONT COLOR="#007297">Cualquier daño o perjuicio adicional demostrable fehacientemente ocasionado por el no cumplimiento de las fechas acordadas, será imputable al SELLER.</FONT></LI>
</UL>
<span class=title>§ 9 – Product Liability and Insurance</span><UL type=1><LI>The SELLER maintains proper Product Liability insurance and, if necessary according to the agreed delivery terms, All Risks Transport insurance in accordance with the ThyssenKrupp Risk Insurance policy. Any excessive Product Liability will fall under the global ThyssenKrupp Risk Insurance policy and is to be indicated by the BUYER to the SELLER before contract signing.</LI>
  <LI>The SELLER will not purchase any additional Professional Indemnity Insurance and the SELLER will not be liable for any consequent liabilities.</LI>
</UL>
<span class=title>§ 10 – Warranty and Claims</span><UL type=1><LI>If not otherwise agreed between BUYER and SELLER, the SELLER’s Warranty Policy is applicable.</LI>

<LI>The SELLER warrants that all PRODUCTS delivered are brand-new, have the contractually agreed characteristics, correspond to the relevant state of science and technology and do not have any defects which cancel or reduce their value or suitability for the normal use and the purposes intended by the BUYER. Unless any further requirements are specified in the PURCHASE ORDER, The SELLER warrants the supply of the PRODUCTS in accordance with the legal and technical rules applying at the place of receipt or use as stated in the PURCHASE ORDER.</LI>

<LI>The limited warranty only covers parts requirement, and the SELLER will provide replacements at its own risk and expense. Compensation of labor or third party service provider costs should be negotiated with the SELLER in advance. (see mutual agreement under 8 (3.b). The limited warranty DOES NOT cover damages due to:<UL type=a><LI>acts of God, force majeure, accident, misuse, abuse, negligence; or</LI>
  <LI>improper operation or maintenance of the PRODUCT; or</LI>
  <LI>normal wear and tear.</LI></UL>
The limited warranty DOES NOT apply when the malfunction results from the use of the PRODUCT in conjunction with accessories, PRODUCTS or ancillary or peripheral equipment, or where it is determined by the SELLER that there is no fault with the PRODUCT itself. The SELLER is ONLY responsible for the PRODUCT purchased.</LI>
  <LI>This limited warranty will be rendered invalid if the BUYER installs any parts or components, being hardware or software, from any non-ThyssenKrupp third parties. <FONT COLOR="#007297">Esto es cuestionable. Habría que investigar si la instalación de la parte o componente tiene o no que ver con la falla.</FONT></LI>
  <LI>The SELLER guarantees that the BUYER acquires good title to the PRODUCTS purchased hereunder at the time of their delivery, free and clear of all liens and encumbrances.</LI>
  <LI>The warranty period for defect liability claims will be 12 (twelve) months after beginning of commercial operation (date of acceptance by the owner), or at the most, for 18 (eighteen) months after the date of shipment, provided the PRODUCT is stored properly.</LI>
  <LI>All warranty claims will be raised to the SELLER’s Overseas Sales Field Support team. The claim has to be raised in writing immediately, at the latest within 5(five) working days <FONT COLOR="#007297">( pretenderiamos como minimo 15 dias laborables)</FONT> of the occurrence of a defect. The Overseas Sales Field Support team will be engaged to identify the causes of the claim and approve any claims against the SELLER. <FONT COLOR="#007297">(El reclamo debera incluir material y mano de obra)</FONT></LI>
  <LI>For any service outside of the SELLER’s national jurisdiction, the SELLER and the BUYER will mutually consider national tax rules and agree on an adequate procedure to comply with them. The BUYER will issue a work PURCHASE ORDER and the same terms and conditions set forth within this DOCUMENT should be applicable.</LI>
  <LI>The BUYER warrants that any maintenance of the PRODUCTS is performed by skilled technicians according to the service manual of the SELLER. Any service activities need to be documented. <FONT COLOR="#007297">No tenemos manuales de mantenimiento entregados por ustedes. En todo caso deberian enviarnoslos en ingles)</FONT></LI>
</UL>
<span class=title>§ 11 – Term</span><UL type=1><LI>These Terms and Conditions will come into force with effect from January 1, 2010 and remain in full force until superseded or terminated by mutual agreement. Any changes, adjustments or other agreements must be signed in written to become effective.
</UL>
</pre>
</div>
<?
if ( $memInfor['agreement'] != 'Y' ) {
?>
<BR>
<TABLE border=0 id=confirm>
<TR>
    <TD><span id='agreement_content' style='font-size:11pt'><input type=checkbox id='agreement'> I agree to the contract.</span></TD>
    <TD align=right><button class=button1 id=confirmBtn>Confirm</button></TD>
</TR>
</TABLE>
<?
}
?>
<!-- <TABLE border=1 id=signed bordercolor=black>
<TR><TD class=title>Signed for and on behalf of:</TD><TD class=value>Signed for and on behalf of:</TD></TR>
<TR><TD class=title>THYSSENKRUPP ELEVATOR<br></TD><TD class=value>THYSSENKRUPP ELEVATOR<br>(KOREA) LTD.</TD></TR>
<TR><TD class=title>_______________________________________________</TD><TD class=value>_______________________________________________</TD></TR>
<TR><TD class=title></TD><TD class=value>Jin Bae CEO</TD></TR>
<TR><TD class=title>_______________________________________________</TD><TD class=value>_______________________________________________</TD></TR>
<TR><TD class=title></TD><TD class=value>JY Yi CEO</TD></TR>
</TABLE> -->
<?
    require("../inc/footer.php"); // footer

} // end if [op=="default"]
else if ( $op == "exec_agreement_confirm") {
    $p_agreement = $_POST["p_agreement"]; // p_agreement
    $errors = array();
    $m = $op;
    if ( $p_agreement ) {
        $db->getConnect();

/*
        $sql = "SELECT 'a' ";
        $r = $db->get($sql);
        $country_code= $r->COUNTRY_CODE ;
*/
        if ( $db->starttransaction() ) {
            $sql = " UPDATE"
                    . " tbl_member "
                    . " SET "
                    . " AGREEMENT      = 'Y',"
                    . " AGREEMENT_DATE = now()"
                    . " WHERE USER_NO= '" . $memInfor[user_no] . "'\n"
            ;

            if ( !$db->exec($sql) ) {
                $errors[] = xlate('tbl_member update failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            }

            if ( !empty($errors) ) {
                $errors[] = xlate('Transaction Rollback.');
                $db->rollback();
            } else {
                if ( $db->commit() ) {
                    Session::setSession('agreement','Y');
                } else {
                    $errors[] = xlate('Data Not Valid!');
                }
            }
        } else {
            $errors[] = xlate('Start Transaction Error');
        }
        $db->release();
    } else {
        $errors[] = xlate('parameter invalid passing');
    }

    if (!empty($errors)) print ('ERROR|'   . $op . '|' . $p_agreement  . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $op . '|' . $p_agreement  . '|' . '');
} // exec_agreement_confirm

} // end grant
} // end login
?>