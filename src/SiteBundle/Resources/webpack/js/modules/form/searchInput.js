export class SearchInput
{
	data (input)
	{
		let idinput = $(input).attr('id')
		let data = {}

		if (idinput !== undefined)
		{
			let form = $(input).closest('form')

			$(form).find('select').each(
				function()
				{
					let id = $(this).attr('id')

					if (id !== idinput)
					{
						if ($(this).hasClass('select2-offscreen'))
						{
							data[id] = $(this).select2('val')
						}
						else
						{
							data[id] = $(this).val()
						}
					}
				}
			)
			$(form).find('input').each(
				function()
				{
					let id = $(this).attr('id')

					if (id !== 'user__token' && id !== idinput && !$(this).hasClass('select2-focusser') && !$(this).hasClass('select2-input') && $(this).attr('data-upload') === undefined)
					{
						let val = $(this).val()

						if (val !== '')
						{
							data[id] = val
						}
					}
				}
			)
		}
		return data
	}
	constructor ()
	{}
	async traiter (input)
	{
		if ($(input).hasClass('InputAdresseCp') === false && $(input).attr('data-url') !== undefined)
		{
			let obj = {}

			if ($(input).attr('data-uri') === undefined)
			{
				obj = this.data(input)
			}

			obj.limit = 10
			$(input).select2(
				{
					'minimumInputLength': 0,
					'multiple'          : $(input).attr('data-multiple') !== undefined,
					'ajax'              : {
						'url'     : $(input).attr('data-url'),
						'dataType': 'json',
						'delay'   : 250,
						'data'    : function(lettre, page)
						{
							obj.placeholder = $(this).attr('placeholder')
							obj.required = $(this).attr('required') === 'required' && $(this).attr('data-multiple') === undefined ? 1 : 0
							obj.lettre = lettre
							obj.page = page
							return obj
						},
						'results': function(data, page)
						{
							let more = page * 10 < data.total

							return {
								'results': data.results,
								'more'   : more
							}
						},
						'cache': true
					},
					'escapeMarkup': function(markup)
					{
						return markup
					},
					'formatResult': function(entity)
					{
						return entity.nom
					},
					'formatSelection': function(entity)
					{
						return entity.nom
					},
					'initSelection': function(element, callback)
					{
						let valeur = $(element).val()

						if (valeur !== '')
						{
							$.ajax(
								$(element).attr('data-url'),
								{
									'data': {
										'id': $(element).val()
									},
									'dataType': 'json',
									'method'  : 'POST'
								}
							).done(
								function(data)
								{
									callback(data)
								}
							)
						}
					}
				}
			)
		}
	}
}
