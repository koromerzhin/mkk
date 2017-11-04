import {Modal} from './js/modules/modal'
import {Navbar} from './js/modules/navbar'
import {RevolutionSlider} from './js/modules/RevolutionSlider'
import {Collection} from './js/modules/collection'
import {Wysiwyg} from './js/modules/wysiwyg'
import {ActifDesactif} from './js/modules/actifdesactif'
import {Supprimer} from './js/modules/supprimer'
import {Dupliquer} from './js/modules/dupliquer'
import {Form} from './js/modules/form'
import {getXHRJson} from './js/modules/xhr/getXHRJson'
import {JqueryInit} from './js/modules/JqueryInit'
//import Turbolinks from 'turbolinks'
export class MkkSite
{
	cacheTableHTML ()
	{
		let nodata = $('#NoData').html()

		$('table').each(
			function()
			{
				if (!$(this).hasClass('NOCache') && $(this).closest('.modal').html() === undefined && $(this).closest('.EmplacementUpload').html() === undefined
				)
				{
					let tr = $(this).find('tbody').find('tr')

					if ($(tr).length === 0)
					{
						$(this).fadeOut(
							'slow',
							function()
							{
								$(this).after(nodata)
							}
						)
					}
				}
			}
		)
	}
	getModule ()
	{
		return $('body').data('module')
	}
	getRoute ()
	{
		return $('body').data('route')
	}
	ClickSelectAll ()
	{
		let checked = $(this).attr('checked')
		let tableau = $(this).closest('table')

		if (checked === 'checked')
		{
			$(tableau).find('input[type=\'checkbox\']').each(
				function()
				{
					$(this).attr('checked', 'checked')
				}
			)
		}
		else
		{
			$(tableau).find('input[type=\'checkbox\']').each(
				function()
				{
					$(this).removeAttr('checked')
				}
			)
		}
	}

	OnClickLinkDisabled ()
	{
		$('#PopupLienDesactiver').modal('toggle')
	}

	linkDisabled ()
	{
		$('a[data-rel=\'LienDesactiver\']').on('click', this.OnClickLinkDisabled)
	}

	player ()
	{
		if ($('.player').length === 1)
		{
			$('.player').mb_YTplayer()
		}
	}
	OnClickShowTel (event)
	{
		this.lienTel(event.currentTarget)
		event.preventDefault()
	}
	telephone ()
	{
		$('.Showtel').on('click', this.OnClickShowTel.bind(this))
		if ($.browser !== undefined && $.browser.mobile)
		{
			$('.LienTel').each(
				function()
				{
					var aTag = document.createElement('a')

					$(aTag).attr('href', 'tel:' + $(this).attr('data-tel')).html($(this).attr('data-tel'))
					$(this).html(aTag)
				}
			)
		}
	}
	getForm ()
	{
		return this.form
	}
	accordion ()
	{
		$('.accordion').each(
			function()
			{
				$(this).accordion(
					{
						'heightStyle': 'content',
						'collapsible': true
					}
				)
			}
		)
	}
	iClick ()
	{
		$('i').on('click',
			function()
			{
				$(this).closest('a').trigger('click')
			}
		)
	}
	constructor ()
	{
		//Turbolinks.start()
		this.JqueryInit = new JqueryInit()
		this.Modal = new Modal()
		this.accordion()
		this.iClick()
		this.telephone()
		this.Navbar = new Navbar()
		this.RevolutionSlider = new RevolutionSlider()
		this.ActifDesactif = new ActifDesactif()
		this.Collection = new Collection()
		this.Supprimer = new Supprimer()
		this.Wysiwyg = new Wysiwyg()
		this.Dupliquer = new Dupliquer()
		this.form = new Form()
		this.linkDisabled()
		this.player()
		this.cacheTableHTML()
		this.lazyLoadImages()
	}
	lazyLoadImages()
	{
		document.querySelectorAll('img[data-src]').forEach(
			function(img)
			{
				img.setAttribute('src', img.getAttribute('data-src'))
				img.onload = function()
				{
					img.removeAttribute('data-src')
				}
			}
		)
	}
	async lienTel (event)
	{
		let url = $(event).attr('href')
		let response = await getXHRJson(url)

		$(event).html(response)
		if ($.browser !== undefined && $.browser.mobile)
		{
			$(event).attr('href', 'tel:' + response)
		}
		else
		{
			$(event).removeAttr('href')
		}
	}
}
