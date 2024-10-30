function exec_queries(squery,snonce){
	var data = {
		action: 'cpr_exec_query',
		cpr_nonce: snonce,
		query: squery

	};

	jQuery.post("admin-ajax.php", data, function(r) {
		alert(r);
	});
}
