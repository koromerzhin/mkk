class Email
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
	ligne (event)
	{
		let utilisation = $(event).find('.InputEmailUtilisation:first')
		let tagsemail = []

		$(event).closest('fieldset').find('.TagsCollection').find('li').each(
			function()
			{
				tagsemail.push($(this).html())
			}
		)
		$(utilisation).select2(
			{
				'tags'                : tagsemail,
				'allowClear'          : true,
				'placeholder'         : $(utilisation).attr('placeholder'),
				'maximumSelectionSize': 1,
				'containerCssClass'   : 'select2email'
			}
		)
	}
}
export {Email}
