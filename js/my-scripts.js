$('#income').my({
	var manifest = {
		data: {gross: 0, net: 0},
		init: function ($node, runtime) {
			$node.html(
				'<div><input id="gross-pay" type="number" placeholder="0"/></div>' +
				'<div><input id="net-pay" type="number" placeholder="0"/></div>'
			);
		},
		ui: {
			'gross-pay': {
				bind: gross,
				recalc: '.result'
			},
			'net-pay': {
				bind: net,
				recalc: '.result'
			},
			'.result': {
				bind: function(data) {
					return (data.gross - data.net).round(2);
				},
				watch: 'gross, net'
			}
		}
	}
})