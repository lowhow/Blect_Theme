<!--
Do not modify the NAME value of any of the INPUT fields
the FORM action, or any of the hidden fields (eg. input type=hidden).
These are all required for this form to function correctly.
-->
<form role="form" class="form-inline" method="post" action="http://emm.adsmart.com.my/form.php?form=7" id="frmSS7" onSubmit="return CheckForm7(this);">
	<div class="form-group">
		<div class="input-group">
	    	<input type="text" class="form-control" name="email" value="" placeholder="您的电邮"> 
	    	<span class="input-group-btn">
				<button id="subscribesubmit" class="btn btn-danger" type="submit"><i class="fa fa-envelope fa-fw fa-lg"></i> 订阅 </button> 
			</span>
	    </div>
	    <input type="hidden" name="format" value="h">
    </div>  	
</form>

<script language="javascript">
    function CheckMultiple7(frm, name) {
        for (var i=0; i < frm.length; i++)
        {
            fldObj = frm.elements[i];
            fldId = fldObj.id;
            if (fldId) {
                var fieldnamecheck=fldObj.id.indexOf(name);
                if (fieldnamecheck != -1) {
                    if (fldObj.checked) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    function CheckForm7(f) {
        if (f.email.value == "") {
            alert("Please enter your email address.");
            f.email.focus();
            return false;
        }
    
            return true;
        };
</script>