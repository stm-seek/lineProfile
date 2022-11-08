(function($) {

	// Chart Functionality
	$.fn.setChart = function() {
		return this.each(function() {
			// Variables
			var chart = $(this),
				path = $('.chart__foreground path', chart),
				dashoffset = path.get(0).getTotalLength(),
				goal = chart.attr('data-goal'),
				consumed = chart.attr('data-count');

			$('.chart__foreground', chart).css({
				'stroke-dashoffset': Math.round(dashoffset - ((dashoffset / goal) * consumed))
			});
		});
	}; // setChart()

	// Count
	$.fn.count = function() {
		return this.each(function() {
			$(this).prop('Counter', 0).animate({
				Counter: $(this).attr('data-count')
			}, {
				duration: 1000,
				easing: 'swing',
				step: function(now) {
					$(this).text(Math.ceil(now));
				}
			});
		});
	}; // count()

	$(window).load(function() {
		$('.js-chart').setChart();
		$('.js-count').count();
	});

})(jQuery);

let menuToggle = document.querySelector('.menu-toggle');
let navigation = document.querySelector('.navigation');

menuToggle.onclick = function() {
  navigation.classList.toggle('active');
}