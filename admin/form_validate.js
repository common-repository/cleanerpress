(function ($) {

$(document).ready(function(){
		$('.wrap').on('focus','input[class!="colpick"], textarea',function(e){val_mblue(e.target,false);});
		$('.wrap').on('blur','input[class!="colpick"], textarea',function(e){val_blur(e.target,false);});
});

function val_mblue(elem){
		var chk = ($(elem).attr("type")==undefined)  ? false : $(elem).is(':checkbox') || $(elem).is(':radio');
		if (!chk){
	var feed_back=	$(elem).parent().closest('.lblmiddle').next('.lblhint');
	$(feed_back).removeClass("lblhintok lblhinterror").addClass("lblhinttext");
	var dh=($(elem).attr("data-hint")==undefined) ? "" : $(elem).attr("data-hint");
	$(feed_back).html(dh);
	$(elem).css('background','#ffffff');
	if (!$(elem).hasClass('val-glowred')){
	$(elem).addClass('val-glowblue');
	}
}
}

/**
 *
 * @access public
 * @return void
 **/
function val_blur(elem,ret_val){
	var feed_back=	$(elem).parent().closest('.lblmiddle').next('.lblhint');
	var chk = ($(elem).attr("type")==undefined)  ? false : $(elem).is(':checkbox') || $(elem).is(':radio');
	
		if (!chk) {
			$(elem).removeClass('val-glowblue val-glowgreen val-glowred')

			var required = ($(elem).attr("data-req")==undefined)  ? false : $(elem).attr("data-req")=="true";
			var reg_exp = ($(elem).attr("data-val")==undefined || $(elem).attr("data-val")=="" )  ? false :
			new RegExp( $(elem).attr("data-val"),'gim'); /** modifiers cant be passed as part of the pattern */


		if(required && $(elem).val()=="" ){
		$(feed_back).html("This field is required!");
		$(feed_back).addClass('lblhinterror').removeClass("lblhintok lblhinttext");
		$(elem).addClass('val-glowred');
//		$(elem).css('background','red');
		return false;

		} else if ($(elem).val()!="" && (reg_exp!=false  && !$.isArray($(elem).val().match(reg_exp))) ){
		var data_message =  ($(elem).attr("data-message")==undefined) ? "" : $(elem).attr("data-message");
		$(feed_back).addClass('lblhinterror').removeClass("lblhintok lblhinttext");
		$(feed_back).html(data_message);
		$(elem).addClass('val-glowred');
		$(elem).css('background','red');
		return false;


		} else { /** proceed*/
			var good_msg= ($(elem).attr("data-good")==undefined) ? 'ok' : $(elem).attr("data-good");
			/** no good_msg*/
			good_msg=""
			$(feed_back).html(good_msg)
			$(elem).css('background','#ffffff');
			$(feed_back).addClass('lblhintok').removeClass("lblhinterror lblhinttext");
//			$(elem).addClass('val-glowgreen');
			return true;

		}

	}
}


})(jQuery)