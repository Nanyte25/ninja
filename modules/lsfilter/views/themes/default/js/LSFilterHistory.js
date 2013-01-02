var lsfilter_history = {
	update : function(query, source, metadata) {
		if( source == 'history' ) return;
		window.history.pushState({
			query : query
		}, window.title, '?q='+encodeURIComponent(query));
	},
	init : function() {
		window.onpopstate = function(evt) {
			if (evt.state && evt.state.query) {
				lsfilter_main.update(evt.state.query, 'history');
			} else {
				console.log('think about the history');
				console.log(evt);
			}
		}
	}
}