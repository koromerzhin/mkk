export class Country
{
	FormatSelect2Pays (state)
	{
		if (!state.id)
		{
			return state.text
		}
		let emplacement = $('body').attr('data-dir') + 'bundles/mkksite/img/country/'

		if (state.id !== '')
		{
			let balise = '<img src="' + emplacement + state.id + '.png"'

			balise = balise + (' onerror="this.style.display=\'none\'" />&nbsp&nbsp' + state.text)
			return balise
		}
		return state.text
	}
	searchInput ()
	{
		let val = ''

		if (!$(this).hasClass('select2-offscreen'))
		{
			val = $(this).val()
		}
		else
		{
			val = $(this).select2('val')
			$(this).select2('destroy')
		}
		if (val === '')
		{
			val = 'FR'
		}
		$(this).select2(
			{
				'formatNoMatches': function()
				{
					return ''
				},
				'placeholder'      : $(this).attr('placeholder'),
				'width'            : 'element',
				'allowClear'       : true,
				'templateSelection': this.FormatSelect2Pays,
				'templateResult'   : this.FormatSelect2Pays
			}
		)
		if (val !== '')
		{
			$(this).select2('val', val)
		}
	}
	constructor ()
	{
		$(this).find('.InputAdressePays').each(this.searchInput.bind(this))
	}
}
