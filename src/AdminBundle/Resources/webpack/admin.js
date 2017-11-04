import {MkkSite} from 'mkksite/site'
import {formEnvoyer} from 'mkksite/js/modules/form/envoyer'
import {Sortable} from './admin/sortable'
import {Modules} from './admin/modules'
export class MkkAdmin extends MkkSite
{
	fix ()
	{
		$('.layout-boxed > .wrapper').css('overflow', 'hidden')
		let footerHeight = $('.main-footer').outerHeight() || 0
		let neg = $('.main-header').outerHeight() + footerHeight
		let windowHeight = $(window).height()
		let sidebarHeight = $('.sidebar').height() || 0

		if ($('body').hasClass('fixed'))
		{
			$('.content-wrapper, .right-side').css('min-height', windowHeight - footerHeight)
		}
		else
		{
			let postSetWidth

			if (windowHeight >= sidebarHeight)
			{
				$('.content-wrapper, .right-side').css('min-height', windowHeight - neg)
				postSetWidth = windowHeight - neg
			}
			else
			{
				$('.content-wrapper, .right-side').css('min-height', sidebarHeight)
				postSetWidth = sidebarHeight
			}

			// Fix for the control sidebar height
			let $controlSidebar = $('.control-sidebar')

			if (typeof $controlSidebar !== 'undefined')
			{
				if ($controlSidebar.height() > postSetWidth)
				{
					$('.content-wrapper, .right-side').css('min-height', $controlSidebar.height())
				}
			}
		}
	}

	tree (menu)
	{
		let _this = this
		let animationSpeed = 500

		$(document).off('click', menu + ' li a').on('click', menu + ' li a', function(event)
		{
			// Get the clicked link and the next element
			let $this = $(this)
			let checkElement = $this.next()

			// Check if the next element is a menu and is visible
			if (checkElement.is('.treeview-menu') && checkElement.is(':visible') && !$('body').hasClass('sidebar-collapse'))
			{
				// Close the menu
				checkElement.slideUp(animationSpeed, function()
				{
					checkElement.removeClass('menu-open')
					// Fix the layout in case the sidebar stretches over the height of the window
					// _this.layout.fix();
				} )

				checkElement.parent('li').removeClass('active')
				// If the menu is not visible
			}
			else if (checkElement.is('.treeview-menu') && !checkElement.is(':visible'))
			{
				// Get the parent menu
				let parent = $this.parents('ul').first()
				// Close all open menus within the parent
				let ul = parent.find('ul:visible').slideUp(animationSpeed)
				// Remove the menu-open class from the parent

				ul.removeClass('menu-open')
				// Get the parent li
				let parent_li = $this.parent('li')

				// Open the target menu and add the menu-open class
				checkElement.slideDown(animationSpeed, function()
				{
					// Add the class active to the parent li
					checkElement.addClass('menu-open')
					parent.find('li.active').removeClass('active')
					parent_li.addClass('active')
					// Fix the layout in case the sidebar stretches over the height of the window
					_this.fix()
				} )
			}
			// if this isn't a link, prevent the page from being redirected
			if (checkElement.is('.treeview-menu'))
			{
				event.preventDefault()
			}
		} )
	}

	activate (toggleBtn)
	{
		// Get the screen sizes
		let screenSizes = {
			'xs': 480,
			'sm': 768,
			'md': 992,
			'lg': 1200
		}

		// Enable sidebar toggle
		$(document).on('click', toggleBtn, function(event)
		{
			event.preventDefault()

			// Enable sidebar push menu
			if ($(window).width() > screenSizes.sm - 1)
			{
				if ($('body').hasClass('sidebar-collapse'))
				{
					$('body').removeClass('sidebar-collapse').trigger('expanded.pushMenu')
				}
				else
				{
					$('body').addClass('sidebar-collapse').trigger('collapsed.pushMenu')
				}
			}
			else if ($('body').hasClass('sidebar-open'))
			{
				$('body').removeClass('sidebar-open').removeClass('sidebar-collapse').trigger('collapsed.pushMenu')
			}
			else
			{
				$('body').addClass('sidebar-open').trigger('expanded.pushMenu')
			}
		}
		)

		$('.main-admin').click(function()
		{
			// Enable hide menu when clicking on the content-wrapper on small screens
			if ($(window).width() <= screenSizes.sm - 1 && $('body').hasClass('sidebar-open'))
			{
				$('body').removeClass('sidebar-open')
			}
		} )
	}

	BoutonSaveClick (event)
	{
		event.preventDefault()
		let formID = $(event.currentTarget).attr('data-submit')

		formEnvoyer('#' + formID)
	}

	navTab ()
	{
		$('.NavLang').on(
			'click',
			function()
			{
				$(this).closest('.nav-tabs').find('.NavSelect').html($(this).html())
			}
		)
	}

	constructor ()
	{
		super()
		this.navTab()
		this.tree('.sidebar')
		this.Sortable = new Sortable()
		this.Modules = new Modules()
		this.activate('[data-toggle=\'offcanvas\']')
		$('#BoutonSave').on('click', this.BoutonSaveClick.bind(this))
	}
}
