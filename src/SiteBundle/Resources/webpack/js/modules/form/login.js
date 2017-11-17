export class Login
{
	glyphiconlockOnmouseover ()
	{
		if ($(this).css('cursor') === 'pointer')
		{
			let input = $(this).closest('.input-group').find('input')

			if ($(input).length)
			{
				$(input).attr('type', 'text')
			}
		}
	}

	glyphiconlockOnmouseout ()
	{
		if ($(this).css('cursor') === 'pointer')
		{
			let input = $(this).closest('.input-group').find('input')

			if ($(input).length)
			{
				$(input).attr('type', 'password')
			}
		}
	}

	ShowForgotOnClick ()
	{
		$('#DivFormulaireLogin').hide()
		$('#DivFormulaireForgot').show()
		return false
	}

	ShowLoginOnClick ()
	{
		$('#DivFormulaireForgot').hide()
		$('#DivFormulaireLogin').show()
		return false
	}
	constructor ()
	{
		$('#ShowForgot').on('click', this.ShowForgotOnClick),
		$('#ShowLogin').on('click', this.ShowLoginOnClick)
		$('.glyphicon-lock').on('mouseover', this.glyphiconlockOnmouseover)
		$('.glyphicon-lock').on('mouseout', this.glyphiconlockOnmouseout)
	}
}
