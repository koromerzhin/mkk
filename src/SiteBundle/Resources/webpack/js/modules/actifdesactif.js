import {postXHRJson} from 'mkksite/js/modules/xhr/postXHRJson'
export class ActifDesactif
{
	Selection ()
	{
		let selection = ''
		let $checked = $('input[type=\'checkbox\']:checked')

		$.each(
			$checked,
			function()
			{
				if ($(this).val() !== '' && $(this).val() !== 'on' && $(this).closest('table').html() !== undefined)
				{
					if (selection !== '')
					{
						selection = selection + ','
					}
					selection = selection + $(this).val()
				}
			}
		)
		return selection
	}

	AllAllSelectOnClick ()
	{
		// clic sur la case cocher/decocher
		let allchecked = $(this).is(':checked')
		let tbody = $(this).closest('table').find('tbody')

		if (allchecked === true)
		{
			if ($('#BoutonActiver').length)
			{
				$('#BoutonActiver, #BoutonDesactiver').removeClass('disabled')
			}
			$(tbody).find('input[type=checkbox]').each(
				function()
				{
					$(this).prop('checked', true)
				}
			)
		}
		else
		{
			if ($('#BoutonActiver').length)
			{
				$('#BoutonActiver, #BoutonDesactiver').addClass('disabled')
			}
			$(tbody).find('input[type=checkbox]').each(
				function()
				{
					$(this).prop('checked', false)
				}
			)
		}
	}

	InputCheckboxOnClick ()
	{
		let table = $(this).closest('tbody')
		let selection = $(table).find('input[type=\'checkbox\']:checked')

		if (selection.length)
		{
			if ($('#BoutonActiver').length)
			{
				$('#BoutonActiver, #BoutonDesactiver').removeClass('disabled')
			}
		}
		else if ($('#BoutonActiver').length)
		{
			$('#BoutonActiver, #BoutonDesactiver').addClass('disabled')
		}
	}
	checkedAll ()
	{
		let parent = this

		$('[data-rel=\'allselect\']').each(
			function()
			{
				$(this).on('click', parent.AllAllSelectOnClick)
				if ($(this).attr('data-onselect') === undefined)
				{
					let table = $(this).closest('table')

					$(table).find('input[type=checkbox]').each(
						function()
						{
							$(this).prop('checked', false)
						}
					)
				}
			}
		)
		$('table>tbody').each(
			function()
			{
				$(this).find('input[type=\'checkbox\']').each(
					function()
					{
						$(this).on('click', parent.InputCheckboxOnClick)
					}
				)
			}
		)
	}
	btnBoolTrueConfirm (event)
	{
		event.preventDefault()
		let selection = $('.BtnBoolTrueConfirm').attr('data-id')

		this.executer(selection, 1, $('.BtnBoolTrueConfirm').attr('href'))
	}
	btnBoolFalseConfirm (event)
	{
		event.preventDefault()
		let selection = $('.BtnBoolFalseConfirm').attr('data-id')

		this.executer(selection, 0, $('.BtnBoolFalseConfirm').attr('href'))
	}
	btnBool (event)
	{
		event.preventDefault()
		let etat = $(event.currentTarget).hasClass('btn-success')
		let popup
		let id = $(event.currentTarget).attr('data-id')
		let url = $(event.currentTarget).attr('data-url')

		if (url !== undefined)
		{
			if (etat === false)
			{
				popup = 'PopupActiver'
				$('.BtnBoolTrueConfirm').attr('data-id', id)
				$('.BtnBoolTrueConfirm').attr('href', url)
			}
			else
			{
				popup = 'PopupDesactiver'
				$('.BtnBoolFalseConfirm').attr('data-id', id)
				$('.BtnBoolFalseConfirm').attr('href', url)
			}
			$('#' + popup).modal('toggle')
		}
	}
	constructor ()
	{
		this.checkedAll()
		$('.BtnBool').on('click', this.btnBool.bind(this))
		$('.BtnBoolTrueConfirm').on('click', this.btnBoolTrueConfirm.bind(this))
		$('.BtnBoolFalseConfirm').on('click', this.btnBoolFalseConfirm.bind(this))
	}
	async executer (id, etat, url)
	{
		let datapost = {
			'etat': etat,
			'id'  : id
		}

		await postXHRJson(url, datapost, 1)
		document.location.reload()
	}
}
