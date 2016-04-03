var clip = null;

$(function(){
	$.fn.zero_init_download = function(){
		return this.each(function() {
			var code = $(this).parent('.cadre_download').prev('.cadre'),
				me = this,
				content_data = code.attr('data-clipboard-text');
			if(!content_data && $(this).parent().find('a').eq(0)){
				if($(this).parent().find('a').eq(0).attr('href')){
					$.get($(this).parent().find('a').eq(0).attr('href'),function(data) {
						$(me).parent().append('<div style="display:none" class="data-clipboard-hidden"></div>');
						$(me).parent().find('.data-clipboard-hidden').text(data);
					});
				}
			}else if(!$(me).attr('data-clipboard-text')){
				$(me).attr('data-clipboard-text',content_data);
			}
		});
	}
	var copypaste_init = function(){
		var copy = false;
		if($('.copypaste').length)
			$('.copypaste').each(function(){
				if(!$(this).prev().is('.copypaste_container')){
					$(this).before('<div class="copypaste_container" style="position:relative"><a title="'+locale.zeroclipboard.link_title_copy+'" class="copypaste_link">'+locale.zeroclipboard.link_title_copy+'</a></div>');
					copy = true;
				}
				if($(this).attr('id'))
					$(this).prev('.copypaste_container').find('a').attr('data-clipboard-target',$(this).attr('id'));
				else if($(this).is('input') || $(this).is('textarea'))
					$(this).prev('.copypaste_container').find('a').attr('data-clipboard-text',$(this).val());
			});
		
		if($('.coloration_code').length){
			if($('.cadre_download').length)
				$('.coloration_code .cadre_download').each(function(){
					/**
					 * On ajoute la class si pas déjà fait
					 */
					if(!$(this).is('.copypaste_container')){
						$(this)
							.addClass('copypaste_container')
							.css({'position':"relative"})
							.append(' - <a title="'+locale.zeroclipboard.link_title_copy+'" class="copypaste_link">'+locale.zeroclipboard.link_title_copy+'</a>');
						copy = true;
					}
				});
			$('.coloration_code').each(function(){
				if(!$(this).is('.code') && !$(this).find('.cadre_download')[0] && !$(this).next().is('.cadre_download') && $(this).attr('data-clipboard-text') != ''){
					$(this).append('<p class="download cadre_download copypaste_container" style="position:relative"><a title="'+locale.zeroclipboard.link_title_copy+'" class="copypaste_link">'+locale.zeroclipboard.link_title_copy+'</a></p>');
					copy = true;
				}
			});
			if(copy)
				$('.copypaste_link').zero_init_download();
		}

		ZeroClipboard.destroy();
		if(copy){
			clip = new ZeroClipboard($('.copypaste_link'));
			clip.on('ready', function(event) {
				$('.copypaste_copied').html(locale.zeroclipboard.link_title_copy)
					.attr('title',locale.zeroclipboard.link_title_copy)
					.removeClass('copypaste_copied');
				clip.on('copy', function(event) {
					if(typeof($(event.target).attr('data-clipboard-text')) == "undefined"){
						event.clipboardData.setData('text/plain', $(event.target).parent().find('.data-clipboard-hidden').text());
					}
				});
				clip.on('aftercopy', function(event) {
					if(event.data['text/plain'] != undefined){
						$(event.target)
							.html(locale.zeroclipboard.link_title_copied).attr('title',locale.zeroclipboard.link_title_copied).addClass('copypaste_copied');
						$('.copypaste_copied').not($(event.target)).each(function(i){
							$(this)
								.html(locale.zeroclipboard.link_title_copy)
								.attr('title',locale.zeroclipboard.link_title_copy)
								.removeClass('copypaste_copied');
						});
					}
				});
			});
			clip.on( 'error', function(event) {
				ZeroClipboard.destroy();
			});
		}
	}
	copypaste_init();
});