import {Adresse} from './collection/adresse'
import {Email} from './collection/email'
import {Telephone} from './collection/telephone'
import {Horaire} from './collection/horaire'
class Collection
{
	constructor ()
	{
		this.Telephone = new Telephone()
		this.Email = new Email()
		this.Adresse = new Adresse()
		this.Horaire = new Horaire()
		let parent = this

		$(document).on('click', '.BtnCollectionAdd', this.Ajouter.bind(this))
		$(document).on('click', '.BtnCollectionDelete', this.Supprimer).bind(this)
		$('.FieldCollection').each(
			function()
			{
				let type = $(this).attr('data-type')

				if (type === 'telephones')
				{
					parent.Telephone.tableau(this)
				}
				else if (type === 'emails')
				{
					parent.Email.tableau(this)
				}
				else if (type === 'adresses')
				{
					parent.Adresse.tableau(this)
				}
			}
		)
		$('input,select').on(
			'keypress',
			function(event)
			{
				if (event.which === 13)
				{
					$(this).blur()
					event.preventDefault()
				}
			}
		)
	}
	Ajouter (event)
	{
		let type = $(event.currentTarget).attr('data-type')
		let fieldset = $(event.currentTarget).closest('fieldset')
		let prototype = $(fieldset).attr('data-prototype')
		let index = $(fieldset).find('tr').length
		let tags = prototype.replace(/__name__/g, index)
		let tabCollection = $(fieldset).find('.TabCollection' + type)

		$(tabCollection).append(tags)
		let row = $(tabCollection).find('.CollectionRow:last')

		if (type === 'telephones')
		{
			this.Telephone.ligne(row)
		}
		else if (type === 'emails')
		{
			this.Email.ligne(row)
		}
		else if (type === 'adresses')
		{
			this.Adresse.ligne(row)
		}
	}
	Supprimer ()
	{
		$(this).closest('.CollectionRow').remove()
	}
}
export {Collection}
