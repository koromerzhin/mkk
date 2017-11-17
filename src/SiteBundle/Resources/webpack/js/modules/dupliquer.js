export class Dupliquer
{
	AllAllSelectOnClick ()
	{
		// clic sur la case cocher/decocher
		let allchecked = $(this).is(':checked')
		let tbody = $(this).closest('table').find('tbody')

		if (allchecked === true)
		{
			if ($('#BoutonDupliquer').length)
			{
				$('#BoutonDupliquer').removeClass('disabled')
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
			if ($('#BoutonDupliquer').length)
			{
				$('#BoutonDupliquer').addClass('disabled')
			}
			$(tbody).find('input[type=checkbox]').each(
				function()
				{
					$(this).prop('checked', false)
				}
			)
		}
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

	InputCheckboxOnClick ()
	{
		let table = $(this).closest('tbody')
		let selection = $(table).find('input[type=\'checkbox\']:checked')

		if (selection.length)
		{
			if ($('#BoutonDupliquer').length)
			{
				$('#BoutonDupliquer').removeClass('disabled')
			}
		}
		else if ($('#BoutonDupliquer').length)
		{
			$('#BoutonDupliquer').addClass('disabled')
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
	BoutonActiverOnClick (event)
	{
		let selection = this.selection()

		if (selection !== '')
		{
			$('#PopupDupliquer').modal('show')
		}
		event.preventDefault()
	}
	PopupActiverRelSaveOnClick ()
	{
		let selection = this.selection()
		// Elle est ou cette fonction ???

		this.executer(selection, $('#BoutonDupliquer').attr('href'))
	}
	constructor ()
	{
		this.checkedAll()
		$('#BtnDupliquerConfirm').on('click', this.PopupActiverRelSaveOnClick.bind(this))
		$('#BoutonDupliquer').on('click', this.BoutonActiverOnClick.bind(this))
	}
}
