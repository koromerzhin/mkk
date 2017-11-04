export class Select2
{
	selection ()
	{
		let parent = this

		$('select').each(
			function()
			{
				if ($(this).data('url') === undefined && !$(this).hasClass('InputAdresseCp'))
				{
					parent.input(this)
				}
			}
		)
	}
	dataTags ()
	{
		$('input[data-tags]').each(
			function()
			{
				let tags = $(this).attr('data-tags').split(',')
				let data = {
					'tags': tags
				}

				if ($(this).attr('data-maximumSelectionSize') !== undefined)
				{
					data.maximumSelectionSize = $(this).attr('data-maximumSelectionSize')
				}
				$(this).select2(data)
			}
		)
	}
	input (champs)
	{
		let option = $(champs).find('option').length
		let data = {
			'formatNoMatches': function()
			{
				return ''
			},
			'placeholder': $(champs).attr('placeholder'),
			'allowClear' : true
		}

		if (option <= 25)
		{
			data.minimumResultsForSearch = -1
		}
		$(champs).select2(data)
		if ($(champs).attr('readonly') !== undefined)
		{
			$(champs).select2('readonly', true)
		}
	}
	constructor()
	{
		this.dataTags()
		this.selection()
	}
}
