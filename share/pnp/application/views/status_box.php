<div class="ui-widget">
 <div class="ui-widget-header ui-corner-top">
Status
 </div>
 <div class="p4 ui-widget-content ui-corner-bottom">
<?php if(isset($host)) echo "<strong>Host:&nbsp;</strong>".
	html::anchor('graph'.
	"?host=".$lhost,
	html::specialchars(pnp::shorten($host))."<br>");?>
<?php if(isset($service)) echo "<strong>Service:&nbsp;</strong>" .
	html::anchor('graph'.
	"?host=".$lhost.
	"&srv=".$lservice,
	html::specialchars(pnp::shorten($service))."<br>");?>
<?php if(isset($timet)) echo "<strong>Last Check:&nbsp;</strong>$timet<br>"?>
 </div>
</div>
<p>
