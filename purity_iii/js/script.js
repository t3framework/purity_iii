/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */

// count up
(function($) {
	
	function CountUp(element, options){
		this.$element  = $(element);
		this.$counter  = this.$element.find('.count-up');
		this.$progress = this.$element.find('.pro-bar');
		this.options   = options;
		this.value     = options.from;
		this.$element
			.on('mouseenter', $.proxy(this.run, this));
	}

	CountUp.prototype = {
		run: function(){
			
			if(this.$element.hasClass('start')){
				return;
			}
			this.$element.addClass('start');
			this.$counter.stop(true).css('display', 'block').fadeTo(250, 1).siblings('.face').css('display', 'none');
			$(this).stop(true).animate({
				value: this.options.to
			}, {
				step: function(now){
					this.$counter.html(Math.round(now) + '%');
				},
				duration: this.options.duration,
				complete: function(){

					setTimeout($.proxy(function(){
						this.$counter.delay(250).parent().children().css({display: '', opacity: ''});
						this.$progress.css('display', '');
					}, this), 250);
					
					//clean
					this.$element.off('mouseenter');
				}
			});

			this.$progress.css({width: '0%', display: 'block'}).animate({
				width: this.options.to + '%'
			}, this.options.duration);
		}
	}

	CountUp.defaults = {
		from: 0,
		to: 100,
		duration: 2000
	}

	$.fn.countup = function (option) {
    return this.each(function () {
      var 
      	$this   = $(this),
      	data    = $this.data('countup'),
      	options = $.extend({}, CountUp.defaults, $this.data(), typeof option == 'object' && option),
      	action  = typeof option == 'string' ? option : false;

      if (!data){
      	$this.data('countup', (data = new CountUp(this, options)))
      }

      if (action && data[action]){
      	data[action]()
      }
    })
  }

})(jQuery);

// kickstart
(function($){

	$(document).ready(function(){
		
		//init count up
		(function(){
			$('[data-js="count-up"]').countup();
		})();


	});

})(jQuery);


