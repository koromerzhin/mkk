import {SearchInput} from '../modules/form/searchInput'
import {Select2} from '../modules/form/select2'
export class Modal
{
	verifChampsRequired ()
	{
		$('.modal').each(
			function()
			{
				let champsrequired = $(this).find('.ModalRequired')

				if ($(this).find('label.required').length !== 0)
				{
					$(champsrequired).show()
				}
				else
				{
					$(champsrequired).hide()
				}
			}
		)
	}
	onShow (event)
	{
		let input = $(event.currentTarget).find('input')
		let parent = this

		$(input).each(
			function()
			{
				if ($(this).attr('type') !== 'submit' && $(this).attr('data-url') !== undefined)
				{
					parent.searchInput.traiter(this)
				}
			}
		)
		if ($(input).length === 0)
		{
			$(this).focus()
		}
		else
		{
			$($(input).get(0)).focus()
		}
	}
	onHide (event)
	{
		let select = $(event.currentTarget).find('select,input')

		select.each(
			function()
			{
				$(this).select2('close')
			}
		)
	}
	onShown (event)
	{
		let parent = this

		$(event.currentTarget).find('select').each(
			function()
			{
				parent.select2.input(this)
			}
		)
		let footer = $(event.currentTarget).find('.modal-footer')
		let aTag = $(footer).find('a')

		if ($(aTag).length === 1 && $(event.currentTarget).data('autofocus') === true)
		{
			$(aTag).focus()
		}

		if ($(event.currentTarget).data('autoclose') !== undefined)
		{
			footer = $(event.currentTarget).find('.modal-footer')
			aTag = $(footer).find('a')
			if ($(aTag).length === 1 && $(event.currentTarget).attr('data-autoclose') !== 'false')
			{
				setTimeout(
					function()
					{
						$($(aTag).get(0)).trigger('click')
					},
					1500
				)
			}
		}
	}
	constructor ()
	{
		this.select2 = new Select2()
		this.searchInput = new SearchInput()
		this.verifChampsRequired()
		$('.modal').on('show.bs.modal', this.onShow.bind(this))
		$('.modal').on('shown.bs.modal', this.onShown.bind(this))
		$('.modal').on('hide.bs.modal', this.onHide.bind(this))
	}
}
