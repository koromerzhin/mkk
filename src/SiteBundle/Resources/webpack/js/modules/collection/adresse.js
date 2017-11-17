class Adresse
{
	constructor ()
	{}
	tableau (event)
	{
		let collection = $(event).find('.CollectionRow')
		let parent = this

		$(collection).each(
			function()
			{
				let row = this

				parent.ligne(row)
			}
		)
	}
	// Geolocaliser (collection) {
	// }
	ligne (event)
	{
		let utilisation = $(event).find('.InputAdresseUtilisation:first')
		let tagsadresse = []

		$(event).closest('fieldset').find('.TagsCollection').find('li').each(
			function()
			{
				tagsadresse.push($(this).html())
			}
		)
		$(utilisation).select2(
			{
				'tags'                : tagsadresse,
				'allowClear'          : true,
				'placeholder'         : $(utilisation).attr('placeholder'),
				'maximumSelectionSize': 1,
				'containerCssClass'   : 'select2adresse'
			}
		)
		let inputCp = $(event).find('.InputAdresseCp:first')

		$(inputCp).select2(
			{
				'placeholder'       : $(inputCp).attr('placeholder'),
				'minimumInputLength': 0,
				'ajax'              : {
					'url'        : $(inputCp).attr('data-url'),
					'dataType'   : 'json',
					'delay'      : 250,
					'quietMillis': 100,
					'data'       : function(lettre)
					{
						let pays = $(this).closest('.CollectionRow').find('.InputAdressePays:first').val()

						return {
							'pays': pays,
							'cp'  : lettre
						}
					},
					'results': function(data)
					{
						return {
							'results': data.reponse,
							'more'   : false
						}
					},
					'cache': true
				},
				'formatResult': function(codepostal)
				{
					let markup = codepostal.placeName

					return markup
				},
				'formatSelection': function(codepostal)
				{
					let collection = $(this.element).closest('.CollectionRow')

					$(collection).find('.InputAdresseVille:first').val(codepostal.placeName)
					//parent.Geolocaliser(collection)
					return codepostal.postalCode
				},
				'escapeMarkup': function(markup)
				{
					return markup
				},
				'initSelection': function(element, callback)
				{
					let valeur = $(element).val()

					if (valeur !== '')
					{
						let collection = $(element).closest('.CollectionRow')
						let pays = $(collection).find('.InputAdressePays:first')
						let ville = $(collection).find('.InputAdresseVille:first')
						let gps = $(collection).find('.InputAdresseGps:first')

						$.ajax(
							$(element).attr('data-url'),
							{
								'data': {
									'pays' : $(pays).val(),
									'cp'   : valeur,
									'ville': $(ville).val(),
									'gps'  : $(gps).val()
								},
								'dataType': 'json',
								'method'  : 'POST'
							}
						).done(
							function(data)
							{
								let response = {}

								if ($(data.reponse).length !== 0)
								{
									response = data.reponse[0]
								}
								callback(response)
							}
						)
					}
				}
			}
		)
	}
}
export {Adresse}
