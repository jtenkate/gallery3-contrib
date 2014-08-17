<?php defined("SYSPATH") or die("No direct script access.")
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2013 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Basket_Plus version 1.2
 */  
?>
<SCRIPT language="JavaScript">
	function back(){
		history.go(-1);
	}

  function isValidEmail(s){
    return (s.indexOf(".")>1)&&(s.indexOf("@")>0);
  }

  function isHotmail(s) { //not used
    return(s.indexOf("hotmail")==-1)
  }

  function se(val){
    val.style.backgroundColor="#FAA";
  }

  function re(val){
    val.style.backgroundColor="#FFF";
  }

  function checkInput(val){
    if ((!val.value) || (val.value.length==0)) {se(val);return false;}
    re(val);
    return true;
  }
	//mandatory fields with all delivery options
  function checkMandatory() {
    var pass=true;
    var doc=document.checkout;
    //check initials
    if(!checkInput(doc.initials)){pass=false;}
    //check name
    if(!checkInput(doc.fname)){pass=false;}
    //check phone if required
		if(doc.phonereq.value==true){
			if(!checkInput(doc.phone)){pass=false;}
		}
    //check email
    if((!checkInput(doc.email))||(!isValidEmail(doc.email.value))){
			se(doc.email);pass=false;
		}
		
		if (!pass){
				alert(doc.msg_req_all.value);
    }
    return pass;  
  }
	//mandatory fields with all delivery option MAIL
  function checkAddress() {
    var pass=true;
    var doc=document.checkout;
    //check address
    if(!checkInput(doc.street)){pass=false;}
    if(!checkInput(doc.house)){pass=false;}
    if(!checkInput(doc.postalcode)){pass=false;}
    if(!checkInput(doc.town)){pass=false;}
    if (!pass){
				alert(doc.msg_req_address.value);
    }
    return pass;  
  }
	//mandatory fields with all delivery option PICKUP
  function checkRef() {
    var pass=true;
    var doc=document.checkout;
    //check additional reference if order ref is used
		if(doc.useorderref.value==true){
			if(!checkInput(doc.order_ref1)){pass=false;}
			if(!checkInput(doc.order_ref2)){pass=false;}
		}
    if (!pass){
				alert(doc.msg_req_ref.value);
    }
    return pass;  
  }
  function checkTerms() {
    var doc=document.checkout;
    //check agreeTerms if required
		if(doc.termsreq.value==true){
			if(doc.agreeterms.checked==false){
					alert(doc.msg_agree_terms.value);
				return false;
			}
    }
    return true;
  }
  //checkout with pickup
  function checkCheckoutPickup() {
    if (checkMandatory()){
			if (checkTerms()) {
				if (checkRef()){
					document.checkout.submit();
				}
			}
    }
  }
  //checkout with e-mail
  function checkCheckoutEmail() {
    if (checkMandatory()){
			if (checkTerms()) {
				document.checkout.submit();
			}
    }
  }
  //checkout with pack&post
  function checkCheckoutMail() {
    var pass=true;
    if (checkMandatory()){
      if (checkAddress()) {
        if (checkTerms()) {
          document.checkout.submit();
        }
      }
    }
  }
</SCRIPT>

<div class="g-block">
<h2><?= t("Delivery and Contact (Step 1 of 3)") ?></h2>
  <div id="b-complete">
  <? 
	$payment_details = basket_plus::getBasketVar(PAYMENT_OPTIONS); 
  $webshop = basket_plus::getBasketVar(WEBSHOP);
  $payment_details = basket_plus::replaceStrings($payment_details,Array("webshop"=> $webshop));
	/* here the payment options text is loaded */
	if ($payment_details):?>
    <div class="basket-right" id="payment">
      <h3> <?= t("Payment Options") ?></h3>
      <?= $payment_details; ?>
    </div>
  <? 
	endif;
	/* here the form is loaded */?>
	<?= $form ?>
  <div><label><?= t("* required field") ?><br/></label></div>
		<div class="basketbuttons">
			<a href="javascript:back();" class="left g-button ui-state-default ui-corner-all ui-icon-left">
				<span class="ui-icon ui-icon-arrow-1-w"></span><?= t("Back to Basket") ?></a>
			<?
			/* check for pack&post */
			$basket = Session_Basket::get();
			$postage = $basket->postage_cost();

			/* Pickup not selected and postage cost */
			if ($basket->pickup && $postage > 0):?>
			<a href="javascript: checkCheckoutPickup()" class="right g-button ui-state-default ui-corner-all ui-icon-right">
				<span class="ui-icon ui-icon-arrow-1-e"></span><?= t("To Order Confirmation") ?></a>
		<? /* Pickup selected and postage cost */
			elseif ($postage > 0):?>
			<a href="javascript: checkCheckoutMail()" class="right g-button ui-state-default ui-corner-all ui-icon-right">
				<span class="ui-icon ui-icon-arrow-1-e"></span><?= t("To Order Confirmation") ?></a>
		<? /* no postage cost */
			else: ?>
			<a href="javascript: checkCheckoutEmail()" class="right g-button ui-state-default ui-corner-all ui-icon-right">
				<span class="ui-icon ui-icon-arrow-1-e"></span><?= t("To Order Confirmation") ?></a>
		<? endif; ?>
		</div>
  </div>
</div>
