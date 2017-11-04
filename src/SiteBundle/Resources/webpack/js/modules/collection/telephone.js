import {postXHRJson} from 'mkksite/js/modules/xhr/postXHRJson'
class Telephone
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
	verifTel (event)
	{
		this.asyncVerifTel(event.currentTarget)
	}
	async asyncVerifTel (event)
	{
		let val = $(event).val()
		let tr = $(event).closest('tr')

		if ($(tr).data('md5') === undefined)
		{
			let md5 = Math.random()

			$(tr).attr('data-md5', md5)
		}

		let md5 = $(tr).attr('data-md5')
		let datapost = {
			'telephone': val,
			'md5'      : md5
		}

		let fieldset = $(event).closest('fieldset')
		let url = $(fieldset).data('route')
		let response = await postXHRJson(url, datapost, 0)

		tr = $('tr[data-md5=\'' + md5 + '\']')
		if ($(tr).length)
		{
			if (typeof response.iconpays !== undefined)
			{
				let drapeau = $(tr).find('.drapeaupays:first')

				if (response.iconpays === 'glyphicon-question-sign')
				{
					$(drapeau).attr('class', 'drapeaupays glyphicon ' + response.iconpays)
				}
				else
				{
					$(tr).find('.InputTelPays:first').val(response.country)
					$(drapeau).attr(
						{
							'class': '',
							'src'  : response.iconpays
						}
					)
				}
				let typetel = $(tr).find('.typetel:first')

				$(typetel).attr('class', 'typetel glyphicon ' + response.icontypetel)
				$(tr).find('.InputTelType:first').val(response.icontypetel)
			}
		}
	}
	onkeyUp (event)
	{
		if (event.which === 13)
		{
			$(this).blur()
		}
	}
	ligne (event)
	{
		let type = $(event).find('.InputTelType:first')
		let span = $(event).find('.typetel:first')

		$(span).addClass($(type).val())
		let pays = $(event).find('.InputTelPays:first')
		let img = $(event).find('.drapeaupays:first')

		if ($(pays).val() !== '')
		{
			let image = $(img).data('src') + $(pays).val() + '.png'

			$(img).attr('src', image)
		}

		let chiffre = $(event).find('.InputTelChiffre:first')
		let utilisation = $(event).find('.InputTelUtilisation:first')
		let tagstelephone = []

		$(event).closest('fieldset').find('.TagsCollection').find('li').each(
			function()
			{
				tagstelephone.push($(this).html())
			}
		)
		$(utilisation).select2(
			{
				'tags'                : tagstelephone,
				'allowClear'          : true,
				'placeholder'         : $(utilisation).attr('placeholder'),
				'maximumSelectionSize': 1,
				'containerCssClass'   : 'select2tel'
			}
		)
		$(chiffre).on('blur', this.verifTel.bind(this))
		// $(chiffre).on('onkeyup', this.onkeyUp)
	}
}
export {Telephone}
