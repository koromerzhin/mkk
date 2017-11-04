import {postXHRJson} from 'mkksite/js/modules/xhr/postXHRJson'
export class Supprimer
{
	AllAllSelectOnClick ()
	{
		// clic sur la case cocher/decocher
		let allchecked = $(this).is(':checked')
		let tbody = $(this).closest('table').find('tbody')

		if (allchecked === true)
		{
			if ($('#BoutonSupprimer').length)
			{
				$('#BoutonSupprimer').removeClass('disabled')
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
			if ($('#BoutonSupprimer').length)
			{
				$('#BoutonSupprimer').addClass('disabled')
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
			if ($('#BoutonSupprimer').length)
			{
				$('#BoutonSupprimer').removeClass('disabled')
			}
		}
		else if ($('#BoutonSupprimer').length)
		{
			$('#BoutonSupprimer').addClass('disabled')
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
	selection ()
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
	BtnDelConfirm (event)
	{
		event.preventDefault()
		let selection = this.selection()

		this.executer(selection, $('#BoutonSupprimer').attr('href'))
	}
	BtnViderConfirm (event)
	{
		$('#PopupVider').modal('hide')
		this.executer( {}, $('#BoutonVider').attr('href'))
		event.preventDefault()
	}
	BoutonSupprimerOnClick (event)
	{
		let selection = this.selection()

		if (selection !== '')
		{
			$('#PopupSupprimer').modal('show')
		}
		event.preventDefault()
	}
	BoutonViderOnClick (event)
	{
		$('#PopupVider').modal('show')
		event.preventDefault()
	}
	async executer (selection, url)
	{
		let datapost = {
			'selection': selection
		}

		await postXHRJson(url, datapost, 1)
	}
	constructor ()
	{
		this.checkedAll()
		$('#BoutonSupprimer').on('click', this.BoutonSupprimerOnClick.bind(this))
		$('.BtnDelConfirm').on('click', this.BtnDelConfirm.bind(this))
		$('#BoutonVider').on('click', this.BoutonViderOnClick)
		$('.BtnViderConfirm').on('click', this.BtnViderConfirm.bind(this))
	}
}
